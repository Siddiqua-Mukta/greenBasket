<?php
session_start();
include 'db_connect.php';

// ✅ Initialize cart session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<?php if (!empty($message)): ?>
<div class="alert alert-success text-center mb-0">
    <?php echo $message; ?>
</div>
<?php endif; 
?>

<?php
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


<?php include('navbar.php'); ?>

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

                        <button data-product-id="<?php echo $prod_id; ?>" 
                             class="btn btn-sm btn-success add-to-cart-ajax">
                         <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                        
                        <a href="product_details.php?id=<?php echo $prod_id; ?>" class="btn btn-sm btn-outline-primary mt-1">
                            Details
                         </a>
                        
                        <div class="mt-2" id="ajax-msg-<?php echo $prod_id; ?>"></div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    
    // AJAX Add to Cart button handler (product page & search page - product card)
    $('.add-to-cart-ajax').on('click', function(e) {
        e.preventDefault(); 
        
        var productId = $(this).data('productId');
        var button = $(this); 
        var messageArea = $('#ajax-msg-' + productId); // ঐ নির্দিষ্ট প্রোডাক্টের মেসেজ এরিয়া

        // বাটন ডিজেবল ও লোডিং স্টেট
        button.prop('disabled', true).html('Adding...');
        messageArea.html('');

        $.ajax({
            url: 'cart.php', // cart.php তে রিকোয়েস্ট পাঠানো হলো
            method: 'POST',
            data: {
                action: 'add_product_ajax', // এই অ্যাকশনটি cart.php হ্যান্ডেল করবে
                product_id: productId,
                quantity: 1 // এই পেজ থেকে সবসময় ১টি করে প্রোডাক্ট যোগ করা হবে
            },
            dataType: 'json',
            success: function(response) {
                // Navbar Cart Count আপডেট করা হলো
                if (response.cart_count !== undefined) {
                    $('.cart-count-badge').text(response.cart_count); 
                }
                
                if (response.success) {
                    // সফল মেসেজ দেখানো
                    messageArea.html('<div class="text-success small font-weight-bold">Product Added Successfully</div>');
                    button.html('<i class="fas fa-check"></i> Added!').removeClass('btn-success').addClass('btn-secondary');
                } else {
                    // ব্যর্থতা বার্তা দেখানো
                    var msg = response.message || "Failed to add product.";
                    messageArea.html('<div class="text-danger small font-weight-bold">Failed!</div>');
                    button.html('<i class="fas fa-times"></i> Failed').removeClass('btn-success').addClass('btn-danger');
                }
                
                // ৩ সেকেন্ড পর বাটন এবং মেসেজ রিসেট করা
                setTimeout(function() {
                    button.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart').removeClass('btn-secondary btn-danger').addClass('btn-success');
                    messageArea.html(''); 
                }, 3000);
            },
            error: function() {
                // সার্ভার এরর
                messageArea.html('<div class="text-danger small font-weight-bold">Error!</div>');
                button.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart');
                setTimeout(function() {
                    messageArea.html('');
                }, 3000);
            }
        });
    });
});
</script>
</body>
</html>
