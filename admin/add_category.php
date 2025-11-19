<?php
include '../db_connect.php';
include 'session.php';

$cat_title = mysqli_real_escape_string($conn, $_POST['cat_title']);
$image_name = "";

if (!empty($_FILES['image']['name'])) {
    $image_name = time() . "_" . basename($_FILES['image']['name']);
    $target = "../uploads/category/" . $image_name;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
}

$sql = "INSERT INTO category (cat_title, image) VALUES ('$cat_title', '$image_name')";
mysqli_query($conn, $sql);

header("Location: manage_categories.php");
exit();
?>
