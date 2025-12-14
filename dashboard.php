<?php
require_once 'config/database.php';

// Check if patient is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
$patient_name = $_SESSION['patient_name'];

// Get appointment counts
$sql = "SELECT 
        COUNT(*) as total,
        COUNT(CASE WHEN status='pending' THEN 1 END) as pending,
        COUNT(CASE WHEN status='confirmed' THEN 1 END) as confirmed,
        COUNT(CASE WHEN status='completed' THEN 1 END) as completed
        FROM appointments WHERE patient_id=$patient_id";
$result = mysqli_query($conn, $sql);
$counts = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tena Hospital</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>TENA <span>HOSPITAL</span></h1>
                </div>
                <nav class="nav">
                    <ul>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="book_appointment.php">Book Appointment</a></li>
                        <li><a href="view_appointments.php">My Appointments</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div style="background:white; padding:20px; border-radius:8px; margin:20px 0;">
            <h2>Welcome, <?php echo $patient_name; ?>!</h2>
            <p>Manage your appointments from here.</p>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Appointments</h3>
                <p style="font-size:36px; font-weight:bold;"><?php echo $counts['total'] ?? 0; ?></p>
            </div>
            <div class="card">
                <h3>Pending</h3>
                <p style="font-size:36px; font-weight:bold; color:orange;"><?php echo $counts['pending'] ?? 0; ?></p>
            </div>
            <div class="card">
                <h3>Confirmed</h3>
                <p style="font-size:36px; font-weight:bold; color:green;"><?php echo $counts['confirmed'] ?? 0; ?></p>
            </div>
            <div class="card">
                <h3>Completed</h3>
                <p style="font-size:36px; font-weight:bold; color:blue;"><?php echo $counts['completed'] ?? 0; ?></p>
            </div>
        </div>

        <div style="background:white; padding:20px; border-radius:8px; margin:20px 0;">
            <h3>Quick Actions</h3>
            <div style="display:flex; gap:10px; margin-top:15px;">
                <a href="book_appointment.php" class="btn">Book New Appointment</a>
                <a href="view_appointments.php" class="btn btn-secondary">View All Appointments</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Tena Hospital</p>
        </div>
    </div>
</body>
</html>