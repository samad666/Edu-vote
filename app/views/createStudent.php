<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create User</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>
<body> -->
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
// Include configuration
require_once  '../includes/config.php';

// // Set page-specific variables
setActivePage('students');
setPageTitle('Create Student');
$additional_scripts = ['assets/js/charts.js'];

// Include header
include '../includes/header.php';

// Include sidebar  
include '../includes/sidebar.php';

// Fetch classes for dropdown
$classes_sql = "SELECT id, class_name FROM class ORDER BY class_name";
$classes_result = mysqli_query($conn, $classes_sql);

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name      = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email          = mysqli_real_escape_string($conn, $_POST['email']);
    $phone          = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob            = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender         = mysqli_real_escape_string($conn, $_POST['gender']);
    $address        = mysqli_real_escape_string($conn, $_POST['address']);
    $department     = mysqli_real_escape_string($conn, $_POST['department']);
    $class_id       = mysqli_real_escape_string($conn, $_POST['class_id']);
    $admission_year = mysqli_real_escape_string($conn, $_POST['admissionYear']);
    $semester       = mysqli_real_escape_string($conn, $_POST['semester']);
    $status         = mysqli_real_escape_string($conn, $_POST['status']);
    $student_id     = mysqli_real_escape_string($conn, $_POST['studentId']);
    
    // Get class name from class_id
    $class_name_sql = "SELECT class_name FROM class WHERE id = '$class_id'";
    $class_name_result = mysqli_query($conn, $class_name_sql);
    $class_name_row = mysqli_fetch_assoc($class_name_result);
    $class = $class_name_row['class_name'];
    
    // Handle photo upload
    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = '../uploads/students/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_name = $student_id . '_' . time() . '.' . $file_extension;
        $photo_path = $upload_dir . $photo_name;
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            $photo_path = '/uploads/students/' . $photo_name;
        } else {
            $photo_path = null;
        }
    }
    
    $sql = "INSERT INTO students (full_name, email, phone, dob, gender, address, department, class, class_id, admission_year, semester, student_id, status, photo) 
            VALUES ('$full_name', '$email', '$phone', '$dob', '$gender', '$address', '$department', '$class', '$class_id', '$admission_year', '$semester', '$student_id', '$status', '$photo_path')";

    if (mysqli_query($conn, $sql)) {
        $message = "✅ User created successfully!";
    } else {
        $message = "❌ Error: " . mysqli_error($conn);
    }
}

?>



<div class="main-content">
  <div class="form-container">
    <h2><i class="fas fa-user-plus"></i> Create New User</h2>
     <form method="POST" action="" enctype="multipart/form-data">
    <!-- Personal Information -->
    <div class="form-section">
      <h3>Personal Information</h3>
      <div class="form-grid">
        <div class="form-group">
          <label for="fullName">Full Name</label>
          <input type="text" name="fullName" id="fullName" placeholder="John Smith">
        </div>
        <div class="form-group">
          <label for="studentId">Student ID</label>
          <input type="text" name="studentId" id="studentId" placeholder="ST001">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" placeholder="john.smith@example.com">
        </div>
        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="text" name="phone" id="phone" placeholder="+1 (555) 123-4567">
        </div>
        <div class="form-group">
          <label for="dob">Date of Birth</label>
          <input type="date" name="dob" id="dob">
        </div>
        <div class="form-group">
          <label for="gender">Gender</label>
          <select id="gender" name="gender">
            <option value="">Select</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
          </select>
        </div>
        <div class="form-group">
          <label for="photo">Photo</label>
          <input type="file" name="photo" id="photo" accept="image/*">
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <textarea id="address" name="address" rows="2" placeholder="123 Campus Street, University Area"></textarea>
        </div>
      </div>
    </div>

    <!-- Academic Information -->
    <div class="form-section">
      <h3>Academic Information</h3>
      <div class="form-grid">
        <div class="form-group">
          <label for="department">Department</label>
          <input type="text" name="department" id="department" placeholder="Computer Science">
        </div>
        <div class="form-group">
          <label for="class_id">Class</label>
          <select name="class_id" id="class_id" required>
            <option value="">Select Class</option>
            <?php while ($class = mysqli_fetch_assoc($classes_result)): ?>
              <option value="<?= htmlspecialchars($class['id']) ?>" data-class-name="<?= htmlspecialchars($class['class_name']) ?>">
                <?= htmlspecialchars($class['class_name']) ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="admissionYear">Admission Year</label>
          <input type="number" name="admissionYear" id="admissionYear" placeholder="2023">
        </div>
        <div class="form-group">
          <label for="semester">Current Semester</label>
          <input type="text" name="semester" id="semester" placeholder="3rd Semester">
        </div>
        <div class="form-group">
          <label for="status">Academic Status</label>
          <select id="status" name="status">
            <option>Active</option>
            <option>Inactive</option>
            <option>Suspended</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Create User</button>
        </form>

  </div>
<script src="../../assets/js/admin.js"></script>
</body>
</html>
