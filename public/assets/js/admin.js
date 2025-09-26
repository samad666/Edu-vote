document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            if (mainContent) {
                mainContent.classList.toggle('expanded');
            }
        });
    }

    // Navigation
    const navLinks = document.querySelectorAll('.nav-link');
    const pages = document.querySelectorAll('.page-content');
    const currentPage = document.getElementById('currentPage');
    
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            link.classList.add('active');
            
            const pageId = link.getAttribute('data-page');
            const parentRow = link.closest('tr');
            
            // Handle different page navigations
            if (pageId === 'dashboard') {
                window.location.href = '/admin';
            } else if (window.location.pathname.includes('Detail.php')) {
                // If we're on a detail page, go back to the list view
                window.location.href = '/admin#' + pageId;
            } else if (parentRow) {
                // If clicked from a table row, go to detail view
                window.location.href = '/admin/' + pageId.slice(0, -1);
            } else {
                // Regular navigation
                window.location.href = '/admin#' + pageId;
            }
            
            // Update page content if we're not navigating away
            if (pages.length > 0) {
                pages.forEach(p => p.classList.remove('active'));
                const page = document.getElementById(pageId);
                if (page) {
                    page.classList.add('active');
                    if (currentPage) {
                        currentPage.textContent = link.querySelector('span').textContent;
                    }
                }
            }
        });
    });

    // Initialize charts if they exist
    if (typeof Chart !== 'undefined') {
        // Overview Chart
        const overviewCtx = document.getElementById('overviewChart');
        if (overviewCtx) {
            new Chart(overviewCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Students',
                        data: [1200, 1250, 1300, 1280, 1290, 1250],
                        borderColor: getComputedStyle(document.documentElement)
                            .getPropertyValue('--color-primary').trim(),
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        // Participation Chart
        const participationCtx = document.getElementById('participationChart');
        if (participationCtx) {
            new Chart(participationCtx, {
                type: 'bar',
                data: {
                    labels: ['Election 1', 'Election 2', 'Election 3', 'Election 4'],
                    datasets: [{
                        label: 'Participation Rate',
                        data: [75, 82, 78, 85],
                        backgroundColor: getComputedStyle(document.documentElement)
                            .getPropertyValue('--color-primary').trim()
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    }
});
