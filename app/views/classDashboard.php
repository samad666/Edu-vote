<?php
session_start();
require_once '../includes/config.php';

// Check if user is logged in as class admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'class_admin') {
    header('Location: /login');
    exit;
}

$admin_id = $_SESSION['admin_id'];

// Get admin's classes
$classes_sql = "SELECT * FROM class WHERE admin_id = ?";
$classes_stmt = mysqli_prepare($conn, $classes_sql);
mysqli_stmt_bind_param($classes_stmt, "s", $admin_id);
mysqli_stmt_execute($classes_stmt);
$classes_result = mysqli_stmt_get_result($classes_stmt);
$classes = mysqli_fetch_all($classes_result, MYSQLI_ASSOC);

// Get stats for admin's classes
$class_ids = array_column($classes, 'id');
$class_ids_str = implode(',', array_map('intval', $class_ids));

$stats = [
    'total_classes' => count($classes),
    'total_students' => 0,
    'total_elections' => 0,
    'active_elections' => 0
];

if (!empty($class_ids)) {
    // Count students
    $students_sql = "SELECT COUNT(*) as count FROM students WHERE class_id IN ($class_ids_str)";
    $students_result = mysqli_query($conn, $students_sql);
    $stats['total_students'] = mysqli_fetch_assoc($students_result)['count'];
    
    // Count elections
    $elections_sql = "SELECT COUNT(*) as count FROM elections WHERE class_id IN ($class_ids_str)";
    $elections_result = mysqli_query($conn, $elections_sql);
    $stats['total_elections'] = mysqli_fetch_assoc($elections_result)['count'];
    
    // Count active elections
    $active_elections_sql = "SELECT COUNT(*) as count FROM elections WHERE class_id IN ($class_ids_str) AND status = 'Active'";
    $active_elections_result = mysqli_query($conn, $active_elections_sql);
    $stats['active_elections'] = mysqli_fetch_assoc($active_elections_result)['count'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Admin Dashboard - EduVote</title>
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
        <div class="header-right">
            <div class="profile-dropdown">
                <button class="profile-btn">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span><?= htmlspecialchars($_SESSION['username']) ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu">
                    <a href="/logout" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li><a href="/admin/class-dashboard" class="nav-link active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li><a href="#" onclick="showSection('classes')" class="nav-link"><i class="fas fa-graduation-cap"></i><span>My Classes</span></a></li>
                <li><a href="#" onclick="showSection('students')" class="nav-link"><i class="fas fa-user-graduate"></i><span>Students</span></a></li>
                <li><a href="#" onclick="showSection('elections')" class="nav-link"><i class="fas fa-poll"></i><span>Elections</span></a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="breadcrumb">
            <span id="currentPage">Class Admin Dashboard</span>
        </div>

        <!-- Dashboard Section -->
        <div id="dashboard" class="page-content active">
            <div class="page-header">
                <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
                <p class="page-description">Manage your classes and elections</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-1">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $stats['total_classes'] ?></h3>
                        <p>My Classes</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-2">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $stats['total_students'] ?></h3>
                        <p>Total Students</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-3">
                        <i class="fas fa-poll"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $stats['total_elections'] ?></h3>
                        <p>Total Elections</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $stats['active_elections'] ?></h3>
                        <p>Active Elections</p>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <div class="content-card">
                    <div class="card-header">
                        <h3>My Classes</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Students</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($classes as $class): ?>
                                <tr>
                                    <td><?= htmlspecialchars($class['class_name']) ?></td>
                                    <td>
                                        <?php
                                        $student_count_sql = "SELECT COUNT(*) as count FROM students WHERE class_id = ?";
                                        $student_count_stmt = mysqli_prepare($conn, $student_count_sql);
                                        mysqli_stmt_bind_param($student_count_stmt, "i", $class['id']);
                                        mysqli_stmt_execute($student_count_stmt);
                                        $student_count = mysqli_fetch_assoc(mysqli_stmt_get_result($student_count_stmt))['count'];
                                        echo $student_count;
                                        ?>
                                    </td>
                                    <td><span class="status status--success">Active</span></td>
                                    <td>
                                        <button class="btn btn--icon" onclick="viewClass(<?= $class['id'] ?>)"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes Section -->
        <div id="classes" class="page-content">
            <div class="page-header">
                <h1>My Classes</h1>
            </div>
            <div class="content-card">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Class Code</th>
                                <th>Class Name</th>
                                <th>Department</th>
                                <th>Students</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($classes as $class): ?>
                            <tr>
                                <td><?= htmlspecialchars($class['class_code'] ?? $class['id']) ?></td>
                                <td><?= htmlspecialchars($class['class_name']) ?></td>
                                <td><?= htmlspecialchars($class['department'] ?? 'N/A') ?></td>
                                <td>
                                    <?php
                                    $student_count_sql = "SELECT COUNT(*) as count FROM students WHERE class_id = ?";
                                    $student_count_stmt = mysqli_prepare($conn, $student_count_sql);
                                    mysqli_stmt_bind_param($student_count_stmt, "i", $class['id']);
                                    mysqli_stmt_execute($student_count_stmt);
                                    $student_count = mysqli_fetch_assoc(mysqli_stmt_get_result($student_count_stmt))['count'];
                                    echo $student_count;
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn--icon"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-users"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Students Section -->
        <div id="students" class="page-content">
            <div class="page-header">
                <h1>My Students</h1>
            </div>
            <div class="content-card">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($class_ids)): ?>
                                <?php
                                $students_sql = "SELECT s.*, c.class_name FROM students s 
                                               LEFT JOIN class c ON s.class_id = c.id 
                                               WHERE s.class_id IN ($class_ids_str) 
                                               ORDER BY s.full_name";
                                $students_result = mysqli_query($conn, $students_sql);
                                while ($student = mysqli_fetch_assoc($students_result)):
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['student_id']) ?></td>
                                    <td><?= htmlspecialchars($student['full_name']) ?></td>
                                    <td><?= htmlspecialchars($student['class_name']) ?></td>
                                    <td><?= htmlspecialchars($student['email']) ?></td>
                                    <td><span class="status status--success"><?= htmlspecialchars($student['status']) ?></span></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Elections Section -->
        <div id="elections" class="page-content">
            <div class="page-header">
                <h1>My Elections</h1>
            </div>
            <div class="content-card">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Election Name</th>
                                <th>Type</th>
                                <th>Class</th>
                                <th>Status</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($class_ids)): ?>
                                <?php
                                $elections_sql = "SELECT e.*, c.class_name FROM elections e 
                                                LEFT JOIN class c ON e.class_id = c.id 
                                                WHERE e.class_id IN ($class_ids_str) 
                                                ORDER BY e.start_date DESC";
                                $elections_result = mysqli_query($conn, $elections_sql);
                                while ($election = mysqli_fetch_assoc($elections_result)):
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($election['name']) ?></td>
                                    <td><?= htmlspecialchars($election['type']) ?></td>
                                    <td><?= htmlspecialchars($election['class_name']) ?></td>
                                    <td>
                                        <span class="status <?= $election['status'] === 'Active' ? 'status--success' : 'status--warning' ?>">
                                            <?= htmlspecialchars($election['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M j, Y', strtotime($election['end_date'])) ?></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.page-content').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionId).classList.add('active');
            
            // Update breadcrumb
            const breadcrumb = document.getElementById('currentPage');
            const titles = {
                'dashboard': 'Class Admin Dashboard',
                'classes': 'My Classes',
                'students': 'My Students',
                'elections': 'My Elections'
            };
            breadcrumb.textContent = titles[sectionId] || 'Dashboard';
            
            // Update active nav link
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            event.target.closest('.nav-link').classList.add('active');
        }

        function viewClass(classId) {
            // Implement class view functionality
            alert('View class details for ID: ' + classId);
        }
    </script>
</body>
</html>