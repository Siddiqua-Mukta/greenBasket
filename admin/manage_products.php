<?php
include '../db_connect.php';
<<<<<<< HEAD
session_start();
=======
include 'session.php';
>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success fw-bold">Manage Products</h2>
<<<<<<< HEAD
        <a href="add_product.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add Product</a>
=======
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-circle"></i> Add Product
        </button>
>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
    </div>

    <!-- Search Bar -->
    <div class="input-group mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by name or category...">
        <button class="btn btn-success" type="button"><i class="bi bi-search"></i></button>
    </div>

    <!-- Products Table -->
    <div class="table-responsive shadow-sm rounded" id="productTableWrapper">
        <!-- Table content will be loaded via AJAX -->
    </div>
</div>

<<<<<<< HEAD
=======
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-end modal-dialog-scrollable">
    <form action="add_product_action.php" method="POST" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Product Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-control" required>
            <?php
              $cat = mysqli_query($conn, "SELECT * FROM category");
              while($c = mysqli_fetch_assoc($cat)){
                  echo "<option value='{$c['id']}'>{$c['cat_title']}</option>";
              }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Price (৳)</label>
          <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Upload Image</label>
          <input type="file" name="image" class="form-control" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Add Product</button>
      </div>
    </form>
  </div>
</div>

>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-end modal-dialog-scrollable">
    <form action="update_product.php" method="POST" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="id" id="edit_id">

        <div class="mb-3">
          <label class="form-label">Product Name</label>
          <input type="text" name="name" id="edit_name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" id="edit_category" class="form-control" required>
            <?php
                $cat = mysqli_query($conn, "SELECT * FROM category");
                while($c = mysqli_fetch_assoc($cat)){
                    echo "<option value='{$c['id']}'>{$c['cat_title']}</option>";
                }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Price (৳)</label>
          <input type="number" name="price" id="edit_price" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Current Image</label><br>
          <img id="edit_image_preview" src="" style="width:120px; border-radius:6px; border:1px solid #ccc;">
        </div>

        <div class="mb-3">
          <label class="form-label">Change Image</label>
          <input type="file" name="new_image" class="form-control">
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Load products function
function loadProducts(page = 1, search = '') {
    $.ajax({
        url: 'fetch_products.php',
        method: 'GET',
        data: { page: page, search: search },
        success: function(data) {
            $('#productTableWrapper').html(data);
        }
    });
}

// Initial load
loadProducts();

// Global search
$('#searchInput').on('keyup', function(){
    var search = $(this).val();
    loadProducts(1, search); // reset to first page on search
});

<<<<<<< HEAD
// Delegate edit button click for dynamically loaded content
=======
// Delegate edit button click
>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
$(document).on('click', '.editBtn', function(){
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_category').val($(this).data('category'));
    $('#edit_price').val($(this).data('price'));
    $('#edit_image_preview').attr('src', "../image/" + $(this).data('image'));
    new bootstrap.Modal(document.getElementById('editProductModal')).show();
});

// Delegate pagination button click
$(document).on('click', '.paginationBtn', function(e){
    e.preventDefault();
    var page = $(this).data('page');
    var search = $('#searchInput').val();
    loadProducts(page, search);
});
</script>

<style>
<<<<<<< HEAD
.table-hover tbody tr:hover { background-color: #d4edda; transition: 0.3s; }
.table-responsive { border-radius: 12px; overflow: hidden; }
.modal-dialog-end { margin-left: auto; height: 100%; }
nav a { text-decoration:none; font-weight:bold; font-size:18px; }
nav a:hover { color:#28a745; }
=======
.table {
  border-collapse: collapse !important;
  width: 100%;
}

.table th,
.table td {
  border: 1px solid #ccc !important;
  vertical-align: middle;
}

.table thead th {
  background-color: #d1e7dd;
  font-weight: 600;
  text-align: center;
}

.table-hover tbody tr:hover {
  background-color: #d4edda !important;
  transition: 0.3s;
}

.table-responsive {
  border: 1px solid #ccc;
  border-radius: 12px;
  overflow: hidden;
}

.modal-dialog-end { margin-left: auto; height: 100%; }
nav a { text-decoration:none; font-weight:bold; font-size:18px; }
nav a:hover { color:#28a745; }

>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c
@media(max-width:768px){
    h2 { font-size: 20px; }
    .btn { font-size: 13px; padding: 5px 10px; }
    .table th, .table td { font-size: 14px; padding: 8px; }
}
</style>
