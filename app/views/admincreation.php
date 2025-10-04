<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduVote - Create Admin</title>
  <link rel="stylesheet" href="../../assets/css/admin.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    .form-container {
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      /* background: #fff; */
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
      font-size: 1.6rem;
      color: #958b8bff;
    }

    .form-section {
      margin-bottom: 25px;
    }

    .form-section h3 {
      font-size: 1.1rem;
      margin-bottom: 15px;
      border-left: 4px solid #007bff;
      padding-left: 10px;
      color: #bdb4b4ff;
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
    .form-group select {
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 0.9rem;
      outline: none;
      transition: border 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus {
      border-color: #007bff;
    }

    .btn-submit {
      background: #007bff;
      color: #b6acacff;
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
require_once  '../includes/config.php';

// // Set page-specific variables
setActivePage('elections');   // <-- FIXED, was 'dashboard'
setPageTitle('Election Details');
$additional_scripts = ['assets/js/charts.js'];

// Include header
include '../includes/header.php';

// Include sidebar  
include '../includes/sidebar.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Retrieve data
    $full_name  = $_POST['fullName'];
    $admin_id   = $_POST['adminId'];
    $role       = $_POST['role'];
    $department = $_POST['department'];
    $join_date  = $_POST['joinDate'];
    $status     = $_POST['status'];
    $email      = $_POST['email'];

    // 2. Prepare the SQL statement
    $sql = "INSERT INTO admins 
            (full_name, admin_id, role, department, join_date, status, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // 3. Bind parameters (s=string, d=double, i=integer)
        // All fields are strings except join_date which is a date string.
        mysqli_stmt_bind_param($stmt, "sssssss", 
            $full_name, $admin_id, $role, $department, $join_date, $status, $email
        );
        
        // 4. Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            $message = "✅ Admin created successfully! (Admin ID: " . $admin_id . ")";
        } else {
            $message = "❌ Error creating admin: " . mysqli_stmt_error($stmt);
        }
        
        // 5. Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $message = "❌ Database error: Could not prepare statement.";
    }
}

?>

<div class="main-content">
  <div class="form-container">
         <form method="POST" action="">

    <h2><i class="fas fa-user-shield"></i> Create New Admin</h2>

    <!-- Admin Information -->
    <div class="form-section">
      <h3>Admin Information</h3>
      <div class="form-grid">
        <div class="form-group">
          <label for="fullName">Full Name</label>
          <input type="text" name="fullName" id="fullName" placeholder="Prof. Robert Wilson">
        </div>
        <div class="form-group">
          <label for="adminId">Admin ID</label>
          <input type="text" name="adminId" id="adminId" placeholder="ADM-001">
        </div>
        <div class="form-group">
          <label for="role">Role</label>
          <select id="role" name="role">
            <option value="">Select</option>
            <option>Class Administrator</option>
            <option>Department Head</option>
            <option>Super Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label for="department">Department</label>
          <input type="text" id="department" name="department" placeholder="Computer Science Department">
        </div>
        <div class="form-group">
          <label for="joinDate">Join Date</label>
          <input type="date" id="joinDate" name="joinDate">
        </div>
        <div class="form-group">
          <label for="status">Status</label>
          <select id="status" name="status">
            <option>Active</option>
            <option>Inactive</option>
            <option>Suspended</option>
          </select>
        </div>
        <div class="form-group" style="grid-column: span 2;">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="robert.wilson@example.com">
        </div>
      </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Create Admin</button>
  </div>
  </form>
</div>

<script src="../../assets/js/admin.js"></script>
</body>
</html>
