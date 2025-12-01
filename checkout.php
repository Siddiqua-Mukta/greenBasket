<?php
include('db_connect.php');

// 🟢 Start session
if (session_status() === PHP_SESSION_NONE) session_start();

// ✅ ইউজার ডেটা ফেচ করা
$checkout_user = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // ডাটাবেস থেকে সব তথ্য ফেচ করা
    $user_query = $conn->prepare("SELECT name, email, phone, address, country, state, zip_code FROM users WHERE id=?");
    $user_query->bind_param("i", $user_id);
    $user_query->execute();
    $result = $user_query->get_result();
    
    if ($result->num_rows > 0) {
        $checkout_user = $result->fetch_assoc();
    }
    $user_query->close();
}

// 🛒 Cart info
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_count = array_sum(array_column($cart, 'quantity'));
$total_price = 0;
$total_qty = 0;
foreach ($cart as $item){
    $total_price += $item['price'] * $item['quantity'];
    $total_qty += $item['quantity'];
} 
$order_success = false;
$placed_total = 0;

// 🧾 Place order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($cart)) {
    
    // ডাটা পোস্ট থেকে গ্রহণ করা
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $payment = $_POST['payment'];
    $delivery_type = $_POST['delivery_type']; 
    $user_id = $_SESSION['user_id'] ?? null; 

    // Insert order into orders table
    $stmt = $conn->prepare("INSERT INTO orders (user_id, name, phone, email, address, country, state, zipcode, payment, total, total_quantity, delivery_type) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?)");
    if (!$stmt) die("Order Prepare failed: " . $conn->error);
    $stmt->bind_param("issssssssdis", $user_id,$name, $phone, $email, $address, $country, $state, $zipcode, $payment, $total_price,$total_qty, $delivery_type);
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
    /* Navbar এবং body এর ডিজাইন */
    .navbar-nav .nav-item { margin-left: 20px; }
    .navbar-nav .nav-item .nav-link { color: white; }
    .navbar-brand { color: white; }
    .search-bar input[type="text"] { width: 300px; border-radius: 0; }
    .search-bar button { border-radius: 0; }
    body { background-color: #f8f9fa; }
    h2 { margin-bottom:1rem; }
    .card { transition: transform 0.3s ease, box-shadow 0.3s ease; }

    /* Footer ডিজাইন */
    .footer { background-color: #116b2e; color: white; padding: 20px 0; text-align: center; }
    .footer a { color: white; text-decoration: none; }
    .footer .social-icons a { margin: 0 10px; }
    .footer .social-icons i { font-size: 24px; }
    .card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
</style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Checkout</h1>
    
    <?php if ($order_success): ?>
    <div class="alert alert-success text-center mx-auto" style="font-size: 22px; width: fit-content;">
        &#x1F642; Thank you for shopping with <strong>GreenBasket</strong> 🌿
    </div>
    <?php endif; ?>

    <div class="row">

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">Billing Information</div>
                <div class="card-body">
                    <form method="POST" action="">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Full Name *</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($checkout_user['name'] ?? ''); ?>" required class="form-control" placeholder="Enter your full name">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Phone Number *</label>
                                <input type="text" name="phone" value="<?php echo htmlspecialchars($checkout_user['phone'] ?? ''); ?>" required class="form-control" placeholder="+8801XXXXXXXXX">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($checkout_user['email'] ?? ''); ?>" class="form-control" placeholder="example@email.com">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Address *</label>
                                <input type="text" name="address" value="<?php echo htmlspecialchars($checkout_user['address'] ?? ''); ?>" required class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3"> 
                            <div class="col-md-6">
                                <label>Country *</label>
                                <select name="country" class="form-control" required>
                                    <option value="">Select Country</option>
                                    <option value="Bangladesh" <?php echo (isset($checkout_user['country']) && $checkout_user['country'] == 'Bangladesh') ? 'selected' : ''; ?>>Bangladesh</option>
                                    <option value="India" <?php echo (isset($checkout_user['country']) && $checkout_user['country'] == 'India') ? 'selected' : ''; ?>>India</option>
                                    <option value="Nepal" <?php echo (isset($checkout_user['country']) && $checkout_user['country'] == 'Nepal') ? 'selected' : ''; ?>>Nepal</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label>State *</label>
                                <select name="state" class="form-control" required>
                                    <option value="">Select State</option>
                                    <option value="Dhaka" <?php echo (isset($checkout_user['state']) && $checkout_user['state'] == 'Dhaka') ? 'selected' : ''; ?>>Dhaka</option>
                                    <option value="Chittagong" <?php echo (isset($checkout_user['state']) && $checkout_user['state'] == 'Chittagong') ? 'selected' : ''; ?>>Chittagong</option>
                                    <option value="Khulna" <?php echo (isset($checkout_user['state']) && $checkout_user['state'] == 'Khulna') ? 'selected' : ''; ?>>Khulna</option>
                                </select>
                            </div>
                            
                            <div class="col-md-2">
                                <label>Zip</label>
                                <input type="text" name="zipcode" value="<?php echo htmlspecialchars($checkout_user['zip_code'] ?? ''); ?>" class="form-control">
                            </div>
                        </div> 

                        <div class="row"> 
                            <div class="col-md-12 mb-3">
                                <label>Payment Method *</label><br>
                                <input type="radio" name="payment" value="Bikash" class="ml-3" required> Bikash
                                <input type="radio" name="payment" value="Nagad" class="ml-3"> Nagad
                                <input type="radio" name="payment" value="Cash on delivery" class="ml-3"> Cash on delivery
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Delivery Type *</label>
                                <select name="delivery_type" class="form-control" required>
                                    <option value="">Select Delivery Type</option>
                                    <option value="Home Delivery">Home Delivery</option>
                                    <option value="Pickup">Pickup</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 text-center mt-3">
                                <button type="submit" class="btn btn-success w-50" <?php echo empty($cart) ? 'disabled' : ''; ?>>Place Order</button>
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

    </div> </div> 
    

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