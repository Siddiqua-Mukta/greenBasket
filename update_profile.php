<?php
include('db_connect.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in";
    exit;
}

$user_id = $_SESSION['user_id'];

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$address = trim($_POST['address']);

// Fetch old image
$getOld = $conn->prepare("SELECT image FROM users WHERE id=?");
$getOld->bind_param("i", $user_id);
$getOld->execute();
$result = $getOld->get_result()->fetch_assoc();
$old_image = $result['image'];

// Image handling
$new_image_name = $old_image;

if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {

    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        echo "Only JPG, JPEG, PNG & WEBP allowed!";
        exit;
    }

    $new_image_name = "user_" . $user_id . "." . $ext;
    $target = "uploads/" . $new_image_name;

    if (!empty($old_image) && $old_image !== "default.png" && file_exists("uploads/" . $old_image)) {
        unlink("uploads/" . $old_image);
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "Image upload failed!";
        exit;
    }
}

// Update query
$sql = "UPDATE users SET name=?, email=?, phone=?, address=?, image=? WHERE id=?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "SQL ERROR: " . $conn->error;
    exit;
}

$stmt->bind_param("sssssi", $name, $email, $phone, $address, $new_image_name, $user_id);

if ($stmt->execute()) {
    echo "Profile updated successfully!";
} else {
    echo "Update failed!";
}
?>
