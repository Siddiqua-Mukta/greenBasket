<?php
session_start();
include '../db_connect.php';

if(!isset($_SESSION['vendor_id'])){
    exit('Unauthorized');
}

$vendor_id = $_SESSION['vendor_id'];

$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit  = 10;
$offset = ($page - 1) * $limit;

$where = "WHERE vendor_id='$vendor_id'";

if($search != ''){
    $search = mysqli_real_escape_string($conn, $search);
    $where .= " AND (products.name LIKE '%$search%' OR category.cat_title LIKE '%$search%')";
}

$sql = "SELECT products.*, category.cat_title 
        FROM products 
        JOIN category ON products.category_id = category.id
        $where
        ORDER BY products.id DESC
        LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $sql);
?>

<table class="table table-bordered table-hover w-100">
<thead class="table-success">
<tr>
    <th>#</th>
    <th>Image</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Action</th>
</tr>
</thead>
<tbody>

<?php if(mysqli_num_rows($result)>0): 
$i = $offset + 1;
while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $i++ ?></td>
    <td>
        <img src="../image/<?= $row['image'] ?>" width="50">
    </td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['cat_title']) ?></td>
    <td>৳ <?= number_format($row['price'],2) ?></td>
    <td>
        <!-- EDIT -->
        <button class="btn btn-sm btn-primary editBtn"
            data-id="<?= $row['id'] ?>"
            data-name="<?= htmlspecialchars($row['name']) ?>"
            data-category="<?= $row['category_id'] ?>"
            data-price="<?= $row['price'] ?>"
            data-image="<?= $row['image'] ?>">
            Edit
        </button>

        <!-- DELETE -->
        <button class="btn btn-sm btn-danger deleteBtn"
            data-id="<?= $row['id'] ?>">
            Delete
        </button>
    </td>
</tr>
<?php endwhile; else: ?>
<tr>
    <td colspan="6" class="text-center">No products found</td>
</tr>
<?php endif; ?>
</tbody>
</table>

<?php
$count = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM products $where")
)['total'];

$totalPages = ceil($count / $limit);

if($totalPages > 1):
?>
<nav class="mt-3">
<ul class="pagination">
<?php for($i=1;$i<=$totalPages;$i++): ?>
<li class="page-item <?= ($i==$page)?'active':'' ?>">
    <a href="#" class="page-link paginationBtn" data-page="<?= $i ?>">
        <?= $i ?>
    </a>
</li>
<?php endfor; ?>
</ul>
</nav>
<?php endif; ?>
