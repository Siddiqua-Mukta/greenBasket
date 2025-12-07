<?php
include '../db_connect.php';

// Pagination & search
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = $_GET['search'] ?? '';

// Count total products
$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM products p
    JOIN category c ON c.id = p.category_id
    WHERE p.name LIKE '%$search%' OR c.cat_title LIKE '%$search%'");
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

// Fetch products
$result = mysqli_query($conn, "SELECT p.*, c.cat_title FROM products p
    JOIN category c ON c.id = p.category_id
    WHERE p.name LIKE '%$search%' OR c.cat_title LIKE '%$search%'
    ORDER BY p.id DESC LIMIT $offset, $limit");

?>

<table class="table table-striped table-hover align-middle text-center">
    <thead class="table-success">
        <tr>
            <th>SL</th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price (৳)</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php $sl = $offset + 1; ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= $row['id'] ?></td>
                    <td class="text-start ps-3"><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['cat_title']) ?></td>
                    <td><?= $row['price'] ?></td>
                    <td>
                        <?php if(!empty($row['image'])): ?>
                            <img src="../image/<?= htmlspecialchars($row['image']) ?>" width="60" height="60" class="rounded">
                        <?php else: ?>
                            <span class="text-muted">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm me-1 editBtn"
                                data-id="<?= $row['id'] ?>"
                                data-name="<?= htmlspecialchars($row['name']) ?>"
                                data-category="<?= $row['category_id'] ?>"
                                data-price="<?= $row['price'] ?>"
                                data-image="<?= $row['image'] ?>">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-muted">No products found!</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination -->
<nav>
    <ul class="pagination justify-content-center mt-3">
        <?php if($page > 1): ?>
            <li class="page-item"><a href="#" class="page-link paginationBtn" data-page="<?= $page-1 ?>">&laquo;</a></li>
        <?php endif; ?>

        <?php for($i=1; $i<=$total_pages; $i++): ?>
            <li class="page-item <?= ($i==$page)?'active':'' ?>">
                <a href="#" class="page-link paginationBtn" data-page="<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
            <li class="page-item"><a href="#" class="page-link paginationBtn" data-page="<?= $page+1 ?>">&raquo;</a></li>
        <?php endif; ?>
    </ul>
</nav>
