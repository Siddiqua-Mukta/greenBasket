<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];

    // Image upload
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $target = "../image/" . basename($image_name);
    move_uploaded_file($image_tmp, $target);

    $sql = "INSERT INTO products (name, category_id, price, image) 
            VALUES ('$name', '$category_id', '$price', '$image_name')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('✅ Product added successfully!');
            window.location.href='manage_products.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error: Could not add product.');
            window.location.href='manage_products.php';
        </script>";
    }
}
?>
