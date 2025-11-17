<?php
include '../db_connect.php';
session_start();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #ffffffff;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      width: 360px;
    }
    .card-header {
      background-color: #2e7d32;
      color: white;
      text-align: center;
      font-weight: bold;
      font-size: 20px;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }
    .btn-green {
      background-color: #43a047;
      color: white;
      transition: 0.3s;
    }
    .btn-green:hover {
      background-color: #2e7d32;
    }
    .toggle-eye {
      position: absolute;
      right: 15px;
      top: 36px;
      cursor: pointer;
      color: gray;
    }
    a.forgot {
      color: #2e7d32;
      font-size: 14px;
      text-decoration: none;
      display: inline-block;
      margin-top: 10px;
    }
    a.forgot:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-header">Admin Login</div>
    <div class="card-body">
      <form method="post">
        <div class="form-group">
          <label><strong>Username</strong></label>
          <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
        </div>

        <div class="form-group position-relative">
          <label><strong>Password</strong></label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
          <span class="toggle-eye" onclick="togglePassword()">👁️</span>
        </div>

        <button type="submit" name="login" class="btn btn-green btn-block mt-2">Login</button>

        <div class="text-center">
          <a href="forgot_password.php" class="forgot">Forgot Password?</a>
        </div>

        <?php if(isset($error)) echo "<p class='text-danger text-center mt-3'>$error</p>"; ?>
      </form>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passInput = document.getElementById("password");
      const eye = document.querySelector(".toggle-eye");
      if (passInput.type === "password") {
        passInput.type = "text";
        eye.textContent = "🙈";
      } else {
        passInput.type = "password";
        eye.textContent = "👁️";
      }
    }
  </script>
</body>
</html>
