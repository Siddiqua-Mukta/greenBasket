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

// Fetch user info
function get_user($conn, $user_id) {
    $stmt = $conn->prepare("SELECT id, name, email, image, password FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}

$user = get_user($conn, $user_id);

// ---- Change Password ----
if (isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if (password_verify($current, $user['password']) || $current === $user['password']) {
        if ($new === $confirm) {
            $hashed = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
            $stmt->bind_param("si", $hashed, $user_id);
            $stmt->execute();
            $success = "✅ Password changed successfully!";
        } else {
            $error = "New passwords do not match!";
        }
    } else {
        $error = "Current password is incorrect!";
    }
}

// ---- Reset Password ----
if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if ($new_pass === $confirm_pass) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
            $row = $res->fetch_assoc();
            $uid = $row['id'];

            $update = $conn->prepare("UPDATE users SET password=? WHERE id=?");
            $update->bind_param("si", $hashed, $uid);
            $update->execute();
            $success = "✅ Password reset successfully!";
        } else {
            $error = "Email not found!";
        }
    } else {
        $error = "New passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Change Password - GreenBasket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background-color: #f5f6fa;
    font-family: 'Segoe UI', sans-serif;
}

/* ✅ Sidebar CSS Added */
.sidebar {
    height: 100vh;
    background-color: #378149ff;
    color: #fff;
    padding-top: 30px;
    position: fixed;
    width: 220px;
    top: 0;
    left: 0;
}
.sidebar a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 12px 20px;
    border-radius: 8px;
    margin: 5px 10px;
    transition: 0.3s;
    font-weight: 500;
}
.sidebar a:hover {
    background-color: #232a24ff;
}

.main-content {
    margin-left: 240px;
    padding: 40px;
}

.card {
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    padding: 50px 45px;
    min-height: 420px;
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.alert {
    border-radius: 10px;
    position: fixed;
    top: 15px;
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.6s ease-in-out;
}
.alert.show {
    opacity: 1;
}

.match-message {
    font-size: 14px;
    margin-top: -5px;
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3 class="text-center mb-2">
        <a href="index.php" style="text-decoration: none; color: inherit;">GreenBasket</a>
    </h3>
    <a href="user_panel.php">Profile</a>
    <a href="user_change_pass.php">Change Password</a>
    <a href="user_orders.php">Orders</a>
    <a href="user_logout.php">Logout</a>
</div>

<!-- Main content -->
<div class="main-content">
    <div class="container d-flex justify-content-center align-items-start" style="min-height: 80vh; padding-top: 80px;">
        <div class="col-lg-6 col-md-8">

            <!-- Change Password Box -->
            <div class="card" id="changeBox">
                <h4 class="text-center mb-4">🔒 Change Password</h4>
                <form method="post">
                    <input type="password" name="current_password" class="form-control mb-3" placeholder="Current Password" required>
                    <input type="password" id="new_password" name="new_password" class="form-control mb-2" placeholder="New Password" required>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control mb-1" placeholder="Confirm Password" required>
                    <p id="match-message" class="match-message text-center"></p>
                    <button type="submit" name="change_password" class="btn btn-warning w-100 mt-2">Change Password</button>
                </form>
                <p class="text-center mt-3"><a href="#" id="showReset" class="text-primary text-decoration-none">Forgot Password?</a></p>
            </div>

            <!-- Reset Password Box -->
            <div class="card" id="resetBox" style="display:none;">
                <h4 class="text-center mb-4">🔁 Reset Password</h4>
                <form method="post">
                    <input type="email" name="email" class="form-control mb-3" placeholder="Your Registered Email" required>
                    <input type="password" name="new_pass" class="form-control mb-3" placeholder="New Password" required>
                    <input type="password" name="confirm_pass" class="form-control mb-3" placeholder="Confirm New Password" required>
                    <button type="submit" name="reset_password" class="btn btn-success w-100 mt-2">Reset Password</button>
                </form>
                <p class="text-center mt-3"><a href="#" id="showChange" class="text-primary text-decoration-none">← Back to Change Password</a></p>
            </div>

        </div>
    </div>
</div>

<!-- Popup Alerts -->
<?php if ($success || $error): ?>
<div id="popupAlert" class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>">
    <?php echo $success ? $success : $error; ?>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ---- Toggle Forms ----
document.getElementById('showReset').addEventListener('click', function(e){
    e.preventDefault();
    document.getElementById('changeBox').style.display = 'none';
    document.getElementById('resetBox').style.display = 'block';
});
document.getElementById('showChange').addEventListener('click', function(e){
    e.preventDefault();
    document.getElementById('resetBox').style.display = 'none';
    document.getElementById('changeBox').style.display = 'block';
});

// ---- Password Match (Change) ----
const newPass = document.getElementById('new_password');
const confirmPass = document.getElementById('confirm_password');
const message = document.getElementById('match-message');

function checkMatch() {
    if (confirmPass.value === "") {
        message.textContent = "";
        return;
    }
    if (newPass.value === confirmPass.value) {
        message.textContent = "✅ Passwords match";
        message.style.color = "green";
    } else {
        message.textContent = "❌ Passwords do not match";
        message.style.color = "red";
    }
}
newPass.addEventListener('keyup', checkMatch);
confirmPass.addEventListener('keyup', checkMatch);

// ---- Popup Animation ----
const alertBox = document.getElementById('popupAlert');
if (alertBox) {
    setTimeout(() => {
        alertBox.classList.add('show');
    }, 100); // show animation
    setTimeout(() => {
        alertBox.classList.remove('show');
        setTimeout(() => alertBox.remove(), 600); // remove from DOM after fade
    }, 3000); // disappear after 3 sec
}
</script>

</body>
</html>
