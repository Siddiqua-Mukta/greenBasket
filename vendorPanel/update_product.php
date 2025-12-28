<?php
session_start();
include '../db_connect.php';

if(!isset($_SESSION['vendor_id'])){
    exit("Unauthorized");
}

$vendor_id = $_SESSION['vendor_id'];

$id         = $_POST['id'];
$name       = $_POST['name'];
$category   = $_POST['category_id'];
$price      = $_POST['price'];

/* product ownership check */
$check = mysqli_query($conn,
    "SELECT image FROM products 
     WHERE id='$id' AND vendor_id='$vendor_id'"
);

if(mysqli_num_rows($check) == 0){
    exit("Invalid product");
}

$product = mysqli_fetch_assoc($check);
$imageName = $product['image'];

/* image update */
if(!empty($_FILES['new_image']['name'])){
    $newImg = time().'_'.$_FILES['new_image']['name'];
    $tmp = $_FILES['new_image']['tmp_name'];

    if(move_uploaded_file($tmp, "../image/".$newImg)){
        // delete old image
        if($imageName && file_exists("../image/".$imageName)){
            unlink("../image/".$imageName);
        }
        $imageName = $newImg;
    }
}

/* UPDATE QUERY */
$sql = "UPDATE products SET 
        name='$name',
        category_id='$category',
        price='$price',
        image='$imageName'
        WHERE id='$id' AND vendor_id='$vendor_id'";

if(mysqli_query($conn, $sql)){
    header("Location: manage_products.php?updated=1");
}else{
    echo "Update failed";
}
