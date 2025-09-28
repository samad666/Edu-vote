<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - EduVote' : 'EduVote - Admin Panel'; ?></title>
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
                    <span><?php echo isset($admin_name) ? $admin_name : 'Admin User'; ?></span>
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
                    <a href="logout.php" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>
