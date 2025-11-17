<?php
include '../db_connect.php';
include 'session.php';
include 'includes/header.php';

$id = $_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id='$id'"));

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];

    // Image upload handling
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $img_name = $_FILES['image']['name'];
        $img_tmp = $_FILES['image']['tmp_name'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg','jpeg','png','gif'];

        if(in_array($img_ext, $allowed_ext)){
            // Rename image to avoid conflicts
            $new_img_name = uniqid('prod_', true) . '.' . $img_ext;
            $img_path = '../uploads/' . $new_img_name;
            move_uploaded_file($img_tmp, $img_path);

            // Delete old image if exists
            if(!empty($product['image']) && file_exists('../uploads/'.$product['image'])){
                unlink('../uploads/'.$product['image']);
            }

            // Update with new image
            mysqli_query($conn, "UPDATE products SET name='$name', category_id='$category_id', price='$price', image='$new_img_name' WHERE id='$id'");
        } else {
            echo "<div class='alert alert-danger'>Invalid image type. Only JPG, PNG, GIF allowed.</div>";
        }
    } else {
        // Update without changing image
        mysqli_query($conn, "UPDATE products SET name='$name', category_id='$category_id', price='$price' WHERE id='$id'");
    }

    header("Location: manage_products.php");
    exit;
}

// Fetch categories for dropdown
$categories = mysqli_query($conn, "SELECT * FROM category");
?>

<h2 class="text-success fw-bold mb-4">Edit Product</h2>

<form method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Product Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-select" required>
      <?php while($cat = mysqli_fetch_assoc($categories)): ?>
        <option value="<?= $cat['id'] ?>" <?= $product['category_id']==$cat['id']?'selected':'' ?>>
          <?= htmlspecialchars($cat['cat_title']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Price (৳)</label>
    <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Product Image</label>
    <?php if(!empty($product['image']) && file_exists('../uploads/'.$product['image'])): ?>
        <div class="mb-2">
            <img src="../uploads/<?= $product['image'] ?>" alt="Product Image" style="width:150px;">
        </div>
    <?php endif; ?>
    <!-- Show current image filename -->
    <input type="text" class="form-control mb-2" value="<?= $product['image'] ?>" readonly>
    <input type="file" name="image" class="form-control">
    <small class="text-muted">Leave empty if you don't want to change the image.</small>
  </div>

  <button type="submit" name="submit" class="btn btn-warning">Update Product</button>
</form>

<?php include 'includes/footer.php'; ?>
