<?php
include '../db_connect.php';
include 'session.php';

// Show errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // Check if username exists
    $sql = "SELECT * FROM admin WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $token = bin2hex(random_bytes(50)); // Generate secure token
        $expiry = date("Y-m-d H:i:s", strtotime("+15 minutes")); // Token valid for 15 mins

        // Update DB
        $update = "UPDATE admin SET reset_token='$token', token_expiry='$expiry' WHERE username='$username'";
        mysqli_query($conn, $update);

        // Display the reset link (can later use email)
        $resetLink = "http://localhost/greenBasket/admin/reset_password.php?token=$token";
        $message = "Password reset link: <a href='$resetLink'>$resetLink</a>";
    } else {
        $error = "Username not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card p-4" style="width: 400px;">
    <h4 class="text-center mb-3">Forgot Password</h4>

    <form method="post">
        <div class="form-group">
            <label>Enter Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <button type="submit" name="submit" class="btn btn-success btn-block">Continue</button>
    </form>

    <?php
        if(isset($error)) echo "<p class='text-danger mt-3'>$error</p>";
        if(isset($message)) echo "<p class='text-success mt-3'>$message</p>";
    ?>
</div>

</body>
</html>
