<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Detail - EduVote Admin</title>
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


    <!-- Main Content -->
    <main class="main-content">
            <?php include '../includes/sidebar.php'; ?>

        <div class="breadcrumb">
            <a href="/admin" class="breadcrumb-item">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="#" class="breadcrumb-item">Classes</a>
            <i class="fas fa-chevron-right"></i>
            <span class="breadcrumb-item active">Class Details</span>
        </div>

        <div class="student-profile">
            <div class="profile-header">
                <div class="profile-cover"></div>
                <div class="profile-info">
                    <div class="profile-avatar-large">
                        <i class="fas fa-graduation-cap fa-3x"></i>
                    </div>
                    <div class="profile-details">
                        <h1>Computer Science A</h1>
                        <p class="student-id">Class Code: CSA-2024</p>
                        <div class="profile-stats">
                            <div class="stat-item">
                                <i class="fas fa-user-graduate"></i>
                                <span>35 Students</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-poll"></i>
                                <span>5 Active Elections</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-calendar"></i>
                                <span>2023-2024</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="btn btn--primary">
                            <i class="fas fa-edit"></i>
                            Edit Class
                        </button>
                        <button class="btn btn--outline">
                            <i class="fas fa-plus"></i>
                            Add Student
                        </button>
                    </div>
                </div>
            </div>

            <div class="profile-content">
                <div class="content-grid">
                    <!-- Class Information -->
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Class Information</h3>
                            <button class="btn btn--icon">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="card__body">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Class Name</label>
                                    <p>Computer Science A</p>
                                </div>
                                <div class="info-item">
                                    <label>Department</label>
                                    <p>Computer Science</p>
                                </div>
                                <div class="info-item">
                                    <label>Class Code</label>
                                    <p>CSA-2024</p>
                                </div>
                                <div class="info-item">
                                    <label>Academic Year</label>
                                    <p>2023-2024</p>
                                </div>
                                <div class="info-item">
                                    <label>Status</label>
                                    <span class="status status--success">Active</span>
                                </div>
                                <div class="info-item">
                                    <label>Class Admin</label>
                                    <p>Prof. Robert Wilson</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Class Statistics -->
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Class Statistics</h3>
                            <button class="btn btn--outline btn--sm">Export Report</button>
                        </div>
                        <div class="card__body">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Total Students</label>
                                    <p>35</p>
                                </div>
                                <div class="info-item">
                                    <label>Active Elections</label>
                                    <p>5</p>
                                </div>
                                <div class="info-item">
                                    <label>Completed Elections</label>
                                    <p>12</p>
                                </div>
                                <div class="info-item">
                                    <label>Average Participation</label>
                                    <p>85%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students List -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Enrolled Students</h3>
                        <button class="btn btn--primary btn--sm">Add Student</button>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Elections Participated</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ST001</td>
                                    <td><a href="/admin/student">John Smith</a></td>
                                    <td>john.smith@example.com</td>
                                    <td>8</td>
                                    <td><span class="status status--success">Active</span></td>
                                    <td>
                                        <a href="/admin/student" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn--icon"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>ST002</td>
                                    <td><a href="/admin/student">Sarah Johnson</a></td>
                                    <td>sarah.j@example.com</td>
                                    <td>6</td>
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

                <!-- Active Elections -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Active Elections</h3>
                        <button class="btn btn--primary btn--sm">Create Election</button>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Election</th>
                                    <th>Position</th>
                                    <th>End Date</th>
                                    <th>Participation</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="/admin/election">Class Representative</a></td>
                                    <td>Class Rep</td>
                                    <td>Mar 20, 2024</td>
                                    <td>65%</td>
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
        </div>
    </main>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
