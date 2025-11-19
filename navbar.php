<?php
// ✅ Start session
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// ✅ DB connect
include('db_connect.php');

// ✅ Cart count (optional)
$cart_count = 0;
if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])){
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
        $image_path = 'uploads/' . $user['image']; // user_panel er image folder
        if(!empty($user['image']) && file_exists($image_path)){
            $user_img = $image_path;
        }
    }
}
?>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">GreenBasket</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

        <!-- ✅ Left Menu -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-item"><a class="nav-link" href="product_page.php">Products</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>

        <!-- ✅ Search Bar -->
        <form class="form-inline search-bar" action="search.php" method="GET">
            <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>

        <!-- ✅ Right Side -->
        <ul class="navbar-nav ml-auto">

            <!-- ✅ Cart -->
            <li class="nav-item">
                <a class="nav-link" href="cart.php">🛒 Cart (<?php echo $cart_count; ?>)</a>
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
