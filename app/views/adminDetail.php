<?php
// Load DB config
require_once "../includes/config.php";

// -------------------------------
// 1. Get Admin ID from URL
// -------------------------------
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid Admin ID");
}
$admin_id = (int) $_GET['id'];

// -------------------------------
// 2. Fetch Admin Data
// -------------------------------
$sql = "SELECT * FROM admins WHERE id = $admin_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("❌ Admin not found");
}

$admin = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Detail - EduVote</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php
// Include configuration
require_once  '../includes/config.php';

// // Set page-specific variables
setActivePage('winners');   // <-- FIXED, was 'dashboard'
setPageTitle('Winner Details');
$additional_scripts = ['assets/js/charts.js'];

// Include header
include '../includes/header.php';

// Include sidebar  
include '../includes/sidebar.php';
?>
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
                <li><a href="/admin/students.php" class="nav-link"><i class="fas fa-user-graduate"></i><span>Students</span></a></li>
                <li><a href="/admin/admins.php" class="nav-link active"><i class="fas fa-users-cog"></i><span>Class Admins</span></a></li>
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
            <a href="/admin/admins.php" class="breadcrumb-item">Class Admins</a>
            <i class="fas fa-chevron-right"></i>
            <span class="breadcrumb-item active">Admin Details</span>
        </div>

        <div class="student-profile">
            <div class="profile-header">
                <div class="profile-cover"></div>
                <div class="profile-info">
                    <div class="profile-avatar-large">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($admin['full_name']); ?>&background=4a90e2&color=fff" alt="<?php echo htmlspecialchars($admin['full_name']); ?>">
                    </div>
                    <div class="profile-details">
                        <h1><?php echo htmlspecialchars($admin['full_name']); ?></h1>
                        <p class="student-id">Admin ID: <?php echo htmlspecialchars($admin['admin_id']); ?></p>
                        <div class="profile-stats">
                            <div class="stat-item"><i class="fas fa-briefcase"></i> <span><?php echo htmlspecialchars($admin['role']); ?></span></div>
                            <div class="stat-item"><i class="fas fa-building"></i> <span><?php echo htmlspecialchars($admin['department']); ?></span></div>
                            <div class="stat-item"><i class="fas fa-envelope"></i> <span><?php echo htmlspecialchars($admin['email']); ?></span></div>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="btn btn--primary"><i class="fas fa-edit"></i> Edit Profile</button>
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
                                <div class="info-item"><label>Full Name</label><p><?php echo htmlspecialchars($admin['full_name']); ?></p></div>
                                <div class="info-item"><label>Email</label><p><?php echo htmlspecialchars($admin['email']); ?></p></div>
                                <div class="info-item"><label>Admin ID</label><p><?php echo htmlspecialchars($admin['admin_id']); ?></p></div>
                                <div class="info-item"><label>Join Date</label><p><?php echo htmlspecialchars($admin['join_date']); ?></p></div>
                                <div class="info-item"><label>Status</label><span class="status status--success"><?php echo htmlspecialchars($admin['status']); ?></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Professional Information</h3>
                        </div>
                        <div class="card__body">
                            <div class="info-grid">
                                <div class="info-item"><label>Role</label><p><?php echo htmlspecialchars($admin['role']); ?></p></div>
                                <div class="info-item"><label>Department</label><p><?php echo htmlspecialchars($admin['department']); ?></p></div>
                                <div class="info-item"><label>Join Date</label><p><?php echo htmlspecialchars($admin['join_date']); ?></p></div>
                                <div class="info-item"><label>Status</label><span class="status status--success"><?php echo htmlspecialchars($admin['status']); ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="/assets/js/admin.js"></script>
</body>
</html>