<?php
session_start();
include('db_connect.php');

// Initialize cart session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Remove item
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit;
}

// Update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty'])) {
    foreach ($_POST['qty'] as $id => $quantity) {
        if ($quantity > 0) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }
    }
    header("Location: cart.php");
    exit;
}

// Add to cart
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

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
    }
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Cart - GreenBasket</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
body {
    background-color: #f8f9fa;
}
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
.cart-container {
    margin-top: 80px;
    margin-bottom: 80px;
}
.cart-table {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.cart-table th {
    background-color: #116b2e;
    color: white;
    text-align: center;
}
.cart-table td {
    text-align: center;
    vertical-align: middle;
}
.cart-table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}
.total-box {
    text-align: right;
    font-size: 1.3rem;
    font-weight: bold;
    margin-top: 20px;
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
.card:hover {
    transform: scale(1.05);
    box-shadow: 0px 6px 20px rgba(0,0,0,0.2);
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


<!-- Cart Section -->
<div class="container cart-container">
    <h2 class="text-center mb-4">🛒 Your Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info text-center">
            Your cart is empty. <a href="product_page.php" class="alert-link">Shop now!</a>
        </div>
    <?php else: ?>
        <form method="POST" id="cartForm">
            <table class="table table-bordered cart-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price (Tk)</th>
                        <th>Quantity</th>
                        <th>Total (Tk)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    foreach ($_SESSION['cart'] as $id => $item): 
                        $total = $item['price'] * $item['quantity'];
                        $grand_total += $total;

                        // Image path fix
                        $imagePath = $item['image'];
                        if (!preg_match('/image\//', $imagePath)) {
                            $imagePath = 'image/' . $imagePath;
                        }
                    ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td class="price" data-price="<?php echo $item['price']; ?>"><?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="form-control text-center qty-input" style="width:80px; margin:auto;">
                        </td>
                        <td class="item-total"><?php echo number_format($total, 2); ?></td>
                        <td><a href="cart.php?remove=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-box">
                Total: <span id="grandTotal" class="text-success"><?php echo number_format($grand_total, 2); ?> Tk</span>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="product_page.php" class="btn btn-secondary">← Continue Shopping</a>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout →</a>
        </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="footer mt-5">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-4 text-left">
                <h3>GreenBasket</h3>
                <p>Fresh & eco-friendly vibe...!</p>
                <p><i class="fas fa-home"></i> Uttor Halishahar, Chattogram</p>
                <p><i class="fas fa-envelope"></i> info@GreenBasket.com</p>
                <p><i class="fas fa-phone"></i> +880 123 456 789</p>
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

<!-- Scripts -->
<script>
document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('input', function() {
        const row = this.closest('tr');
        const price = parseFloat(row.querySelector('.price').dataset.price);
        const qty = parseInt(this.value);
        const total = (price * qty).toFixed(2);
        row.querySelector('.item-total').textContent = total;

        let grandTotal = 0;
        document.querySelectorAll('.item-total').forEach(el => {
            grandTotal += parseFloat(el.textContent);
        });
        document.getElementById('grandTotal').textContent = grandTotal.toFixed(2) + ' Tk';
    });
});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
