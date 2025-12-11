<?php
include('../db_connect.php'); // vendor folder থেকে db_connect include

$errors = [];
$success = '';

// ফর্ম সাবমিশন চেক
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $shop_name = trim($_POST['shop_name']);

    // ইনপুট ভ্যালিডেশন
    if (empty($name)) $errors[] = "Full Name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($password)) $errors[] = "Password is required.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (empty($shop_name)) $errors[] = "Shop name is required.";

    // ইমেল এক্সিস্ট চেক
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM vendors WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Email is already registered.";
        }
        $stmt->close();
    }

    // ভেন্ডর ইনসার্ট
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO vendors (name,email,password,shop_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $shop_name);
        if ($stmt->execute()) {
            $success = "Vendor account created successfully! <a href='login.php'>Login here</a>";
        } else {
            $errors[] = "Database error: " . $stmt->error;
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
<title>Create Vendor Account - GreenBasket</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    body { background-color: #f8f9fa; }
    .account-container {
        max-width: 450px; margin: 100px auto; padding: 20px;
        background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .account-container .btn { width: 100%; }
    .account-container .text-center a { color: #007bff; }
    .account-container .text-center a:hover { text-decoration: underline; }
</style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container">
    <div class="account-container">
        <h2 class="text-center">Vendor Registration</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error) echo "<li>$error</li>"; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="shop_name">Shop Name</label>
                <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Enter your shop name" required>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
            <div class="text-center mt-3">
                <p>Already have a vendor account? <a href="login.php">Login here</a></p>
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
