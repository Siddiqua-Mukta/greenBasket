<?php
include '../db_connect.php';

if (isset($_POST['send'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $sql = "SELECT * FROM admin WHERE username='$username'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $token = bin2hex(random_bytes(16));
        $update = "UPDATE admin SET reset_token='$token' WHERE username='$username'";
        mysqli_query($conn, $update);

        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";

        echo "<script>alert('Reset link: $reset_link');</script>"; 
    } else {
        $error = "Username Not Found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Forget Password</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
body {
    height: 100vh;
    background: #f2f2f2; /* subtle gray background */
    display: flex;
    justify-content: center;
    align-items: center;
}

.reset-card {
    background: #fff; /* solid white card */
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.form-control {
    transition: 0.3s;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 8px rgba(40,167,69,0.3);
}

.btn-success {
    background: #28a745;
    border: none;
    transition: 0.3s;
}

.btn-success:hover {
    background: #218838;
}

a { color: #28a745; transition: color 0.3s; }
a:hover { color: #19692c; }

.alert-danger {
    background: #f8d7da;
    color: #842029;
    border: none;
}

@media(max-width: 480px){
    .reset-card { padding: 1.5rem; }
}
</style>
</head>
<body>

<div class="reset-card">
    <h2 class="mb-3">Reset Password</h2>
    <h5 class="mb-4">Enter your username</h5>

    <?php if(isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">
        <div class="mb-3 text-start">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <button type="submit" name="send" class="btn btn-success w-100">Send Reset Link</button>

        <div class="mt-3">
            <a href="login.php">Back to Login</a>
        </div>
    </form>
</div>

</body>
</html>
