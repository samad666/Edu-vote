<?php
require_once '../includes/config.php';

// Get Election ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid Election ID");
}
$election_id = (int) $_GET['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $scope = mysqli_real_escape_string($conn, $_POST['scope']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $profile = mysqli_real_escape_string($conn, $_POST['profile']);
    $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
    
    $sql = "UPDATE elections SET type='$type', scope='$scope', name='$name', start_date='$start_date', end_date='$end_date', status='$status', profile='$profile', class_id='$class_id' WHERE id=$election_id";
    
    if (mysqli_query($conn, $sql)) {
        $success = "Election updated successfully!";
    } else {
        $error = "Failed to update election.";
    }
}

// Fetch Election Data
$sql = "SELECT * FROM elections WHERE id = $election_id LIMIT 1";
$result = mysqli_query($conn, $sql);
$election = mysqli_fetch_assoc($result);

// Fetch classes for dropdown
$classes_sql = "SELECT id, class_name FROM class ORDER BY class_name";
$classes_result = mysqli_query($conn, $classes_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Election - EduVote</title>
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
            <span class="breadcrumb-item active">Edit Election</span>
        </div>

        <div class="page-header">
            <h1>Edit Election</h1>
            <p class="page-description">Update election details</p>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert--success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert--error"><?= $error ?></div>
        <?php endif; ?>

        <div class="content-card">
            <form method="POST" class="form">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="type">Election Type</label>
                        <input type="text" id="type" name="type" class="form-control" value="<?= htmlspecialchars($election['type']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="scope">Scope</label>
                        <input type="text" id="scope" name="scope" class="form-control" value="<?= htmlspecialchars($election['scope']) ?>" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="name">Election Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($election['name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="datetime-local" id="start_date" name="start_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($election['start_date'])) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="datetime-local" id="end_date" name="end_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($election['end_date'])) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="Active" <?= $election['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                            <option value="Inactive" <?= $election['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="Completed" <?= $election['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="profile">Profile</label>
                        <input type="text" id="profile" name="profile" class="form-control" value="<?= htmlspecialchars($election['profile']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="class_id">Class</label>
                        <select id="class_id" name="class_id" class="form-control" required>
                            <option value="">Select Class</option>
                            <?php while ($class = mysqli_fetch_assoc($classes_result)): ?>
                                <option value="<?= $class['id'] ?>" <?= $election['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($class['class_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Update Election</button>
                    <a href="/admin/election?id=<?= $election_id ?>" class="btn btn--outline">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <script src="/assets/js/admin.js"></script>
</body>
</html>