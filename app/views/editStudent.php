<?php
require_once '../includes/config.php';

// Get Student ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid Student ID");
}
$student_id = (int) $_GET['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
    $admission_year = mysqli_real_escape_string($conn, $_POST['admissionYear']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $student_code = mysqli_real_escape_string($conn, $_POST['studentId']);
    
    // Get class name from class_id
    $class_name_sql = "SELECT class_name FROM class WHERE id = '$class_id'";
    $class_name_result = mysqli_query($conn, $class_name_sql);
    $class_name_row = mysqli_fetch_assoc($class_name_result);
    $class = $class_name_row['class_name'];
    
    // Handle photo upload
    $photo_update = "";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = '../uploads/students/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_name = $student_code . '_' . time() . '.' . $file_extension;
        $photo_path = $upload_dir . $photo_name;
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            $photo_path = '/uploads/students/' . $photo_name;
            $photo_update = ", photo = '$photo_path'";
        }
    }
    
    $sql = "UPDATE students SET full_name='$full_name', email='$email', phone='$phone', dob='$dob', gender='$gender', address='$address', department='$department', class='$class', class_id='$class_id', admission_year='$admission_year', semester='$semester', student_id='$student_code', status='$status' $photo_update WHERE id=$student_id";
    
    if (mysqli_query($conn, $sql)) {
        $success = "Student updated successfully!";
    } else {
        $error = "Failed to update student.";
    }
}

// Fetch Student Data
$sql = "SELECT * FROM students WHERE id = $student_id LIMIT 1";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

// Fetch classes for dropdown
$classes_sql = "SELECT id, class_name FROM class ORDER BY class_name";
$classes_result = mysqli_query($conn, $classes_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - EduVote</title>
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
        .form-group input, .form-group select, .form-group textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            transition: border 0.2s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
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
            <a href="/admin#students" class="breadcrumb-item">Students</a>
            <i class="fas fa-chevron-right"></i>
            <span class="breadcrumb-item active">Edit Student</span>
        </div>

        <div class="page-header">
            <h1>Edit Student</h1>
            <p class="page-description">Update student information</p>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert--success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert--error"><?= $error ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-section">
                    <h3>Personal Information</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" name="fullName" id="fullName" value="<?= htmlspecialchars($student['full_name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="studentId">Student ID</label>
                            <input type="text" name="studentId" id="studentId" value="<?= htmlspecialchars($student['student_id']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?= htmlspecialchars($student['email']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($student['phone']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" id="dob" value="<?= htmlspecialchars($student['dob']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender">
                                <option value="">Select</option>
                                <option <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                <option <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                <option <?= $student['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" id="photo" accept="image/*">
                            <?php if ($student['photo']): ?>
                                <small>Current photo: <img src="<?= htmlspecialchars($student['photo']) ?>" style="width: 30px; height: 30px; border-radius: 50%;"></small>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="2"><?= htmlspecialchars($student['address']) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Academic Information</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input type="text" name="department" id="department" value="<?= htmlspecialchars($student['department']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="class_id">Class</label>
                            <select name="class_id" id="class_id" required>
                                <option value="">Select Class</option>
                                <?php while ($class = mysqli_fetch_assoc($classes_result)): ?>
                                    <option value="<?= htmlspecialchars($class['id']) ?>" <?= $student['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($class['class_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="admissionYear">Admission Year</label>
                            <input type="number" name="admissionYear" id="admissionYear" value="<?= htmlspecialchars($student['admission_year']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="semester">Current Semester</label>
                            <input type="text" name="semester" id="semester" value="<?= htmlspecialchars($student['semester']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="status">Academic Status</label>
                            <select id="status" name="status">
                                <option <?= $student['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                                <option <?= $student['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option <?= $student['status'] === 'Suspended' ? 'selected' : '' ?>>Suspended</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Update Student</button>
                    <a href="/admin/student?id=<?= $student_id ?>" class="btn btn--outline">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <script src="/assets/js/admin.js"></script>
</body>
</html>