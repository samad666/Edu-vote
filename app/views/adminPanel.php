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
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-circle"></i>
                        Profile
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link active" data-page="dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-page="classes">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Class Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-page="students">
                        <i class="fas fa-user-graduate"></i>
                        <span>Students</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-page="admins">
                        <i class="fas fa-users-cog"></i>
                        <span>Class Admins</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-page="elections">
                        <i class="fas fa-poll"></i>
                        <span>Elections</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-page="winners">
                        <i class="fas fa-trophy"></i>
                        <span>Election Winners</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-page="analytics">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

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

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-1">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-content">
                        <h3>1,250</h3>
                        <p>Total Students</p>
                        <span class="stat-change positive">+5.2%</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-2">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <h3>45</h3>
                        <p>Classes</p>
                        <span class="stat-change positive">+2.1%</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-3">
                        <i class="fas fa-poll"></i>
                    </div>
                    <div class="stat-content">
                        <h3>12</h3>
                        <p>Total Elections</p>
                        <span class="stat-change neutral">3 Active</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-4">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <h3>78%</h3>
                        <p>Participation Rate</p>
                        <span class="stat-change positive">+12%</span>
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
                        <div class="election-item">
                            <div class="election-info">
                                <h4>Student Body President Election</h4>
                                <p>March 15, 2024 • 892 participants</p>
                            </div>
                            <span class="status status--success">Completed</span>
                        </div>
                        <div class="election-item">
                            <div class="election-info">
                                <h4>Class Representative Election</h4>
                                <p>March 10, 2024 • 456 participants</p>
                            </div>
                            <span class="status status--success">Completed</span>
                        </div>
                        <div class="election-item">
                            <div class="election-info">
                                <h4>Sports Captain Election</h4>
                                <p>March 5, 2024 • 234 participants</p>
                            </div>
                            <span class="status status--warning">Ongoing</span>
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <div class="card-header">
                        <h3>Quick Actions</h3>
                    </div>
                    <div class="quick-actions">
                        <button class="btn btn--primary btn--full-width">Create New Election</button>
                        <button class="btn btn--outline btn--full-width">Add Student</button>
                        <button class="btn btn--outline btn--full-width">Manage Classes</button>
                        <button class="btn btn--outline btn--full-width">Export Reports</button>
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

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-1">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-content">
                        <h3>1,250</h3>
                        <p>Students</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-2">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <h3>45</h3>
                        <p>Classes</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-3">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="stat-content">
                        <h3>28</h3>
                        <p>Class Admins</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-4">
                        <i class="fas fa-poll"></i>
                    </div>
                    <div class="stat-content">
                        <h3>12</h3>
                        <p>Elections</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-5">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <h3>35</h3>
                        <p>Winners</p>
                    </div>
                </div>
            </div>

            <div class="charts-grid">
                <div class="chart-card">
                    <div class="card-header">
                        <h3>System Overview</h3>
                        <button class="btn btn--outline btn--sm">Export Data</button>
                    </div>
                    <div class="chart-container" style="position: relative; height: 400px;">
                        <canvas id="overviewChart"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="card-header">
                        <h3>Election Participation</h3>
                        <button class="btn btn--outline btn--sm">Details</button>
                    </div>
                    <div class="chart-container" style="position: relative; height: 400px;">
                        <canvas id="participationChart"></canvas>
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
                    <button class="btn btn--primary btn--sm">Add New Class</button>
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
                            <tr>
                                <td>BMB-2024</td>
                                <td><a href="/admin/class" class="detail-link">Business Management B</a></td>
                                <td>Business</td>
                                <td>42</td>
                                <td><span class="status status--success">Active</span></td>
                                <td>
                                    <a href="/admin/class" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
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
                    <button class="btn btn--primary btn--sm">Add New Student</button>
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
                        <tbody>
                            <tr>
                                <td>ST001</td>
                                <td><a href="/admin/student" class="student-link">John Smith</a></td>
                                <td>Computer Science A</td>
                                <td>john.smith@example.com</td>
                                <td><span class="status status--success">Active</span></td>
                                <td>
                                    <a href="/admin/student" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ST002</td>
                                <td><a href="/admin/student" class="student-link">Sarah Johnson</a></td>
                                <td>Business Management B</td>
                                <td>sarah.j@example.com</td>
                                <td><span class="status status--success">Active</span></td>
                                <td>
                                    <a href="/admin/student" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
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
                    <button class="btn btn--primary btn--sm">Add New Admin</button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Classes</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ADM001</td>
                                <td><a href="/admin/admin" class="detail-link">Prof. Robert Wilson</a></td>
                                <td>Computer Science</td>
                                <td>2</td>
                                <td><span class="status status--success">Active</span></td>
                                <td>
                                    <a href="/admin/admin" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-key"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ADM002</td>
                                <td><a href="/admin/admin" class="detail-link">Dr. Emily Parker</a></td>
                                <td>Business</td>
                                <td>3</td>
                                <td><span class="status status--success">Active</span></td>
                                <td>
                                    <a href="/admin/admin" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-key"></i></button>
                                </td>
                            </tr>
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
                    <button class="btn btn--primary btn--sm">Create New Election</button>
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
                            <tr>
                                <td>EL002</td>
                                <td><a href="/admin/election" class="detail-link">Class Representative</a></td>
                                <td>Computer Science A</td>
                                <td>Mar 25, 2024</td>
                                <td><span class="status status--warning">Ongoing</span></td>
                                <td>
                                    <a href="/admin/election" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-chart-bar"></i></button>
                                </td>
                            </tr>
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
                            <tr>
                                <td>Sports Captain Election</td>
                                <td><a href="/admin/winner" class="detail-link">Michael Brown</a></td>
                                <td>Sports Captain</td>
                                <td>245</td>
                                <td>Mar 15, 2024</td>
                                <td>
                                    <a href="/admin/winner" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-certificate"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-share"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Class Rep Election</td>
                                <td><a href="/admin/winner" class="detail-link">Emma Wilson</a></td>
                                <td>Class Representative</td>
                                <td>198</td>
                                <td>Mar 10, 2024</td>
                                <td>
                                    <a href="/admin/winner" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-certificate"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-share"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/admin.js"></script>
</body>
</html>