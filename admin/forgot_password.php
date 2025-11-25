<?php
include 'db_connect.php';

if (isset($_POST['send'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "SELECT * FROM admin WHERE email='$email'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $token = bin2hex(random_bytes(16));
        $update = "UPDATE admin SET reset_token='$token' WHERE email='$email'";
        mysqli_query($conn, $update);

        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";

        echo "<script>alert('Reset link: $reset_link');</script>"; 
    } else {
        $error = "Email Not Found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forget Password</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    
    <div class="col-md-5 bg-white p-4 shadow rounded">
        <h4 class="text-center mb-3">Forget Password</h4>

        <?php if(isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label>Enter your email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <button type="submit" name="send" class="btn btn-success w-100">Send Reset Link</button>

        </form>
    </div>

</div>

</body>
</html>
