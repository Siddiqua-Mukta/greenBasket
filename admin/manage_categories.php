<?php
include '../db_connect.php';
session_start();
include 'includes/header.php';

// Pagination setup
$limit = 10; // number of categories per page
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Count total categories
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM category");
$total_row = mysqli_fetch_assoc($total_result);
$total_categories = $total_row['total'];
$total_pages = ceil($total_categories / $limit);

// Fetch categories for current page
$result = mysqli_query($conn, "SELECT * FROM category ORDER BY id DESC LIMIT $offset, $limit");
?>

<h2 class="text-success fw-bold mb-4">Manage Categories</h2>

<!-- Categories Table -->
<div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle text-center">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $catName = isset($row['cat_title']) ? $row['cat_title'] : '';

                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td class='text-start ps-3'>{$catName}</td>
                        <td>
                            <button class='btn btn-warning btn-sm me-1 editBtn'
                                data-id='{$row['id']}'
                                data-name='{$catName}'>
                                <i class='bi bi-pencil-square'></i>
                            </button>
                            <a href='delete_category.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
                                <i class='bi bi-trash'></i>
                            </a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-muted'>No categories found!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<nav>
    <ul class="pagination">
        <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page-1 ?>">&laquo;</a>
            </li>
        <?php endif; ?>

        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page+1 ?>">&raquo;</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-end modal-dialog-scrollable">
    <form action="update_category.php" method="POST" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="id" id="edit_cat_id">

        <div class="mb-3">
          <label class="form-label">Category Name</label>
          <input type="text" name="cat_title" id="edit_cat_name" class="form-control" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

<?php //include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Handle edit button click
$(document).on('click', '.editBtn', function(){
    $('#edit_cat_id').val($(this).data('id'));
    $('#edit_cat_name').val($(this).data('name'));
    new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
});
</script>

<style>
/* Table styling */
.table {
  border-collapse: collapse !important;
  width: 100%;
}

.table th,
.table td {
  border: 1px solid #e0e0e0 !important;
  vertical-align: middle;
}

.table thead th {
  background-color: #e8f5e9 !important;
  font-weight: 600;
  text-align: center;
}

.table-hover tbody tr:hover {
  background-color: #f1f8f4 !important;
  transition: 0.3s;
}

.table-responsive {
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  overflow: hidden;
}

.modal-dialog-end { margin-left:auto; height:100%; }

/* Plain number-only pagination */
.pagination {
  justify-content: center;
  list-style: none;
  padding: 0;
  margin-top: 20px;
}

.pagination .page-item {
  display: inline-block;
  margin: 0 5px;
}

.pagination .page-link {
  color: #000; /* black numbers */
  text-decoration: none;
  padding: 0;
  border: none;
  background: none;
  font-weight: 500;
}

.pagination .page-item.active .page-link {
  color: #28a745; /* active page */
  font-weight: 700;
}

.pagination .page-link:hover {
  color: #28a745;
}
</style>
