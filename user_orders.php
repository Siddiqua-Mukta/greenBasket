<?php
session_start();
include('db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = "";
$error = "";

// Function to get user info
function get_user($conn, $user_id) {
    $stmt = $conn->prepare("SELECT id, name, email, image FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}

$user = get_user($conn, $user_id);

// Fetch orders by user_id
$orders = [];
$stmt = $conn->prepare("SELECT id, total, total_quantity, payment, delivery_type, order_status, order_date, address FROM orders WHERE user_id=? ORDER BY order_date DESC");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) $orders = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $error = "Failed to fetch orders. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Orders - GreenBasket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f5f6fa; }
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
.sidebar a:hover { background-color: #232a24ff; }
.main-content { margin-left: 240px; padding: 40px; }
.card { border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.alert { border-radius: 10px; }
</style>
</head>
<body>

<div class="sidebar">
    <h3 class="text-center mb-2">
        <a href="index.php" style="text-decoration: none; color: inherit;">GreenBasket</a>
    </h3>
    <a href="user_panel.php">Profile</a>
    <a href="user_change_pass.php">Change Password</a>
    <a href="user_orders.php">Orders</a>
    <a href="user_logout.php">Logout</a>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-lg-12" id="orders">
                <div class="card p-4 mt-3">
                    <h5 class="text-center">🛒 Your Orders</h5>
                    <?php if(empty($orders)) { ?>
                        <p class="text-center text-muted mt-3">No orders found.</p>
                    <?php } else { ?>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-bordered text-center">
                                <thead class="table-success">
                                    <tr>
                                        <th>ID</th>
                                        <th>Total Amount</th>
                                        <th>Quantity</th>
                                        <th>Payment Type</th>
                                        <th>Delivery Type</th>
                                        <th>Order Status</th>
                                        <th>Order Date</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($orders as $o): ?>
                                    <tr>
                                        <td><?php echo $o['id']; ?></td>
                                        <td><?php echo number_format($o['total'],2); ?> ৳</td>
                                        <td><?php echo $o['total_quantity']; ?></td>
                                        <td><?php echo htmlspecialchars($o['payment']); ?></td>
                                        <td><?php echo htmlspecialchars($o['delivery_type']); ?></td>
                                        <td><?php echo htmlspecialchars($o['order_status']); ?></td>
                                        <td><?php echo htmlspecialchars($o['order_date']); ?></td>
                                        <td><?php echo htmlspecialchars($o['address']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
            <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
