<?php
include('db_connect.php');

// Get product ID from URL
if(isset($_GET['id'])){
    $product_id = intval($_GET['id']);
    
} else {
    echo "No product selected!";
    exit;
}

// Fetch product details
$product_query = "SELECT products.*,categories.cat_title as category_name FROM `products`,categories WHERE products.category_id=categories.id and  products.id = $product_id";
$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);

// Fetch related products (same category)
$related_query = "SELECT * FROM products WHERE category_id='{$product['category_id']}' AND id != $product_id LIMIT 4";
$related_result = mysqli_query($conn, $related_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - GreenBasket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .product-img { width: 100%; height: 400px; object-fit: cover; }
        .thumb-img { width: 80px; height: 80px; object-fit: cover; margin: 5px; cursor: pointer; border: 2px solid #ddd; }
        .thumb-img:hover { border-color: #28a745; }
        .quantity-input { width: 60px; text-align: center; }
        .btn-add, .btn-checkout { margin-right: 10px; }
        .related-product .card-img-top { height: 200px; object-fit: cover; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row">
        <!-- Left: Product Images -->
        <div class="col-md-6">
            <img id="mainImg" src="<?php echo $product['image']; ?>" class="product-img mb-3">
            <div class="d-flex">
                <img src="<?php echo $product['image']; ?>" class="thumb-img" onclick="document.getElementById('mainImg').src=this.src;">
                <!-- Add more thumbnails if multiple images exist -->
            </div>
        </div>

        <!-- Right: Product Details -->
        <div class="col-md-6">
            <h2><?php echo $product['name']; ?></h2>
            <p>Category: <strong><?php echo $product['category_name']; ?></strong></p>
            <p>Price: <strong>৳<?php echo $product['price']; ?></strong></p>

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
            <p><?php echo $product['details']; ?></p>

            <!-- Buttons -->
            <button class="btn btn-success btn-add">Add to Cart</button>
            <button class="btn btn-primary btn-checkout"><a href="checkout.php" style="color:white; text-decoration:none;">Checkout</a></button>
        </div>
    </div>

    <hr class="my-5">

    <!-- Related Products -->
    <h4>Related Products</h4>
    <div class="row">
        <?php while($rel = mysqli_fetch_assoc($related_result)): ?>
        <div class="col-6 col-md-3 mb-4">
            <div class="card related-product h-100">
                <a href="product_details.php?id=<?php echo $rel['id']; ?>">
                    <img src="<?php echo $rel['image']; ?>" class="card-img-top" alt="<?php echo $rel['name']; ?>">
                     </a>
                    <div class="card-body text-center">
                    <h6 class="card-title"><?php echo $rel['name']; ?></h6>
                    <p><strong>৳<?php echo $rel['price']; ?></strong></p>
                    <a href="product_details.php?id=<?php echo $rel['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
    function increaseQty(){
        let qty = document.getElementById('quantity');
        qty.value = parseInt(qty.value) + 1;
    }
    function decreaseQty(){
        let qty = document.getElementById('quantity');
        if(parseInt(qty.value) > 1){
            qty.value = parseInt(qty.value) - 1;
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
