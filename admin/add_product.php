<?php
include '../db_connect.php';
session_start();
include 'includes/header.php';

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

            // Insert into database with image path
            $query = mysqli_query($conn, "INSERT INTO products (name, category_id, price, image) VALUES ('$name', '$category_id', '$price', '$new_img_name')");
            
            if($query){
                header("Location: manage_products.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Error adding product.</div>";
            }

        } else {
            echo "<div class='alert alert-danger'>Invalid image type. Only JPG, PNG, GIF allowed.</div>";
        }

    } else {
        echo "<div class='alert alert-danger'>Please upload an image.</div>";
    }
}

// Fetch categories for dropdown
$categories = mysqli_query($conn, "SELECT * FROM category");
?>

<h2 class="text-success fw-bold mb-4">Add Product</h2>

<form method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Product Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-select" required>
      <option value="">Select Category</option>
      <?php while($cat = mysqli_fetch_assoc($categories)): ?>
        <option value="<?= $cat['id'] ?>"><?= $cat['cat_title'] ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Price (৳)</label>
    <input type="number" name="price" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Product Image</label>
    <input type="file" name="image" class="form-control" required>
  </div>
  <button type="submit" name="submit" class="btn btn-success">Add Product</button>
</form>

<?php include 'includes/footer.php'; ?>
