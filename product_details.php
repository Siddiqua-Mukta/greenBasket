<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db_connect.php');

// Get product ID from URL
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
} else {
    echo "No product selected!";
    exit;
}

// Fetch product details
$product_query = "
    SELECT products.*, category.cat_title AS category_name 
    FROM products
    JOIN category ON products.category_id = category.id
    WHERE products.id = $product_id
";
$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);

if (!$product) {
    echo "Product not found!";
    exit;
}

// Fetch related products (same category)
$related_query = "
    SELECT * FROM products 
    WHERE category_id = '{$product['category_id']}' 
    AND id != $product_id 
    LIMIT 4
";
$related_result = mysqli_query($conn, $related_query);


$cart_status = isset($_GET['status']) && $_GET['status'] == 'added' ? true : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - GreenBasket</title>
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
        .product-img { width: 100%; height: 500px; object-fit: cover; border-radius: 10px; }
        .thumb-img { width: 80px; height: 80px; object-fit: cover; margin: 5px; cursor: pointer; border: 2px solid #ddd; border-radius: 5px; }
        .thumb-img:hover { border-color: #28a745; }
        
        /* Quantity Input (Fixed Alignment) */
        .quantity-input { 
            width: 60px; 
            text-align: center; 
            height: calc(1.5em + .75rem + 2px); 
            padding: .375rem .75rem;
        }
        
        .btn-add, .btn-checkout { margin-right: 10px; }
        .related-product .card-img-top { height: 200px; object-fit: cover; }
        .btn-checkout a { color: white; text-decoration: none; }

        .img-zoom-container {
            position: relative;
            overflow: hidden;
        }

        .img-zoom-container img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            transition: transform 0.3s ease; /* smooth zoom effect */
        }

        .img-zoom-container:hover img {
            transform: scale(2); /* Zoom factor */
            cursor: zoom-in;
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


<?php include('navbar.php'); ?>


<div class="container py-5">
    
    <?php if ($cart_status): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Product added to cart.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="img-zoom-container">
                <img id="mainImg" src="image/<?php echo htmlspecialchars($product['image']); ?>" class="product-img" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="d-flex mt-2">
                <img src="image/<?php echo htmlspecialchars($product['image']); ?>" class="thumb-img" onclick="changeImage(this.src)">
            </div>
        </div>



        <!-- Right: Product Details -->
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p>Category: <strong><?php echo htmlspecialchars($product['category_name']); ?></strong></p>
            <p>Price: <strong>৳<?php echo htmlspecialchars($product['price']); ?></strong></p>

            <!-- Quantity -->
            <div class="d-flex align-items-center mb-3">
                <label for="quantity" class="mr-2">Quantity:</label>
                <button class="btn btn-outline-secondary" onclick="decreaseQty()">-</button>
                <input type="number" id="quantity" class="quantity-input mx-2" value="1" min="1">
                <button class="btn btn-outline-secondary" onclick="increaseQty()">+</button>
            </div>

            <!-- Review stars -->
            <p>
                Review: 
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star-half-alt text-warning"></i>
                <i class="far fa-star text-warning"></i>
            </p>

            <!-- Description -->
            <p><?php echo nl2br(htmlspecialchars($product['details'])); ?></p>

            <div class="d-flex my-4"> <form action="cart.php" method="POST" class="mr-2"> 
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    
                    <input type="hidden" name="quantity_value" id="quantity_value" value="1">
                    
                    <button type="submit" name="add_to_cart" class="btn btn-success btn-add">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </form>
                
                <button type="button" class="btn btn-primary btn-checkout">
                    <a href="checkout.php" style="color: white; text-decoration: none;">Checkout</a>
                </button>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <!-- Related Products -->
    <h4>Related Products</h4>
    <div class="row">
        <?php while ($rel = mysqli_fetch_assoc($related_result)): ?>
        <div class="col-6 col-md-3 mb-4">
            <div class="card related-product h-100">
                <a href="product_details.php?id=<?php echo $rel['id']; ?>">
                    <img src="image/<?php echo htmlspecialchars($rel['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($rel['name']); ?>">
                </a>
                <div class="card-body text-center">
                    <h6 class="card-title"><?php echo htmlspecialchars($rel['name']); ?></h6>
                    <p><strong>৳<?php echo htmlspecialchars($rel['price']); ?></strong></p>
                    <a href="product_details.php?id=<?php echo $rel['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('footer.php'); ?>


   <!-- Optional JS for Bootstrap -->


<script>
    // ফাংশন যা লুকানো কোয়ান্টিটি ইনপুটটি আপডেট করবে
    function updateHiddenQuantity() {
        // quantity_value ইনপুটটির মান update করা হচ্ছে
        document.getElementById('quantity_value').value = document.getElementById('quantity').value;
    }

    function increaseQty() {
        let qty = document.getElementById('quantity');
        qty.value = parseInt(qty.value) + 1; // 1 করে বাড়ানো হচ্ছে
        updateHiddenQuantity(); // ✅ লুকানো ইনপুট আপডেট
    }
    
    function decreaseQty() {
        let qty = document.getElementById('quantity');
        if (parseInt(qty.value) > 1) {
            qty.value = parseInt(qty.value) - 1;
        }
        updateHiddenQuantity(); // ✅ লুকানো ইনপুট আপডেট
    }


    // ইনপুট বক্সে কোনো পরিবর্তন হলে সেটিও আপডেট করবে
    document.getElementById('quantity').addEventListener('change', updateHiddenQuantity);

    // পেজ লোড হওয়ার সময় একবার কল করা হলো
    updateHiddenQuantity();


    function changeImage(src) {
        document.getElementById('mainImg').src = src;
    }

    const imgContainer = document.querySelector('.img-zoom-container');
    const mainImg = document.getElementById('mainImg');

    imgContainer.addEventListener('mousemove', function(e){
        const rect = imgContainer.getBoundingClientRect();
        const x = e.clientX - rect.left; // cursor x inside container
        const y = e.clientY - rect.top;  // cursor y inside container

        const xPercent = x / rect.width * 100;
        const yPercent = y / rect.height * 100;

        mainImg.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        mainImg.style.transform = 'scale(2)'; // zoom factor
    });

    imgContainer.addEventListener('mouseleave', function(){
        mainImg.style.transform = 'scale(1)';
        mainImg.style.transformOrigin = 'center center';
    });


</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
