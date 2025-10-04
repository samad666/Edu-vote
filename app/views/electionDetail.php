<?php
require_once '../includes/config.php';
require __DIR__ . '/../../includes/mail.php';
require_once __DIR__ . '/../models/candidates.php';

// Get Election ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid Election ID");
}
$election_id = (int) $_GET['id'];

// Handle candidate actions and election control
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_candidate'])) {
        $student_id = $_POST['student_id'];
        $election_type = $_POST['election_type'];
        if (addCandidate($election_type, $student_id)) {
            $success = "Candidate added successfully!";
        } else {
            $error = "Failed to add candidate.";
        }
    } elseif (isset($_POST['remove_candidate'])) {
        $student_id = $_POST['student_id'];
        $election_type = $_POST['election_type'];
        if (removeCandidate($election_type, $student_id)) {
            $success = "Candidate removed successfully!";
        } else {
            $error = "Failed to remove candidate.";
        }
    } elseif (isset($_POST['start_election'])) {
        // Get election data first
        $election_sql = "SELECT * FROM elections WHERE id = $election_id";
        $election_result = mysqli_query($conn, $election_sql);
        $election_data = mysqli_fetch_assoc($election_result);
        
        $update_sql = "UPDATE elections SET status='Active' WHERE id=$election_id";
        if (mysqli_query($conn, $update_sql)) {
            // Send emails to students
            $mail_result = sendVotingEmails($election_id, $election_data['name'], $election_data['class_id']);
            $success = "Election started successfully! Emails sent to {$mail_result['sent']} students.";
            if ($mail_result['failed'] > 0) {
                $success .= " ({$mail_result['failed']} emails failed to send)";
            }
        } else {
            $error = "Failed to start election.";
        }
    } elseif (isset($_POST['stop_election'])) {
        $update_sql = "UPDATE elections SET status='Completed' WHERE id=$election_id";
        if (mysqli_query($conn, $update_sql)) {
            $success = "Election stopped successfully!";
            $election['status'] = 'Completed';
        } else {
            $error = "Failed to stop election.";
        }
    }
}

// Fetch Election Data
$sql = "SELECT e.*, c.class_name FROM elections e LEFT JOIN class c ON e.class_id = c.id WHERE e.id = $election_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("❌ Election not found");
}

$election = mysqli_fetch_assoc($result);

// Get candidates and available students
$candidates = getCandidatesByElection($election['type']);
$availableStudents = getAvailableStudents($election['type'], $election['class_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Detail - EduVote</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="breadcrumb">
            <a href="/admin" class="breadcrumb-item">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="/admin#elections" class="breadcrumb-item">Elections</a>
            <i class="fas fa-chevron-right"></i>
            <span class="breadcrumb-item active"><?= htmlspecialchars($election['name']) ?></span>
        </div>

        <div class="profile-header">
            <div class="profile-info">
                <h1><?= htmlspecialchars($election['name']) ?></h1>
                <div class="profile-meta">
                    <span class="meta-item">
                        <i class="fas fa-calendar"></i>
                        Started: <?= date('M j, Y', strtotime($election['start_date'])) ?>
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-hourglass-end"></i>
                        Ends: <?= date('M j, Y', strtotime($election['end_date'])) ?>
                    </span>
                    <span class="status <?= $election['status'] === 'Active' ? 'status--success' : 'status--warning' ?>">
                        <?= htmlspecialchars($election['status']) ?>
                    </span>
                </div>
            </div>
            <div class="profile-actions">
                <a href="/admin/editElection?id=<?= $election_id ?>" class="btn btn--primary">Edit Election</a>
                <?php if ($election['status'] === 'Inactive'): ?>
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="start_election" class="btn btn--success" onclick="return confirm('Start this election?')">Start Election</button>
                    </form>
                <?php elseif ($election['status'] === 'Active'): ?>
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="stop_election" class="btn btn--danger" onclick="return confirm('Stop this election?')">Stop Election</button>
                    </form>
                <?php endif; ?>
                <button class="btn btn--outline">Export Results</button>
            </div>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert--success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert--error"><?= $error ?></div>
        <?php endif; ?>

        <div class="profile-content">
            <div class="content-grid">
                <div class="content-card">
                    <div class="card-header">
                        <h3>Election Information</h3>
                    </div>
                    <div class="card__body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Election Type</label>
                                <p><?= htmlspecialchars($election['type']) ?></p>
                            </div>
                            <div class="info-item">
                                <label>Scope</label>
                                <p><?= htmlspecialchars($election['scope']) ?></p>
                            </div>
                            <div class="info-item">
                                <label>Class</label>
                                <p><?= htmlspecialchars($election['class_name'] ?? 'All Classes') ?></p>
                            </div>
                            <div class="info-item">
                                <label>Profile</label>
                                <p><?= htmlspecialchars($election['profile']) ?></p>
                            </div>
                            <div class="info-item">
                                <label>Status</label>
                                <span class="status <?= $election['status'] === 'Active' ? 'status--success' : 'status--warning' ?>">
                                    <?= htmlspecialchars($election['status']) ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <label>Winner</label>
                                <p><?= $election['winner_student_id'] ? htmlspecialchars($election['winner_student_id']) : 'TBD' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Candidate Form -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Add Candidate</h3>
                </div>
                <div class="card__body">
                    <form method="POST" class="form">
                        <input type="hidden" name="election_type" value="<?= htmlspecialchars($election['type']) ?>">
                        <div class="form-group">
                            <label for="student_id">Select Student</label>
                            <select name="student_id" id="student_id" class="form-control" required>
                                <option value="">Choose a student...</option>
                                <?php foreach ($availableStudents as $student): ?>
                                    <option value="<?= htmlspecialchars($student['student_id']) ?>">
                                        <?= htmlspecialchars($student['full_name']) ?> (<?= htmlspecialchars($student['student_id']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="add_candidate" class="btn btn--primary">Add Candidate</button>
                    </form>
                </div>
            </div>

            <!-- Candidates List -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Candidates (<?= count($candidates) ?>)</h3>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($candidates)): ?>
                                <?php foreach ($candidates as $candidate): ?>
                                    <tr>
                                        <td>
                                            <?php if ($candidate['photo']): ?>
                                                <img src="<?= htmlspecialchars($candidate['photo']) ?>" alt="Photo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                            <?php else: ?>
                                                <div style="width: 40px; height: 40px; border-radius: 50%; background: #ddd; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($candidate['student_id']) ?></td>
                                        <td><?= htmlspecialchars($candidate['full_name']) ?></td>
                                        <td><?= htmlspecialchars($candidate['class']) ?></td>
                                        <td><?= htmlspecialchars($candidate['email']) ?></td>
                                        <td>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="election_type" value="<?= htmlspecialchars($election['type']) ?>">
                                                <input type="hidden" name="student_id" value="<?= htmlspecialchars($candidate['student_id']) ?>">
                                                <button type="submit" name="remove_candidate" class="btn btn--icon" onclick="return confirm('Remove this candidate?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6">No candidates added yet</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <script src="/assets/js/admin.js"></script>
</body>
</html>