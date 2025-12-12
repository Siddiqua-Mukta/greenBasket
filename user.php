<?php
include('db_connect.php');
session_start();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email)) $errors[] = "Email is required.";
    if (empty($password)) $errors[] = "Password is required.";

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $name, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                
                if(password_verify($password, $hashed_password)){

    // Admin
    if($email == "admin@gmail.com"){
        $_SESSION['is_admin'] = true;
        $_SESSION['user_id'] = $id;
        header("refresh:2;url=admin_page.php");
    }
    // Vendor
    elseif(strpos($email,'@vendor.com') !== false){
        // যদি vendors table ব্যবহার করো, query দিয়ে vendor check করতে হবে
        $_SESSION['vendor_id'] = $id;
        $_SESSION['vendor_name'] = $name;
        header("refresh:2;url=vendor/dashboard.php");
    }
    // Normal User
    else{
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        header("refresh:2;url=index.php");
    }
}

            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "No account found with this email.";
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
<title>Login - GreenBasket</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
        background-color: #f8f9fa;
    }

    .navbar-nav .nav-item {
        margin-left: 20px;
    }
    .navbar-nav .nav-item .nav-link, .navbar-brand {
        color: white;
    }
    .search-bar input[type="text"] {
        width: 300px;
        border-radius: 0;
    }
    .search-bar button {
        border-radius: 0;
    }

    .content {
        flex: 1 0 auto; /* Pushes footer down */
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px 15px;
    }

.login-container {
    max-width: 450px;
    margin: 120px auto 60px auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.15);
}

.login-container h2 {
    text-align: center;
    margin-bottom: 25px;
}

.login-container .btn {
    width: 100%;
}

.login-container .text-center a {
    color: #007bff;
}

.login-container .text-center a:hover {
    text-decoration: underline;
}

</style>
</head>
<body>

<?php include('navbar.php');?>

<section class="py-4 bg-light">
    <h1 class="text-center mb-1">Welcome to GreenBasket</h1>
    <div class="row">
    </div>

<div class="container">
    <div class="login-container">
        <h2 class="text-center">Login to Your Account</h2>

        <!-- Errors -->
        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach($errors as $error) echo "<li>$error</li>"; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Success -->
        <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-success">Login</button>
            <div class="text-center mt-3"><a href="forgot_password.php">Forgot Password?</a></div>
            <div class="text-center mt-2">
                <p>Don't have an account? <a href="caccount.php">Create an Account</a></p>
            </div>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
