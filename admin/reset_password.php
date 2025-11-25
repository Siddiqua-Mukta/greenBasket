<?php
include 'db_connect.php';

if (!isset($_GET['token'])) {
    die("Invalid Request!");
}

$token = $_GET['token'];

$check = "SELECT * FROM admin WHERE reset_token='$token'";
$res = mysqli_query($conn, $check);

if (mysqli_num_rows($res) != 1) {
    die("Invalid or Expired Token!");
}

if (isset($_POST['reset'])) {
    $new = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $update = "UPDATE admin SET password='$new', reset_token='' WHERE reset_token='$token'";
    mysqli_query($conn, $update);

    echo "<script>alert('Password Reset Successful!'); window.location='login.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="col-md-5 bg-white p-4 shadow rounded">

        <h4 class="text-center mb-3">Reset Password</h4>

        <form method="POST">

            <div class="mb-3">
                <label>New Password:</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <button type="submit" name="reset" class="btn btn-success w-100">Reset Password</button>

        </form>

    </div>
</div>

</body>
</html>
