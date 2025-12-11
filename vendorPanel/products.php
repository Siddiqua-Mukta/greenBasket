<?php
session_start();
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit;
}

include('../db_connect.php');
$vendor_id = $_SESSION['vendor_id'];

// Fetch vendor products
$result = mysqli_query($conn, "SELECT * FROM products WHERE vendor_id = $vendor_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vendor | My Products</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        display: flex;
        background: #f4f4f9;
        font-family: Arial;
    }
    .sidebar {
        width: 250px;
        height: 100vh;
        background: #343a40;
        padding-top: 20px;
        position: fixed;
        left: 0;
        top: 0;
    }
    .sidebar a {
        display: block;
        padding: 12px 20px;
        color: #ffffff;
        text-decoration: none;
        font-size: 16px;
        margin-bottom: 5px;
    }
    .sidebar a:hover {
        background: #495057;
        text-decoration: none;
    }
    .main-content {
        margin-left: 260px;
        padding: 25px;
        width: calc(100% - 260px);
    }
    .table thead {
        background: #007bff;
        color: #fff;
    }
    .btn-add {
        background: #28a745;
        color: #fff;
    }
    .btn-add:hover {
        background: #218838;
        color: #fff;
    }
</style>

</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center text-white mb-4">Vendor Panel</h4>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="products.php">📦 My Products</a>
    <a href="add_product.php">➕ Add Product</a>
    <a href="orders.php">🛒 My Orders</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h3 class="mb-3">📦 My Products</h3>

    <a href="add_product.php" class="btn btn-add mb-3">➕ Add New Product</a>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Thumbnail</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th width="160px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)): 
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>

                        <td>
                            <img src="../uploads/<?php echo $row['image']; ?>" 
                                 width="60" height="60" style="object-fit:cover;">
                        </td>

                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo $row['price']; ?> ৳</td>
                        <td><?php echo $row['stock']; ?></td>

                        <td>
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" 
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure to delete this product?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
