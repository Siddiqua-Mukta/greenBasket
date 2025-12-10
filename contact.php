<?php
include('db_connect.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $message = mysqli_real_escape_string($conn, $_POST['message'] ?? '');

    if ($name && $email && $message) {
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $sql)) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - GreenBasket</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
body { font-family: Arial, sans-serif; }
        .navbar-nav .nav-item { margin-left: 20px; }
        .navbar-nav .nav-item .nav-link, .navbar-brand { color: white; }
        .search-bar input[type="text"] { width: 300px; border-radius: 0; }
        .search-bar button { border-radius: 0; }
.card { margin-top: 20px; }
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

<!-- Contact Section -->
<div class="container mt-5">
    <h2 class="text-center">Contact Us</h2>

    <?php if (!empty($success)) { ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Get in Touch</h4>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" class="form-control" id="message" rows="4" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Send Message</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Contact Information</h4>
                    <p><strong>Address:</strong> Uttor Halishahar, Boropool, Notunpara, 26 no ward, Chattogram</p>
                    <p><strong>Phone:</strong> 01980468252</p>
                    <p><strong>Email:</strong> info@GreenBasket.com</p>
                    <h5 class="card-title text-center">Follow Us</h5>
                    <a href="#" class="btn btn-outline-primary btn-sm"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="#" class="btn btn-outline-info btn-sm"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="#" class="btn btn-outline-success btn-sm"><i class="fab fa-whatsapp"></i> Whatsapp</a>
                    <div class="mt-5">
                        <h4>Our Location on Map</h4>
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14762.105815533447!2d91.7831068!3d22.3337422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30acd9379c683353%3A0xfafeee50eb582cf9!2s26%20No.%20North%20Halishahar%20Ward%2C%20Chattogram!5e0!3m2!1sen!2sbd!4v1763626935517!5m2!1sen!2sbd" 
                            width="100%" 
                            height="250" 
                            style="border:0; border-radius: 5px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-5">
    <div class="container">
        <div class="row">

            <div class="col-md-4 text-left">
                <h3>GreenBasket</h3>
                <p>Fresh & eco-friendly vibe...!</p>
                <p><i class="fas fa-home"></i> Uttor Halishahar, Chattogram</p>
                <p><i class="fas fa-envelope"></i> info@GreenBasket.com</p>
                <p><i class="fas fa-phone"></i> 01980468252</p>
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
        <hr class="bg-light">
        <div class="text-center">
            <p>&copy; 2025 GreenBasket. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
