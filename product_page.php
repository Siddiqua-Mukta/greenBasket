<?php
session_start();
include 'db_connect.php';

// ✅ Initialize cart session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ✅ Add to cart when button clicked
if (isset($_GET['add_to_cart'])) {
    $product_id = intval($_GET['add_to_cart']);

    $query = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $id = $product['id'];
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
        $message = "✅ " . $product['name'] . " added to cart!";
    }
}

// ✅ Get category ID from URL
$category = isset($_GET['category']) ? $_GET['category'] : 'All';
$category = mysqli_real_escape_string($conn, $category);

// ✅ Fetch products based on selected category
if ($category == 'All') {
    $sql = "SELECT * FROM products";
} else {
    $sql = "SELECT * FROM products WHERE category_id = '$category'";
}
$products = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Products</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: Arial, sans-serif; }
    .navbar-nav .nav-item { margin-left: 20px; }
    .navbar-nav .nav-item .nav-link, .navbar-brand { color: white; }
    .search-bar input[type="text"] { width: 300px; border-radius: 0; }
    .search-bar button { border-radius: 0; }
    .product-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      transition: 0.3s;
    }
    .product-card:hover {
      transform: scale(1.05);
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }
    .product-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    .footer { background-color: #116b2e; color: white; padding: 20px 0; text-align: center; }
    .footer a { color: white; text-decoration: none; }
    .footer .social-icons a { margin: 0 10px; font-size: 24px; }
    .filter-links a { margin: 0 10px; font-weight: 600; color: #28a745; text-decoration: none; }
    .filter-links a:hover { text-decoration: underline; }
  </style>
</head>
<body>


<?php
//  Session start (অবশ্যই উপরে রাখো)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//  Cart item সংখ্যা গণনা
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>

<!--  Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">GreenBasket</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-item"><a class="nav-link" href="product_page.php">Products</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>

        <form class="form-inline search-bar" action="search.php" method="GET">
            <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="cart.php">
                    🛒 Cart (<?php echo $cart_count; ?>)
                </a>
            </li>
            <li class="nav-item"><a class="nav-link" href="user.php">👤 User</a></li>
        </ul>
    </div>
</nav>

<!-- ✅ Success message -->
<?php if (!empty($message)): ?>
<div class="alert alert-success text-center mb-0">
    <?php echo $message; ?>
</div>
<?php endif; ?>

<!-- Category Filter -->
<div class="text-center py-3 bg-white filter-links">
  <a href="product_page.php?category=All" class="<?= ($category=='All') ? 'text-success font-weight-bold' : '' ?>">All</a>
  <a href="product_page.php?category=1" class="<?= ($category=='1') ? 'text-success font-weight-bold' : '' ?>">Fruits</a>
  <a href="product_page.php?category=2" class="<?= ($category=='2') ? 'text-success font-weight-bold' : '' ?>">Vegetables</a>
  <a href="product_page.php?category=3" class="<?= ($category=='3') ? 'text-success font-weight-bold' : '' ?>">Dairy</a>
  <a href="product_page.php?category=4" class="<?= ($category=='4') ? 'text-success font-weight-bold' : '' ?>">Snacks</a>
  <a href="product_page.php?category=5" class="<?= ($category=='5') ? 'text-success font-weight-bold' : '' ?>">Pantry</a>
</div>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Our Products</h2>
        <div class="row">
            <?php
            if (mysqli_num_rows($products) > 0) {
                while($row = mysqli_fetch_assoc($products)){
                    $prod_id = $row['id'];
                    $prod_name = $row['name'];
                    $prod_image = $row['image'];
                    $prod_price = $row['price'];
            ?>
            <div class="col-6 col-md-3 mb-4">
                <div class="card product-card h-100">
                    <a href="product_details.php?id=<?php echo $prod_id; ?>">
                        <img src="image/<?php echo $prod_image; ?>" class="card-img-top product-img" alt="<?php echo $prod_name; ?>">
                    </a>
                    <div class="card-body text-center p-2">
                        <h6 class="card-title"><?php echo $prod_name; ?></h6>
                        <p><strong>৳<?php echo $prod_price; ?></strong></p>
                        <a href="product_page.php?add_to_cart=<?php echo $prod_id; ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </a>
                        <a href="product_details.php?id=<?php echo $prod_id; ?>" class="btn btn-sm btn-outline-primary mt-1">
                            Details
                        </a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<div class='col-12 text-center'><p>No products found in this category.</p></div>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-left">
                <h3>GreenBasket</h3>
                <p>Fresh & eco-friendly vibe...!</p>
                <p><i class="fas fa-home me-3"></i> Uttor halishahar, Chattogram</p>
                <p><i class="fas fa-envelope me-3"></i> info@GreenBasket.com</p>
                <p><i class="fas fa-phone me-3"></i> +1 234 567 890</p>
            </div>
            <div class="col-md-4">
                <h3>Quick Links</h3>
                <ul class="list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="product_page.php">Shop</a></li>
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
        <hr class="my-3 bg-light opacity-100">
        <div class="text-center mt-3">
            <p>&copy; 2025 GreenBasket. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
