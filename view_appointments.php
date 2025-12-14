<?php
require_once 'config/database.php';

// Check if patient is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

// Get appointments
$sql = "SELECT a.*, d.full_name as doctor_name, d.specialization 
        FROM appointments a 
        JOIN doctors d ON a.doctor_id = d.id 
        WHERE a.patient_id = $patient_id 
        ORDER BY a.appointment_date DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments - Tena Hospital</title>
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
        <div class="table-container">
            <h2>My Appointments</h2>
            
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>Symptoms</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['appointment_date']; ?></td>
                                <td><?php echo $row['appointment_time']; ?></td>
                                <td><?php echo $row['doctor_name']; ?></td>
                                <td><?php echo $row['specialization']; ?></td>
                                <td><?php echo $row['symptoms']; ?></td>
                                <td>
                                    <?php 
                                    $status = $row['status'];
                                    $color = '';
                                    if ($status == 'pending') $color = 'orange';
                                    if ($status == 'confirmed') $color = 'green';
                                    if ($status == 'completed') $color = 'blue';
                                    if ($status == 'cancelled') $color = 'red';
                                    ?>
                                    <span style="color:<?php echo $color; ?>; font-weight:bold;">
                                        <?php echo ucfirst($status); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No appointments found. <a href="book_appointment.php">Book your first appointment</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>