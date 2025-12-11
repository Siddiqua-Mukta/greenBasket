<?php
include('../db_connect.php'); // vendor folder e thakle ../ adjust korte hobe
session_start();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email)) $errors[] = "Email is required.";
    if (empty($password)) $errors[] = "Password is required.";

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, name, password FROM vendors WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $name, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['vendor_id'] = $id;
                $_SESSION['vendor_name'] = $name;
                $success = "Login successful! Redirecting...";
                header("refresh:2;url=dashboard.php"); // vendor dashboard
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "No vendor account found with this email.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vendor Login - GreenBasket</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
body { font-family: Arial, sans-serif; }
        .navbar-nav .nav-item { margin-left: 20px; }
        .navbar-nav .nav-item .nav-link, .navbar-brand { color: white; }
        .search-bar input[type="text"] { width: 300px; border-radius: 0; }
        .search-bar button { border-radius: 0; }
.content {flex: 1 0 auto; display: flex; justify-content: center; align-items: center; padding: 50px 15px;}
.login-container {max-width: 450px; margin: 120px auto 60px auto; padding: 30px; background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.15);}
.login-container h2 {text-align: center; margin-bottom: 25px;}
.login-container .btn {width: 100%;}
.login-container .text-center a {color: #007bff;}
.login-container .text-center a:hover {text-decoration: underline;}
.footer {background-color: #116b2e; color: white; padding: 20px 0;} 
.footer a {color: white; text-decoration: none;} 
.footer .social-icons a {margin: 0 10px;} 
.footer .social-icons i {font-size: 24px;}
</style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container">
    <div class="login-container">
        <h2 class="text-center">Vendor Login</h2>

        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger"><ul><?php foreach($errors as $error) echo "<li>$error</li>"; ?></ul></div>
        <?php endif; ?>

        <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your vendor email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-success">Login</button>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="register.php">Create Vendor Account</a></p>
            </div>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>
