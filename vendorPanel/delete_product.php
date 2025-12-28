<?php
session_start();
include '../db_connect.php';

if(!isset($_SESSION['vendor_id'])){
    exit('Unauthorized');
}

$vendor_id = $_SESSION['vendor_id'];
$id = $_POST['id'];

$check = mysqli_query($conn,"SELECT * FROM products WHERE id='$id' AND vendor_id='$vendor_id'");
if(mysqli_num_rows($check)==0){
    exit("Invalid product");
}

mysqli_query($conn,"DELETE FROM products WHERE id='$id'");
echo "Product deleted successfully";
