<?php
require_once 'config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = clean_input($_POST['full_name']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    $address = clean_input($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($full_name) || empty($email) || empty($phone) || empty($password)) {
        $error = "All fields are required!";
    } elseif ($password != $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        // Check if email exists
        $check_email = "SELECT id FROM patients WHERE email='$email'";
        $result = mysqli_query($conn, $check_email);
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Email already registered!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert into database
            $sql = "INSERT INTO patients (full_name, email, phone, address, password) 
                    VALUES ('$full_name', '$email', '$phone', '$address', '$hashed_password')";
            
            if (mysqli_query($conn, $sql)) {
                $success = "Registration successful! You can now login.";
                header("refresh:2;url=login.php");
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Tena Hospital</title>
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="login.php">Login</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Patient Registration</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required 
                           value="<?php echo isset($_POST['full_name']) ? $_POST['full_name'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required
                           value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" required
                           value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" rows="3"><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn" style="width:100%">Register</button>
            </form>

            <p style="text-align:center; margin-top:20px;">
                Already have an account? <a href="login.php">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>