<?php include('db_connect.php'); ?>
<?php
//  Session start (অবশ্যই উপরে রাখো)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenBasket</title>
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
	.section-padding { 
		padding: 60px 0; 
	}
	.about-box { 
		border: 2px solid #ddd; 
		padding: 20px; 
		border-radius: 10px; 
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
		background-color: #d4edda;
		margin-top: 20px; 
	}
	.section-padding {
            padding: 60px 0;
        }
        .about-box {
            background-color: #f8f9fa; /* Light background for the about section */
            border-radius: 15px; /* Rounded corners */
            padding: 30px; /* Padding inside the box */
        }
        .about-image {
            border-radius: 15px; /* Rounded corners for the image */
			width:450px;
			height:410px;
        }
	
	/*Team*/

.team{
    width: 100%;
    height: auto; 
    padding-top: 20px; 
    padding-bottom: 50px; 
}

.team h1{
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 55px;
    margin-bottom: 80px;
}

.team h1 span{
    color: #fffff;
    margin-left: 15px;
}

.team h1 span::after{
    content: ;
    width: 100%;
    height: 2px;
    background: #fac031;
    display: block;
    position: relative;
    bottom: 15px;
}

.team .team_box{
    width: 95%;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start; 
    justify-content: center;
    position: relative;
    top: 13%;
    height: auto; 
    min-height: 800px;
    padding-bottom: 50px; 
}

.team .team_box .profile{
    width: 320px;
    height: 320px;
    border-radius: 50%;
    margin: 35px 35px; 
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    box-shadow: 0 0 8px rgba(0,0,0,0.5);
    transition: 0.4s;
}

.team .team_box .profile:hover{
    border-radius: 20px;
    height: 410px;
    transform: scale(1.1); /* হালকা বড় করার জন্য */
    z-index: 10;
}

.team .team_box .profile img{
    width: 250px;
    height: 250px;
    object-fit: cover;
    object-position: center;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 0 8px rgba(0,0,0,0.5);
    z-index: 2;
    transition: 0.4s;
}

.team .team_box .profile:hover img{
    border-radius: 20px;
    margin-top: -230px;
}

.team .team_box .profile .info{
    position: absolute;
    text-align: center;
    top: 25%;
    transition: 0.4s;
}

.team .team_box .profile:hover .info{
    top: 60%;
}

.team .team_box .profile .info .name{
    color: #59d476;
    margin-bottom: 15px;
}

.team .team_box .profile .info .bio{
    width: 70%;
    text-align: center;
    margin: 0 auto 10px auto;
}

.team .team_box .profile .info .team_icon i{
    margin: 10px 5px 5px 0;
    cursor: pointer;
    transition: 0.3s;
}

.team .team_box .profile .info .team_icon i:hover{
    color: #59d476;
}
 .team_icon {
            text-align: center;
            margin-top: 20px;
        }
        .team_icon i {
            font-size: 24px;
            margin: 0 10px;
            color: #333;
            transition: color 0.3s;
        }
        .team_icon i:hover {
            color: #007bff;
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


<?php include('navbar.php'); ?>

<!-- About section -->
<div class="container section-padding">
    <div class="row">
        <div class="col-md-12 about-box">
            <div class="row">
                <div class="col-md-6">
                    <h2><center>About Us</center></h2>
                    <p>At our grocery store, we pride ourselves on providing fresh, high-quality products to our community. Whether you're looking for organic produce, gourmet ingredients, or household essentials, we have it all. Our mission is to make your shopping experience as convenient and enjoyable as possible.</p>
                    <h4>Our Values</h4>
                    <ul>
                        <li>Quality: We source the best products for our customers.</li>
                        <li>Community: We support local farmers and businesses.</li>
                        <li>Sustainability: We are committed to eco-friendly practices.</li>
                    </ul>
                    <h4>Our Services</h4>
                    <p>We offer a variety of services to enhance your shopping experience:</p>
                    <ul>
                        <li>Online Ordering and Delivery</li>
                        <li>In-Store Pickup</li>
                        <li>Loyalty Rewards Program</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="about/about us.png" class="img-fluid about-image" alt="Grocery Store Image">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Community Involvement</h4>
                    <p>We believe in giving back to our community. Our store regularly participates in local events, food drives, and charity initiatives. We are dedicated to making a positive impact in the lives of our customers and neighbors.</p>
                </div>
            </div>
        </div>
    </div>
</div>
  
 <!-- Team Section -->
<div class="team">
		<h1>Our<span>Team</span></h1>
		
		<div class="team_box">
			<div class="profile">
				<img src="about/store manager.webp">
				<div class="info">
					<h2 class="name">Store Manager</h2>
					<p class="bio">Manages store operations and staff.</p>
					
					<div class="container">
						<div class="team_icon">
							<i class="fab fa-facebook-f"></i>
							<i class="fab fa-instagram"></i>
							<i class="fab fa-twitter"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="profile">
				<img src="about/assistant.webp">
				<div class="info">
					<h2 class="name">Assistant Manager</h2>
					<p class="bio">Supports management, and ensures team efficiency.</p>
					
					<div class="container">
						<div class="team_icon">
							<i class="fab fa-facebook-f"></i>
							<i class="fab fa-instagram"></i>
							<i class="fab fa-twitter"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="profile">
				<img src="about/customer.png">
				<div class="info">
					<h2 class="name">Customer Service</h2>
					<p class="bio">Helps customers with queries and issues.</p>
					
					<div class="container">
						<div class="team_icon">
							<i class="fab fa-facebook-f"></i>
							<i class="fab fa-instagram"></i>
							<i class="fab fa-twitter"></i>
						</div>
					</div>	
				</div>
			</div>
			<div class="profile">
				<img src="about/content.png">
				<div class="info">
					<h2 class="name">Content Manager</h2>
					<p class="bio">Manages product details and website content.</p>
					
					<div class="container">
						<div class="team_icon">
							<i class="fab fa-facebook-f"></i>
							<i class="fab fa-instagram"></i>
							<i class="fab fa-twitter"></i>
						</div>
					</div>
				</div>
			</div><div class="profile">
				<img src="about/quality.png">
				<div class="info">
					<h2 class="name">Quality Manager</h2>
					<p class="bio">Checks product quality before customer delivery.</p>
					
					<div class="container">
						<div class="team_icon">
							<i class="fab fa-facebook-f"></i>
							<i class="fab fa-instagram"></i>
							<i class="fab fa-twitter"></i>
						</div>
					</div>
				</div>
			</div>
            <div class="profile">
				<img src="about/catalouge.png">
				<div class="info">
					<h2 class="name">Catalouge Manager</h2>
					<p class="bio">Organizes products for easy customer search.</p>
					
					<div class="container">
						<div class="team_icon">
							<i class="fab fa-facebook-f"></i>
							<i class="fab fa-instagram"></i>
							<i class="fab fa-twitter"></i>
						</div>
					</div>
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
          <p><i class="fas fa-phone me-3"></i> 01980468252 </p>

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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
