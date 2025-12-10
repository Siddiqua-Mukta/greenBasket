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

<?php include('navbar.php'); ?>

<!-- Main Content -->
<div class="content container">
    <h3>Search Results for "<?php echo htmlspecialchars($_GET['query']); ?>"</h3>
    <hr>
    <?php if(empty($results)): ?>
        <p>No results found.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach($results as $product): ?>
            <div class="col-6 col-md-3 mb-4">
                <div class="card product-card h-100">
                    <a href="product_details.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                        <img src="image/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </a>
                    <div class="card-body text-center p-2">
                        <h6 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h6>
                        <p><strong>৳<?php echo htmlspecialchars($product['price']); ?></strong></p>
                        <button data-product-id="<?php echo htmlspecialchars($product['id']); ?>" 
                            class="btn btn-sm btn-success add-to-cart-ajax">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                        <a href="product_details.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-sm btn-outline-primary mt-1">
                            Details
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<?php include('footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    
    // AJAX Add to Cart button handler
    $('.add-to-cart-ajax').on('click', function(e) {
        e.preventDefault(); // ডিফল্ট বাটন অ্যাকশন (রিডাইরেক্ট) বন্ধ করা হলো
        
        var productId = $(this).data('productId');
        var button = $(this); 

        // বাটন ডিজেবল ও লোডিং স্টেট
        button.prop('disabled', true).html('Adding...');

        $.ajax({
            url: 'cart.php', // রিকোয়েস্ট cart.php তে পাঠানো হলো
            method: 'POST',
            data: {
                action: 'add_product_ajax', // cart.php তে এই অ্যাকশনটি হ্যান্ডেল করবে
                product_id: productId,
                quantity: 1 
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Navbar Cart Count আপডেট করা হলো
                    $('.cart-count-badge').text(response.cart_count); 
                    
                    // সফল মেসেজ দেখিয়ে বাটন রিসেট
                    button.html('Added!').removeClass('btn-success').addClass('btn-secondary');
                    
                    setTimeout(function() {
                        button.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart').removeClass('btn-secondary').addClass('btn-success');
                    }, 1500);

                } else {
                    alert("Failed to add product: " + (response.message || "Please log in or product not found."));
                    button.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart');
                }
            },
            error: function() {
                alert("Error connecting to server or AJAX error.");
                button.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart');
            }
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
