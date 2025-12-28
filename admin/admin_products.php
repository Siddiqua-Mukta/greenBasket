<?php
session_start();
include '../db_connect.php';
if(!isset($_SESSION['admin_id'])) exit('Unauthorized');

// Fetch all pending products
$sql = "SELECT products.*, category.cat_title, users.name AS vendor_name
        FROM products
        JOIN category ON products.category_id = category.id
        JOIN users ON products.vendor_id = users.id
        WHERE status = 0
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<h3>Pending Products</h3>
<table class="table table-bordered">
<tr>
    <th>Vendor</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Action</th>
</tr>
<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($row['vendor_name']) ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['cat_title']) ?></td>
    <td>৳ <?= number_format($row['price'],2) ?></td>
    <td>
        <a href="admin_action.php?id=<?= $row['id'] ?>&action=approve" class="btn btn-success btn-sm">Approve</a>
        <a href="admin_action.php?id=<?= $row['id'] ?>&action=reject" class="btn btn-danger btn-sm">Reject</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
