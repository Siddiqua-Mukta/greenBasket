<?php
include '../db_connect.php';
include 'session.php';
include 'includes/header.php';

// Handle search
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Categories</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
/* Sidebar and Navbar */
body { min-height:100vh; }
.sidebar {
    min-width: 200px;
    max-width: 200px;
    background-color: #198754;
    min-height: 100vh;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    transition: all 0.3s ease;
    z-index: 1000;
}
.sidebar a { color:white; text-decoration:none; display:block; padding:12px; }
.sidebar a:hover { background-color:#145c36; }

.content {
    margin-left: 100px;
    padding:20px;
    transition: all 0.3s ease;
}

/* Mobile Navbar */
.navbar-mobile { display:none; }
@media(max-width:768px){
    .sidebar { left:-220px; position:fixed; }
    .content { margin-left:0; padding:10px; }
    .navbar-mobile { display:flex; justify-content:space-between; align-items:center; background:#198754; color:white; padding:10px; }
    .navbar-mobile button { background:none; border:none; color:white; font-size:1.5rem; }

    /* Close button inside sidebar */
    #sidebarClose { display:inline-block; }
}

/* Table styling */
.table { border-collapse: collapse !important; width: 100%; font-size: 14px; }
.table th, .table td { border: 1px solid #e0e0e0 !important; vertical-align: middle; padding: 8px; }
.table thead th { background-color: #e8f5e9 !important; font-weight: 600; }
.table-hover tbody tr:hover { background-color: #f1f8f4 !important; transition: 0.3s; }
.table-responsive { border: 1px solid #e0e0e0; border-radius: 10px; overflow: auto; }

/* Modal adjustments */
.modal-dialog-end { margin-left:auto; height:100%; max-width: 500px; }
@media(max-width:576px){
    .modal-dialog-end { max-width: 100%; margin:10px auto; }
}

/* Pagination */
.pagination { justify-content: center; list-style: none; padding: 0; margin-top: 20px; flex-wrap: wrap; }
.pagination .page-item { display:inline-block; margin:2px; }
.pagination .page-link { color:#000; text-decoration:none; padding:6px 10px; border-radius:5px; border:1px solid #ddd; background:#fff; font-weight:500; }
.pagination .page-item.active .page-link { color:#fff; background-color:#28a745; font-weight:700; border-color:#28a745; }
.pagination .page-link:hover { color:#fff; background-color:#28a745; border-color:#28a745; }

/* Zoom effect for category images */
#categoryTable img {
    transition: transform 0.3s ease;
    cursor: pointer;
}
#categoryTable img:hover {
    transform: scale(1.3);
    position: relative;
    z-index: 10;
}

/* Responsive adjustments for small devices */
@media(max-width:768px){
    h2 { font-size:20px; }
    .btn { font-size:13px; padding:5px 10px; }
    .table th, .table td { font-size:12px; padding:6px; }
    #categoryTable img { width:50px; height:50px; }
    form.d-flex { flex-direction:column; gap:8px; }
    form.d-flex input, form.d-flex button { width:100%; }
}
</style>
</head>
<body>

<!-- Mobile Navbar -->
<div class="navbar-mobile">
    <span class="fw-bold">Admin Panel</span>
    <button id="menuToggle"><i class="bi bi-list"></i></button>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Close button for mobile -->
    <div class="d-flex justify-content-end d-md-none p-2">
        <button id="sidebarClose" class="btn btn-sm btn-light"><i class="bi bi-x"></i></button>
    </div>

    <h4 class="text-center py-3"><a href="index.php">Admin Panel</a></h4>
    <a href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="manage_products.php"><i class="bi bi-box"></i> Products</a>
    <a href="manage_categories.php"><i class="bi bi-tags"></i> Categories</a>
    <a href="manage_orders.php"><i class="bi bi-bag"></i> Orders</a>
    <a href="manage_users.php"><i class="bi bi-people"></i> Users</a>
    <a href="manage_messages.php"><i class="bi bi-envelope"></i> Messages</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="content">

<h2 class="text-success fw-bold mb-4">Manage Categories</h2>

<!-- Search Form -->
<form method="get" class="mb-3 d-flex">
    <input type="text" id="searchInput" name="search" class="form-control me-2" placeholder="Search category..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-success">Search</button>
</form>

<!-- ADD NEW CATEGORY BUTTON -->
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
    <i class="bi bi-plus-circle"></i> Add New Category
</button>

<!-- Categories Table -->
<div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle text-center" id="categoryTable">
        <thead class="table-success">
            <tr>
                <th>SL</th>
                <th>Catagory ID</th>
                <th>Category Name</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php $sl = $offset + 1; ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $sl++ ?></td>
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
            <tr><td colspan="5" class="text-muted">No categories found!</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

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

        <div class="mb-3">
          <label class="form-label">Image (optional)</label>
          <input type="file" name="image" class="form-control">
        </div>

        <img id="previewImage" src="" width="80" class="rounded mt-2">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

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

    // Sidebar toggle
    $('#menuToggle').click(function(){
        $('#sidebar').css('left','0');
    });

    // Close button
    $('#sidebarClose').click(function(){
        $('#sidebar').css('left','-220px');
    });
});
</script>

</body>
</html>
