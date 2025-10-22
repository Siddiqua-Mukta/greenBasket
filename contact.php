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
    margin-top: 20px;
}

.btn {
    margin-right: 5px;
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
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="Dairy Products.php">Dairy Products</a>
                    <a class="dropdown-item" href="Vegetables.php">Vegetables</a>
                    <a class="dropdown-item" href="Snacks.php">Snacks</a>
					 <a class="dropdown-item" href="Fruits.php">Fruits</a>
                    <a class="dropdown-item" href="Pantry.php">Pantry</a>
                   
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
<div class="container mt-5">
    <h2 class="text-center">Contact Us</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Get in Touch</h4>
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center card-title">Contact Information</h4></br>
                    <p><strong>Address:</strong> Uttor halishahar, Chattogram</p>
                    <p><strong>Phone:</strong> +1 234 567 890</p>
                    <p><strong>Email:</strong> info@GreenBasket.com</p>
					<h5 class="text-white">Follow Us</h5>
						<a href="#" class="btn btn-outline-primary btn-sm">
						<i class="fab fa-facebook-f"></i> Facebook
						</a>
						<a href="#" class="btn btn-outline-info btn-sm">
						<i class="fab fa-twitter"></i> Twitter
						</a>
						<a href="#" class="btn btn-outline-danger btn-sm">
						<i class="fab fa-instagram"></i> Instagram</a>
		                <a href="#" class="btn btn-outline-success btn-sm">
						<i class="fab fa-whatsapp"></i> Whatsapp
						</a>				
                        
                </div>
            </div>
        </div>
    </div>
</div></br>
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
						<li><a href="index.php">Home</a></li> 
						<li><a href="about.php">About</a></li>
            <li><a href="categories.php">Shop</a></li> 
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
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
