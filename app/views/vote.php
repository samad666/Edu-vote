<?php
require_once '../includes/config.php';

// Get election ID and token from URL
$election_id = isset($_GET['electionId']) ? (int)$_GET['electionId'] : 0;
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (!$election_id || !$token) {
    die("Invalid voting link");
}

// Verify token and get student info (simplified - you'd implement proper token validation)
$student_sql = "SELECT * FROM students WHERE MD5(CONCAT(student_id, '$election_id')) = '$token' LIMIT 1";
$student_result = mysqli_query($conn, $student_sql);

if (!$student_result || mysqli_num_rows($student_result) === 0) {
    die("Invalid or expired voting token");
}

$student = mysqli_fetch_assoc($student_result);

// Check if student already voted
$vote_check_sql = "SELECT id FROM votes WHERE student_id = '{$student['student_id']}' AND election_id = $election_id";
$vote_check = mysqli_query($conn, $vote_check_sql);

if (mysqli_num_rows($vote_check) > 0) {
    $already_voted = true;
} else {
    $already_voted = false;
}

// Get election details
$election_sql = "SELECT e.*, c.class_name FROM elections e LEFT JOIN class c ON e.class_id = c.id WHERE e.id = $election_id";
$election_result = mysqli_query($conn, $election_sql);
$election = mysqli_fetch_assoc($election_result);

// Get candidates
    require_once __DIR__ . '/../models/candidates.php';

$candidates = getCandidatesByElection($election['type']);

// Handle vote submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$already_voted) {
    $candidate_id = (int)$_POST['candidate_id'];
    
    $vote_sql = "INSERT INTO votes (student_id, election_id, vote_candidate_id) VALUES ('{$student['student_id']}', $election_id, $candidate_id)";
    
    if (mysqli_query($conn, $vote_sql)) {
        $vote_success = true;
        $already_voted = true;
    } else {
        $vote_error = "Failed to record your vote. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote - <?= htmlspecialchars($election['name']) ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .election-info {
            background: #f8f9fa;
            padding: 30px;
            border-bottom: 1px solid #e9ecef;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .info-item i {
            font-size: 2rem;
            color: #4facfe;
            margin-bottom: 10px;
        }

        .info-item h3 {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .info-item p {
            color: #666;
            font-size: 0.9rem;
        }

        .voting-section {
            padding: 40px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 10px;
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
        }

        .candidates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .candidate-card {
            background: white;
            border: 3px solid #e9ecef;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .candidate-card:hover {
            border-color: #4facfe;
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(79, 172, 254, 0.2);
        }

        .candidate-card.selected {
            border-color: #4facfe;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .candidate-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            overflow: hidden;
            border: 4px solid #e9ecef;
        }

        .candidate-card.selected .candidate-photo {
            border-color: white;
        }

        .candidate-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .candidate-photo .default-avatar {
            width: 100%;
            height: 100%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #adb5bd;
        }

        .candidate-info h3 {
            font-size: 1.4rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .candidate-info p {
            margin-bottom: 8px;
            opacity: 0.8;
        }

        .vote-button {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 0 auto;
            min-width: 200px;
        }

        .vote-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
        }

        .vote-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .success-message, .error-message {
            text-align: center;
            padding: 30px;
            margin: 20px;
            border-radius: 12px;
            font-size: 1.1rem;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .already-voted {
            text-align: center;
            padding: 60px 40px;
        }

        .already-voted i {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 20px;
        }

        .already-voted h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .already-voted p {
            color: #666;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .candidates-grid {
                grid-template-columns: 1fr;
            }
            
            .candidate-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-vote-yea"></i> EduVote</h1>
            <p>Secure Digital Voting Platform</p>
        </div>

        <div class="election-info">
            <div class="info-grid">
                <div class="info-item">
                    <i class="fas fa-poll"></i>
                    <h3><?= htmlspecialchars($election['name']) ?></h3>
                    <p>Election Title</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-graduation-cap"></i>
                    <h3><?= htmlspecialchars($election['class_name'] ?? 'All Classes') ?></h3>
                    <p>Scope</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar"></i>
                    <h3><?= date('M j, Y', strtotime($election['end_date'])) ?></h3>
                    <p>Ends On</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-user"></i>
                    <h3><?= htmlspecialchars($student['full_name']) ?></h3>
                    <p>Voter</p>
                </div>
            </div>
        </div>

        <?php if (isset($vote_success)): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <strong>Vote Recorded Successfully!</strong><br>
                Thank you for participating in the election.
            </div>
        <?php endif; ?>

        <?php if (isset($vote_error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i>
                <?= $vote_error ?>
            </div>
        <?php endif; ?>

        <?php if ($already_voted): ?>
            <div class="already-voted">
                <i class="fas fa-check-circle"></i>
                <h2>You have already voted!</h2>
                <p>Thank you for participating in this election. Your vote has been recorded securely.</p>
            </div>
        <?php else: ?>
            <div class="voting-section">
                <div class="section-title">
                    <h2>Choose Your Candidate</h2>
                    <p>Click on a candidate to select them, then click "Cast Vote" to submit your choice</p>
                </div>

                <form method="POST" id="voteForm">
                    <div class="candidates-grid">
                        <?php foreach ($candidates as $candidate): ?>
                            <div class="candidate-card" onclick="selectCandidate(<?= $candidate['id'] ?>)">
                                <div class="candidate-photo">
                                    <?php if ($candidate['photo']): ?>
                                        <img src="<?= htmlspecialchars($candidate['photo']) ?>" alt="<?= htmlspecialchars($candidate['full_name']) ?>">
                                    <?php else: ?>
                                        <div class="default-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="candidate-info">
                                    <h3><?= htmlspecialchars($candidate['full_name']) ?></h3>
                                    <p><i class="fas fa-id-card"></i> <?= htmlspecialchars($candidate['student_id']) ?></p>
                                    <p><i class="fas fa-graduation-cap"></i> <?= htmlspecialchars($candidate['class']) ?></p>
                                    <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($candidate['email']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <input type="hidden" name="candidate_id" id="selectedCandidate" value="">
                    <button type="submit" class="vote-button" id="voteButton" disabled>
                        <i class="fas fa-vote-yea"></i> Cast Your Vote
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script>
        let selectedCandidateId = null;

        function selectCandidate(candidateId) {
            // Remove previous selection
            document.querySelectorAll('.candidate-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selection to clicked card
            event.currentTarget.classList.add('selected');
            
            // Update form
            selectedCandidateId = candidateId;
            document.getElementById('selectedCandidate').value = candidateId;
            document.getElementById('voteButton').disabled = false;
        }

        // Confirm vote submission
        document.getElementById('voteForm').addEventListener('submit', function(e) {
            if (!selectedCandidateId) {
                e.preventDefault();
                alert('Please select a candidate before voting.');
                return;
            }

            if (!confirm('Are you sure you want to cast your vote? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>