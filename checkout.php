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
 
<!--Navigation start-->    
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
                    <a class="dropdown-item" href="#">Grains</a>
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
<!--Navigation End-->   

<div class="container mt-3 py-4">

        <div class="row col-md-12">
            <h4 class="text-start text-uppercase text-center"><span class="mt-2 mb-3">Checkout</span></h4>   
                <p>Checkout is the final step where customers review selected items, confirm quantities, provide delivery details, choose payment method, and complete their grocery shopping securely and conveniently with confidence.</p>
                <hr my-4>
            
                <div class="col-md-8 mt-2">
                <div class="card checkout-billing-card">
                    <div class="card-header">
                    Billing Information
                    </div>
                    <div class="card-body">
                    <form  class="row gy-3 needs-validation"  method="get"  id="checkoutForm" novalidate>

                            <!-- First Name -->
                            <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name *</label>
                            <input type="text" name="firstname" id="firstName" required placeholder="Enter Your First Name" class="form-control">
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name *</label>
                            <input type="text" name="lastname" id="lastName" required placeholder="Enter Your Last Name" class="form-control">
                            </div>

                            <!-- Username -->
                            <div class="col-md-12">
                            <label for="inputUsername" class="form-label">User Name *</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" name="username" id="inputUsername" required placeholder="Enter Your Username" class="form-control">
                            </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-12">
                            <label for="email" class="form-label">Email (Optional)</label>
                            <input type="email" name="email" id="email" placeholder="User@gmail.com" class="form-control">
                            </div>

                            <!-- Address -->
                            <div class="col-md-12">
                            <label for="address" class="form-label">Address *</label>
                            <input type="text" name="address" id="address" required placeholder="Enter Address Here" class="form-control">
                            </div>

                            <!-- Country -->
                            <div class="col-md-6">
                            <label for="inputCountry" class="form-label">Country *</label>
                            <select id="inputCountry" class="form-select" name="country" required>
                                <option value="">Choose your country...</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="India">India</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Srilanka">Srilanka</option>
                            </select>
                            </div>

                            <!-- State -->
                            <div class="col-md-4">
                            <label for="inputState" class="form-label">State *</label>
                            <select id="inputState" class="form-select" name="state" required>
                                <option value="">Choose your state...</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Cumilla">Cumilla</option>
                                <option value="Noakhali">Noakhali</option>
                            </select>
                            </div>

                            <!-- Zip Code -->
                            <div class="col-md-2">
                            <label for="zipcode" class="form-label">Zip Code</label>
                            <input type="text" name="zipcode" id="zipcode" placeholder="Zipcode" class="form-control">
                            </div>

                            <!-- Checkboxes -->
                            <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" name="shippingAddress" value="true" class="form-check-input" id="defaultCheck">
                                <label for="defaultCheck" class="form-check-label">Shipping Address is same as billing address</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="rememberAddress" value="true" class="form-check-input" id="rememberAddress">
                                <label for="rememberAddress" class="form-check-label">Remember for next time</label>
                            </div>
                            </div>

                            <!-- Payment -->
                            <div class="col-md-12">
                            <label class="form-label">Payment *</label>
                            <div class="form-check">
                                <input type="radio" name="payment" value="creditcard" class="form-check-input" required id="paymentcreditcard">
                                <label for="paymentcreditcard" class="form-check-label">Credit Card</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="payment" value="debitcart" class="form-check-input" id="paymentdebitcart">
                                <label for="paymentdebitcart" class="form-check-label">Debit Card</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="payment" value="paypal" class="form-check-input" id="paymentpaypal">
                                <label for="paymentpaypal" class="form-check-label">Paypal</label>
                            </div>
                            </div>

                            <!-- Card Name -->
                            <div class="col-md-6">
                            <label for="cardName" class="form-label">Card Name *</label>
                            <input type="text" name="cardName" id="cardName" required placeholder="Enter Your Card Name" class="form-control">
                            </div>

                            <!-- Card Number -->
                            <div class="col-md-6">
                            <label for="cardNumber" class="form-label">Credit Card Number *</label>
                            <input type="number" name="cardNumber" id="cardNumber" required placeholder="Enter 16-digit Card Number" class="form-control">
                            </div>

                            <!-- Expired Date -->
                            <div class="col-md-3">
                            <label for="expiredDate" class="form-label">Expired Date *</label>
                            <input type="date" name="expiredDate" id="expiredDate" required class="form-control">
                            </div>

                            <!-- CVV -->
                            <div class="col-md-3">
                            <label for="cvv" class="form-label">CVV *</label>
                            <input type="text" name="cvv" id="cvv" required class="form-control">
                            </div>

                            <!-- Submit -->
                            <div class="col-md-6 mt-3 text-center offset-md-3">
                            <button type="submit" class="btn btn-success w-100">Continue to Checkout</button>
                            </div>
                        </form>
                    </div>
                </div>
                    
            </div>
            <div class="col-md-4 mt-2">
                 <div class="card checkout-prouduct-card">
                    <div class="card-header">Product Cart Information</div>
                    <div class="card-body">
                        <div class="row border border-1 border-start-0 border-top-0 border-end-0">
                                <div class="col-md-9 text-start">
                                    <p class="checkout-product">Product Name</p>
                                    <p class="checkout-product-subtitle">Product Subtitle</p>
                                </div>
                                <div class="col-md-3 text-end">
                                   <span class="text-end">00.00</span>
                                </div>
                        </div>
                        <div class="row border border-1 border-start-0 border-top-0 border-end-0">
                                <div class="col-md-9 text-start">
                                    <p class="checkout-product">Product Name</p>
                                    <p class="checkout-product-subtitle">Product Subtitle</p>
                                </div>
                                <div class="col-md-3 text-end">
                                   <span class="text-end">00.00</span>
                                </div>
                        </div>
                        <div class="row border border-1 border-start-0 border-top-0 border-end-0">
                                <div class="col-md-9 text-start">
                                    <p class="checkout-product">Product Name</p>
                                    <p class="checkout-product-subtitle">Product Subtitle</p>
                                </div>
                                <div class="col-md-3 text-end">
                                   <span class="text-end">00.00</span>
                                </div>
                        </div>
                        <div class="row border border-1 border-start-0 border-top-0 border-end-0">
                                <div class="col-md-9 text-start">
                                    <p class="checkout-product">Product Name</p>
                                    <p class="checkout-product-subtitle">Product Subtitle</p>
                                </div>
                                <div class="col-md-3 text-end">
                                   <span class="text-end">00.00</span>
                                </div>
                        </div>
                        <div class="row border border-1 border-start-0 border-top-0 border-end-0">
                                <div class="col-md-9 text-start">
                                    <p class="checkout-product">Total BDT</p>
                                    
                                </div>
                                <div class="col-md-3 text-end">
                                   <span class="text-end">00.00</span>
                                </div>
                        </div>
                       
                        
                    </div>
                 </div>

                 <div class="div mt-3">
                    <form class="d-flex" role="redeem">
                    <input class="form-control me-2" type="text" placeholder="redeem"     aria-label="redeem"/>
                    <button class="btn btn-secondary" type="submit">Redeem</button>
            </form>
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
    <!-- Footer Section End -->
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>