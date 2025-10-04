<?php
// Load DB config
require_once "../includes/config.php";

// -------------------------------
// 1. Get Student ID from URL
// -------------------------------
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid Student ID");
}
$student_id = (int) $_GET['id'];

// -------------------------------
// 2. Fetch Student Data
// -------------------------------
$sql = "SELECT * FROM students WHERE id = $student_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("❌ Student not found");
}

$student = mysqli_fetch_assoc($result);

// -------------------------------
// 3. Fetch Election History with Vote Counts and Positions
// -------------------------------
$sql = "
    SELECT 
        e.name,
        e.type as position,
        e.end_date as election_date,
        COALESCE(vote_counts.vote_count, 0) as votes,
        CASE 
            WHEN e.winner_student_id = '{$student['student_id']}' THEN 'Won'
            WHEN vote_counts.position = 2 THEN 'Runner Up'
            WHEN vote_counts.position IS NOT NULL THEN CONCAT('Position ', vote_counts.position)
            ELSE 'Participated'
        END as result
    FROM elections e
    INNER JOIN candidates c ON e.id = c.election_id
    LEFT JOIN (
        SELECT 
            v.election_id,
            v.vote_candidate_id,
            COUNT(*) as vote_count,
            RANK() OVER (PARTITION BY v.election_id ORDER BY COUNT(*) DESC) as position
        FROM votes v
        GROUP BY v.election_id, v.vote_candidate_id
    ) vote_counts ON c.election_id = vote_counts.election_id AND c.student_id = vote_counts.vote_candidate_id
    WHERE c.student_id = '{$student['student_id']}'
    ORDER BY e.end_date DESC
";

$elections = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Detail - EduVote</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="logo">
                <i class="fas fa-vote-yea"></i>
                <span>EduVote</span>
            </div>
        </div>
        <div class="header-center">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search..." class="form-control">
            </div>
        </div>
        <div class="header-right">
            <button class="notification-btn">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </button>
            <div class="profile-dropdown">
                <button class="profile-btn">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span>Admin User</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item"><i class="fas fa-user-circle"></i> Profile</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a href="/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li><a href="/admin" class="nav-link"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li><a href="/admin/classes.php" class="nav-link"><i class="fas fa-graduation-cap"></i><span>Class Management</span></a></li>
                <li><a href="/admin/students.php" class="nav-link active"><i class="fas fa-user-graduate"></i><span>Students</span></a></li>
                <li><a href="/admin/admins.php" class="nav-link"><i class="fas fa-users-cog"></i><span>Class Admins</span></a></li>
                <li><a href="/admin/elections.php" class="nav-link"><i class="fas fa-poll"></i><span>Elections</span></a></li>
                <li><a href="/admin/winners.php" class="nav-link"><i class="fas fa-trophy"></i><span>Election Winners</span></a></li>
                <li><a href="/admin/analytics.php" class="nav-link"><i class="fas fa-chart-bar"></i><span>Analytics</span></a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="breadcrumb">
            <a href="/admin" class="breadcrumb-item">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="/admin/students.php" class="breadcrumb-item">Students</a>
            <i class="fas fa-chevron-right"></i>
            <span class="breadcrumb-item active">Student Details</span>
        </div>

        <div class="student-profile">
            <div class="profile-header">
                <div class="profile-cover"></div>
                <div class="profile-info">
                    <div class="profile-avatar-large">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($student['full_name']); ?>&background=4a90e2&color=fff" alt="<?php echo htmlspecialchars($student['full_name']); ?>">
                    </div>
                    <div class="profile-details">
                        <h1><?php echo htmlspecialchars($student['full_name']); ?></h1>
                        <p class="student-id">Student ID: <?php echo htmlspecialchars($student['student_id']); ?></p>
                        <div class="profile-stats">
                            <div class="stat-item"><i class="fas fa-graduation-cap"></i> <span><?php echo htmlspecialchars($student['class']); ?></span></div>
                            <div class="stat-item"><i class="fas fa-envelope"></i> <span><?php echo htmlspecialchars($student['email']); ?></span></div>
                            <div class="stat-item"><i class="fas fa-phone"></i> <span><?php echo htmlspecialchars($student['phone']); ?></span></div>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <a href="/admin/editStudent?id=<?= $student_id ?>" class="btn btn--primary"><i class="fas fa-edit"></i> Edit Profile</a>
                        <button class="btn btn--outline"><i class="fas fa-envelope"></i> Send Message</button>
                    </div>
                </div>
            </div>

            <div class="profile-content">
                <div class="content-grid">
                    <!-- Personal Information -->
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Personal Information</h3>
                        </div>
                        <div class="card__body">
                            <div class="info-grid">
                                <div class="info-item"><label>Full Name</label><p><?php echo htmlspecialchars($student['full_name']); ?></p></div>
                                <div class="info-item"><label>Email</label><p><?php echo htmlspecialchars($student['email']); ?></p></div>
                                <div class="info-item"><label>Phone</label><p><?php echo htmlspecialchars($student['phone']); ?></p></div>
                                <div class="info-item"><label>Date of Birth</label><p><?php echo htmlspecialchars($student['dob']); ?></p></div>
                                <div class="info-item"><label>Gender</label><p><?php echo htmlspecialchars($student['gender']); ?></p></div>
                                <div class="info-item"><label>Address</label><p><?php echo htmlspecialchars($student['address']); ?></p></div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Academic Information</h3>
                        </div>
                        <div class="card__body">
                            <div class="info-grid">
                                <div class="info-item"><label>Department</label><p><?php echo htmlspecialchars($student['department']); ?></p></div>
                                <div class="info-item"><label>Class</label><p><?php echo htmlspecialchars($student['class']); ?></p></div>
                                <div class="info-item"><label>Admission Year</label><p><?php echo htmlspecialchars($student['admission_year']); ?></p></div>
                                <div class="info-item"><label>Current Semester</label><p><?php echo htmlspecialchars($student['semester']); ?></p></div>
                                <div class="info-item"><label>Status</label><span class="status status--success"><?php echo htmlspecialchars($student['status']); ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Election History -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Election History</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Election</th>
                                    <th>Position</th>
                                    <th>Date</th>
                                    <th>Result</th>
                                    <th>Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($elections && mysqli_num_rows($elections) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($elections)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['position']); ?></td>
                                            <td><?php echo date("M d, Y", strtotime($row['election_date'])); ?></td>
                                            <td>
                                                <span class="status 
                                                    <?php echo $row['result'] == 'Won' ? 'status--success' : ($row['result'] == 'Runner Up' ? 'status--warning' : 'status--error'); ?>">
                                                    <?php echo htmlspecialchars($row['result']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo (int) $row['votes']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="5">No elections found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
