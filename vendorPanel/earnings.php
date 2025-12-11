<?php
session_start();
if(!isset($_SESSION['vendor_id'])){
    header("Location: login.php");
    exit();
}
include '../db_connect.php';
include 'sidebar.php';
$vendor_id = $_SESSION['vendor_id'];

// Total Sales (completed orders)
$total_sales_q = mysqli_query($conn, "SELECT SUM(total) as total FROM orders WHERE vendor_id='$vendor_id' AND order_status='completed'");
$total_sales_row = mysqli_fetch_assoc($total_sales_q);
$total_sales = $total_sales_row['total'] ?? 0;

// Pending Payout (orders completed but not withdrawn)
$pending_q = mysqli_query($conn, "SELECT SUM(total) as pending FROM orders 
    WHERE vendor_id='$vendor_id' AND order_status='completed' 
    AND id NOT IN (SELECT id FROM vendor_withdraws WHERE vendor_id='$vendor_id' AND status='completed')");
$pending_row = mysqli_fetch_assoc($pending_q);
$pending_payout = $pending_row['pending'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vendor Earnings</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
body {
    display: flex;
    min-height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
}

/* Sidebar width */
.sidebar {
    width: 250px;
    min-height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: #343a40;
    color: #fff;
}

/* Content area next to sidebar */
.content-area {
    margin-left: 250px; /* sidebar width */
    width: calc(100% - 250px);
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

/* Earnings card style */
.earnings-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 2rem;
    margin-bottom: 1.5rem;
}
.earnings-card h5 {
    margin-bottom: 1rem;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        position: relative;
        width: 100%;
        min-height: auto;
    }
    .content-area {
        margin-left: 0;
        width: 100%;
        padding: 1rem;
    }
}
</style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="content-area">
    <h2 class="text-success fw-bold mb-4">Earnings</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="earnings-card text-center">
                <h5>Total Sales</h5>
                <p class="fs-3 text-success">৳<?php echo number_format($total_sales,2); ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="earnings-card text-center">
                <h5>Pending Payout</h5>
                <p class="fs-3 text-warning">৳<?php echo number_format($pending_payout,2); ?></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
