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

$grand_total = 0;
$grand_quantity = 0;

foreach ($orders as $order) {
    $grand_total += $order['total'];
    $grand_quantity += $order['total_quantity'];
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
    background-color: #286136ff;
    color: #fff;
    padding-top: 30px;
    position: fixed;
    width: 235px;
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
.sidebar a:hover { background-color: #232a24; }
.main-content { margin-left: 240px; padding: 40px; }
.card { border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }

/* Table Footer & Summary */
.order-summary-row {
    display: table-row;
    font-weight: bold;
}
.order-summary-row td {
    border: none !important;
    padding-top: 15px !important;
}
.grand-label {
    font-size: 0.9rem;
    font-weight: bold;
    color: #b42828;
    display: block;
    margin-bottom: -5px;
}
.total-orders-cell { text-align: left !important; font-size: 1rem; color: #478b58; }
.grand-quantity-cell { text-align: center !important; font-size: 1rem; color: #000; }
.grand-total-cell { text-align: center !important; font-size: 1rem; color: #000; }
/* লোগো ইমেজের স্টাইল */
.navbar-brand .logo-img {
    height: 35px; /* ⭐ উচ্চতা (Height) পরিবর্তন করুন ⭐ */
    width: auto;  /* প্রস্থ (Width) স্বয়ংক্রিয়ভাবে উচ্চতার সাথে সামঞ্জস্য করবে */
    margin-right: 0px; 
    vertical-align: middle; 
}
    @media (min-width: 992px) { 
        /* 'dropdown' ক্লাস যুক্ত li-কে হোভার করলে ড্রপডাউন মেনুটি দেখাবে */
        .navbar .dropdown:hover .dropdown-menu {
            display: block; /* ড্রপডাউন মেনুটিকে দৃশ্যমান করে */
            margin-top: 0; /* মেনু যাতে ন্যাভবারের সাথে লেগে থাকে */
        }

        /* ড্রপডাউন মেনুটি স্বাভাবিকভাবেই উপরে চলে যায়, তাই এটিকে সঠিকভাবে সারিবদ্ধ করার জন্য */
        .navbar .dropdown-menu {
            margin-top: -1px; 
        }
    }
</style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center"><a class="navbar-brand" href="index.php">
        <img src="image/logo.png" alt="GreenBasket Logo" class="logo-img"> 
        GreenBasket
    </a></h4>
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
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th>Payment Type</th>
                                        <th>Delivery Type</th>
                                        <th>Order Status</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($orders as $o): ?>
                                    <tr>
                                        <td><?php echo $o['id']; ?></td>
                                        <td><?php echo date('M d, Y h:i A', strtotime($o['order_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($o['payment']); ?></td>
                                        <td><?php echo htmlspecialchars($o['delivery_type']); ?></td>
                                        <td><?php echo htmlspecialchars($o['order_status']); ?></td>
                                        <td><?php echo $o['total_quantity']; ?></td>
                                        <td><?php echo number_format($o['total'],2); ?> ৳</td>
                                        <td>
                                            <button class="btn btn-sm btn-success text-white" 
                                                onclick="loadOrderDetails(<?php echo $o['id']; ?>)" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#orderDetailsModal">
                                                Details
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="order-summary-row">
                                        <td colspan="3" class="text-start total-orders-cell">
                                            Total Orders: <span class="badge bg-success"><?php echo count($orders); ?></span>
                                        </td>
                                        <td colspan="2"></td>
                                        <td class="grand-quantity-cell">
                                            <span class="grand-label">Grand Quantity:</span> <?php echo $grand_quantity; ?> Items
                                        </td>
                                        <td class="grand-total-cell">
                                            <span class="grand-label">Grand Total:</span> ৳<?php echo number_format($grand_total, 2); ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
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

<!-- Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="orderDetailsBody">
        <p class="text-center text-muted">Loading...</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// AJAX function to load order details
function loadOrderDetails(orderId) {
    document.getElementById("orderDetailsBody").innerHTML = "<p class='text-center text-muted'>Loading...</p>";
    fetch("fetch_order_details.php?id=" + orderId)
        .then(res => res.text())
        .then(data => {
            document.getElementById("orderDetailsBody").innerHTML = data;
        })
        .catch(err => {
            document.getElementById("orderDetailsBody").innerHTML = "<p class='text-danger'>Failed to load order details.</p>";
        });
}
</script>

</body>
</html>
