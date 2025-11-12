<?php
include('db_connect.php'); // ডাটাবেস কানেকশন

$query = $_GET['query'] ?? '';
$results = [];

if (!empty($query)) {
    $like = "%".$query."%";
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $results[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Results - GreenBasket</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    body, html {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .navbar-nav .nav-item { margin-left: 20px; }
    .navbar-nav .nav-item .nav-link, .navbar-brand { color: white; }
    .search-bar input[type="text"] { width: 300px; border-radius: 0; }
    .search-bar button { border-radius: 0; }

    .content {
        flex: 1 0 auto; /* push footer down */
        padding: 50px 15px;
    }
    .product-card { margin-bottom: 20px; }

    footer.footer {
        flex-shrink: 0;
        background-color: #116b2e;
        color: white;
        padding: 20px 0;
    }
    footer.footer a { color: white; text-decoration: none; }
    footer .social-icons a { margin: 0 10px; }
    footer .social-icons i { font-size: 24px; }
</style>
</head>
<body>

<!-- Navbar -->
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
            <li class="nav-item"><a class="nav-link" href="cart.php">🛒 Cart (<?php echo $cart_count; ?>)</a></li>
            <li class="nav-item"><a class="nav-link" href="user.php">👤 User</a></li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<div class="content container">
    <h3>Search Results for "<?php echo htmlspecialchars($query); ?>"</h3>
    <hr>
    <?php if(empty($results)): ?>
        <p>No results found.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach($results as $product): ?>
                <div class="col-md-4 product-card">
                    <div class="card">
                        <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text">Price: <?php echo $product['price']; ?> Tk</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-4 text-left">
                <h3>GreenBasket</h3>
                <p>Fresh & eco-friendly vibe...!</p>
                <p><i class="fas fa-home"></i> Uttor Halishahar, Chattogram</p>
                <p><i class="fas fa-envelope"></i> info@GreenBasket.com</p>
                <p><i class="fas fa-phone"></i> +1 234 567 890</p>
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
        <hr class="my-3 bg-light opacity-100">
        <div class="text-center mt-3">&copy; 2025 GreenBasket. All rights reserved.</div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
