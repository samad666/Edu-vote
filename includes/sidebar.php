    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>" data-page="dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link <?php echo ($current_page == 'classes') ? 'active' : ''; ?>" data-page="classes">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Class Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link <?php echo ($current_page == 'students') ? 'active' : ''; ?>" data-page="students">
                        <i class="fas fa-user-graduate"></i>
                        <span>Students</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link <?php echo ($current_page == 'admins') ? 'active' : ''; ?>" data-page="admins">
                        <i class="fas fa-users-cog"></i>
                        <span>Class Admins</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link <?php echo ($current_page == 'elections') ? 'active' : ''; ?>" data-page="elections">
                        <i class="fas fa-poll"></i>
                        <span>Elections</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link <?php echo ($current_page == 'winners') ? 'active' : ''; ?>" data-page="winners">
                        <i class="fas fa-trophy"></i>
                        <span>Election Winners</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link <?php echo ($current_page == 'analytics') ? 'active' : ''; ?>" data-page="analytics">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
