<?php
include('db_connect.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $message = mysqli_real_escape_string($conn, $_POST['message'] ?? '');

    if ($name && $email && $message) {
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $sql)) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - GreenBasket</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
body { font-family: Arial, sans-serif; }
        .navbar-nav .nav-item { margin-left: 20px; }
        .navbar-nav .nav-item .nav-link, .navbar-brand { color: white; }
        .search-bar input[type="text"] { width: 300px; border-radius: 0; }
        .search-bar button { border-radius: 0; }
.card { margin-top: 20px; }
.footer {
        background-color: #f8f9fa;
        padding: 20px;
        text-align: center;
       
        width: 100%;
            bottom: 0;
        }
    .footer { 
		background-color: #116b2e; 
		color: white; 
		padding: 20px 0; 
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

<?php
//  Session start (অবশ্যই উপরে রাখো)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//  Cart item সংখ্যা গণনা
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?> 

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


<!-- Contact Section -->
<div class="container mt-5">
    <h2 class="text-center">Contact Us</h2>

    <?php if (!empty($success)) { ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Get in Touch</h4>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" class="form-control" id="message" rows="4" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Send Message</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Contact Information</h4>
                    <p><strong>Address:</strong> Uttor Halishahar, Chattogram</p>
                    <p><strong>Phone:</strong> +1 234 567 890</p>
                    <p><strong>Email:</strong> info@GreenBasket.com</p>
                    <h5>Follow Us</h5>
                    <a href="#" class="btn btn-outline-primary btn-sm"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="#" class="btn btn-outline-info btn-sm"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="#" class="btn btn-outline-success btn-sm"><i class="fab fa-whatsapp"></i> Whatsapp</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-5">
    <div class="container">
        <div class="row">

            <div class="col-md-4">
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
        <hr class="bg-light">
        <div class="text-center">
            <p>&copy; 2025 GreenBasket. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
