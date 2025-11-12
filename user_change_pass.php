<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = "";
$error = "";

function get_user($conn, $user_id) {
    $stmt = $conn->prepare("SELECT id,name,email,image,password FROM users WHERE id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}

$user = get_user($conn,$user_id);



// Change password
if(isset($_POST['change_password'])){
    $current=$_POST['current_password'];
    $new=$_POST['new_password'];
    $confirm=$_POST['confirm_password'];

    if(password_verify($current,$user['password']) || $current===$user['password']){
        if($new===$confirm){
            $hashed=password_hash($new,PASSWORD_DEFAULT);
            $stmt=$conn->prepare("UPDATE users SET password=? WHERE id=?");
            $stmt->bind_param("si",$hashed,$user_id);
            $stmt->execute();
            $success="Password changed successfully!";
        } else $error="New passwords do not match!";
    } else $error="Current password is incorrect!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Panel - GreenBasket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f5f6fa; }
.sidebar {
    height: 100vh;
    background-color: #28a745;
    color: #fff;
    padding-top: 30px;
    position: fixed;
    width: 220px;
}
.sidebar a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 12px 20px;
    border-radius: 8px;
    margin: 5px 10px;
}
.sidebar a:hover {
    background-color: #232a24ff;
}
.main-content {
    margin-left: 240px;
    padding: 40px;
}
.card { border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.alert { border-radius: 10px; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center mb-4">GreenBasket</h4>
    <a href="user_panel.php">Profile</a>
    <a href="user_change_pass.php">Change Password</a>
    <a href="user_orders.php">Orders</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Main content -->
<div class="main-content">
    <div class="container-fluid">
        <div class="row g-4">

            <!-- Password -->
            <div class="col-lg-4" id="password">
                <div class="card p-4">
                    <h5 class="text-center">🔒 Change Password</h5>
                    <form method="post" class="mt-3">
                        <input type="password" name="current_password" class="form-control mb-3" placeholder="Current Password" required>
                        <input type="password" name="new_password" class="form-control mb-3" placeholder="New Password" required>
                        <input type="password" name="confirm_password" class="form-control mb-3" placeholder="Confirm Password" required>
                        <button type="submit" name="change_password" class="btn btn-warning w-100">Change Password</button>
                    </form>
                </div>
            </div>

            
        <!-- Alerts -->
        <div class="mt-4">
            <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
            <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
