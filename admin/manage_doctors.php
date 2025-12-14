<?php
require_once '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$error = '';
$success = '';

// Add new doctor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_doctor'])) {
    $full_name = clean_input($_POST['full_name']);
    $specialization = clean_input($_POST['specialization']);
    $phone = clean_input($_POST['phone']);
    $email = clean_input($_POST['email']);
    $available_days = clean_input($_POST['available_days']);
    $available_time = clean_input($_POST['available_time']);

    if (empty($full_name) || empty($specialization)) {
        $error = "Doctor name and specialization are required!";
    } else {
        $sql = "INSERT INTO doctors (full_name, specialization, phone, email, available_days, available_time) 
                VALUES ('$full_name', '$specialization', '$phone', '$email', '$available_days', '$available_time')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Doctor added successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

// Get all doctors
$doctors = mysqli_query($conn, "SELECT * FROM doctors ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors - Tena Hospital</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>TENA <span>HOSPITAL</span> - ADMIN</h1>
                </div>
                <nav class="nav">
                    <ul>
                        <li><a href="admin_dashboard.php">Dashboard</a></li>
                        <li><a href="manage_doctors.php">Manage Doctors</a></li>
                        <li><a href="../logout.php">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="form-container" style="margin-bottom:30px;">
            <h2>Add New Doctor</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>

                <div class="form-group">
                    <label>Specialization</label>
                    <input type="text" name="specialization" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>

                <div class="form-group">
                    <label>Available Days</label>
                    <input type="text" name="available_days" placeholder="e.g., Mon, Wed, Fri">
                </div>

                <div class="form-group">
                    <label>Available Time</label>
                    <input type="text" name="available_time" placeholder="e.g., 9:00 AM - 5:00 PM">
                </div>

                <button type="submit" name="add_doctor" class="btn" style="width:100%">Add Doctor</button>
            </form>
        </div>

        <div class="table-container">
            <h2>All Doctors</h2>
            
            <?php if (mysqli_num_rows($doctors) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Available Days</th>
                            <th>Available Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($doctor = mysqli_fetch_assoc($doctors)): ?>
                            <tr>
                                <td><?php echo $doctor['id']; ?></td>
                                <td><?php echo $doctor['full_name']; ?></td>
                                <td><?php echo $doctor['specialization']; ?></td>
                                <td><?php echo $doctor['phone']; ?></td>
                                <td><?php echo $doctor['email']; ?></td>
                                <td><?php echo $doctor['available_days']; ?></td>
                                <td><?php echo $doctor['available_time']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No doctors found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>