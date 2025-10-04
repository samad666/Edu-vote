<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduVote - Admin Panel</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
// Include configuration
include_once '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_type'])) {
    header('Location: /login');
    exit;
}

// Get user role and admin classes if class admin
$is_super_admin = $_SESSION['user_type'] === 'super_admin';
$admin_class_ids = [];

if (!$is_super_admin && $_SESSION['user_type'] === 'class_admin') {
    $admin_id = $_SESSION['admin_id'];
    $class_sql = "SELECT id FROM class WHERE adminId = ?";
    $class_stmt = mysqli_prepare($conn, $class_sql);
    mysqli_stmt_bind_param($class_stmt, "s", $admin_id);
    mysqli_stmt_execute($class_stmt);
    $class_result = mysqli_stmt_get_result($class_stmt);
    while ($class_row = mysqli_fetch_assoc($class_result)) {
        $admin_class_ids[] = $class_row['id'];
    }
}

// Set page-specific variables
setActivePage('dashboard');
setPageTitle('Admin Dashboard');
$additional_scripts = ['assets/js/charts.js'];

// Include header
include '../includes/header.php';

// Include sidebar  
include '../includes/sidebar.php';
?>

    <!-- Main Content -->
   <main class="main-content">
        <div class="breadcrumb">
            <span id="currentPage">Dashboard</span>
        </div>

        <!-- Dashboard Page -->
        <div id="dashboard" class="page-content active">
            <div class="page-header">
                <h1>Welcome to EduVote Admin Panel</h1>
                <p class="page-description">Manage your college election system efficiently</p>
            </div>

            <?php
            // Get real statistics from database with role-based filtering
            if ($is_super_admin) {
                $students_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM students"))['count'];
                $classes_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM class"))['count'];
                $elections_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections"))['count'];
                $active_elections = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections WHERE status = 'Active'"))['count'];
            } else {
                // Class admin - only their classes
                if (!empty($admin_class_ids)) {
                    $class_ids_str = implode(',', array_map('intval', $admin_class_ids));
                    $students_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM students WHERE class_id IN ($class_ids_str)"))['count'];
                    $classes_count = count($admin_class_ids);
                    $elections_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections WHERE class_id IN ($class_ids_str)"))['count'];
                    $active_elections = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections WHERE class_id IN ($class_ids_str) AND status = 'Active'"))['count'];
                } else {
                    $students_count = $classes_count = $elections_count = $active_elections = 0;
                }
            }
            ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-1">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= number_format($students_count) ?></h3>
                        <p>Total Students</p>
                        <span class="stat-change positive">Active</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-2">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $classes_count ?></h3>
                        <p>Classes</p>
                        <span class="stat-change positive"><?= $is_super_admin ? 'All' : 'My Classes' ?></span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-3">
                        <i class="fas fa-poll"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $elections_count ?></h3>
                        <p>Total Elections</p>
                        <span class="stat-change neutral"><?= $active_elections ?> Active</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-4">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $active_elections > 0 ? round(($active_elections / max($elections_count, 1)) * 100) : 0 ?>%</h3>
                        <p>Active Rate</p>
                        <span class="stat-change positive">Live</span>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <div class="content-card">
                    <div class="card-header">
                        <h3>Recent Elections</h3>
                        <button class="btn btn--outline btn--sm">View All</button>
                    </div>
                    <div class="elections-list">
                        <?php
                        require_once __DIR__ . '/../models/elections.php';
                        $recentElections = getElections(3, 0); // Get 3 most recent elections
                        if (!empty($recentElections)):
                            foreach ($recentElections as $election):
                        ?>
                        <div class="election-item">
                            <div class="election-info">
                                <h4><?= htmlspecialchars($election['name']) ?></h4>
                                <p><?= date('M j, Y', strtotime($election['start_date'])) ?> • <?= htmlspecialchars($election['type']) ?></p>
                            </div>
                            <span class="status <?= $election['status'] === 'Active' ? 'status--warning' : 'status--success' ?>">
                                <?= htmlspecialchars($election['status']) ?>
                            </span>
                        </div>
                        <?php
                            endforeach;
                        else:
                        ?>
                        <div class="election-item">
                            <div class="election-info">
                                <h4>No elections found</h4>
                                <p>Create your first election to get started</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="content-card">
                    <div class="card-header">
                        <h3>Quick Actions</h3>
                    </div>
                    <div class="quick-actions">
                        <a href="/admin/createElection" class="btn btn--primary btn--full-width">Create New Election</a>
                        <a href="/admin/create" class="btn btn--outline btn--full-width">Add Student</a>
                        <a href="/admin/createClass" class="btn btn--outline btn--full-width">Manage Classes</a>
                        <button class="btn btn--outline btn--full-width" onclick="exportReports()">Export Reports</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Page -->
        <div id="analytics" class="page-content">
            <div class="page-header">
                <h1>Analytics Dashboard</h1>
                <p class="page-description">Comprehensive insights and data visualization</p>
            </div>

            <?php
            // Get analytics statistics with role-based filtering
            if ($is_super_admin) {
                $admins_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM admins"))['count'];
                $winners_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections WHERE winner_student_id IS NOT NULL"))['count'];
            } else {
                $admins_count = 1; // Class admin can only see themselves
                if (!empty($admin_class_ids)) {
                    $class_ids_str = implode(',', array_map('intval', $admin_class_ids));
                    $winners_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections WHERE class_id IN ($class_ids_str) AND winner_student_id IS NOT NULL"))['count'];
                } else {
                    $winners_count = 0;
                }
            }
            ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-1">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= number_format($students_count) ?></h3>
                        <p>Students</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-2">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $classes_count ?></h3>
                        <p>Classes</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-3">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $admins_count ?></h3>
                        <p>Class Admins</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-4">
                        <i class="fas fa-poll"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $elections_count ?></h3>
                        <p>Elections</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-5">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $winners_count ?></h3>
                        <p>Winners</p>
                    </div>
                </div>
            </div>

            <?php
            // Get chart data with role-based filtering
            if ($is_super_admin) {
                $completed_elections = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections WHERE status = 'Completed'"))['count'];
                $inactive_elections = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections WHERE status = 'Inactive'"))['count'];
                $total_votes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM votes"))['count'];
            } else {
                if (!empty($admin_class_ids)) {
                    $class_ids_str = implode(',', array_map('intval', $admin_class_ids));
                    $completed_elections = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections WHERE class_id IN ($class_ids_str) AND status = 'Completed'"))['count'];
                    $inactive_elections = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM elections WHERE class_id IN ($class_ids_str) AND status = 'Inactive'"))['count'];
                    $total_votes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM votes v JOIN elections e ON v.election_id = e.id WHERE e.class_id IN ($class_ids_str)"))['count'];
                } else {
                    $completed_elections = $inactive_elections = $total_votes = 0;
                }
            }
            $participation_rate = $students_count > 0 ? round(($total_votes / $students_count) * 100) : 0;
            ?>
            <div class="charts-grid">
                <div class="chart-card">
                    <div class="card-header">
                        <h3>System Overview</h3>
                        <button class="btn btn--outline btn--sm" onclick="exportSystemData()">Export Data</button>
                    </div>
                    <div class="chart-container" style="position: relative; height: 400px;">
                        <canvas id="overviewChart"></canvas>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('overviewChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['Students', 'Classes', 'Elections', 'Admins'],
                                    datasets: [{
                                        data: [<?= $students_count ?>, <?= $classes_count ?>, <?= $elections_count ?>, <?= $admins_count ?>],
                                        backgroundColor: ['#4facfe', '#00f2fe', '#43e97b', '#38f9d7']
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { position: 'bottom' }
                                    }
                                }
                            });
                        });
                        </script>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="card-header">
                        <h3>Election Participation</h3>
                        <button class="btn btn--outline btn--sm" onclick="showParticipationDetails()">Details</button>
                    </div>
                    <div class="chart-container" style="position: relative; height: 400px;">
                        <canvas id="participationChart"></canvas>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx2 = document.getElementById('participationChart').getContext('2d');
                            new Chart(ctx2, {
                                type: 'bar',
                                data: {
                                    labels: ['Active', 'Completed', 'Inactive', 'Total Votes'],
                                    datasets: [{
                                        label: 'Count',
                                        data: [<?= $active_elections ?>, <?= $completed_elections ?>, <?= $inactive_elections ?>, <?= $total_votes ?>],
                                        backgroundColor: ['#43e97b', '#4facfe', '#ffa726', '#ff6b6b']
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: { beginAtZero: true }
                                    }
                                }
                            });
                        });
                        </script>
                    </div>
                </div>
            </div>

            <div class="activity-card">
                <div class="card-header">
                    <h3>Recent Activity</h3>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon bg-3">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h4>New student registered</h4>
                            <p>John Doe joined Computer Science A</p>
                        </div>
                        <span class="activity-time">2 minutes ago</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-4">
                            <i class="fas fa-poll-h"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Election result published</h4>
                            <p>Sports Captain Election results are now live</p>
                        </div>
                        <span class="activity-time">15 minutes ago</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-2">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Class admin updated</h4>
                            <p>Prof. Smith updated class information</p>
                        </div>
                        <span class="activity-time">1 hour ago</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Pages (placeholder content) -->
        <div id="classes" class="page-content">
            <div class="page-header">
                <h1>Class Management</h1>
                <p class="page-description">Manage all classes and their information</p>
            </div>
            <div class="content-card">
                <div class="card-header">
                    <h3>Class List</h3>
                        <a href="http://localhost:4000/admin/createClass" class="btn btn--primary btn--sm">Add New Class</a>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Class Code</th>
                                <th>Class Name</th>
                                <th>Department</th>
                                <th>Students</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                require_once  __DIR__ . '/../models/classes.php';
                                
                                // Pagination logic
                                $perPage = 10;
                                $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                                $offset = ($page - 1) * $perPage;
                                
                                // Fetch data with role-based filtering
                                if ($is_super_admin) {
                                    $classes = getClasses($perPage, $offset);
                                } else {
                                    // Class admin - only show their classes
                                    if (!empty($admin_class_ids)) {
                                        $class_ids_str = implode(',', array_map('intval', $admin_class_ids));
                                        $classes_sql = "SELECT * FROM class WHERE id IN ($class_ids_str) LIMIT $perPage OFFSET $offset";
                                        $classes_result = mysqli_query($conn, $classes_sql);
                                        $classes = mysqli_fetch_all($classes_result, MYSQLI_ASSOC);
                                    } else {
                                        $classes = [];
                                    }
                                }
                                
                                if (!empty($classes)) :
                                    foreach ($classes as $row):
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['class_code'] ?? $row['id']) ?></td>
                                    <td><a href="/admin/class?id=<?= $row['id'] ?>" class="detail-link"><?= htmlspecialchars($row['class_name'] ?? $row['name']) ?></a></td>
                                    <td><?= htmlspecialchars($row['department'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['student_count'] ?? '0') ?></td>
                                    <td>
                                        <span class="status <?= ($row['status'] ?? 'Active') === 'Active' ? 'status--success' : 'status--danger' ?>">
                                            <?= htmlspecialchars($row['status'] ?? 'Active') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/admin/class?id=<?= $row['id'] ?>" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn--icon"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php
                                    endforeach;
                                else:
                            ?>
                                <tr><td colspan="6">No classes found</td></tr>
                            <?php
                                endif;
                            } catch (Exception $e) {
                                // Fallback to dummy data if model fails
                            ?>
                                <tr>
                                    <td>CSA-2024</td>
                                    <td><a href="/admin/class" class="detail-link">Computer Science A</a></td>
                                    <td>Computer Science</td>
                                    <td>35</td>
                                    <td><span class="status status--success">Active</span></td>
                                    <td>
                                        <a href="/admin/class" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn--icon"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="students" class="page-content">
            <div class="page-header">
                <h1>Students</h1>
                <p class="page-description">Manage student records and information</p>
            </div>
            <div class="content-card">
                <div class="card-header">
                    <h3>Student List</h3>
                    <a href="http://localhost:4000/admin/create" class="btn btn--primary btn--sm">
    Add New Student
</a>
                    <!-- <button type='submit' class="btn btn--primary btn--sm" action='/admin/create'>Add New Student</button> -->
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?php
require_once  __DIR__ . '/../models/students.php';

// Pagination logic
$perPage = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Fetch data with role-based filtering
if ($is_super_admin) {
    $students = getStudents($perPage, $offset);
    $totalStudents = getStudentCount();
} else {
    // Class admin - only show students from their classes
    if (!empty($admin_class_ids)) {
        $class_ids_str = implode(',', array_map('intval', $admin_class_ids));
        $students_sql = "SELECT s.*, c.class_name as class FROM students s LEFT JOIN class c ON s.class_id = c.id WHERE s.class_id IN ($class_ids_str) LIMIT $perPage OFFSET $offset";
        $students_result = mysqli_query($conn, $students_sql);
        $students = mysqli_fetch_all($students_result, MYSQLI_ASSOC);
        
        $count_sql = "SELECT COUNT(*) as count FROM students WHERE class_id IN ($class_ids_str)";
        $count_result = mysqli_query($conn, $count_sql);
        $totalStudents = mysqli_fetch_assoc($count_result)['count'];
    } else {
        $students = [];
        $totalStudents = 0;
    }
}
$totalPages = ceil($totalStudents / $perPage);
?>

<tbody>
<?php if (!empty($students)) : ?>
    <?php foreach ($students as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['student_id']) ?></td>
            <td><a href="/admin/student?id=<?= $row['id'] ?>" class="student-link"><?= htmlspecialchars($row['full_name']) ?></a></td>
            <td><?= htmlspecialchars($row['class']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <span class="status <?= $row['status'] === 'Active' ? 'status--success' : 'status--danger' ?>">
                    <?= htmlspecialchars($row['status']) ?>
                </span>
            </td>
            <td>
                <a href="/admin/student?id=<?= $row['id'] ?>" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                <button class="btn btn--icon"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="6">No students found</td></tr>
<?php endif; ?>
</tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="admins" class="page-content">
            <div class="page-header">
                <h1>Class Admins</h1>
                <p class="page-description">Manage class administrators and permissions</p>
            </div>
            <div class="content-card">
                <div class="card-header">
                    <h3>Class Administrators</h3>
                    <a href="http://localhost:4000/admin/createAdmin" class="btn btn--primary btn--sm">Add New Admin</a>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?php
require_once  __DIR__ . '/../models/admins.php';

// Pagination logic
$perPage = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Fetch data - only super admin can see other admins
if ($is_super_admin) {
    $admins = getAdmins($perPage, $offset);
    $totalAdmins = getAdminCount();
} else {
    $admins = [];
    $totalAdmins = 0;
}
$totalPages = ceil($totalAdmins / $perPage);
?>

<tbody>
<?php if (!empty($admins)) : ?>
    <?php foreach ($admins as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['admin_id']) ?></td>
            <td><a href="/admin/admin?id=<?= $row['id'] ?>" class="detail-link"><?= htmlspecialchars($row['full_name']) ?></a></td>
            <td><?= htmlspecialchars($row['department']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td>
                <span class="status <?= $row['status'] === 'Active' ? 'status--success' : 'status--danger' ?>">
                    <?= htmlspecialchars($row['status']) ?>
                </span>
            </td>
            <td>
                <a href="/admin/adminDetail?id=<?= $row['id'] ?>" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                <button class="btn btn--icon"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="6">No admins found</td></tr>
<?php endif; ?>
</tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="elections" class="page-content">
            <div class="page-header">
                <h1>Elections</h1>
                <p class="page-description">Create and manage elections</p>
            </div>
            <div class="content-card">
                <div class="card-header">
                    <h3>Active Elections</h3>
                    <a href="/admin/createElection" class="btn btn--primary btn--sm">Create New Election</a>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Class</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                require_once  __DIR__ . '/../models/elections.php';
                                
                                // Pagination logic
                                $perPage = 10;
                                $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                                $offset = ($page - 1) * $perPage;
                                
                                // Fetch data with role-based filtering
                                if ($is_super_admin) {
                                    $elections = getElections($perPage, $offset);
                                } else {
                                    // Class admin - only show elections for their classes
                                    if (!empty($admin_class_ids)) {
                                        $class_ids_str = implode(',', array_map('intval', $admin_class_ids));
                                        $elections_sql = "SELECT * FROM elections WHERE class_id IN ($class_ids_str) LIMIT $perPage OFFSET $offset";
                                        $elections_result = mysqli_query($conn, $elections_sql);
                                        $elections = mysqli_fetch_all($elections_result, MYSQLI_ASSOC);
                                    } else {
                                        $elections = [];
                                    }
                                }
                                
                                if (!empty($elections)) :
                                    foreach ($elections as $row):
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['type']) ?></td>
                                    <td><a href="/admin/election?id=<?= $row['id'] ?>" class="detail-link"><?= htmlspecialchars($row['name']) ?></a></td>
                                    <td><?= htmlspecialchars($row['scope']) ?></td>
                                    <td><?= date('M j, Y', strtotime($row['end_date'])) ?></td>
                                    <td>
                                        <span class="status <?= $row['status'] === 'Active' ? 'status--success' : ($row['status'] === 'Completed' ? 'status--warning' : 'status--danger') ?>">
                                            <?= htmlspecialchars($row['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/admin/election?id=<?= $row['id'] ?>" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn--icon"><i class="fas fa-chart-bar"></i></button>
                                    </td>
                                </tr>
                            <?php
                                    endforeach;
                                else:
                            ?>
                                <tr><td colspan="6">No elections found</td></tr>
                            <?php
                                endif;
                            } catch (Exception $e) {
                                // Fallback to dummy data if model fails
                            ?>
                                <tr>
                                    <td>EL001</td>
                                    <td><a href="/admin/election" class="detail-link">Student Body President</a></td>
                                    <td>All Classes</td>
                                    <td>Mar 20, 2024</td>
                                    <td><span class="status status--warning">Ongoing</span></td>
                                    <td>
                                        <a href="/admin/election" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn--icon"><i class="fas fa-chart-bar"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="winners" class="page-content">
            <div class="page-header">
                <h1>Election Winners</h1>
                <p class="page-description">View and manage election results</p>
            </div>
            <div class="content-card">
                <div class="card-header">
                    <h3>Recent Winners</h3>
                    <button class="btn btn--primary btn--sm">View All Winners</button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Election</th>
                                <th>Winner</th>
                                <th>Position</th>
                                <th>Votes</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Get elections with winners
                            $winners_sql = "SELECT e.name, e.type, e.end_date, e.winner_student_id, s.full_name as winner_name, s.student_id 
                                          FROM elections e 
                                          LEFT JOIN students s ON e.winner_student_id = s.student_id 
                                          WHERE e.winner_student_id IS NOT NULL 
                                          ORDER BY e.end_date DESC 
                                          LIMIT 10";
                            $winners_result = mysqli_query($conn, $winners_sql);
                            
                            if ($winners_result && mysqli_num_rows($winners_result) > 0):
                                while ($winner = mysqli_fetch_assoc($winners_result)):
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($winner['name']) ?></td>
                                <td><a href="/admin/student?id=<?= htmlspecialchars($winner['student_id']) ?>" class="detail-link"><?= htmlspecialchars($winner['winner_name'] ?? 'Unknown Student') ?></a></td>
                                <td><?= htmlspecialchars($winner['type']) ?></td>
                                <td>-</td>
                                <td><?= date('M j, Y', strtotime($winner['end_date'])) ?></td>
                                <td>
                                    <a href="/admin/student?id=<?= htmlspecialchars($winner['student_id']) ?>" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-certificate"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-share"></i></button>
                                </td>
                            </tr>
                            <?php
                                endwhile;
                            else:
                            ?>
                            <tr>
                                <td colspan="6">No election winners found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

<?php
// Include footer
include '../includes/footer.php';
?>
<script src="assets/js/admin.js"></script>
<script>
function exportReports() {
    alert('Export Reports functionality will be implemented soon!');
    // TODO: Implement export functionality
}

function exportSystemData() {
    const data = {
        students: <?= $students_count ?>,
        classes: <?= $classes_count ?>,
        elections: <?= $elections_count ?>,
        admins: <?= $admins_count ?>
    };
    const dataStr = JSON.stringify(data, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    const url = URL.createObjectURL(dataBlob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'system_overview.json';
    link.click();
}

function showParticipationDetails() {
    alert(`Participation Details:\n\nActive Elections: <?= $active_elections ?>\nCompleted Elections: <?= $completed_elections ?>\nInactive Elections: <?= $inactive_elections ?>\nTotal Votes Cast: <?= $total_votes ?>\nParticipation Rate: <?= $participation_rate ?>%`);
}
</script>
</body>
</html>


