<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GreenBasket</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .navbar-nav .nav-item {
      margin-left: 20px;
    }
    .navbar-nav .nav-item .nav-link {
      color: white;
    }
    .navbar-brand {
      color: white;
    }
    .search-bar input[type="text"] {
      width: 300px;
      border-radius: 0;
    }
    .search-bar button {
      border-radius: 0;
    }
    body {
      background-color: #f8f9fa;
    }
    .message-container {
      max-width: 700px;
      margin: 100px auto;
      padding: 40px;
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      text-align: center;
    }
    .message-container h2 {
      color: #116b2e;
      font-weight: bold;
    }
    .message-container p {
      font-size: 18px;
      margin-top: 15px;
    }
    .message-container h4 {
      margin-top: 25px;
      color: #116b2e;
    }
    .message-container .btn {
      margin-top: 20px;
      padding: 12px 30px;
      font-size: 18px;
    }
    .footer {
      background-color: #116b2e;
      color: white;
      padding: 20px 0;
      text-align: center;
      width: 100%;
    }
    .footer a {
      color: white;
      text-decoration: none;
    }
    .footer .social-icons a {
      margin: 0 10px;
    }
    .footer .social-icons i {
      font-size: 24px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">GreenBasket</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.html">About</a>
        </li>
				<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="categories.html" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="Dairy Products.html">Dairy Products</a>
                    <a class="dropdown-item" href="Vegetables.html">Vegetables</a>
                    <a class="dropdown-item" href="Snacks.html">Snacks</a>
					          <a class="dropdown-item" href="Fruits.html">Fruits</a>
                    <a class="dropdown-item" href="Pantry.html">Pantry</a>
                </div> 
            </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.html">Contact</a>
        </li>
      </ul>

      <form class="form-inline search-bar">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="add to cart.html">🛒 Add to Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="user.html">👤 User</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Motivational Message Section -->
  <div class="container">
    <div class="message-container">
      <h2>Welcome to GreenBasket!</h2>
      <p>
        🌱 Freshness that you deserve, delivered right to your door.  
        Every product is handpicked with love, ensuring the best quality for you and your family.
      </p>
      <h4>🛒 Start shopping today and enjoy healthy living tomorrow!</h4>
      <a href="categories.html" class="btn btn-success">Shop Now</a>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <!-- About -->
        <div class="col-md-4 text-left text-left">
          <h3>GreenBasket</h3>
          <p>Fresh & eco-friendly vibe...!</p>
          <p><i class="fas fa-home me-3"></i> Uttor Halishahar, Chattogram</p>
          <p><i class="fas fa-envelope me-3"></i> info@GreenBasket.com</p>
          <p><i class="fas fa-phone me-3"></i> +1 234 567 890</p>
        </div>
        <!-- Quick Links -->
        <div class="col-md-4">
          <h3>Quick Links</h3>
          <ul class="list-unstyled">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="categories.html">Shop</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div>
        <!-- Social Links -->
        <div class="col-md-4">
          <h3>Follow Us</h3>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
      </div>
      <hr class="my-3 bg-light opacity-100">
      <div class="text-center mt-3">
        <p>&copy; 2025 GreenBasket. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
