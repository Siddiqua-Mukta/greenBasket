<?php 
include('../db_connect.php'); 
// 🟢 সেশন শুরু
if (session_status() === PHP_SESSION_NONE) session_start();
?>


    <style>
        body { font-family: Arial, sans-serif; }
                .fade-in { opacity: 0; transform: translateY(20px); animation: fadeInUp 1.5s forwards; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    footer.footer {
        flex-shrink: 0;
        background-color: #116b2e;
        color: white;
        padding: 20px 0;
    }
    footer.footer a {
        color: white;
        text-decoration: none;
    }
    footer .social-icons a {
        margin: 0 10px;
    }
    footer .social-icons i {
        font-size: 24px;
    }
    </style>
</head>

<body>
<footer class="footer"> 
        <div class="container"> 
            <div class="row"> 
                <div class="col-md-4 text-left"> 
                <h3 class="d-inline-block align-middle">
                    <img src="../image/logo.png" alt="GreenBasket Logo" style="height: 35px; margin-right: 0px;" class="img-fluid"> 
                    GreenBasket
                </h3>
                    <p>Fresh & eco-friendly vibe...!</p> 
                    <p><i class="fas fa-home me-3"></i> Uttor Halishahar, Chattogram</p>
                    <p><i class="fas fa-envelope me-3"></i> info@GreenBasket.com</p>
                    <p><i class="fas fa-phone me-3"></i> 01980-468252</p>
                </div> 
                <div class="col-md-4 text-center"> 
                    <h3>Quick Links</h3> 
                    <ul class="list-unstyled"> 
                        <li><a href="../index.php">Home</a></li> 
                        <li><a href="../about.php">About</a></li>
                        <li><a href="../product_page.php">Shop</a></li> 
                        <li><a href="../contact.php">Contact</a></li>
                        <li><a href="../return_policy.php" target="_blank">Returned Policy</a></li> 
                    </ul> 
                </div> 
                <div class="col-md-4 text-center"> 
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
</body>

<script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </script>

