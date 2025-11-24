<?php
include '../db_connect.php';
<<<<<<< HEAD
session_start();
include 'includes/header.php';
=======
include 'session.php';
include 'includes/header.php';

// Handle search for server-side fallback (optional)
$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Count total rows
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM category 
    WHERE cat_title LIKE '%$search%'");
$total_row = mysqli_fetch_assoc($total_result);
$total_categories = $total_row['total'];
$total_pages = ceil($total_categories / $limit);

// Fetch categories
$result = mysqli_query($conn, "SELECT * FROM category 
    WHERE cat_title LIKE '%$search%' 
    ORDER BY id DESC LIMIT $offset, $limit");
>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
?>

<h2 class="text-success fw-bold mb-4">Manage Categories</h2>

<<<<<<< HEAD
<!-- Categories Table -->
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle text-center">
=======
<!-- ADD NEW CATEGORY BUTTON -->
<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="bi bi-plus-circle"></i> Add New Category
    </button>
</div>


<!-- Search Form -->
<form method="get" class="mb-3 d-flex">
    <input type="text" id="searchInput" name="search" class="form-control me-2" placeholder="Search category..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
</form>



<!-- Categories Table -->
<div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle text-center" id="categoryTable">
>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Category Name</th>
<<<<<<< HEAD
=======
                <th>Image</th>
>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
<<<<<<< HEAD
            <?php
            $result = mysqli_query($conn, "SELECT * FROM category");

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
=======
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td class="text-start ps-3"><?= htmlspecialchars($row['cat_title']) ?></td>
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="uploads/category/<?= htmlspecialchars($row['image']) ?>" width="60" height="60" class="rounded">
                        <?php else: ?>
                            <span class="text-muted">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm me-1 editBtn"
                                data-id="<?= $row['id'] ?>"
                                data-name="<?= htmlspecialchars($row['cat_title']) ?>"
                                data-image="<?= $row['image'] ?>">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <a href="delete_category.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" class="text-muted">No categories found!</td></tr>
        <?php endif; ?>
>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
        </tbody>
    </table>
</div>

<<<<<<< HEAD
<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-end modal-dialog-scrollable">
    <form action="update_category.php" method="POST" class="modal-content">
=======
<!-- Pagination -->
<nav>
    <ul class="pagination">
        <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">&laquo;</a>
            </li>
        <?php endif; ?>

        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">&raquo;</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<!-- ADD CATEGORY MODAL -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-end modal-dialog-scrollable">
    <form action="add_category.php" method="POST" enctype="multipart/form-data" class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Add New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Category Name</label>
          <input type="text" name="cat_title" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Image</label>
          <input type="file" name="image" class="form-control">
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>

    </form>
  </div>
</div>

<!-- EDIT CATEGORY MODAL -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-end modal-dialog-scrollable">
    <form action="update_category.php" method="POST" enctype="multipart/form-data" class="modal-content">

>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
<<<<<<< HEAD
=======

>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
        <input type="hidden" name="id" id="edit_cat_id">

        <div class="mb-3">
          <label class="form-label">Category Name</label>
          <input type="text" name="cat_title" id="edit_cat_name" class="form-control" required>
        </div>
<<<<<<< HEAD
=======

        <div class="mb-3">
          <label class="form-label">Image (optional)</label>
          <input type="file" name="image" class="form-control">
        </div>

        <img id="previewImage" src="" width="80" class="rounded mt-2">

>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Update</button>
      </div>
<<<<<<< HEAD
=======

>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
    </form>
  </div>
</div>

<<<<<<< HEAD
<?php include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Handle edit button click
$(document).on('click', '.editBtn', function(){
    $('#edit_cat_id').val($(this).data('id'));
    $('#edit_cat_name').val($(this).data('name'));
    new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
=======
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){

    // Edit Button
    $(document).on('click', '.editBtn', function(){
        $('#edit_cat_id').val($(this).data('id'));
        $('#edit_cat_name').val($(this).data('name'));

        let img = $(this).data('image');
        if(img){
            $('#previewImage').attr('src', 'uploads/category/' + img).show();
        } else {
            $('#previewImage').hide();
        }

        new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    });

    // Live search filter (typing)
    $('#searchInput').on('keyup', function(){
        let value = $(this).val().toLowerCase();
        $('#categoryTable tbody tr').filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
});
</script>

<style>
<<<<<<< HEAD
.modal-dialog-end { margin-left:auto; height:100%; }
.table-hover tbody tr:hover { background-color:#d4edda; transition:0.3s; }
</style>
=======
.table { border-collapse: collapse !important; width: 100%; }
.table th, .table td { border: 1px solid #e0e0e0 !important; vertical-align: middle; }
.table thead th { background-color: #e8f5e9 !important; font-weight: 600; }
.table-hover tbody tr:hover { background-color: #f1f8f4 !important; transition: 0.3s; }
.table-responsive { border: 1px solid #e0e0e0; border-radius: 10px; overflow: hidden; }
.modal-dialog-end { margin-left:auto; height:100%; }

.pagination {
  justify-content: center;
  list-style: none;
  padding: 0;
  margin-top: 20px;
}
.pagination .page-item { display: inline-block; margin: 0 5px; }
.pagination .page-link { color: #000; text-decoration: none; padding: 0; border: none; background: none; font-weight: 500; }
.pagination .page-item.active .page-link { color: #28a745; font-weight: 700; }
.pagination .page-link:hover { color: #28a745; }
</style>

<?php //include 'includes/footer.php'; ?>
>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
