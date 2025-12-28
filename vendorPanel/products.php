<?php
session_start();
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit;
}

include('../db_connect.php');
include 'sidebar.php';

$vendor_id = $_SESSION['vendor_id'];

/*
|--------------------------------------------------------------------------
| Fetch vendor products with category name
| Assumption:
| products.category_id  -> category.id
|--------------------------------------------------------------------------
*/
$sql = "
    SELECT 
        products.*,
        category.cat_title
    FROM products
    LEFT JOIN category ON products.category_id = category.id
    WHERE products.vendor_id = $vendor_id
    ORDER BY products.id DESC
";

$result = mysqli_query($conn, $sql);
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
    font-family: Arial, sans-serif;
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

.low-stock {
    background-color: #fff3cd;
}
</style>
</head>

<body>

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
                        <th width="160">Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0):
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                        $isLowStock = ($row['stock'] <= 5);
                ?>
                    <tr class="<?= $isLowStock ? 'low-stock' : ''; ?>">
                        <td><?= $i++; ?></td>

                        <td>
                            <img src="../image/<?= htmlspecialchars($row['image']); ?>"
                                 width="60" height="60"
                                 style="object-fit:cover;border-radius:6px;">
                        </td>

                        <td><?= htmlspecialchars($row['name']); ?></td>

                        <td><?= htmlspecialchars($row['cat_title'] ?? 'N/A'); ?></td>

                        <td><?= number_format($row['price'], 2); ?> ৳</td>

                        <td>
                            <?= $row['stock']; ?>
                            <?php if ($isLowStock): ?>
                                <span class="badge badge-danger ml-1">Low</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="edit_product.php?id=<?= $row['id']; ?>" 
                               class="btn btn-sm btn-warning">Edit</a>

                            <a href="delete_product.php?id=<?= $row['id']; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure to delete this product?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No products found
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>
