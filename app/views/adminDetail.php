<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduVote - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php
// Include configuration
include 'includes/config.php';

// // Set page-specific variables
setActivePage('winners');   // <-- FIXED, was 'dashboard'
setPageTitle('Winner Details');
$additional_scripts = ['assets/js/charts.js'];

// Include header
include '../includes/header.php';

// Include sidebar  
include '../includes/sidebar.php';
?>



<div class="main-content">
<div class="admin-layout">
    <?php include $root . '/includes/sidebar.php'; ?>
    
    <main class="admin-main">
        <div class="detail-header">
            <div class="breadcrumb">
                <a href="/admin/dashboard">Dashboard</a>
                <span class="separator">/</span>
                <a href="/admin/administrators">Administrators</a>
                <span class="separator">/</span>
                <span class="current">Prof. Robert Wilson</span>
            </div>
        </div>

        <div class="profile-header">
            <div class="profile-info">
                <h1>Prof. Robert Wilson</h1>
                <div class="profile-meta">
                    <span class="meta-item">
                        <i class="fas fa-id-badge"></i>
                        ADM-001
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-envelope"></i>
                        robert.wilson@example.com
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-building"></i>
                        Computer Science Department
                    </span>
                    <span class="status status--success">Active</span>
                </div>
            </div>
            <div class="profile-actions">
                <button class="btn btn--primary">Edit Profile</button>
                <button class="btn btn--outline">Reset Password</button>
            </div>
        </div>

        <div class="profile-content">
            <div class="content-grid">
                <!-- Admin Information -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Admin Information</h3>
                        <button class="btn btn--icon">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="card__body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Full Name</label>
                                <p>Prof. Robert Wilson</p>
                            </div>
                            <div class="info-item">
                                <label>Role</label>
                                <p>Class Administrator</p>
                            </div>
                            <div class="info-item">
                                <label>Department</label>
                                <p>Computer Science</p>
                            </div>
                            <div class="info-item">
                                <label>Join Date</label>
                                <p>Jan 01, 2024</p>
                            </div>
                            <div class="info-item">
                                <label>Status</label>
                                <span class="status status--success">Active</span>
                            </div>
                            <div class="info-item">
                                <label>Email</label>
                                <p>robert.wilson@example.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Statistics -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Activity Statistics</h3>
                        <button class="btn btn--outline btn--sm">View Report</button>
                    </div>
                    <div class="card__body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Classes Managed</label>
                                <p>2</p>
                            </div>
                            <div class="info-item">
                                <label>Total Students</label>
                                <p>65</p>
                            </div>
                            <div class="info-item">
                                <label>Elections Created</label>
                                <p>8</p>
                            </div>
                            <div class="info-item">
                                <label>Last Active</label>
                                <p>2 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Managed Classes -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Managed Classes</h3>
                    <button class="btn btn--primary btn--sm">Add Class</button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Class Code</th>
                                <th>Class Name</th>
                                <th>Students</th>
                                <th>Active Elections</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CSA-2024</td>
                                <td><a href="/admin/class">Computer Science A</a></td>
                                <td>35</td>
                                <td>2</td>
                                <td><span class="status status--success">Active</span></td>
                                <td>
                                    <a href="/admin/class" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-chart-bar"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Recent Activity</h3>
                    <button class="btn btn--outline btn--sm">View All</button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Added Student</td>
                                <td>Added John Smith to Computer Science A</td>
                                <td>Sep 26, 2025</td>
                                <td>10:30 AM</td>
                                <td><span class="status status--success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>Created Election</td>
                                <td>New Class Representative Election</td>
                                <td>Sep 25, 2025</td>
                                <td>2:45 PM</td>
                                <td><span class="status status--success">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include $root . '/includes/footer.php'; ?>

    <script src="/assets/js/admin.js"></script>
</body>
</html>