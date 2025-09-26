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
                    <a href="#" class="nav-link" data-page="dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="classes">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Class Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link active" data-page="students">
                        <i class="fas fa-user-graduate"></i>
                        <span>Students</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="admins">
                        <i class="fas fa-users-cog"></i>
                        <span>Class Admins</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="elections">
                        <i class="fas fa-poll"></i>
                        <span>Elections</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="winners">
                        <i class="fas fa-trophy"></i>
                        <span>Election Winners</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-page="analytics">
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
            <a href="/admin" class="breadcrumb-item">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="#" class="breadcrumb-item">Students</a>
            <i class="fas fa-chevron-right"></i>
            <span class="breadcrumb-item active">Student Details</span>
        </div>

        <div class="student-profile">
            <div class="profile-header">
                <div class="profile-cover"></div>
                <div class="profile-info">
                    <div class="profile-avatar-large">
                        <img src="https://ui-avatars.com/api/?name=John+Smith&background=4a90e2&color=fff" alt="John Smith">
                    </div>
                    <div class="profile-details">
                        <h1>John Smith</h1>
                        <p class="student-id">Student ID: ST001</p>
                        <div class="profile-stats">
                            <div class="stat-item">
                                <i class="fas fa-poll"></i>
                                <span>12 Elections Participated</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-trophy"></i>
                                <span>3 Positions Held</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Computer Science A</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="btn btn--primary">
                            <i class="fas fa-edit"></i>
                            Edit Profile
                        </button>
                        <button class="btn btn--outline">
                            <i class="fas fa-envelope"></i>
                            Send Message
                        </button>
                    </div>
                </div>
            </div>

            <div class="profile-content">
                <div class="content-grid">
                    <!-- Personal Information -->
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Personal Information</h3>
                            <button class="btn btn--icon">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="card__body">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Full Name</label>
                                    <p>John Smith</p>
                                </div>
                                <div class="info-item">
                                    <label>Email</label>
                                    <p>john.smith@example.com</p>
                                </div>
                                <div class="info-item">
                                    <label>Phone</label>
                                    <p>+1 (555) 123-4567</p>
                                </div>
                                <div class="info-item">
                                    <label>Date of Birth</label>
                                    <p>March 15, 2000</p>
                                </div>
                                <div class="info-item">
                                    <label>Gender</label>
                                    <p>Male</p>
                                </div>
                                <div class="info-item">
                                    <label>Address</label>
                                    <p>123 Campus Street, University Area</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Academic Information</h3>
                            <button class="btn btn--icon">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        <div class="card__body">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Department</label>
                                    <p>Computer Science</p>
                                </div>
                                <div class="info-item">
                                    <label>Class</label>
                                    <p>Computer Science A</p>
                                </div>
                                <div class="info-item">
                                    <label>Admission Year</label>
                                    <p>2023</p>
                                </div>
                                <div class="info-item">
                                    <label>Current Semester</label>
                                    <p>3rd Semester</p>
                                </div>
                                <div class="info-item">
                                    <label>Academic Status</label>
                                    <span class="status status--success">Active</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Election History -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Election History</h3>
                        <button class="btn btn--outline btn--sm">View All</button>
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
                                <tr>
                                    <td>Student Council 2024</td>
                                    <td>President</td>
                                    <td>Mar 15, 2024</td>
                                    <td><span class="status status--success">Won</span></td>
                                    <td>458</td>
                                </tr>
                                <tr>
                                    <td>Department Rep 2023</td>
                                    <td>CS Representative</td>
                                    <td>Nov 10, 2023</td>
                                    <td><span class="status status--warning">Runner Up</span></td>
                                    <td>342</td>
                                </tr>
                                <tr>
                                    <td>Sports Committee 2023</td>
                                    <td>Sports Secretary</td>
                                    <td>Aug 05, 2023</td>
                                    <td><span class="status status--error">Lost</span></td>
                                    <td>234</td>
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
