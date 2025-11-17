<?php
include('db_connect.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$query = $conn->prepare("SELECT * FROM users WHERE id=?");
$query->bind_param("i", $user_id);
$query->execute();
$user = $query->get_result()->fetch_assoc();

// Values
$name = $user['name'];
$email = $user['email'];
$phone = $user['phone'] ?? '';
$address = $user['address'] ?? '';
$profile_pic = $user['image'];

// FIX: handle image
if (!empty($profile_pic) && file_exists("uploads/" . $profile_pic)) {
    $image = "uploads/" . $profile_pic;
} else {
    $image = "uploads/default.png";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Panel - GreenBasket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f5f6fa; }

/* Sidebar */
.sidebar {
    height: 100vh;
    background-color: #378149ff;
    color: #fff;
    padding-top: 30px;
    position: fixed;
    width: 220px;
    top: 0;
    left: 0;
}
.sidebar a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 12px 20px;
    border-radius: 8px;
    margin: 5px 10px;
    transition: 0.3s;
    font-weight: 500;
}
.sidebar a:hover { background-color: #232a24ff; }

.profile-box {
    background:white; 
    padding:80px;
    border-radius:20px;
    box-shadow:0 4px 18px rgba(0,0,0,0.1);
}
.profile-img {
    width:200px; 
    height:200px;
    border-radius:50%;
    border:4px solid #28a745;
    object-fit:cover;
}
</style>
</head>
<body>

<div class="sidebar">
    <h3 class="text-center"><a style="color:white" href="index.php">GreenBasket</a></h3>
    <a href="user_panel.php">Profile</a>
    <a href="user_change_pass.php">Change Password</a>
    <a href="user_orders.php">Orders</a>
    <a href="user_logout.php">Logout</a>
</div>

<div style="margin-left:260px; padding:30px;">
    <div class="profile-box row">

        <!-- LEFT -->
        <div class="col-md-7">
            <h3 class="text-center"><b>Profile Information</b></h3>
            <hr>

            <div class="text-center mb-3">
                <img src="<?php echo $image; ?>" class="profile-img">
            </div>

            <table class="table">
                <tr><td><b>Name</b></td><td><?php echo $name; ?></td></tr>
                <tr><td><b>Email</b></td><td><?php echo $email; ?></td></tr>
                <tr><td><b>Phone</b></td><td><?php echo $phone; ?></td></tr>
                <tr><td><b>Address</b></td><td><?php echo $address; ?></td></tr>
            </table>
        </div>

        <!-- RIGHT -->
        <div class="col-md-5 bg-light" style="border-left:4px solid #c3c2c2ff;">
            <h3 class="text-center"><b>Edit Profile</b></h3>
            <hr>

            <div id="msg-area"></div>

            <form id="updateForm" enctype="multipart/form-data">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>" class="form-control mb-3" required>

                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>" class="form-control mb-3" required>

                <label>Phone</label>
                <input type="text" name="phone" value="<?php echo $phone; ?>" class="form-control mb-3">

                <label>Address</label>
                <input type="text" name="address" value="<?php echo $address; ?>" class="form-control mb-3">

                <label>Profile Picture</label>
                <input type="file" name="image" class="form-control mb-3">

                <button class="btn btn-success btn-block">Update Profile</button>
            </form>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
function showMessage(msg, type='success'){
    $('#msg-area').html(`<div class="alert alert-${type}">${msg}</div>`);
}

$('#updateForm').submit(function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url:'update_profile.php',
        type:'POST',
        data:formData,
        contentType:false,
        processData:false,
        success:function(response){
            showMessage(response);
            setTimeout(()=>{ location.reload(); }, 1000);
        }
    });
});
</script>

</body>
</html>
