<?php
session_start();
if(!isset($_SESSION['vendor_id'])){
    header("Location: login.php");
    exit();
}

include '../db_connect.php';
?>

<!-- Sidebar include (fixed-left layout) -->
<?php include 'sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="content-area">
    <div class="container fluid mt-4">
        
        <!-- Heading + Add Button -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <h2 class="text-success fw-bold mb-3 mb-md-0">Manage Products</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle"></i> Add Product
            </button>
        </div>

        <!-- Search -->
        <div class="input-group mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by name or category...">
        </div>

        <!-- Product Table -->
        <div class="table-responsive shadow-sm rounded bg-white p-3" id="productTableWrapper">
            <!-- AJAX Load here -->
        </div>
    </div>
</div>

<!-- ADD PRODUCT MODAL -->
<div class="modal fade" id="addProductModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <form action="add_product_action.php" method="POST" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Product Name</label>
          <label class="form-label">Product Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-control" required>
            <?php
              $cat = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_title ASC");
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

<!-- EDIT PRODUCT MODAL -->
<div class="modal fade" id="editProductModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
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
              $cat = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_title ASC");
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
          <img id="edit_image_preview" src="" class="img-fluid rounded border p-1">
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

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function loadProducts(page = 1, search = '') {
    $.ajax({
        url: 'fetch_products.php',
        method: 'GET',
        data: { page: page, search: search },
        success: function(data){
            $('#productTableWrapper').html(data);
        }
    });
}

loadProducts();

$('#searchInput').on('keyup', function(){
    loadProducts(1, $(this).val());
});

$(document).on('click', '.editBtn', function () {

    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_category').val($(this).data('category'));
    $('#edit_price').val($(this).data('price'));

    let img = $(this).data('image');
    $('#edit_image_preview').attr('src', '../image/' + img);

    let modal = new bootstrap.Modal(document.getElementById('editProductModal'));
    modal.show();
});


$(document).on('click', '.paginationBtn', function(e){
    e.preventDefault();
    loadProducts($(this).data('page'), $('#searchInput').val());
});

$(document).on('click', '.deleteBtn', function(){
    if(confirm("Are you sure you want to delete this product?")){
        var id = $(this).data('id');
        $.ajax({
            url: 'delete_product.php',
            method: 'POST',
            data: { id: id },
            success: function(response){
                alert(response);
                loadProducts();
            }
        });
    }
});
</script>

<style>
/* Fix sidebar layout */
.content-area{
    margin-left: 250px;
    padding: 20px;
}

/* Hover effect */
.table-hover tbody tr:hover { 
    background-color: #d4edda; 
    transition: 0.3s; 
}

#productTableWrapper img { 
    transition: transform 0.3s ease; 
    cursor: pointer; 
}
#productTableWrapper img:hover { 
    transform: scale(1.4); 
    z-index: 10;
}

/* Responsive */
@media(max-width: 768px){
    .content-area{ margin-left: 0; }
}
</style>
