<?php
session_start();
include 'db_connect.php';

// 1. ইউজার লগইন চেক করা
if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. POST থেকে ডেটা নেওয়া এবং স্যানিটাইজ করা
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$country = $_POST['country'] ?? '';
$state = $_POST['state'] ?? '';
$zip_code = $_POST['zip_code'] ?? '';

// Basic validation
if (empty($name) || empty($email)) {
    echo "Error: Name and Email are required.";
    exit;
}

// 3. ফাইল আপলোড হ্যান্ডেল করা
$new_image_name = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed_ext = array("jpg", "jpeg", "png", "gif");

    if (in_array($file_ext, $allowed_ext)) {
        // একটি ইউনিক নাম তৈরি করা
        $new_image_name = $user_id . '_' . time() . '.' . $file_ext;
        $upload_path = 'uploads/' . $new_image_name;
        
        if (move_uploaded_file($file_tmp, $upload_path)) {
            // যদি সফলভাবে আপলোড হয়, তবে ডাটাবেস থেকে পুরোনো ছবি মুছে ফেলা
            $query_old = $conn->prepare("SELECT image FROM users WHERE id = ?");
            $query_old->bind_param("i", $user_id);
            $query_old->execute();
            $old_image_result = $query_old->get_result()->fetch_assoc();
            $old_image = $old_image_result['image'];

            if (!empty($old_image) && $old_image !== 'default.png' && file_exists('uploads/' . $old_image)) {
                unlink('uploads/' . $old_image);
            }
        } else {
            echo "Error: File upload failed.";
            exit;
        }
    } else {
        echo "Error: Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.";
        exit;
    }
}

// 4. SQL UPDATE কোয়েরি তৈরি করা
if (!empty($new_image_name)) {
    // যদি নতুন ছবি আপলোড হয়
    $sql = "UPDATE users SET 
                name=?, email=?, phone=?, address=?, country=?, state=?, zip_code=?, image=? 
            WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", 
        $name, $email, $phone, $address, $country, $state, $zip_code, $new_image_name, $user_id);
} else {
    // যদি নতুন ছবি আপলোড না হয়
    $sql = "UPDATE users SET 
                name=?, email=?, phone=?, address=?, country=?, state=?, zip_code=? 
            WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", 
        $name, $email, $phone, $address, $country, $state, $zip_code, $user_id);
}

// 5. কোয়েরি এক্সিকিউট করা
if ($stmt->execute()) {
    echo "Profile updated successfully!";
} else {
    echo "Error updating profile: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>