<?php
session_start();
include '../db_connect.php';
if(!isset($_SESSION['admin_id'])) exit('Unauthorized');

$id = (int)$_GET['id'];
$action = $_GET['action'];

if($action=='approve'){
    $status = 1;
} elseif($action=='reject'){
    $status = 2;
} else {
    exit('Invalid action');
}

$stmt = $conn->prepare("UPDATE products SET status=? WHERE id=?");
$stmt->bind_param("ii", $status, $id);
$stmt->execute();
$stmt->close();

header("Location: admin_products.php");
exit;
