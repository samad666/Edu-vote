<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduVote - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<?php
session_start();
// Include configuration
require_once  '../includes/config.php';

setActivePage('classes');
setPageTitle('Create Class');
$additional_scripts = ['assets/js/charts.js'];

// Include header
include '../includes/header.php';

// Include sidebar  
include '../includes/sidebar.php';

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_name     = $_POST['className'];
    $department     = $_POST['department'];
    $semester       = $_POST['semester'];
    $acadamic_year  = $_POST['academicYear'];
    $class_code     = $_POST['classCode'];
    $profile        = $_POST['profile'];
    $adminId        = $_POST['adminId'];
    $createdBy      = $_SESSION['user_id']; // Get from current user session

    $sql = "INSERT INTO class
            (class_name, department, semester, acadamic_year, class_code, profile, adminId, createdBy) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssisssss", 
            $class_name, $department, $semester, $acadamic_year, $class_code, $profile, $adminId, $createdBy
        );
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "✅ Class created successfully!";
        } else {
            $message = "❌ Error: " . mysqli_stmt_error($stmt);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $message = "❌ Database error: Could not prepare statement.";
    }
}
?>

<div class="main-content">
  <div class="form-container">
    <h2><i class="fas fa-graduation-cap"></i> Create New Class</h2>
     <form method="POST" action="">
    <!-- Class Information -->
    <div class="form-section">
      <h3>Class Information</h3>
      <div class="form-grid">
        <div class="form-group">
          <label for="className">Class Name</label>
          <input type="text" name="className" id="className" placeholder="Computer Science A" required>
        </div>
        <div class="form-group">
          <label for="classCode">Class Code</label>
          <input type="text" name="classCode" id="classCode" placeholder="CSA-2024" required>
        </div>
        <div class="form-group">
          <label for="department">Department</label>
          <input type="text" name="department" id="department" placeholder="Computer Science" required>
        </div>
        <div class="form-group">
          <label for="semester">Semester</label>
          <input type="number" name="semester" id="semester" placeholder="3" required>
        </div>
        <div class="form-group">
          <label for="academicYear">Academic Year</label>
          <input type="text" name="academicYear" id="academicYear" placeholder="2023-2024" required>
        </div>
        <div class="form-group">
          <label for="profile">Profile</label>
          <input type="text" name="profile" id="profile" placeholder="CS_A_2024" required>
        </div>
      </div>
    </div>

    <!-- Assignment Information -->
    <div class="form-section">
      <h3>Assignment Information</h3>
      <div class="form-grid">
        <div class="form-group">
          <label for="adminId">Admin ID</label>
          <input type="text" name="adminId" id="adminId" placeholder="ADM001" required>
        </div>
        <div class="form-group">
          <label>Created By</label>
          <input type="text" value="<?= htmlspecialchars($_SESSION['username'] ?? 'Current User') ?>" readonly style="background-color: #f5f5f5;">
          <small style="color: #666; font-size: 0.8rem;">Automatically set to current user</small>
        </div>
      </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Create Class</button>
        </form>

  </div>
<script src="../../assets/js/admin.js"></script>
</body>
</html>