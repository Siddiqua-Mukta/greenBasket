<?php
include '../db_connect.php';

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Search filter
$where = $search ? "WHERE p.name LIKE '%$search%' OR c.cat_title LIKE '%$search%'" : '';

// Products query
$query = "SELECT p.*, c.cat_title AS cat_name 
          FROM products p 
          LEFT JOIN category c ON p.category_id = c.id
          $where
          ORDER BY p.id DESC
          LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

// Total filtered products
$total_query = "SELECT COUNT(*) as total FROM products p LEFT JOIN category c ON p.category_id = c.id $where";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);
?>

<table class="table table-striped table-hover align-middle text-center">
    <thead class="table-success">
        <tr>
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
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td class="text-start ps-3"><?= $row['name'] ?></td>
                <td><?= $row['cat_name'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><img src="../image/<?= $row['image'] ?>" style="width:60px; border-radius:6px;"></td>
                <td>
                    <button class="btn btn-warning btn-sm me-1 editBtn"
                        data-id="<?= $row['id'] ?>"
                        data-name="<?= $row['name'] ?>"
                        data-category="<?= $row['category_id'] ?>"
                        data-price="<?= $row['price'] ?>"
                        data-image="<?= $row['image'] ?>">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-muted">No products found!</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center mt-3">
        <?php
        $adjacents = 2; // pages around current

        // Previous Button
        if ($page > 1) {
            echo '<li class="page-item"><a href="#" class="page-link paginationBtn" data-page="'.($page-1).'">&laquo;</a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
        }

        // Start and End Range
        $start = max(1, $page - $adjacents);
        $end = min($total_pages, $page + $adjacents);

        // If start > 1, show first page + ellipsis
        if ($start > 1) {
            echo '<li class="page-item"><a class="page-link paginationBtn" data-page="1" href="#">1</a></li>';
            if ($start > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        // Page numbers in range
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $page) {
                echo '<li class="page-item active"><span class="page-link">'.$i.'</span></li>';
            } else {
                echo '<li class="page-item"><a class="page-link paginationBtn" data-page="'.$i.'" href="#">'.$i.'</a></li>';
            }
        }

        // If end < total_pages, show ellipsis + last page
        if ($end < $total_pages) {
            if ($end < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            echo '<li class="page-item"><a class="page-link paginationBtn" data-page="'.$total_pages.'" href="#">'.$total_pages.'</a></li>';
        }

        // Next Button
        if ($page < $total_pages) {
            echo '<li class="page-item"><a href="#" class="page-link paginationBtn" data-page="'.($page+1).'">&raquo;</a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
        }
        ?>
    </ul>
</nav>

