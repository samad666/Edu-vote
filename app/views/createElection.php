<?php
require_once '../includes/config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../models/elections.php';
    
    $data = [
        'type' => $_POST['type'],
        'scope' => $_POST['scope'],
        'name' => $_POST['name'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'status' => $_POST['status'],
        'profile' => $_POST['profile'],
        'class_id' => $_POST['class_id']
    ];
    
    if (createElection($data)) {
        $success = "Election created successfully!";
    } else {
        $error = "Failed to create election.";
    }
}

// Fetch classes for dropdown
$classes_sql = "SELECT id, class_name FROM class ORDER BY class_name";
$classes_result = mysqli_query($conn, $classes_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Election - EduVote</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
            .form-container {
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    .form-section {
      margin-bottom: 25px;
    }

    .form-section h3 {
      font-size: 1.1rem;
      margin-bottom: 15px;
      border-left: 4px solid #007bff;
      padding-left: 10px;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    .form-group label {
      font-weight: 500;
      margin-bottom: 6px;
      font-size: 0.9rem;
    }

    .form-group input, 
    .form-group select, 
    .form-group textarea {
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 0.9rem;
      outline: none;
      transition: border 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: #007bff;
    }

    .btn-submit {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.2s;
      width: 100%;
    }

    .btn-submit:hover {
      background: #0056b3;
    }
</style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="breadcrumb">
            <a href="/admin" class="breadcrumb-item">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="/admin#elections" class="breadcrumb-item">Elections</a>
            <i class="fas fa-chevron-right"></i>
            <span class="breadcrumb-item active">Create Election</span>
        </div>

        <div class="page-header">
            <h1>Create New Election</h1>
            <p class="page-description">Set up a new election for your institution</p>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert--success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert--error"><?= $error ?></div>
        <?php endif; ?>

        <div class="content-card">
            <form method="POST" class="form">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="type">Election Type</label>
                        <input type="text" id="type" name="type" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="scope">Scope</label>
                        <input type="text" id="scope" name="scope" class="form-control" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="name">Election Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="datetime-local" id="start_date" name="start_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="datetime-local" id="end_date" name="end_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="profile">Profile</label>
                        <input type="text" id="profile" name="profile" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="class_id">Class</label>
                        <select id="class_id" name="class_id" class="form-control" required>
                            <option value="">Select Class</option>
                            <?php while ($class = mysqli_fetch_assoc($classes_result)): ?>
                                <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Create Election</button>
                    <a href="/admin#elections" class="btn btn--outline">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>