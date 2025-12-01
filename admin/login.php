<?php
include '../db_connect.php';
session_start();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Wrong Password!";
        }
    } else {
        $error = "Username Not Found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
/* Animated Gradient Background */
body {
    height: 100vh;
    margin:0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(-45deg, #28a745, #85e085, #3cb371, #a4f9a4);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    overflow: hidden;
}

@keyframes gradientBG {
    0% {background-position:0% 50%;}
    50% {background-position:100% 50%;}
    100% {background-position:0% 50%;}
}

/* Floating particles */
.particle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    pointer-events: none;
    animation: float 10s linear infinite;
}

@keyframes float {
    0% {transform: translateY(0) translateX(0);}
    100% {transform: translateY(-120vh) translateX(50px);}
}

/* Glass card */
.outer-card {
    position: relative;
    z-index: 1;
    background: #ffffff;       /* White background */
    backdrop-filter: none;     /* Glass effect off */
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    border: 1px solid rgba(0,0,0,0.1);  
}


.outer-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 16px 32px rgba(0,0,0,0.3);
}

/* Inner form */
.inner-form {
    background: #ffffff;       /* White background */
    backdrop-filter: none;
    padding: 1.5rem;
    border-radius: 15px;
    border: 1px solid rgba(0,0,0,0.1);
}


/* Inputs */
.form-control {
    background: #fff;
    border: 1px solid #ccc;
    color: #212529;
}
.form-control:focus {
    background: #fff;
    border-color: #28a745;
    box-shadow: 0 0 10px rgba(40,167,69,0.5);
}


/* Button */
.btn-success {
    background: #28a745;
    border: none;
    color: #fff;
    font-weight: bold;
    transition: 0.3s;
}
.btn-success:hover {
    background: #218838;
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(33,136,56,0.4);
}

/* Links */
a { 
    color: #fff; 
    transition: color 0.3s; 
}
a:hover { color: #e0ffe0; }

/* Headings */
h2, h3 { font-weight: bold; color: #000000ff; text-shadow: 1px 1px 2px rgba(0,0,0,0.2); }

/* Alerts */
.alert-danger {
    background: rgba(220,53,69,0.2);
    color: #842029;
    border: none;
}

/* Responsive */
@media(max-width:768px){
    .outer-card { padding:1.5rem; }
    .inner-form { padding:1rem; }
}
</style>
</head>
<body>

<!-- Floating particles -->
<script>
for(let i=0;i<30;i++){
    let particle = document.createElement('div');
    particle.className='particle';
    let size = Math.random()*8+4;
    particle.style.width = size+'px';
    particle.style.height = size+'px';
    particle.style.left = Math.random()*100+'vw';
    particle.style.top = Math.random()*100+'vh';
    particle.style.animationDuration = (Math.random()*10+5)+'s';
    particle.style.opacity = Math.random()*0.5+0.2;
    document.body.appendChild(particle);
}
</script>

<div class="outer-card col-md-8 mx-auto">

    <h2 class="text-center mb-4">Welcome to GreenBasket Admin</h2>

    <div class="inner-form col-md-6 mx-auto">

        <h3 class="text-center mb-3">Login</h3>

        <?php if(isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label><h6>Username:</h6></label>
                <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
            </div>

            <div class="mb-3">
                <label><h6>Password:</h6></label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="login" class="btn btn-success w-100">Login</button>

            <div class="text-center mt-3">
                <a href="forgot_password.php" style="color: #000;">Forgot Password?</a>
            </div>
        </form>

    </div>
</div>

</body>
</html>
