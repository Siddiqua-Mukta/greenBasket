<?php
include '../db_connect.php';
include 'session.php';

$id = $_POST['id'];
$cat_title = mysqli_real_escape_string($conn, $_POST['cat_title']);

$image_query = mysqli_query($conn, "SELECT image FROM category WHERE id=$id");
$old = mysqli_fetch_assoc($image_query);
$old_image = $old['image'];

$image_name = $old_image;

if (!empty($_FILES['image']['name'])) {
    $image_name = time() . "_" . basename($_FILES['image']['name']);
    $target = "../uploads/category/" . $image_name;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    if (!empty($old_image)) {
        unlink("../uploads/category/" . $old_image);
    }
}

mysqli_query($conn, "UPDATE category SET cat_title='$cat_title', image='$image_name' WHERE id=$id");

header("Location: manage_categories.php");
exit();
?>
