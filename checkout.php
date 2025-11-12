<?php
include('db_connect.php');

// 🟢 Start session
if (session_status() === PHP_SESSION_NONE) session_start();

// 🛒 Cart info
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_count = array_sum(array_column($cart, 'quantity'));
$total_price = 0;
foreach ($cart as $item) $total_price += $item['price'] * $item['quantity'];

$order_success = false;
$placed_total = 0;

// 🧾 Place order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($cart)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $payment = $_POST['payment'];

    // Insert order into orders table
    $stmt = $conn->prepare("INSERT INTO orders (name, phone, email, address, country, state, zipcode, payment, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) die("Order Prepare failed: " . $conn->error);
    $stmt->bind_param("ssssssssd", $name, $phone, $email, $address, $country, $state, $zipcode, $payment, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Insert each cart item into order_items
    $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
    if (!$item_stmt) die("Item Prepare failed: " . $conn->error);
    foreach ($cart as $item) {
        $item_stmt->bind_param("isid", $order_id, $item['name'], $item['quantity'], $item['price']);
        $item_stmt->execute();
    }
    $item_stmt->close();

    // 🧹 Save total for message BEFORE clearing cart
    $placed_total = $total_price;

    // Clear cart & update cart_count
    $_SESSION['cart'] = [];
    $cart = [];
    $cart_count = 0;
    $total_price = 0;

    $order_success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - GreenBasket</title>
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

h2 {
    margin-bottom:1rem;
	}
		
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

.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

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

<div class="container mt-4">
    <h1 class="text-center mb-4">Checkout</h1>
    <div class="row">

<?php if ($order_success): ?>
    <div class="alert alert-success text-center mx-auto" style="font-size: 22px; width: fit-content;">
        &#x1F642; Thank you for shopping with <strong>GreenBasket</strong> 🌿
    </div>
<?php endif; ?>

    
    
        <!-- Billing Info -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">Billing Information</div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Full Name *</label>
                                <input type="text" name="name" required class="form-control" placeholder="Enter your full name">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Phone Number *</label>
                                <input type="text" name="phone" required class="form-control" placeholder="+8801XXXXXXXXX">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="example@email.com">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address *</label>
                                <input type="text" name="address" required class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Country *</label>
                                <select name="country" class="form-control" required>
                                    <option value="">Select Country</option>
                                    <option>Bangladesh</option>
                                    <option>India</option>
                                    <option>Nepal</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>State *</label>
                                <select name="state" class="form-control" required>
                                    <option value="">Select State</option>
                                    <option>Dhaka</option>
                                    <option>Chittagong</option>
                                    <option>Khulna</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Zip</label>
                                <input type="text" name="zipcode" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Payment Method *</label><br>
                                <input type="radio" name="payment" value="Credit Card" required> Credit Card
                                <input type="radio" name="payment" value="Debit Card" class="ml-3"> Debit Card
                                <input type="radio" name="payment" value="Bikash" class="ml-3"> Bikash
                                <input type="radio" name="payment" value="Nagad" class="ml-3"> Nagad
                                <input type="radio" name="payment" value="Cash on delivery" class="ml-3"> Cash on delivery
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success w-50">Place Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Cart Info / Success Message -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">Your Cart</div>
                <div class="card-body">
                    <?php if ($order_success): ?>
                        <div class="alert alert-success text-center">
                            🎉 Order placed successfully!<br>
                            You purchased products worth <strong>৳<?php echo number_format($placed_total, 2); ?></strong>.
                        </div>
                    <?php elseif (empty($cart)): ?>
                        <p class="text-center text-muted">Your cart is empty.</p>
                        <div class="text-center mt-3">
                            <a href="product_page.php" class="btn btn-primary w-100">➕ Add Products</a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($cart as $item): ?>
                            <div class="d-flex justify-content-between border-bottom mb-2 pb-2">
                                <div>
                                    <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                                    <small>Qty: <?php echo $item['quantity']; ?></small>
                                </div>
                                <div>৳<?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                        <div class="d-flex justify-content-between font-weight-bold">
                            <span>Total</span>
                            <span>৳<?php echo number_format($total_price, 2); ?></span>
                        </div>
                        <div class="text-center mt-3">
                            <a href="product_page.php" class="btn btn-primary w-100">➕ Add More Products</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

    <!-- Footer Section --> 
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
						<li><a href="index.html">Home</a></li> 
						<li><a href="about.html">About</a></li>
                        <li><a href="categories.html">Shop</a></li> 
						<li><a href="contact.html">Contact</a></li> 
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
