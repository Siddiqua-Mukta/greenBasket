<?php

if(!isset($_SESSION['vendor_id'])){
    header("Location: login.php");
    exit();
}
$vendor_name = $_SESSION['vendor_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vendor Panel Sidebar</title>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body { margin: 0; padding: 0; background: #f4f6f9; }
.sidebar { 
    height: 100vh; 
    width: 240px; 
    position: fixed; 
    top: 0; 
    left: 0; 
    background: #116b2e; 
    padding-top: 20px; 
    color: #fff; 
}
.sidebar a { 
    padding: 12px 20px; 
    display: block; 
    color: #fff; 
    text-decoration: none; 
    font-size: 16px; 
}
.sidebar a:hover { background: #0b4f21; }
.sidebar .active { background: #0a441c; font-weight: bold; }
.content { 
    margin-left: 250px; 
    padding: 20px; 
}
.navbar-brand .logo-img {
    height: 50px; /* ⭐ উচ্চতা (Height) পরিবর্তন করুন ⭐ */
    width: auto;  /* প্রস্থ (Width) স্বয়ংক্রিয়ভাবে উচ্চতার সাথে সামঞ্জস্য করবে */
    margin-right: 0px; 
    vertical-align: middle; 
}
</style>
</head>
<body>

<div class="sidebar">
   <h4 class="text-center"><a class="navbar-brand" href="../index.php">
        <img src="../image/logo.png" alt="GreenBasket Logo" class="logo-img"> 
        GreenBasket
    </a></h4>
    <hr style="background:#fff;">

    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="add_product.php"><i class="fas fa-plus-circle"></i> Add Product</a>
    <a href="manage_products.php"><i class="fas fa-box"></i> Manage Products</a>
    <a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
    <a href="earnings.php"><i class="fas fa-wallet"></i> Earnings</a>
    <a href="withdraw_request.php"><i class="fas fa-money-check-alt"></i> Withdraw</a>
    <a href="withdraw_history.php"><i class="fas fa-history"></i> Withdraw History</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

</body>
</html>
