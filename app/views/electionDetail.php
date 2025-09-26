<?php include '../includes/header.php'; ?>

<div class="admin-layout">
    <?php include '../includes/sidebar.php'; ?>
    
    <main class="admin-main">
        <div class="detail-header">
            <div class="breadcrumb">
                <a href="/admin/dashboard">Dashboard</a>
                <span class="separator">/</span>
                <a href="/admin/elections">Elections</a>
                <span class="separator">/</span>
                <span class="current">Student Body President Election</span>
            </div>
        </div>

        <div class="profile-header">
            <div class="profile-info">
                <h1>Student Body President Election</h1>
                <div class="profile-meta">
                    <span class="meta-item">
                        <i class="fas fa-calendar"></i>
                        Started: Mar 15, 2024
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-hourglass-end"></i>
                        Ends: Mar 20, 2024
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-users"></i>
                        892 Eligible Voters
                    </span>
                    <span class="status status--warning">Ongoing</span>
                </div>
            </div>
            <div class="profile-actions">
                <button class="btn btn--primary">End Election</button>
                <button class="btn btn--outline">Export Results</button>
            </div>
        </div>

        <div class="profile-content">
            <div class="content-grid">
                <!-- Election Information -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Election Information</h3>
                        <button class="btn btn--icon">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="card__body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Election Type</label>
                                <p>Student Body President</p>
                            </div>
                            <div class="info-item">
                                <label>Scope</label>
                                <p>College-wide</p>
                            </div>
                            <div class="info-item">
                                <label>Election ID</label>
                                <p>EL-2024-001</p>
                            </div>
                            <div class="info-item">
                                <label>Duration</label>
                                <p>5 Days</p>
                            </div>
                            <div class="info-item">
                                <label>Status</label>
                                <span class="status status--warning">Ongoing</span>
                            </div>
                            <div class="info-item">
                                <label>Created By</label>
                                <p>Admin User</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Election Statistics -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Election Statistics</h3>
                        <button class="btn btn--outline btn--sm">Download Report</button>
                    </div>
                    <div class="card__body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Total Voters</label>
                                <p>892</p>
                            </div>
                            <div class="info-item">
                                <label>Votes Cast</label>
                                <p>695</p>
                            </div>
                            <div class="info-item">
                                <label>Participation Rate</label>
                                <p>78%</p>
                            </div>
                            <div class="info-item">
                                <label>Time Remaining</label>
                                <p>2 days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Candidates List -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Candidates</h3>
                    <button class="btn btn--primary btn--sm">Add Candidate</button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Year</th>
                                <th>Votes</th>
                                <th>Percentage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>C001</td>
                                <td><a href="/admin/student">Michael Brown</a></td>
                                <td>Computer Science</td>
                                <td>Year 3</td>
                                <td>245</td>
                                <td>35.3%</td>
                                <td>
                                    <a href="/admin/student" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-chart-bar"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>C002</td>
                                <td><a href="/admin/student">Emma Wilson</a></td>
                                <td>Business Admin</td>
                                <td>Year 2</td>
                                <td>198</td>
                                <td>28.5%</td>
                                <td>
                                    <a href="/admin/student" class="btn btn--icon"><i class="fas fa-eye"></i></a>
                                    <button class="btn btn--icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn--icon"><i class="fas fa-chart-bar"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Department Participation -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Department Participation</h3>
                    <button class="btn btn--outline btn--sm">View Details</button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Total Students</th>
                                <th>Votes Cast</th>
                                <th>Participation</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Computer Science</td>
                                <td>250</td>
                                <td>213</td>
                                <td>85%</td>
                                <td><span class="status status--success">High</span></td>
                            </tr>
                            <tr>
                                <td>Business Admin</td>
                                <td>180</td>
                                <td>130</td>
                                <td>72%</td>
                                <td><span class="status status--warning">Medium</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Voting Trends Chart -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Voting Trends</h3>
                    <button class="btn btn--outline btn--sm">Export Data</button>
                </div>
                <div class="card__body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="votingTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>

<script>
    // Initialize voting trend chart
    if (typeof Chart !== 'undefined') {
        const ctx = document.getElementById('votingTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'],
                    datasets: [{
                        label: 'Votes Cast',
                        data: [150, 320, 450, 680, 892],
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
    }
</script>
