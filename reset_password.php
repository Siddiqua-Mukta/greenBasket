<?php
include('db_connect.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$token = $_GET['token'] ?? '';
$errors = [];
$success = '';

if (empty($token)) {
    die("Invalid or missing token.");
}

// Token verify
$stmt = $conn->prepare("SELECT email, token_expiry FROM users WHERE reset_token=?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Invalid token.");
}

if (strtotime($user['token_expiry']) < time()) {
    die("Token expired. Please request a new password reset.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($new_password) || empty($confirm_password)) {
        $errors[] = "Please fill all fields.";
    } elseif ($new_password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $update = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, token_expiry=NULL WHERE reset_token=?");
        $update->bind_param("ss", $hashed, $token);
        $update->execute();

        $success = "✅ Password successfully reset. You can now <a href='user.php'>login</a>.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password - GreenBasket</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        width: 100%;
        max-width: 480px;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .login-container h2 {
        margin-bottom: 20px;
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

    footer.footer {
        flex-shrink: 0;
        background-color: #116b2e;
        color: white;
        padding: 20px 0;
    }
    footer.footer a {
        color: white;
        text-decoration: none;
    }
    footer .social-icons a {
        margin: 0 10px;
    }
    footer .social-icons i {
        font-size: 24px;
    }
</style>
</head>
<body>
<?php include('navbar.php'); ?>




<!-- Main Content -->
<div class="content">
    <div class="login-container">
        <h2 class="text-center">Reset Your Password</h2>

        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach($errors as $error) echo "<p>$error</p>"; ?>
            </div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php else: ?>
            <form method="POST">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-4 text-left">
                <h3>GreenBasket</h3>
                <p>Fresh & eco-friendly vibe...!</p>
                <p><i class="fas fa-home"></i> Uttor Halishahar, Chattogram</p>
                <p><i class="fas fa-envelope"></i> info@GreenBasket.com</p>
                <p><i class="fas fa-phone"></i> 01980468252</p>
            </div>
            <div class="col-md-4">
                <h3>Quick Links</h3>
                <ul class="list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="categories.php">Shop</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="return_policy.php" target="_blank">Returned Policy</a></li> 
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-3 bg-light opacity-100">
        <div class="text-center mt-3">&copy; 2025 GreenBasket. All rights reserved.</div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
