<?php
require_once '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get statistics
$patients_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM patients"))['count'];
$doctors_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM doctors"))['count'];
$appointments_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM appointments"))['count'];
$pending_appointments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM appointments WHERE status='pending'"))['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tena Hospital</title>
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
        <div style="background:white; padding:20px; border-radius:8px; margin:20px 0;">
            <h2>Admin Dashboard</h2>
            <p>Welcome, <?php echo $_SESSION['admin_username']; ?>!</p>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Patients</h3>
                <p style="font-size:36px; font-weight:bold;"><?php echo $patients_count; ?></p>
            </div>
            <div class="card">
                <h3>Total Doctors</h3>
                <p style="font-size:36px; font-weight:bold;"><?php echo $doctors_count; ?></p>
            </div>
            <div class="card">
                <h3>Total Appointments</h3>
                <p style="font-size:36px; font-weight:bold;"><?php echo $appointments_count; ?></p>
            </div>
            <div class="card">
                <h3>Pending Appointments</h3>
                <p style="font-size:36px; font-weight:bold; color:orange;"><?php echo $pending_appointments; ?></p>
            </div>
        </div>

        <div style="background:white; padding:20px; border-radius:8px; margin:20px 0;">
            <h3>Quick Actions</h3>
            <div style="display:flex; gap:10px; margin-top:15px;">
                <a href="manage_doctors.php" class="btn">Manage Doctors</a>
                <a href="../view_appointments.php" class="btn btn-secondary">View All Appointments</a>
            </div>
        </div>
    </div>
</body>
</html>