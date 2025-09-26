<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="welcome-message">
            <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
            <p>This is your dashboard. You are successfully logged in.</p>
        </div>
        
        <a href="/logout" class="logout-btn">Logout</a>
    </div>
</body>
</html>
