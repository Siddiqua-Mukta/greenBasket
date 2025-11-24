<?php
include '../db_connect.php';
<<<<<<< HEAD
session_start();
=======
include 'session.php';
>>>>>>> 7231a1e57a21c5ff99dc19fc8d52583d74305b0c

if(isset($_GET['id'])){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM products WHERE id='$id'");
}

header("Location: manage_products.php");
exit;
