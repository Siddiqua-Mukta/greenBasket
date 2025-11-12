<?php
include('db_connect.php');
session_start();

$user_id = $_SESSION['user_id'] ?? 0;

// ✅ Fetch user data
$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($userQuery);

$name = $user['name'] ?? '';
$email = $user['email'] ?? '';
$phone = $user['phone'] ?? '';
$address = $user['address'] ?? '';
$image = $user['image'] ?? 'default.png';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Profile Info</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
<style>
body { background:#f3f5f8; }

/* ✅ Sidebar CSS Added */
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
.sidebar a:hover {
    background-color: #232a24ff;
}

/* ✅ Profile card styling */
.profile-card {
    background:#fff;
    border-radius:20px;
    padding:40px 30px;
    max-width:500px;
    margin:60px auto;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}
.profile-img {
    width:150px;
    height:150px;
    border-radius:50%;
    overflow:hidden;
    border:5px solid #28a745;
    margin:0 auto 20px auto;
}
.profile-img img {
    width:100%;height:100%;object-fit:cover;
}
</style>
</head>
<body>

<!-- ✅ Sidebar Added -->
<div class="sidebar" style="height:100vh;background-color:#378149ff;color:#fff;padding-top:30px;position:fixed;width:220px;">
    <h3 class="text-center mb-2">
        <a href="index.php" style="text-decoration:none;color:inherit;">GreenBasket</a>
    </h3>

    <a href="user_panel.php" style="color:#fff;text-decoration:none;display:block;padding:12px 20px;border-radius:8px;margin:5px 10px;">Profile</a>
    <a href="user_change_pass.php" style="color:#fff;text-decoration:none;display:block;padding:12px 20px;border-radius:8px;margin:5px 10px;">Change Password</a>
    <a href="user_orders.php" style="color:#fff;text-decoration:none;display:block;padding:12px 20px;border-radius:8px;margin:5px 10px;">Orders</a>
    <a href="logout.php" style="color:#fff;text-decoration:none;display:block;padding:12px 20px;border-radius:8px;margin:5px 10px;">Logout</a>
</div>

<!-- ✅ Main content shift for sidebar -->
<div style="margin-left:240px;padding:40px;">

<div class="profile-card"">
    <h4 class="text-center mb-3">👤 Profile Information</h4>

    <!-- ✅ Success Message Placeholder -->
    <div id="msg-area"></div>

    <!-- ✅ Profile Picture -->
    <div class="profile-img">
        <img id="profilePic" src="uploads/<?php echo $image; ?>" />
    </div>

    <!-- ✅ Image Upload Form (AJAX) -->
    <form id="picForm" enctype="multipart/form-data" class="mb-4">
        <div class="input-group mb-3">
            <input type="file" name="image" id="imgInput" class="form-control" />
        </div>
        <button type="submit" class="btn btn-success btn-block">Update Picture</button>
    </form>

    <!-- ✅ Profile Info Form (AJAX) -->
    <form id="infoForm">
        <div class="input-group mb-3">
            <span class="input-group-text">Name :</span>
            <input type="text" name="name" value="<?php echo $name; ?>" class="form-control" />
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">Email :</span>
            <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" />
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">Phone :</span>
            <input type="text" name="phone" value="<?php echo $phone; ?>" class="form-control" />
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">Address :</span>
            <input type="text" name="address" value="<?php echo $address; ?>" class="form-control" />
        </div>

        <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
// ✅ Success Message Function
function showMessage(msg, type='success'){
    $('#msg-area').html(`<div class="alert alert-${type}">${msg}</div>`);
    setTimeout(() => { $('#msg-area').html(''); }, 3000);
}

// ✅ Picture Update with Validation
$('#picForm').on('submit', function(e){
    e.preventDefault();

    let file = $('#imgInput')[0].files[0];
    if(!file){ showMessage('Please select a picture!', 'danger'); return; }

    let size = file.size / 1024 / 1024;
    if(size > 2){ showMessage('Image must be under 2MB!', 'danger'); return; }

    let allowed = ['image/jpeg','image/png','image/jpg'];
    if(!allowed.includes(file.type)){ showMessage('Only JPG/PNG allowed!', 'danger'); return; }

    let formData = new FormData(this);
    formData.append('update_pic', 1);

    $.ajax({
        url:'update_pic.php',
        type:'POST',
        data: formData,
        contentType:false,
        processData:false,
        success:function(data){
            $('#profilePic').attr('src', 'uploads/' + data);
            showMessage('Profile picture updated successfully!');
        }
    });
});

// ✅ Info Update AJAX
$('#infoForm').on('submit', function(e){
    e.preventDefault();

    $.ajax({
        url:'update_info.php',
        type:'POST',
        data: $(this).serialize(),
        success:function(){
            showMessage('Profile information updated!');
        }
    });
});
</script>
</body>
</html>
