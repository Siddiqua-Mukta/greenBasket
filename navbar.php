<?php
// ✅ Start session
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// ✅ DB connect (নিশ্চিত করুন যে এই ফাইলটি $conn ভ্যারিয়েবল প্রদান করে)
include('db_connect.php');

// HELPER FUNCTION: Calculate total cart count for display
$cart_count = 0;
if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])){
    // array_column এবং array_sum ব্যবহার করে মোট কোয়ান্টিটি গণনা
    $cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
}

// ✅ User info
$user = null;
$user_img = "uploads/default.png"; // default image

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $query = mysqli_query($conn, "SELECT name, image FROM users WHERE id='$user_id'");
    if($query && mysqli_num_rows($query) > 0){
        $user = mysqli_fetch_assoc($query);

        // Check if uploaded image exists
        $image_path = 'uploads/' . $user['image'];
        if(!empty($user['image']) && file_exists($image_path)){
            $user_img = $image_path;
        }
    }
}
?>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">
        <img src="image/logo.png" alt="GreenBasket Logo" class="logo-img"> 
        GreenBasket
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

        <!-- ✅ Left Menu -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="product_page.php" id="productsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Products
                </a>
                <div class="dropdown-menu" aria-labelledby="productsDropdown">
                    <a class="dropdown-item" href="product_page.php?category=1">Fruits</a>
                    <a class="dropdown-item" href="product_page.php?category=2">Vegetables</a>
                    <a class="dropdown-item" href="product_page.php?category=3">Dairy</a>
                    <a class="dropdown-item" href="product_page.php?category=4">Snakes</a>
                    <a class="dropdown-item" href="product_page.php?category=5">Pantry</a>
                    <a class="dropdown-item" href="product_page.php?category=6">Meats</a>
                    <a class="dropdown-item" href="product_page.php?category=7">Fishes</a>
                    <a class="dropdown-item" href="product_page.php?category=8">Pastry</a>
                    <a class="dropdown-item" href="product_page.php?category=9">Frozen</a>
                    <a class="dropdown-item" href="product_page.php?category=All">All</a>
                </div>
            </li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="createAccountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Create Account
                </a>
                <div class="dropdown-menu" aria-labelledby="createAccountDropdown">
                    <a class="dropdown-item" href="caccount.php">User Account</a>
                    <a class="dropdown-item" href="register_vendor.php">Vendor Account</a>
                    </div>
            </li>
        </ul>

        <!-- ✅ Search Bar -->
        <form class="form-inline search-bar ml-auto" action="search.php" method="GET">
            <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>

        <!-- ✅ Right Side -->
        <ul class="navbar-nav ml-auto">

            <!-- ✅ Cart -->
            <li class="nav-item">
    <a class="nav-link" href="cart.php">
        <i class="fas fa-shopping-cart"></i> 
        Cart 
        <span class="badge badge-warning cart-count-badge">
            <?php echo $cart_count; ?>
        </span>
    </a>
</li>

            <!-- ✅ User Logged In -->
            <?php if ($user): ?>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="user_panel.php">

                        <!-- ✅ Profile image with fallback -->
                        <img src="<?php echo $user_img; ?>"
                             onerror="this.src='uploads/default.png';"
                             style="width:30px; height:30px; border-radius:50%; object-fit:cover; margin-right:5px;">

                        <?php echo htmlspecialchars($user['name']); ?>
                    </a>
                </li>

            <!-- ✅ Not logged in -->
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="user.php">👤 Login</a></li>
            <?php endif; ?>

        </ul>
    </div>
</nav>

<style>
    body { font-family: Arial, sans-serif; }
    .navbar.bg-dark {
    /* ⭐ পটভূমির রং পরিবর্তন করা হলো (উজ্জ্বল সবুজ) ⭐ */
    background-color: #394e3eff !important; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
}
/* লোগো ইমেজের স্টাইল */
.navbar-brand .logo-img {
    height: 35px; /* ⭐ উচ্চতা (Height) পরিবর্তন করুন ⭐ */
    width: auto;  /* প্রস্থ (Width) স্বয়ংক্রিয়ভাবে উচ্চতার সাথে সামঞ্জস্য করবে */
    margin-right: 0px; 
    vertical-align: middle; 
}
    @media (min-width: 992px) { 
        /* 'dropdown' ক্লাস যুক্ত li-কে হোভার করলে ড্রপডাউন মেনুটি দেখাবে */
        .navbar .dropdown:hover .dropdown-menu {
            display: block; /* ড্রপডাউন মেনুটিকে দৃশ্যমান করে */
            margin-top: 0; /* মেনু যাতে ন্যাভবারের সাথে লেগে থাকে */
        }

        /* ড্রপডাউন মেনুটি স্বাভাবিকভাবেই উপরে চলে যায়, তাই এটিকে সঠিকভাবে সারিবদ্ধ করার জন্য */
        .navbar .dropdown-menu {
            margin-top: -1px; 
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    
    // --- Products Link: ক্লিক করলে ড্রপডাউন না খুলে সরাসরি পেজে যাবে ---
    $('#productsDropdown').on('click', function(e) {
        // ছোট স্ক্রিন বা যেখানে ড্রপডাউন বন্ধ থাকে (ন্যূনতম 992px এর নিচে) সেখানে ক্লিক করলে
        if ($(window).width() < 992 || $(this).attr('aria-expanded') === 'false') {
            window.location.href = $(this).attr('href');
        }
    });

    // --- ড্রপডাউন হোভার ফাংশনালিটি (শুধুমাত্র বড় স্ক্রিনের জন্য) ---
    // এই কোডটি আপনার পূর্ববর্তী CSS media query-র কাজটিকে JavaScript/jQuery দিয়ে নিশ্চিত করবে।
    if ($(window).width() >= 992) {
        $('.navbar .dropdown').hover(function() {
            $(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
            $(this).addClass('show');
        }, function() {
            $(this).find('.dropdown-menu').first().stop(true, true).slideUp(100, function() {
                $(this).removeClass('show');
            });
        });
    }

});
</script>