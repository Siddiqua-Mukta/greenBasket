<?php
session_start();
include('db_connect.php'); // নিশ্চিত করুন db_connect.php সঠিকভাবে $conn প্রদান করছে

$user_logged_in = isset($_SESSION['user_id']);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// -------------------------------------------------------------------
// *** অস্থায়ী ডিবাগিং টুল: কার্ট ডেটা ক্লিয়ার করার জন্য ***
if (isset($_GET['clear_cart'])) {
    unset($_SESSION['cart']); 
    header("Location: cart.php"); 
    exit;
}

function calculate_cart_count() {
    $count = 0;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $item) {
            $count += intval($item['quantity']); // নিশ্চিত করা হলো
        }
    }
    return $count;
}

// Grand Total গণনা (সংশোধিত: রিফ্রেশে ০ সমস্যা সমাধানের জন্য)
function calculate_grand_total() {
    $total = 0;
    
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $item) {
            
            // ✅ নিশ্চিত করা হলো: price সবসময় floatval এবং quantity সবসময় intval
            $price = isset($item['price']) ? floatval($item['price']) : 0;
            $quantity = isset($item['quantity']) ? intval($item['quantity']) : 0;

            $total += $price * $quantity;
        }
    }
    return $total;
}


// -------------------------------------------------------------------
// ৩. ***** AJAX QUANTITY UPDATE লজিক *****
// -------------------------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] === 'update_quantity_ajax') {
    header('Content-Type: application/json');
    
    $product_id = intval($_POST['id']);
    $new_quantity = intval($_POST['quantity']);
    
    $success = false;
    
    if ($new_quantity >= 1 && isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
        $success = true;
    } 

    $response = [
        'success' => $success,
        'new_grand_total' => number_format(calculate_grand_total(), 2),
        'cart_count' => calculate_cart_count()
    ];
    
    echo json_encode($response);
    exit; 
}
// -------------------------------------------------------------------
// ৩.৫. ***** AJAX ADD TO CART লজিক (Search Page এর জন্য) *****
// -------------------------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] === 'add_product_ajax') {
    header('Content-Type: application/json');
    
    $product_id_to_add = intval($_POST['product_id']);
    $quantity_to_add = intval($_POST['quantity']);
    $success = false;
    $message = '';
    
    if (!$user_logged_in) {
        // লগইন না করা থাকলে ব্যর্থতা বার্তা পাঠানো
        $message = "Please log in to add items to the cart.";
    } else {
        // ডেটাবেস থেকে প্রোডাক্টের তথ্য আনা
        $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id_to_add);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product && $quantity_to_add > 0) {
            $id = $product['id'];
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] += $quantity_to_add; 
            } else {
                // সেশনে সেভ করার সময় price float হিসেবে কাস্ট করা হলো
                $_SESSION['cart'][$id] = [ 
                    'product_id' => $product['id'],
                    'name' => $product['name'],
                    'price' => (float)$product['price'], 
                    'image' => $product['image'],
                    'quantity' => $quantity_to_add
                ];
            }
            $success = true;
            $message = 'Product added successfully.';
        } else {
            $message = 'Product not found.';
        }
    }
    
    $response = [
        'success' => $success,
        'cart_count' => calculate_cart_count(), // calculate_cart_count() ফাংশন ব্যবহার করা হলো
        'message' => $message
    ];
    
    echo json_encode($response);
    exit; 
}

$product_id_to_add = null;
$quantity_to_add = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id_to_add = intval($_POST['product_id']);
    $quantity_to_add = intval($_POST['quantity_value']);
    $redirect_url_on_success = "product_details.php?id=" . $product_id_to_add . "&status=added";
} 
elseif (isset($_GET['add_product_id'])) {
    $product_id_to_add = intval($_GET['add_product_id']);
    $quantity_to_add = 1; 
    $redirect_url_on_success = "cart.php"; 
}


if ($product_id_to_add && $quantity_to_add > 0) {
    
    if (!$user_logged_in) {
        header("Location: user.php?redirect=" . urlencode($redirect_url_on_success));
        exit;
    }

    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id_to_add);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $id = $product['id'];
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity_to_add; 
        } else {
            // ✅ গুরুত্বপূর্ণ ফিক্স: price সেশনে সেভ করার সময় float হিসেবে নিশ্চিত করা হলো
            $_SESSION['cart'][$id] = [ 
                'product_id' => $product['id'],
                'price' => (float)$product['price'], // <--- (float) কাস্ট করা হলো
                'image' => $product['image'],
                'quantity' => $quantity_to_add
            ];
        }
    }
    
    header("Location: " . $redirect_url_on_success);
    exit;
}


// -------------------------------------------------------------------
// ৫. REMOVE ITEM লজিক (GET)
// -------------------------------------------------------------------
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit;
}


$grand_total = calculate_grand_total(); // এখন এটি সুরক্ষিত

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Cart - GreenBasket</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>

body { background-color: #f8f9fa; }
.navbar-nav .nav-item { margin-left: 20px; }
.navbar-nav .nav-item .nav-link { color: white; }
.navbar-brand { color: white; }
.search-bar input[type="text"] { width: 300px; border-radius: 0; }
.search-bar button { border-radius: 0; }
.cart-container { margin-top: 40px; margin-bottom: 80px; }
.cart-table { background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.cart-table th { background-color: #116b2e; color: white; text-align: center; }
.cart-table td { text-align: center; vertical-align: middle; }
.cart-table img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
.total-box { text-align: right; font-size: 1.3rem; font-weight: bold; margin-top: 20px; }
.footer { background-color: #116b2e; color: white; padding: 20px 0; }
.footer a { color: white; text-decoration: none; }
.footer .social-icons a { margin: 0 10px; }
.footer .social-icons i { font-size: 24px; }
.card:hover { transform: scale(1.05); box-shadow: 0px 6px 20px rgba(0,0,0,0.2); }

/* Body & html height 100% */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
}

/* Main content container */
.cart-container {
    flex: 1; /* footer নিচে ঠেলা */
}

/* Footer */
.footer {
    background-color: #116b2e;
    color: white;
    padding: 20px 0;
}

</style>
</head>
<body>


<?php include('navbar.php'); ?>


<div class="container cart-container">
    <h2 class="text-center mb-4">🛒 Your Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info text-center">
            Your cart is empty. <a href="product_page.php" class="alert-link">Shop now!</a>
        </div>
    <?php else: ?>
        <form id="cartForm" onsubmit="return false;">
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
                    foreach ($_SESSION['cart'] as $id => $item): 
                        // নিশ্চিত করার জন্য $item['price'] কে float এ কাস্ট করা হলো
                        $price = floatval($item['price']); 
                        $total = $price * $item['quantity'];
                    
                        $imagePath = $item['image'];
                        if (!preg_match('/image\//', $imagePath)) {
                            $imagePath = 'image/' . $imagePath;
                        }
                    ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td class="price" data-price="<?php echo $price; ?>"><?php echo number_format($price, 2); ?></td>
                        <td>
                            <div class="input-group" style="width:120px; margin:auto;">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary btn-minus" type="button" data-id="<?php echo $id; ?>">-</button>
                                </div>
                                <input type="number" data-id="<?php echo $id; ?>" value="<?php echo $item['quantity']; ?>" min="1" class="form-control text-center qty-input">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-plus" type="button" data-id="<?php echo $id; ?>">+</button>
                                </div>
                             </div>
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
            <?php if ($user_logged_in): ?>
                <a href="checkout.php" class="btn btn-success">Proceed to Checkout →</a>
            <?php else: ?>
                <a href="user.php?redirect=checkout.php" class="btn btn-success">Login to Checkout →</a>
            <?php endif; ?>
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
                <p><i class="fas fa-phone"></i> 01980468252</p>
            </div>
            <div class="col-md-4">
                <h3>Quick Links</h3>
                <ul class="list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="categories.php">Shop</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="return_policy.php" target="_blank">Returned Policy</a></li> 
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
// jQuery ব্যবহার করে AJAX লজিক
$(document).ready(function() {
    
    function updateCartQuantity(id, quantity, inputElement) {
        
        if (quantity < 1) {
            quantity = 1;
            inputElement.val(1);
            return; 
        }

        // 1. ফ্রন্ট-এন্ডে ডাইনামিক আপডেট
        const row = inputElement.closest('tr');
        const price = parseFloat(row.find('.price').data('price'));
        const newTotal = (price * quantity).toFixed(2);
        row.find('.item-total').text(newTotal);

        let grandTotal = 0;
        $('.item-total').each(function() {
            // FIX: কমা (,) এবং অন্য যেকোনো নন-নিউমেরিক ক্যারেকটার সরানোর পর parseFloat ব্যবহার করা হলো।
            let itemTotalText = $(this).text().replace(/,/g, '').trim(); 
            grandTotal += parseFloat(itemTotalText) || 0; 
        });
        $('#grandTotal').text(grandTotal.toFixed(2) + ' Tk');
        

        // 2. ব্যাক-এন্ড AJAX আপডেট
        $.ajax({
            url: 'cart.php', 
            method: 'POST',
            data: {
                action: 'update_quantity_ajax', 
                id: id,
                quantity: quantity
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.cart-count-badge').text(response.cart_count); 
                    $('#grandTotal').text(response.new_grand_total + ' Tk');
                } else {
                    console.error("Failed to update cart:", response.message || "Unknown error");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    $('.qty-input').on('input', function() {
        let inputElement = $(this);
        let id = inputElement.data('id');
        let qty = parseInt(inputElement.val());
        
        if (isNaN(qty) || qty < 1) {
            qty = 1;
            inputElement.val(1);
        }

        updateCartQuantity(id, qty, inputElement);
    });

    $('.btn-plus').on('click', function() {
        const input = $(this).closest('.input-group').find('.qty-input');
        const id = input.data('id');
        let qty = parseInt(input.val()) + 1;
        
        input.val(qty); 
        updateCartQuantity(id, qty, input);
    });

    $('.btn-minus').on('click', function() {
        const input = $(this).closest('.input-group').find('.qty-input');
        const id = input.data('id');
        let current_qty = parseInt(input.val());
        
        if (current_qty > 1) { 
            let new_qty = current_qty - 1;
            input.val(new_qty);
            updateCartQuantity(id, new_qty, input);
        }
    });
});

</script>

</body>
</html>
