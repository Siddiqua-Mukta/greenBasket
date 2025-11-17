<?php
include '../db_connect.php';
if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM category WHERE id=$id";
    if(mysqli_query($conn, $sql)){
        header("Location: manage_category.php");
        exit;
    } else {
        echo "Error deleting category: " . mysqli_error($conn);
    }
}
?>
