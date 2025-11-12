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




// Fetch orders
$orders=[];
$stmt=$conn->prepare("SELECT id,total,payment,order_date,address FROM orders WHERE email=? ORDER BY order_date DESC");
$stmt->bind_param("s",$user['email']);
$stmt->execute();
$res=$stmt->get_result();
if($res) $orders=$res->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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
.profile-pic {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #28a745;
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



            <!-- Orders -->
            <div class="col-lg-12" id="orders">
                <div class="card p-4 mt-3">
                    <h5 class="text-center">🛒 Your Orders</h5>
                    <?php if(empty($orders)){ ?>
                        <p class="text-center text-muted mt-3">No orders found.</p>
                    <?php } else { ?>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-bordered text-center">
                                <thead class="table-success">
                                    <tr>
                                        <th>ID</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($orders as $o): ?>
                                    <tr>
                                        <td><?php echo $o['id']; ?></td>
                                        <td><?php echo number_format($o['total'],2); ?> ৳</td>
                                        <td><?php echo htmlspecialchars($o['payment']); ?></td>
                                        <td><?php echo htmlspecialchars($o['order_date']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
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
