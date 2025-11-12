<?php
include '../db_connect.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];

    // Handle image upload
    if(isset($_FILES['new_image']) && $_FILES['new_image']['name'] != ''){
        $image_name = time() . "_" . $_FILES['new_image']['name'];
        $target = "../image/" . $image_name;
        move_uploaded_file($_FILES['new_image']['tmp_name'], $target);

        // Update with new image
        $sql = "UPDATE products SET name='$name', category_id='$category_id', price='$price', image='$image_name' WHERE id='$id'";
    } else {
        // Update without changing image
        $sql = "UPDATE products SET name='$name', category_id='$category_id', price='$price' WHERE id='$id'";
    }

    if(mysqli_query($conn, $sql)){
        // Redirect back to manage_products.php
        header("Location: manage_products.php");
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
