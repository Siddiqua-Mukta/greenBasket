<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}

$vendor_id = $_SESSION['vendor_id'];

// Total products
$p = $conn->query("SELECT COUNT(*) AS total FROM products WHERE vendor_id='$vendor_id'");
$row = $p->fetch_assoc();
$total_products = $row['total'];

// Total orders
$o = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE vendor_id='$vendor_id'");
$row = $o->fetch_assoc();
$total_orders = $row['total'];

// Completed Orders
$c = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE vendor_id='$vendor_id' AND order_status='completed'");
$row = $c->fetch_assoc();
$completed_orders = $row['total'];

// Low Stock
$l = $conn->query("SELECT COUNT(*) AS total FROM products WHERE vendor_id='$vendor_id' AND stock <= 5");
$row = $l->fetch_assoc();
$low_stock = $row['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vendor Dashboard</title>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body {
    background: #f4f6f9;
}
.content {
    margin-left: 250px;
    padding: 20px;
}

.card-box {
    padding: 25px 20px;
    border-radius: 12px;
    color: #fff;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 10px rgba(0,0,0,0.10);
}
.card-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.20);
    cursor: pointer;
}

.card-box i {
    font-size: 45px;
    opacity: 0.8;
}

.bg1 { background: #007bff; }
.bg2 { background: #28a745; }
.bg3 { background: #17a2b8; }
.bg4 { background: #dc3545; }

.card-title {
    font-size: 18px;
    margin-top: 10px;
}
.card-number {
    font-size: 35px;
    font-weight: bold;
}

@media(max-width: 768px){
    .content { margin-left: 0; }
}
</style>
</head>
<body>

<?php include('sidebar.php'); ?>

<div class="content">
    <h2 class="mb-3">Welcome to Vendor Panel</h2>
    <hr>

    <div class="row">

        <!-- Total Products -->
        <div class="col-md-3 mb-4">
            <div class="card-box bg1 shadow">
                <i class="fas fa-box-open"></i>
                <div class="card-number"><?php echo $total_products; ?></div>
                <div class="card-title">Total Products</div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-3 mb-4">
            <div class="card-box bg2 shadow">
                <i class="fas fa-shopping-cart"></i>
                <div class="card-number"><?php echo $total_orders; ?></div>
                <div class="card-title">Total Orders</div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-md-3 mb-4">
            <div class="card-box bg3 shadow">
                <i class="fas fa-check-circle"></i>
                <div class="card-number"><?php echo $completed_orders; ?></div>
                <div class="card-title">Completed Orders</div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-md-3 mb-4">
            <div class="card-box bg4 shadow">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="card-number"><?php echo $low_stock; ?></div>
                <div class="card-title">Low Stocks</div>
            </div>
        </div>


    </div>
</div>

</body>
</html>
