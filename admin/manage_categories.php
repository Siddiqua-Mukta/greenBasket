<?php
include '../db_connect.php';
session_start();
include 'includes/header.php';
?>

<h2 class="text-success fw-bold mb-4">Manage Categories</h2>

<!-- Categories Table -->
<div class="table-responsive">
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
        </tbody>
    </table>
</div>

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

<?php include 'includes/footer.php'; ?>

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
.modal-dialog-end { margin-left:auto; height:100%; }
.table-hover tbody tr:hover { background-color:#d4edda; transition:0.3s; }
</style>
