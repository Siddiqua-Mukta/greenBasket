<?php
include '../db_connect.php';
include 'session.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM products WHERE id='$id'");
}

header("Location: manage_products.php");
exit;
