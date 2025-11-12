<?php
session_start();
include('db_connect.php');

// Admin check
if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true){
    header("Location: user.php");
    exit;
}

// Products CRUD handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        $stmt = $conn->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $name, $price, $stock);
        $stmt->execute();
        $stmt->close();
        header("Location: admin_page.php");
        exit;
    }

    if (isset($_POST['delete_product'])) {
        $id = $_POST['product_id'];
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: admin_page.php");
        exit;
    }

    if (isset($_POST['edit_product'])) {
        $id = $_POST['product_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, stock=? WHERE id=?");
        $stmt->bind_param("sdii", $name, $price, $stock, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: admin_page.php");
        exit;
    }
}

// Fetch all orders
$orders_query = "SELECT orders.id, users.name AS user_name, users.email AS user_email, orders.total, orders.order_date 
                 FROM orders 
                 JOIN users ON orders.id = users.id 
                 ORDER BY orders.order_date DESC";

$orders = $conn->query($orders_query);
if(!$orders){
    die("Orders query failed: " . $conn->error);
}

// Fetch all products
$products_query = "SELECT * FROM products ORDER BY id DESC";
$products = $conn->query($products_query);
if(!$products){
    die("Products query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - GreenBasket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 50px; margin-bottom: 50px; }
        h1, h2 { margin-bottom: 20px; }
        table { background-color: #fff; }
        .logout-btn { float: right; }
        .form-inline input { margin-right: 5px; margin-bottom:5px;}
    </style>
</head>
<body>
<div class="container">
    <h1>Admin Dashboard</h1>
    <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
    <hr>

    <!-- Orders Section -->
    <h2>Orders</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Order ID</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>Total Price</th>
                <th>Ordered At</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $orders->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['user_name'] ?></td>
                <td><?= $row['user_email'] ?></td>
                <td>$<?= $row['total_price'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <hr>

    <!-- Products Section -->
    <h2>Products</h2>

    <!-- Add Product Form -->
    <form method="POST" class="form-inline mb-3">
        <input type="text" name="name" placeholder="Product Name" class="form-control mr-2" required>
        <input type="number" step="0.01" name="price" placeholder="Price" class="form-control mr-2" required>
        <input type="number" name="stock" placeholder="Stock" class="form-control mr-2" required>
        <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p = $products->fetch_assoc()): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['name'] ?></td>
                <td>$<?= $p['price'] ?></td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <input type="text" name="name" value="<?= $p['name'] ?>" required>
                        <input type="number" step="0.01" name="price" value="<?= $p['price'] ?>" required>
                        <input type="number" name="stock" value="<?= $p['stock'] ?>" required>
                        <button type="submit" name="edit_product" class="btn btn-primary btn-sm">Update</button>
                    </form>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <button type="submit" name="delete_product" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
