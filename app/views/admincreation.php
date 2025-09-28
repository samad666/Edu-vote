<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduVote - Create Admin</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    .form-container {
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      background: #fff;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
      font-size: 1.6rem;
      color: #333;
    }

    .form-section {
      margin-bottom: 25px;
    }

    .form-section h3 {
      font-size: 1.1rem;
      margin-bottom: 15px;
      border-left: 4px solid #007bff;
      padding-left: 10px;
      color: #444;
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
// Include configuration
include 'includes/config.php';

// Page settings
setActivePage('admins');  
setPageTitle('Create Admin');

// Include header & sidebar
include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
  <div class="form-container">
    <h2><i class="fas fa-user-shield"></i> Create New Admin</h2>

    <!-- Admin Information -->
    <div class="form-section">
      <h3>Admin Information</h3>
      <div class="form-grid">
        <div class="form-group">
          <label for="fullName">Full Name</label>
          <input type="text" id="fullName" placeholder="Prof. Robert Wilson">
        </div>
        <div class="form-group">
          <label for="adminId">Admin ID</label>
          <input type="text" id="adminId" placeholder="ADM-001">
        </div>
        <div class="form-group">
          <label for="role">Role</label>
          <select id="role">
            <option value="">Select</option>
            <option>Class Administrator</option>
            <option>Department Head</option>
            <option>Super Admin</option>
          </select>
        </div>
        <div class="form-group">
          <label for="department">Department</label>
          <input type="text" id="department" placeholder="Computer Science Department">
        </div>
        <div class="form-group">
          <label for="joinDate">Join Date</label>
          <input type="date" id="joinDate">
        </div>
        <div class="form-group">
          <label for="status">Status</label>
          <select id="status">
            <option>Active</option>
            <option>Inactive</option>
            <option>Suspended</option>
          </select>
        </div>
        <div class="form-group" style="grid-column: span 2;">
          <label for="email">Email</label>
          <input type="email" id="email" placeholder="robert.wilson@example.com">
        </div>
      </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Create Admin</button>
  </div>
</div>

<script src="../../assets/js/admin.js"></script>
</body>
</html>
