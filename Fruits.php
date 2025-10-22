<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GreenBasket</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <style>
    body { background-color: #f8f9fa; font-family: "Poppins", sans-serif; }
    .navbar-nav .nav-item { margin-left: 20px; }
    .navbar-nav .nav-link, .navbar-brand { color: white !important; }
    .product-card { border: none; transition: 0.3s; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff; }
    .product-card:hover { transform: scale(1.05); box-shadow: 0 5px 20px rgba(0,0,0,0.2); }
    .card-img-top { width: 100%; height: 250px; object-fit: contain; background-color: #fff; padding: 10px; }
    .price { color: green; font-weight: 600; font-size: 1.1em; }
    .btn-details { background-color: #28a745; color: white; margin-top: 10px; }
    .btn-details:hover { background-color: #218838; color: #fff; }
    footer { background-color: #116b2e; color: white; padding: 30px 0; }
    footer a { color: white; text-decoration: none; }
    footer .social-icons a { margin: 0 10px; color: white; }
    footer .social-icons i { font-size: 24px; }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">GreenBasket</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown">Categories</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="Dairy Products.php">Dairy Products</a>
            <a class="dropdown-item" href="Vegetables.php">Vegetables</a>
            <a class="dropdown-item" href="Snacks.php">Snacks</a>
            <a class="dropdown-item" href="Fruits.php">Fruits</a>
            <a class="dropdown-item" href="Pantry.php">Pantry</a>
          </div>
        </li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
      <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" />
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="add-to-cart.php">🛒 Cart</a></li>
        <li class="nav-item"><a class="nav-link" href="user.php">👤 User</a></li>
      </ul>
    </div>
  </nav>

  <!-- Products Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-4">Our Products</h2>
      <div class="row">
        <?php
          $sql = "SELECT * FROM products";
          $result = $conn->query($sql);
          

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '
              <div class="col-md-4 mb-4">
                <div class="card product-card">
                  <a href="product_details.php?id='.$row['id'].'">
                <img src="fruits/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
                </a>
                  <div class="card-body text-center">
                    <h5 class="card-title">'.$row['name'].'</h5>
                    <p class="price">৳ '.$row['price'].'</p>
                    <button class="btn btn-details" data-toggle="modal" data-target="#product'.$row['id'].'">View Details</button>
                   </div>
                </div>
              </div>

              <!-- Modal -->
              <div class="modal fade" id="product'.$row['id'].'" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">'.$row['name'].'</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                      <img src="'.$row['image'].'" class="img-fluid mb-3" style="max-height:250px;">
                      <p>'.$row['details'].'</p>
                      <h6 class="price">৳ '.$row['price'].'</h6>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success">Add to Cart</button>
                    </div>
                  </div>
                </div>
              </div>';
            }
          } else {
            echo "<p class='text-center'>No products found.</p>";
          }
        ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h3>GreenBasket</h3>
          <p>Fresh & eco-friendly vibe...!</p>
          <p><i class="fas fa-home"></i> Uttor Halishahar, Chattogram</p>
          <p><i class="fas fa-envelope"></i> info@greenbasket.com</p>
          <p><i class="fas fa-phone"></i> +880 1234 567 890</p>
        </div>
        <div class="col-md-4">
          <h3>Quick Links</h3>
          <ul class="list-unstyled">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="categories.php">Shop</a></li>
            <li><a href="contact.php">Contact</a></li>
          </ul>
        </div>
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
      <hr class="bg-light">
      <div class="text-center mt-3">
        <p>&copy; 2025 GreenBasket. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
