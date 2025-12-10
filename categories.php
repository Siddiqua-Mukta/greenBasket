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
    margin-bottom:1rem;
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

.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
  transform: scale(1.05);
  box-shadow: 0px 6px 20px rgba(0,0,0,0.2);
}
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

	
<!--Category section-->
<div class="container mt-5">
    <h2 class="text-center">Shop by Category</h2>
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <img src="fruits/fruits.png" class="card-img-top" alt="Fruits">
                <br><br>
                <div class="card-body">
                    <h3 class="card-title">Fruits</h3>
                    <p class="card-text">Fresh and organic fruits sourced from local farms.</p>
                    <a href="Fruits.html" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <img src="vegatables/veg.png" class="card-img-top" alt="Vegetables">
                <div class="card-body">
                    <h3 class="card-title">Vegetables</h3>
                    <p class="card-text">A variety of fresh vegetables for your daily needs.</p>
                    <a href="Vegetables.html" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <img src="Dairy product/dairy.png" class="card-img-top" alt="Dairy Products">
                <div class="card-body">
                    <h3 class="card-title">Dairy Products</h3>
                    <p class="card-text">High-quality dairy products including milk, cheese, and yogurt.</p>
                    <a href="Dairy Products.html" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <img src="snacks/snacks.png" class="card-img-top" alt="Snacks">
                <br><br><br>
                <div class="card-body">
                    <h3 class="card-title">Snacks</h3>
                    <p class="card-text">Delicious snacks for every occasion.</p>
                    <a href="Snacks.html" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <img src="pantry/pantry.png" class="card-img-top" alt="Pantry">
                <div class="card-body">
                    <h3 class="card-title">Pantry</h3>
                    <p class="card-text">Refreshing drinks to quench your thirst.</p>
                    <a href="Pantry.html" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>


	
	
    <!-- Footer Section --> 
<?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
