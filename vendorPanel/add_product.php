<?php
session_start();
include '../db_connect.php';

// Check if vendor is logged in
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}

$vendor_id = $_SESSION['vendor_id'];
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];
    $details = trim($_POST['details']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $commission = $_POST['commission'] ?? 0;

    // Validate
    if(empty($name)) $errors[] = "Product name is required.";
    if(empty($price) || !is_numeric($price)) $errors[] = "Valid price is required.";
    if(empty($stock) || !is_numeric($stock)) $errors[] = "Valid stock is required.";

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
    $target_dir = "uploads/";
    if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    // Save correct path in database
    $image_name = $target_dir . time() . '_' . basename($_FILES['image']['name']);
    $target_file = $image_name;

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif','webp'];

    if(!in_array($imageFileType, $allowed)){
        $errors[] = "Only JPG, PNG, GIF, or WEBP files allowed.";
    } else {
        if(!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
            $errors[] = "Failed to upload image.";
        }
    }
}

    // Insert into database
    if(empty($errors)){
        $stmt = $conn->prepare("INSERT INTO products (vendor_id, name, category_id, details, price, stock, image, commission) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isisdiis", $vendor_id, $name, $category_id, $details, $price, $stock, $image_name, $commission);

        if($stmt->execute()){
            $success = "Product added successfully.";
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch categories
$cat_query = "SELECT id, cat_title FROM category ORDER BY cat_title ASC";
$cat_result = mysqli_query($conn, $cat_query);

include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Product</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
.content-area {
    margin-left: 260px;
    min-height: 100vh;
    display: flex;
    justify-content: center; 
    align-items: center;     
    background: #f5f5f5;
    padding: 20px;
}

.form-box {
    width: 100%;
    max-width: 750px;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<div class="content-area">
    <div class="form-box">

        <h3 class="mb-3 text-center">Add Product</h3>

        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul><?php foreach($errors as $e) echo "<li>$e</li>"; ?></ul>
            </div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success text-center"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">

            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Select Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    <?php while($row = mysqli_fetch_assoc($cat_result)) { ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['cat_title']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Details</label>
                <textarea name="details" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Commission (%)</label>
                <input type="number" step="1" name="commission" class="form-control" value="0">
            </div>

            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success btn-block">Add Product</button>

        </form>
    </div>
</div>

</body>
</html>
