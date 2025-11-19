<?php
include '../db_connect.php';
include 'session.php';

// Show errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check token in URL
if (!isset($_GET['token'])) {
    die("Invalid request! Token missing.");
}

$token = mysqli_real_escape_string($conn, $_GET['token']);

// Fetch user with this token
$sql = "SELECT * FROM admin WHERE reset_token='$token'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    // Check token expiry
    if (strtotime($row['token_expiry']) < time()) {
        die("Token expired! Please request a new password reset.");
    }

} else {
    die("Invalid token! Please request a new password reset.");
}

// Handle form submission
if (isset($_POST['reset'])) {
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Hash new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update password and clear token
        $update = "UPDATE admin SET password='$hashed_password', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token'";
        mysqli_query($conn, $update);

        $success = "Password changed successfully! <a href='login.php'>Login Now</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card p-4" style="width: 400px;">
    <h4 class="text-center mb-3">Reset Password</h4>

    <?php
        if(isset($error)) echo "<p class='text-danger'>$error</p>";
        if(isset($success)) echo "<p class='text-success'>$success</p>";
    ?>

    <?php if(!isset($success)): ?>
    <form method="post">
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm" class="form-control" required>
        </div>
        <button type="submit" name="reset" class="btn btn-success btn-block mt-2">Update Password</button>
    </form>
    <?php endif; ?>
</div>

</body>
</html>
