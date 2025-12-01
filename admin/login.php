<?php
include '../db_connect.php';
session_start();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Wrong Password!";
        }
    } else {
        $error = "Email Not Found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="row w-100">

        <!-- Outer Grid -->
        <div class="col-md-8 mx-auto bg-white shadow p-5 rounded">

            <h2 class="text-center text-success mb-4">Welcome to GreenBasket Admin</h2>

            <!-- Inner Grid -->
            <div class="col-md-6 mx-auto bg-light p-4 rounded">

                <h4 class="text-center mb-3">Login</h4>

                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <form action="" method="POST">

                    <div class="mb-3">
                        <label>Username:</label>
                        <input type="username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-success w-100">Login</button>

                    <div class="text-center mt-3">
                        <a href="forget_password.php">Forgot Password?</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>
