<?php 
include('db_connect.php'); 
// 🟢 সেশন শুরু
if (session_status() === PHP_SESSION_NONE) session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenBasket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .navbar-nav .nav-item { margin-left: 20px; }
        .navbar-nav .nav-item .nav-link, .navbar-brand { color: white; }
        .search-bar input[type="text"] { width: 300px; border-radius: 0; }
        .search-bar button { border-radius: 0; }
        .carousel-item img { width: 100%; height: 300px; object-fit: cover; }
        .carousel-item { transition: opacity 1s ease-in-out; }
        .feature-box { transition: transform 0.3s ease; } 
        .feature-box:hover { transform: scale(1.05); }
        
        /* 💡 product_page.php থেকে নেওয়া ডিজাইন */
    .product-card {
      border: 1px solid #282626ff;
      border-radius: 4px;
      padding: 4px;
      text-align: center;
      transition: 0.3s;
    }
    .product-card:hover {
      transform: scale(1.05);
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }
    .product-img {
      width: 80%;
      height: 120px;
      object-fit: cover;
      border-radius: 4px;
    }
    /* Card Body এর ভিতরের প্যাডিংও কমানো প্রয়োজন */
.product-card .card-body {
    padding: 0.5rem 0.25rem !important; /* উপরে নিচে 0.5rem, ডানে বামে 0.25rem করা হলো */
}
/* দাম এবং টাইটেলের মার্জিন কমানো */
.product-card .card-title {
    font-size: 0.9rem;
    margin-bottom: 0.2rem;
}
.product-card p {
    margin-bottom: 0.4rem;
    font-size: 0.9rem;
}
/* বাটন স্পেস কমানো */
.product-buttons {
    gap: 3px; /* বাটনের মধ্যের গ্যাপ 5px থেকে 3px এ কমানো হলো */
}
/* বাটন ছোট করার জন্য */
.btn-sm {
    padding: 0.2rem 0.5rem;
    font-size: 0.75rem;
}
        /* 💡 ডিজাইন পরিবর্তন শেষ */


        .fade-in { opacity: 0; transform: translateY(20px); animation: fadeInUp 1.5s forwards; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .footer { background-color: #116b2e; color: white; padding: 20px 0; text-align: center; }
        .footer a { color: white; text-decoration: none; }
        .footer .social-icons a { margin: 0 10px; font-size: 24px; }
        .category-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 12px; overflow: hidden; cursor: pointer; }
        .category-card:hover { transform: scale(1.05); box-shadow: 0 8px 20px rgba(0,0,0,0.2); }
        .category-card img { transition: transform 0.3s ease; max-height: 130px; object-fit: contain; }
        .category-card .card-body { padding: 0.75rem; }
        .category-card h5 { font-size: 1.1rem; margin: 0; color:black; }
        
        /* Button Structure for block display and spacing */
        .product-buttons {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .btn-block-custom {
            display: block;
            width: 100%;
        }
        .container-style{
            padding-left : 8px;
            padding-right: 8px;
            padding-top: 8px;
        }
        /* কাস্টম CSS যা ক্যারোসেল এবং ব্যানারের উচ্চতা নিয়ন্ত্রণ করবে */
.custom-carousel-height {
    /* আপনার পছন্দসই উচ্চতা এখানে নির্ধারণ করুন */
    height: 300px; 
    /* এই উচ্চতাটি প্রধান ক্যারোসেল div এবং ব্যানার বক্স উভয় ক্ষেত্রেই প্রযোজ্য হবে */
}

/* ক্যারোসেলের ভিতরের ইমেজ এবং আইটেমগুলো যাতে পুরো উচ্চতা নেয় তা নিশ্চিত করা */
.custom-carousel-height .carousel-inner,
.custom-carousel-height .carousel-item {
    height: 100%;
}

.custom-carousel-height .carousel-item img {
    /* ইমেজ যেন এরিয়া কভার করে এবং বিকৃত না হয় */
    object-fit: cover; 
    height: 100%;
}

/* ব্যানারের জন্য স্টাইল */
.banner-box {
    /* ব্যানার বক্সকে সুন্দরভাবে দেখানোর জন্য কিছু অতিরিক্ত স্টাইল */
    background-color: #f8f9fa; 
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 0px;

}

/* ব্যানার ইমেজ যাতে রেসপনসিভ হয় এবং বক্সের সাথে মানানসই হয় */
.banner-box img {
    height: 100%;
    object-fit: cover;
    width: 100%;
}

/* আইকন এবং লেখার মধ্যে সামান্য দূরত্ব তৈরি করার জন্য */
.custom-icon-left {
    margin-right: 2px; /* আইকনের ডানদিকে ৮ পিক্সেল ফাঁকা স্থান */
    color: #187c3bff; /* আইকনের রং */
    font-size: 23px;
}

/* নিশ্চিত করা যে লেখার সাথে আইকনটি মাঝখানে সারিবদ্ধ থাকে */
.feature-item-left p {
    font-weight: 550;
    line-height: 1; /* লাইন হাইট সেট করা */
    margin-bottom: 0.1rem; /* প্রতিটি আইটেমের নিচে সামান্য মার্জিন */
}

/* আইকনকে টেক্সটের সাথে উল্লম্বভাবে সারিবদ্ধ করার জন্য */
.feature-item-left i {
    vertical-align: middle; 
}

/* মূল কন্টেইনারকে মাঝখানে আনতে */
    .feature-container {
        padding-top: 20px;
        padding-bottom: 10px;
        padding-left :1px;
        padding right :2 px;
        text-align : center;
    }
    
    /* ফিচার আইটেমের কলাম সাইজ বাড়ানো এবং মার্জিন মাঝখানে আনা */
    .feature-item-left {
        margin-bottom: 15px; 
        /* এখন col-md-3 ব্যবহার করা হবে, তাই 12/3 = 4টি আইটেম এক লাইনে থাকবে */
    }
    
    /* কন্টেইনার স্টাইল মাঝখানে আনার জন্য */
    .container-style{
        padding-left : 8px;
        padding-right: 8px;
        padding-top: 8px;
        /* কন্টেন্টকে মাঝখানে আনার জন্য কোনো ক্লাস যোগের প্রয়োজন নেই, কারণ row-এর ভেতরে col-গুলো mx-auto দিয়ে মাঝখানে আনব */
    }
    
    /* এখানে নতুন CSS: কলাম সাইজ পরিবর্তন */
    /* বড় স্ক্রিনের জন্য ক্যারোসেলকে 8 কলামের মধ্যে রেখে মাঝখানে আনতে হবে, আর ব্যানার হবে 4 কলাম */
    .custom-carousel-col {
        padding-left: 0px;
        padding-right: 0px;
    }
    .custom-banner-col {
        padding-left: 0px;
        padding-right: 0px;
    }
    
    @media (min-width: 768px) {
        /* ক্যারোসেলকে ছোট করে মাঝখানে আনতে */
        .main-hero-row {
            justify-content: center !important; 
        }
    }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container-fluid container-style" >
    <div class="row w-100 main-hero-row justify-content-center"> 
        
        <div class="col-md-6 custom-carousel-col">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/5.jpg" class="d-block w-100" alt="Slider 0">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Freshness You Deserve, Every Day</h5>
                            <p>Get the freshest vegetables, fruits, and daily essentials delivered to your doorstep.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/2.jpg" class="d-block w-100" alt="Slider 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Shop Smart, Live Better</h5>
                            <p>Save time and avoid hassle with easy online grocery shopping.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/7.jpg" class="d-block w-100" alt="Slider 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Your Trusted Partner for Everyday Essentials</h5>
                            <p>We care for your family’s happiness and safety with reliable quality and fast delivery.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/1.jpg" class="d-block w-100" alt="Slider 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Quality You Can Taste, Service You Can Trust</h5>
                            <p>From fresh produce to daily groceries, every item is carefully chosen for you.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/111.png" class="d-block w-100" alt="Slider 4">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Making Every Meal Healthier & Happier</h5>
                            <p>Nutritious, safe, and affordable groceries for your family.</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        </div>
        
        <div class="col-md-4 custom-banner-col d-none d-md-block">
            <div class="banner-box custom-carousel-height">
                <img src="image/banner.png" class="img-fluid" alt="Special Offer Banner">
            </div>
        </div>
    </div>
</div>

<div class="container-fluid feature-container">
    <div class="row justify-content-center"> 
        <div class="col-md-10"> 
            <div class="row justify-content-center">
                
                <div class="col-6 col-md-2 col-lg-2 feature-item-left"> <p>
                        <i class="fa-solid fa-seedling custom-icon-left"></i>
                        Fresh Produce
                    </p>
                </div>

                <div class="col-6 col-md-2 col-lg-2 feature-item-left">
                    <p>
                        <i class="fa-solid fa-truck custom-icon-left"></i>
                        Home Delivery
                    </p>
                </div>

                <div class="col-6 col-md-2 col-lg-2 feature-item-left">
                    <p>
                        <i class="fa-solid fa-trophy custom-icon-left"></i>
                        Loyalty Program
                    </p>
                </div>
            
                <div class="col-6 col-md-2 col-lg-2 feature-item-left">
                    <p>
                        <i class="fa-solid fa-leaf custom-icon-left"></i>
                        Organic Options
                    </p>
                </div>
            
        

                <div class="col-6 col-md-2 col-lg-2 feature-item-left">
                    <p>
                        <i class="fa-solid fa-tags custom-icon-left"></i>
                        Weekly Specials
                    </p>
                </div>

                <div class="col-6 col-md-2 col-lg-2 feature-item-left">
                    <p>
                        <i class="fa-solid fa-headset custom-icon-left"></i>
                        Customer Support
                    </p>
                </div>
            </div>
        </div>
        </div>

    </div>
</div>
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Shop by Category</h2>
        <div class="row">
            <?php
            $category = mysqli_query($conn, "SELECT * FROM category");

            if(mysqli_num_rows($category) > 0){
                while($cat = mysqli_fetch_assoc($category)){

                    $cat_name = isset($cat['cat_title']) ? $cat['cat_title'] : 'No Name';
                    $cat_image = isset($cat['image']) ? $cat['image'] : 'default.png';
                    $cat_id = isset($cat['id']) ? $cat['id'] : 0;
            ?>
            <div class="col-6 col-md-2 mb-3">
                <a href="product_page.php?category=<?php echo $cat_id; ?>" class="text-decoration-none">

                    <div class="card category-card text-center h-100 shadow-sm">
                        <img src="image/<?php echo $cat_image; ?>" class="card-img-top p-2" alt="<?php echo $cat_name; ?>">
                        <div class="card-body p-2">
                            <h6 class="card-name text-dark mb-0"><?php echo $cat_name; ?></h6>
                        </div>
                    </div>
                </a>
            </div>
            <?php 
                }
            } else {
                echo "<p class='text-center'>No categories found!</p>";
            }
            ?>
        </div>
    </div>
</section>

    <section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Featured Products</h2>

        <?php
        // Fetch all categories
        $cat_query = mysqli_query($conn, "SELECT id, cat_title FROM category");

        while($cat = mysqli_fetch_assoc($cat_query)){
            $cat_id = $cat['id'];
            $cat_name = $cat['cat_title'];

            // 4 products per category
            $prod_query = mysqli_query($conn, "SELECT * FROM products WHERE category_id = $cat_id LIMIT 6");

            if(mysqli_num_rows($prod_query) > 0){
        ?>

        <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
            <h4 class="text-success m-0"><?php echo $cat_name; ?></h4>

            <a href="product_page.php?category=<?php echo $cat_id; ?>" 
               class="btn btn-sm btn-outline-success">
                View All &rarr;
            </a>
        </div>

        <div class="row">
            <?php while($row = mysqli_fetch_assoc($prod_query)){ ?>
            <div class="col-6 col-md-2 mb-3">
                <div class="card product-card h-100 fade-in" id="product-<?php echo $row['id']; ?>">
                    <a href="product_details.php?id=<?php echo $row['id']; ?>">
                        <img src="image/<?php echo $row['image']; ?>" 
                             class="card-img-top product-img" 
                             alt="<?php echo $row['name']; ?>">
                    </a>

                    <div class="card-body text-center p-2">
                        <h6 class="card-title"><?php echo $row['name']; ?></h6>
                        <p><strong>৳<?php echo $row['price']; ?></strong></p>

                        <div class="product-buttons">

                            <a href="product_details.php?id=<?php echo $row['id']; ?>" 
                                class="btn btn-sm btn-outline-primary btn-block-custom">Details
                            </a>
                            <button data-product-id="<?php echo $row['id']; ?>" 
                                 class="btn btn-sm btn-success btn-block-custom add-to-cart-ajax">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                        <div class="mt-2" id="ajax-msg-<?php echo $row['id']; ?>"></div>

                    </div>

                </div>
            </div>
            <?php } ?>
        </div>

        <?php 
            } 
        } 
        ?>

    </div>
</section>

    
    <footer class="footer"> 
        <div class="container"> 
            <div class="row"> 
                <div class="col-md-4 text-left"> 
                    <h3>GreenBasket</h3> 
                    <p>Fresh & eco-friendly vibe...!</p> 
                    <p><i class="fas fa-home me-3"></i> Uttor halishahar, Chattogram</p>
                    <p><i class="fas fa-envelope me-3"></i> info@GreenBasket.com</p>
                    <p><i class="fas fa-phone me-3"></i> 01980468252</p>
                </div> 
                <div class="col-md-4"> 
                    <h3>Quick Links</h3> 
                    <ul class="list-unstyled"> 
                        <li><a href="index.php">Home</a></li> 
                        <li><a href="about.php">About</a></li>
                        <li><a href="product_page.php">Shop</a></li> 
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
            <div class="text-center mt-3"> 
                <p>&copy; 2025 GreenBasket. All rights reserved.</p> 
            </div> 
        </div> 
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        
        // AJAX Add to Cart button handler (Featured Products Section)
        $('.add-to-cart-ajax').on('click', function(e) {
            e.preventDefault(); 
            
            var productId = $(this).data('productId');
            var button = $(this); 
            // নির্দিষ্ট প্রোডাক্টের মেসেজ এরিয়া টার্গেট করা
            var messageArea = $('#ajax-msg-' + productId); 

            // বাটন ডিজেবল ও লোডিং স্টেট
            button.prop('disabled', true).html('Adding...');
            messageArea.html('');

            $.ajax({
                url: 'cart.php', // cart.php তে রিকোয়েস্ট পাঠানো হলো
                method: 'POST',
                data: {
                    action: 'add_product_ajax', // এই অ্যাকশনটি cart.php হ্যান্ডেল করবে
                    product_id: productId,
                    quantity: 1 // এই পেজ থেকে সবসময় ১টি করে প্রোডাক্ট যোগ করা হবে
                },
                dataType: 'json',
                success: function(response) {
                    // Navbar Cart Count আপডেট করা হলো (যদি আপনার navbar.php-তে .cart-count-badge ক্লাস থাকে)
                    if (response.cart_count !== undefined) {
                        $('.cart-count-badge').text(response.cart_count); 
                    }
                    
                    if (response.success) {
                        // সফল মেসেজ দেখানো
                        messageArea.html('<div class="text-success small font-weight-bold">Added Successfully!</div>');
                        button.html('<i class="fas fa-check"></i> Added!').removeClass('btn-success').addClass('btn-secondary');
                    } else {
                        // ব্যর্থতা বার্তা দেখানো
                        var msg = response.message || "Failed to add product.";
                        messageArea.html('<div class="text-danger small font-weight-bold">Failed! Please log in first.</div>');
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
                    messageArea.html('<div class="text-danger small font-weight-bold">Server Error!</div>');
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
