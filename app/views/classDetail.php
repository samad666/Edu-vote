<?php
// Load DB config
require_once "../includes/config.php";

// -------------------------------
// 1. Get Class ID from URL
// -------------------------------
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid Class ID");
}
$class_id = (int) $_GET['id'];

// -------------------------------
// 2. Fetch Class Data
// -------------------------------
$sql = "SELECT * FROM class WHERE id = $class_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("❌ Class not found");
}

$class = mysqli_fetch_assoc($result);

// -------------------------------
// 3. Fetch Students in this Class
// -------------------------------
$students_sql = "SELECT * FROM students WHERE class = '" . mysqli_real_escape_string($conn, $class['class_name']) . "'";
$students = mysqli_query($conn, $students_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Detail - EduVote</title>
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
                <li><a href="/admin/classes.php" class="nav-link active"><i class="fas fa-graduation-cap"></i><span>Class Management</span></a></li>
                <li><a href="/admin/students.php" class="nav-link"><i class="fas fa-user-graduate"></i><span>Students</span></a></li>
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
            <a href="/admin/classes.php" class="breadcrumb-item">Classes</a>
            <i class="fas fa-chevron-right"></i>
            <span class="breadcrumb-item active">Class Details</span>
        </div>

        <div class="student-profile">
            <div class="profile-header">
                <div class="profile-cover"></div>
                <div class="profile-info">
                    <div class="profile-avatar-large">
                        <i class="fas fa-graduation-cap" style="font-size: 3rem; color: #4a90e2;"></i>
                    </div>
                    <div class="profile-details">
                        <h1><?php echo htmlspecialchars($class['class_name']); ?></h1>
                        <p class="student-id">Class Code: <?php echo htmlspecialchars($class['class_code']); ?></p>
                        <div class="profile-stats">
                            <div class="stat-item"><i class="fas fa-building"></i> <span><?php echo htmlspecialchars($class['department']); ?></span></div>
                            <div class="stat-item"><i class="fas fa-calendar"></i> <span>Semester <?php echo htmlspecialchars($class['semester']); ?></span></div>
                            <div class="stat-item"><i class="fas fa-clock"></i> <span><?php echo htmlspecialchars($class['acadamic_year']); ?></span></div>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="btn btn--primary"><i class="fas fa-edit"></i> Edit Class</button>
                        <button class="btn btn--outline"><i class="fas fa-users"></i> Manage Students</button>
                    </div>
                </div>
            </div>

            <div class="profile-content">
                <div class="content-grid">
                    <!-- Class Information -->
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Class Information</h3>
                        </div>
                        <div class="card__body">
                            <div class="info-grid">
                                <div class="info-item"><label>Class Name</label><p><?php echo htmlspecialchars($class['class_name']); ?></p></div>
                                <div class="info-item"><label>Class Code</label><p><?php echo htmlspecialchars($class['class_code']); ?></p></div>
                                <div class="info-item"><label>Department</label><p><?php echo htmlspecialchars($class['department']); ?></p></div>
                                <div class="info-item"><label>Semester</label><p><?php echo htmlspecialchars($class['semester']); ?></p></div>
                                <div class="info-item"><label>Academic Year</label><p><?php echo htmlspecialchars($class['acadamic_year']); ?></p></div>
                                <div class="info-item"><label>Profile</label><p><?php echo htmlspecialchars($class['profile']); ?></p></div>
                            </div>
                        </div>
                    </div>

                    <!-- Administrative Information -->
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Administrative Information</h3>
                        </div>
                        <div class="card__body">
                            <div class="info-grid">
                                <div class="info-item"><label>Admin ID</label><p><?php echo htmlspecialchars($class['adminId']); ?></p></div>
                                <div class="info-item"><label>Created By</label><p><?php echo htmlspecialchars($class['createdBy']); ?></p></div>
                                <div class="info-item"><label>Created At</label><p><?php echo htmlspecialchars($class['created_at']); ?></p></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students in Class -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Students in Class</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($students && mysqli_num_rows($students) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($students)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                            <td><a href="/admin/student?id=<?= $row['id'] ?>" class="detail-link"><?php echo htmlspecialchars($row['full_name']); ?></a></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td>
                                                <span class="status <?= $row['status'] === 'Active' ? 'status--success' : 'status--danger' ?>">
                                                    <?php echo htmlspecialchars($row['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="/admin/student?id=<?= $row['id'] ?>" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                                <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="5">No students found in this class</td></tr>
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