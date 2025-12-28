<?php
session_start();
include '../db_connect.php';
if(!isset($_SESSION['vendor_id'])) exit('Unauthorized');

$vendor_id = $_SESSION['vendor_id'];

// Fetch vendor products
$sql = "SELECT products.*, category.cat_title
        FROM products
        JOIN category ON products.category_id = category.id
        WHERE vendor_id = $vendor_id
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<h3>My Products</h3>
<table class="table table-bordered">
<tr>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Status</th>
</tr>
<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['cat_title']) ?></td>
    <td>৳ <?= number_format($row['price'],2) ?></td>
    <td>
        <?php 
        if($row['status']==0) echo "<span class='badge bg-warning'>Pending</span>";
        elseif($row['status']==1) echo "<span class='badge bg-success'>Approved</span>";
        elseif($row['status']==2) echo "<span class='badge bg-danger'>Rejected</span>";
        ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
