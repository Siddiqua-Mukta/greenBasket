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
		body {
    background-color: #f8f9fa;
}

h2 {
    margin-bottom: 30px;
}

.card {
    margin-bottom: 20px;
}
.card-img-top {
        width: 100%;
        height: 250px;
        object-fit: contain; 
        background-color: #fff; 
        padding: 10px;
    }

    /* Hover effect */
    .card:hover {
        transform: scale(1.05);
        transition: 0.3s;
        box-shadow: 0px 4px 20px rgba(0,0,0,0.2);
    }
	.product-img {
  height: 210px;
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
}
.btn-details {
        margin-top: 10px;
        background-color: #28a745;
        color: white;
    }
    .btn-details:hover {
        background-color: #218838;
        color: #fff;
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
                    <a class="nav-link" href="index.html">Home</a>
                </li>
				<li class="nav-item active">
                    <a class="nav-link" href="about.html">About</a>
                </li>
				<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="categories.html" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="Dairy Products.html">Dairy Products</a>
                    <a class="dropdown-item" href="Vegetables.html">Vegetables</a>
                    <a class="dropdown-item" href="Snacks.html">Snacks</a>
                    <a class="dropdown-item" href="Fruits.html">Fruits</a>
                   <a class="dropdown-item" href="Pantry.html">Pantry</a>

            </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact</a>
                </li>
            </ul>
            <form class="form-inline search-bar">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="add to cart.html">🛒 Add to Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user.html">👤 User</a>
                </li>
            </ul>
        </div>
    </nav>

<!-- Pantry Product-->
<!-- Products Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">Pantry Item</h2>
    <div class="row">

      <!-- Product 1 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/1.jpg" class="card-img-top product-img" alt="Rice">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Rice</h6>
            <p><strong>৳90</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product1Modal">Details</button>
          </div>
        </div>
      </div>

      <!-- Product 2 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/2.jpg" class="card-img-top product-img" alt="Oil">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Soyabin Oil</h6>
            <p><strong>৳100</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product2Modal">Details</button>
          </div>
        </div>
      </div>

      <!-- Product 3 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/3.png" class="card-img-top product-img" alt="Powder">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Red Chili Powder</h6>
            <p><strong>৳55</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product3Modal">Details</button>
          </div>
        </div>
      </div>

      <!-- Product 4 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/4.png" class="card-img-top product-img" alt="Sugar">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Sugar</h6>
            <p><strong>৳105</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product4Modal">Details</button>
          </div>
        </div>
      </div>

      <!-- Product 5 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/5.png" class="card-img-top product-img" alt="Powder">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Turmaric Powder</h6>
            <p><strong>৳40</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product5Modal">Details</button>
          </div>
        </div>
      </div>

      <!-- Product 6 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/6.png" class="card-img-top product-img" alt="Salt">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Salt</h6>
            <p><strong>৳75</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product6Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 7 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/7.jpg" class="card-img-top product-img" alt="Oil">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Olive Oil</h6>
            <p><strong>৳130</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product7Modal">Details</button>
          </div>
        </div>
      </div>
	 
	  
	  <!-- Product 8 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/8.png" class="card-img-top product-img" alt="Oil">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Coconut Oil</h6>
            <p><strong>৳180</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product8Modal">Details</button>
          </div>
        </div>
      </div>      
      
      <!-- Product 9 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/9.png" class="card-img-top product-img" alt="Powder">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Cumin Powder</h6>
            <p><strong>৳60</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product9Modal">Details</button>
          </div>
        </div>
      </div>

      <!-- Product 10 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/10.png" class="card-img-top product-img" alt="Powder">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Coriander Powder</h6>
            <p><strong>৳90</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product10Modal">Details</button>
          </div>
        </div>
      </div>
	  <!-- Product 11 -->
      <div class="col-6 col-md-3 mb-4">
        <div class="card product-card h-100 fade-in">
          <img src="pantry/11.png" class="card-img-top product-img" alt="Powder">
          <div class="card-body text-center p-2">
            <h6 class="card-title">Garam Masala Powder</h6>
            <p><strong>৳90</strong></p>
            <button class="btn btn-sm btn-success">Add to Cart</button>
            <button class="btn btn-sm btn-outline-primary mt-1" data-toggle="modal" data-target="#product11Modal">Details</button>
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
        <h5 class="modal-title">Rice</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/1.jpg" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Rice</h4>
        <p>Staple grain, essential for daily meals, versatile, filling, nutritious.</p>
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
        <h5 class="modal-title">Soyabin Oil</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/2.jpg" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Soyabin Oil</h4>
        <p>Cooking essential, adds flavor, aids frying, healthy or flavorful.</p>
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
        <h5 class="modal-title">Red Chili Powder</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/3.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Red Chili Powder</h4>
        <p>Spices enhancing taste, aroma, color, and nutritional benefits daily.</p>
        <p><strong>Price:৳55</strong></p>
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
        <h5 class="modal-title">Sugar</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/4.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Sugar</h4>
        <p>Sweetener used in cooking, beverages, desserts, energy source, preservative.</p>
        <p><strong>Price:৳105</strong></p>
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
        <h5 class="modal-title">Turmaric Powder</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/5.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Turmaric Powder</h4>
        <p>Spices enhancing taste, aroma, color, and nutritional benefits daily.</p>
        <p><strong>Price:৳40</strong></p>
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
        <h5 class="modal-title">Salt</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/6.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Salt</h4>
        <p>Seasoning for flavor, food preservation, essential mineral, enhances taste.</p>
        <p><strong>Price:৳75</strong></p>
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
        <h5 class="modal-title">Olive Oil</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/7.jpg" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Olive Oil</h4>
        <p>Cooking essential, adds flavor, aids frying, healthy or flavorful.</p>
        <p><strong>Price:৳130</strong></p>
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
        <h5 class="modal-title">Coconut Oil</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/8.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Coconut Oil</h4>
        <p> Cooking essential, adds flavor, aids frying, healthy or flavorful.</p>
        <p><strong>Price:৳180</strong></p>
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
        <h5 class="modal-title">Cumin Powder</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/9.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Cumin Powder</h4>
        <p>Spices enhancing taste, aroma, color, and nutritional benefits daily.</p>
        <p><strong>Price:৳60</strong></p>
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
        <h5 class="modal-title">Coriander Powder</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/10.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Coriander Powder</h4>
        <p>Spices enhancing taste, aroma, color, and nutritional benefits daily.</p>
        <p><strong>Price:৳90</strong></p>
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
        <h5 class="modal-title">Garam Masala Powder</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="pantry/11.png" class="img-fluid mb-3 zoom-img" style="height:300px; object-fit:cover;">
        <h4>Garam Masala Powder</h4>
        <p>Spices enhancing taste, aroma, color, and nutritional benefits daily.</p>
        <p><strong>Price:৳90</strong></p>
        <button class="btn btn-success">Add to Cart</button>
        <button class="btn btn-success"><a href="checkout.html" style="text-decoration: none; color: white;">Checkout</a></button>
      </div>
    </div>
  </div>
</div><br>
	
	
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
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
