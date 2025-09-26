<?php 
$root = $_SERVER['DOCUMENT_ROOT'] . '/..';
include $root . '/includes/header.php';
?>

<div class="admin-layout">
    <?php include $root . '/includes/sidebar.php'; ?>
    
    <main class="admin-main">
        <div class="detail-header">
            <div class="breadcrumb">
                <a href="/admin/dashboard">Dashboard</a>
                <span class="separator">/</span>
                <a href="/admin/elections">Elections</a>
                <span class="separator">/</span>
                <a href="/admin/election">Student Body President Election</a>
                <span class="separator">/</span>
                <span class="current">Winner Details</span>
            </div>
        </div>

        <div class="profile-header">
            <div class="profile-info">
                <h1>Michael Brown - Election Winner</h1>
                <div class="profile-meta">
                    <span class="meta-item">
                        <i class="fas fa-trophy"></i>
                        Student Body President
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-poll"></i>
                        245 Votes (55%)
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-calendar"></i>
                        Won: Mar 20, 2024
                    </span>
                    <span class="status status--success">Winner</span>
                </div>
            </div>
            <div class="profile-actions">
                <button class="btn btn--primary">View Certificate</button>
                <button class="btn btn--outline">Print Results</button>
            </div>
        </div>

        <div class="profile-content">
            <div class="content-grid">
                <!-- Winner Information -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Winner Information</h3>
                        <button class="btn btn--icon">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="card__body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Full Name</label>
                                <p>Michael Brown</p>
                            </div>
                            <div class="info-item">
                                <label>Department</label>
                                <p>Computer Science</p>
                            </div>
                            <div class="info-item">
                                <label>Year</label>
                                <p>Year 3</p>
                            </div>
                            <div class="info-item">
                                <label>Position Won</label>
                                <p>Student Body President</p>
                            </div>
                            <div class="info-item">
                                <label>Status</label>
                                <span class="status status--success">Winner</span>
                            </div>
                            <div class="info-item">
                                <label>Term</label>
                                <p>2024-2025</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Election Statistics -->
                <div class="content-card">
                    <div class="card-header">
                        <h3>Election Statistics</h3>
                        <button class="btn btn--outline btn--sm">View Report</button>
                    </div>
                    <div class="card__body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Total Votes</label>
                                <p>245</p>
                            </div>
                            <div class="info-item">
                                <label>Vote Percentage</label>
                                <p>55%</p>
                            </div>
                            <div class="info-item">
                                <label>Voter Turnout</label>
                                <p>78%</p>
                            </div>
                            <div class="info-item">
                                <label>Total Voters</label>
                                <p>443</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vote Distribution -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Vote Distribution</h3>
                    <button class="btn btn--outline btn--sm">View Details</button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Candidate</th>
                                <th>Department</th>
                                <th>Year</th>
                                <th>Votes</th>
                                <th>Percentage</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="/admin/student">Michael Brown</a></td>
                                <td>Computer Science</td>
                                <td>Year 3</td>
                                <td>245</td>
                                <td>55%</td>
                                <td><span class="status status--success">Winner</span></td>
                            </tr>
                            <tr>
                                <td><a href="/admin/student">Emma Wilson</a></td>
                                <td>Business Admin</td>
                                <td>Year 2</td>
                                <td>198</td>
                                <td>45%</td>
                                <td><span class="status status--warning">Runner-up</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Winner's Statement -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Winner's Statement</h3>
                    <button class="btn btn--outline btn--sm">Edit Statement</button>
                </div>
                <div class="card__body">
                    <blockquote class="statement-content">
                        "I am honored to be elected as your Student Body President. I promise to work tirelessly to represent all students and make our college a better place for everyone."
                    </blockquote>
                    <p class="text-muted">Posted on March 21, 2024</p>
                </div>
            </div>

            <!-- Election Timeline -->
            <div class="content-card">
                <div class="card-header">
                    <h3>Election Timeline</h3>
                    <button class="btn btn--outline btn--sm">Full Report</button>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Details</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Winner Declared</td>
                                <td>Mar 20, 2024</td>
                                <td>5:00 PM</td>
                                <td>Results officially announced</td>
                                <td><span class="status status--success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>Statement Posted</td>
                                <td>Mar 21, 2024</td>
                                <td>10:00 AM</td>
                                <td>Winner's statement published</td>
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
