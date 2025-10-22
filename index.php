<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Navigation Menu</title>
    <!-- Bootstrap CSS -->
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
		.carousel-item img { 
		width: 100%; 
		height: 600px; 
		object-fit: cover; 
		}
		
		.carousel-item {
  transition: opacity 1s ease-in-out;
}

        .feature-box:hover {
            transform: scale(1.05); /* Scale effect on hover */
        }
		.product-img {
  height: 220px;
  width: 100%;
  object-fit: cover; /* ছবিকে কাটছাঁট করে fit করাবে */
}

/* হোভার ইফেক্ট */
.product-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
  transform: scale(1.05);
  box-shadow: 0px 6px 20px rgba(0,0,0,0.2);
}

/* আস্তে আস্তে display এ আসবে (fade-in effect) */
.fade-in {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 1.5s forwards;
}
@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
 /* Modal image zoom */
    .zoom-img {
      transition: transform 0.3s ease-in-out;
      cursor: zoom-in;
    }
    .zoom-img:hover {
      transform: scale(1.2);
      cursor: zoom-out;
    }
}
/* Zoom Image */
.zoom-img { transition: transform 0.3s ease-in-out; cursor: zoom-in; }
.zoom-img:hover { transform: scale(1.2); cursor: zoom-out; }

		.footer {
        background-color: #f8f9fa;
        padding: 20px;
        text-align: center;
       
        width: 100%;
            bottom: 0;
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

    .category-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
  }
  .category-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  }
  .category-card img {
    transition: transform 0.3s ease;
    max-height: 130px; /* ছবির সাইজ বড় */
    object-fit: contain;
  }
  .category-card .card-body {
    padding: 0.75rem; /* টেক্সট এরিয়া একটু বড় */
  }
  .category-card h5 {
    font-size: 1.1rem; /* টেক্সট সাইজ বড় */
    margin: 0;
    color:black;
  }
  </style>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">GreenBasket</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
				<li class="nav-item active">
                    <a class="nav-link" href="about.php">About</a>
                </li>
				<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="categories.html" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="Dairy Products.php">Dairy Products</a>
                    <a class="dropdown-item" href="Vegetables.php">Vegetables</a>
                    <a class="dropdown-item" href="Snacks.php">Snacks</a>
					          <a class="dropdown-item" href="Fruits.php">Fruits</a>
                    <a class="dropdown-item" href="Pantry.php">Pantry</a>
                </div> 
            </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
            <form class="form-inline search-bar">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="add to cart.php">🛒 Add to Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user.php">👤 User</a>
                </li>
            </ul>
        </div>
    </nav>
<!-- Carousel -->
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
        <p>Get the freshest vegetables, fruits, and daily essentials delivered right to your doorstep. We believe good health starts with quality food.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/2.jpg" class="d-block w-100" alt="Slider 1">
      <div class="carousel-caption d-none d-md-block">
        <h5>Shop Smart, Live Better</h5>
        <p>Save time and avoid hassle with easy online grocery shopping. Get premium quality at affordable prices to make your life simpler and better.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/7.jpg" class="d-block w-100" alt="Slider 2">
      <div class="carousel-caption d-none d-md-block">
        <h5>Your Trusted Partner for Everyday Essentials</h5>
        <p>We care for your family’s happiness and safety. Find everything you need in one place with reliable quality and fast delivery.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/1.jpg" class="d-block w-100" alt="Slider 3">
      <div class="carousel-caption d-none d-md-block">
        <h5>Quality You Can Taste, Service You Can Trust</h5>
        <p>From fresh produce to daily groceries, every item is carefully chosen to give you the best taste and reliable service every time.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/111.png" class="d-block w-100" alt="Slider 4">
      <div class="carousel-caption d-none d-md-block">
        <h5>Making Every Meal Healthier & Happier</h5>
        <p>We bring you nutritious, safe, and affordable groceries so that every meal for your family is filled with health, joy, and satisfaction.</p>
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



<!-- Section starts here -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">What We Provide</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="p-4 bg-light feature-box">
                    <h3>Fresh Produce</h3>
                    <p>We offer a wide variety of fresh fruits and vegetables sourced from local farms to ensure quality and taste.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light feature-box">
                    <h3>Home Delivery</h3>
                    <p>Enjoy the convenience of home delivery. Order online and have your groceries delivered right to your doorstep.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light feature-box">
                    <h3>Loyalty Program</h3>
                    <p>Join our loyalty program to earn points on every purchase and enjoy exclusive discounts and offers.</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="p-4 bg-light feature-box">
                    <h3>Organic Options</h3>
                    <p>We provide a selection of organic products, ensuring you have access to healthy and sustainable choices.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light feature-box">
                    <h3>Weekly Specials</h3>
                    <p>Check out our weekly specials for great deals on your favorite products. Save more every week!</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light feature-box">
                    <h3>Customer Support</h3>
                    <p>Our friendly customer support team is here to assist you with any questions or concerns you may have.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!--catagory section start here-->
<div class="container mt-4">
  <h2 class="text-center mb-4">Shop by Category</h2>
  <div class="row justify-content-center">

    <!-- Fruits -->
    <div class="col-6 col-md-2 mb-3">
      <a href="Fruits.php" class="text-decoration-none">
        <div class="card text-center h-100 shadow-sm category-card">
          <img src="fruits/fruits.png" class="card-img-top p-2" alt="Fruits">
          <div class="card-body">
            <h5 class="card-title">Fruits</h5>
          </div>
        </div>
      </a>
    </div>

    <!-- Vegetables -->
    <div class="col-6 col-md-2 mb-3">
      <a href="Vegetables.php" class="text-decoration-none">
        <div class="card text-center h-100 shadow-sm category-card">
          <img src="vegatables/veg.png" class="card-img-top p-2" alt="Vegetables">
          <div class="card-body">
            <h5 class="card-title">Vegetables</h5>
          </div>
        </div>
      </a>
    </div>

    <!-- Dairy Products -->
    <div class="col-6 col-md-2 mb-3">
      <a href="Dairy Products.php" class="text-decoration-none">
        <div class="card text-center h-100 shadow-sm category-card">
          <img src="Dairy product/dairy.png" class="card-img-top p-2" alt="Dairy Products">
          <div class="card-body">
            <h5 class="card-title">Dairy</h5>
          </div>
        </div>
      </a>
    </div>

    <!-- Snacks -->
    <div class="col-6 col-md-2 mb-3">
      <a href="Snacks.php" class="text-decoration-none">
        <div class="card text-center h-100 shadow-sm category-card">
          <img src="snacks/snacks.png" class="card-img-top p-2" alt="Snacks">
          <div class="card-body">
            <h5 class="card-title">Snacks</h5>
          </div>
        </div>
      </a>
    </div>

    <!-- Pantry -->
    <div class="col-6 col-md-2 mb-3">
      <a href="Pantry.php" class="text-decoration-none">
        <div class="card text-center h-100 shadow-sm category-card">
          <img src="pantry/pantry.png" class="card-img-top p-2" alt="Pantry">
          <div class="card-body">
            <h5 class="card-title">Pantry</h5>
          </div>
        </div>
      </a>
    </div>

  </div>
</div> <br>

<!--catagory section start here-->


<!-- Products Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h1 class="text-center mb-4">Featured Products</h1>
    <div class="row">

      <!-- Product 1 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="img/50.png" class="card-img-top product-img" alt="Milk">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Fresh Milk</h6>
            <p><strong>৳90</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product1Modal">Details</button>
          </div>
        </div>
      </div>

      <!-- Product 2 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="img/51.png" class="card-img-top product-img" alt="Yogurt">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Greek Yogurt</h6>
            <p><strong>৳100</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product2Modal">Details</button>
          </div>
        </div>
      </div>

      <!-- Product 3 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/1.webp" class="card-img-top product-img" alt="Potato">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Potato</h6>
            <p><strong>৳20</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product3Modal">Details</button>
          </div>
        </div>
      </div>

<!-- Product 4 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/4.webp" class="card-img-top product-img" alt="Green Chili">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Green Chili</h6>
            <p><strong>৳20</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product4Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 5 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/5.webp" class="card-img-top product-img" alt="Garlic">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Garlic</h6>
            <p><strong>৳50</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product5Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 6 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/6.webp" class="card-img-top product-img" alt="Coriander">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Coriander</h6>
            <p><strong>৳20</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product6Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 7 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/7.webp" class="card-img-top product-img" alt="Tometo">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Tometo</h6>
            <p><strong>৳80</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product7Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 8 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/8.webp" class="card-img-top product-img" alt="Pointed Gourd">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Pointed Gourd</h6>
            <p><strong>৳70</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product8Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 9 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/9.webp" class="card-img-top product-img" alt="Onion">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Onion</h6>
            <p><strong>৳70</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product9Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 10 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/10.webp" class="card-img-top product-img" alt="Papaya">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Papaya</h6>
            <p><strong>৳50</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product10Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 11 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/11.webp" class="card-img-top product-img" alt="Sweet Pumpkin">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Sweet Pumpkin</h6>
            <p><strong>৳40</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product11Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 12 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/12.webp" class="card-img-top product-img" alt="Ginger">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Ginger</h6>
            <p><strong>৳60</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product12Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 13 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/13.webp" class="card-img-top product-img" alt="Water Spinach">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Water Spinach</h6>
            <p><strong>৳30</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product13Modal">Details</button>
          </div>
        </div>
      </div>
      <!-- Product 14 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/28.webp" class="card-img-top product-img" alt="Water Spinach">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Green Capsicum</h6>
            <p><strong>৳70</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product14Modal">Details</button>
          </div>
        </div>
      </div>
      <!-- Product 15 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/29.webp" class="card-img-top product-img" alt="Water Spinach">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Kakrol (Sweet Bitter Gourd)</h6>
            <p><strong>৳40</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product15Modal">Details</button>
          </div>
        </div>
      </div>
      <!-- Product 16 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="image/31.webp" class="card-img-top product-img" alt="Water Spinach">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Lau (Bottle Gourd)h</h6>
            <p><strong>৳50</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product16Modal">Details</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Product 1 Modal -->
<div class="modal fade" id="product1Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Fresh Milk</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="img/50.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Fresh Milk</h4>
        <p>1 liter of fresh organic milk sourced from local farms.</p>
        <p><strong>Price:৳90</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 2 Modal -->
<div class="modal fade" id="product2Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Greek Yogurt</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="img/51.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Greek Yogurt</h4>
        <p>500 grams of creamy Greek yogurt, perfect for breakfast. Delicious and healthy option.</p>
        <p><strong>Price:৳100</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 3 Modal -->
<div class="modal fade" id="product3Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Potato</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/1.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Potato</h4>
        <p>250 gm of premium potato, perfect for sandwiches and snacks.</p>
        <p><strong>Price:৳20</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>

      </div>
    </div>
  </div>
</div>

<!-- Product 4 Modal -->
<div class="modal fade" id="product4Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Green Chili</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/4.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Green Chili</h4>
        <p>Green chili is a spicy vegetable, enhancing flavor, aroma, and health.</p>
        <p><strong>Price:৳20</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>

      </div>
    </div>
  </div>
</div>

<!-- Product 5 Modal -->
<div class="modal fade" id="product5Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Garlic</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/5.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Garlic</h4>
        <p>Garlic is a flavorful bulb used for cooking and health benefits.</p>
        <p><strong>Price:৳50</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 6 Modal -->
<div class="modal fade" id="product6Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Coriander</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/6.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Coriander</h4>
        <p>1Aromatic herb enhancing flavor in dishes, used fresh or dried.</p>
        <p><strong>Price:৳20</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 7 Modal -->
<div class="modal fade" id="product7Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tometo</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/7.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Tometo</h4>
        <p>uicy fruit, rich in vitamins, essential for cooking sauces.</p>
        <p><strong>Price:৳80</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 8 Modal -->
<div class="modal fade" id="product8Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pointed Gourd</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/8.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Pointed Gourd</h4>
        <p> Green vegetable, nutritious, commonly cooked in curries and stir-fries.</p>
        <p><strong>Price:৳70</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 9 Modal -->
<div class="modal fade" id="product9Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Onion</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/9.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Onion</h4>
        <p>Pungent bulb, adds flavor to countless savory dishes worldwide.</p>
        <p><strong>Price:৳70</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 10 Modal -->
<div class="modal fade" id="product10Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Papaya</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/10.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Papaya</h4>
        <p>Sweet tropical fruit, rich in vitamins, digestive-friendly and refreshing.</p>
        <p><strong>Price:৳50</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 11 Modal -->
<div class="modal fade" id="product11Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sweet Pumpkin</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/11.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Sweet Pumpkin</h4>
        <p>Orange squash, nutritious, versatile for soups, desserts, and curries.</p>
        <p><strong>Price:৳40</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 12 Modal -->
<div class="modal fade" id="product12Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ginger</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/12.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Ginger</h4>
        <p>Spicy root, boosts flavor and provides medicinal benefits.</p>
        <p><strong>Price:৳60</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 13 Modal -->
<div class="modal fade" id="product13Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Water Spinach</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/13.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Water Spinach</h4>
        <p>Leafy vegetable, tender, ideal for stir-fry and soups.</p>
        <p><strong>Price: ৳30 </strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 14 Modal -->
<div class="modal fade" id="product14Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Green Capcicum</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/28.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Green Capcicum</h4>
        <p>Leafy vegetable, tender, ideal for stir-fry and soups.</p>
        <p><strong>Price: ৳70 </strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 15 Modal -->
<div class="modal fade" id="product15Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Kakrol (Sweet Bitter Gourd)</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/29.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Kakrol (Sweet Bitter Gourd)</h4>
        <p>Leafy vegetable, tender, ideal for stir-fry and soups.</p>
        <p><strong>Price: ৳40 </strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>

<!-- Product 16 Modal -->
<div class="modal fade" id="product16Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lau (Bottle Gourd)</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="image/31.webp" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Lau (Bottle Gourd)</h4>
        <p>Leafy vegetable, tender, ideal for stir-fry and soups.</p>
        <p><strong>Price: ৳50 </strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div>





   <!-- Footer Section --> 
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
   <!-- Optional JS for Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>