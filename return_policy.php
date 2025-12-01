<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Policy - GreenBasket</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f0f4f7;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar-nav .nav-item {
        margin-left: 20px;
    }
    .navbar-nav .nav-item .nav-link, .navbar-brand {
        color: white;
    }
    .search-bar input[type="text"] {
        width: 300px;
        border-radius: 0;
    }
    .search-bar button {
        border-radius: 0;
    }
        .policy-container {
            background: #fff;
            padding: 50px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .policy-container h2 {
            color: #28a745;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }
        .policy-container p, .policy-container li {
            font-size: 16px;
            line-height: 1.7;
        }
        .policy-container a {
            color: #28a745;
            text-decoration: none;
        }
        .policy-container a:hover {
            text-decoration: underline;
        }
        .highlight {
            background-color: #eaf9ea;
            border-left: 5px solid #28a745;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .accordion-button:focus {
            box-shadow: none;
        }
        .step-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 5px solid #28a745;
        }
        .step-box i {
            color: #28a745;
            margin-right: 10px;
        }

        .footer { background-color: #116b2e; color: white; padding: 20px 0; text-align: center; }
        .footer a { color: white; text-decoration: none; }
        .footer .social-icons a { margin: 0 10px; font-size: 24px; }
    </style>
</head>
<body>

<?php //include('navbar.php'); ?>


<div class="container policy-container">

    <h2><i class="fas fa-undo-alt"></i> Return Policy</h2>

    <div class="highlight">
        <p><strong>We want you to be 100% satisfied!</strong> If your purchase is not what you expected, you can request a return under the following conditions.</p>
    </div>

    <!-- Accordion for FAQs / Policy Points -->
    <div class="accordion" id="returnPolicyAccordion">

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                    Return Window
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#returnPolicyAccordion">
                <div class="accordion-body">
                    Return requests must be made within <strong>5 days</strong> of receiving the product.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                    Product Condition
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#returnPolicyAccordion">
                <div class="accordion-body">
                    The product must be unused, in its original packaging, and in the same condition as delivered. Some items like perishable goods, personalized products, or hygiene-sensitive items cannot be returned.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                    How to Submit a Return Request
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#returnPolicyAccordion">
                <div class="accordion-body">
                    <div class="step-box"><i class="fas fa-sign-in-alt"></i> Log in to your account.</div>
                    <div class="step-box"><i class="fas fa-box"></i> Go to the <a href="request_return.php">Return Request</a> page.</div>
                    <div class="step-box"><i class="fas fa-list"></i> Select the order and product you want to return.</div>
                    <div class="step-box"><i class="fas fa-pen"></i> Choose the reason and add any additional details.</div>
                    <div class="step-box"><i class="fas fa-paper-plane"></i> Submit your request. You will receive a confirmation email.</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                    Refund Process
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#returnPolicyAccordion">
                <div class="accordion-body">
                    Refunds will be issued to your original payment method within 5–7 business days after receiving the returned item.
                </div>
            </div>
        </div>

    </div>

    <p class="mt-4">If you have any questions about our return policy, please <a href="contact.php">contact us</a>.</p>
</div><br>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        
        // AJAX Add to Cart button handler (Featured Products Section)
        $('.add-to-cart-ajax').on('click', function(e) {
            e.preventDefault(); 
            
            var productId = $(this).data('productId');
            var button = $(this); 
            // নির্দিষ্ট প্রোডাক্টের মেসেজ এরিয়া টার্গেট করা
            var messageArea = $('#ajax-msg-' + productId); 

            // বাটন ডিজেবল ও লোডিং স্টেট
            button.prop('disabled', true).html('Adding...');
            messageArea.html('');

            $.ajax({
                url: 'cart.php', // cart.php তে রিকোয়েস্ট পাঠানো হলো
                method: 'POST',
                data: {
                    action: 'add_product_ajax', // এই অ্যাকশনটি cart.php হ্যান্ডেল করবে
                    product_id: productId,
                    quantity: 1 // এই পেজ থেকে সবসময় ১টি করে প্রোডাক্ট যোগ করা হবে
                },
                dataType: 'json',
                success: function(response) {
                    // Navbar Cart Count আপডেট করা হলো (যদি আপনার navbar.php-তে .cart-count-badge ক্লাস থাকে)
                    if (response.cart_count !== undefined) {
                        $('.cart-count-badge').text(response.cart_count); 
                    }
                    
                    if (response.success) {
                        // সফল মেসেজ দেখানো
                        messageArea.html('<div class="text-success small font-weight-bold">Added Successfully!</div>');
                        button.html('<i class="fas fa-check"></i> Added!').removeClass('btn-success').addClass('btn-secondary');
                    } else {
                        // ব্যর্থতা বার্তা দেখানো
                        var msg = response.message || "Failed to add product.";
                        messageArea.html('<div class="text-danger small font-weight-bold">Failed!</div>');
                        button.html('<i class="fas fa-times"></i> Failed').removeClass('btn-success').addClass('btn-danger');
                    }
                    
                    // ৩ সেকেন্ড পর বাটন এবং মেসেজ রিসেট করা
                    setTimeout(function() {
                        button.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart').removeClass('btn-secondary btn-danger').addClass('btn-success');
                        messageArea.html(''); 
                    }, 3000);
                },
                error: function() {
                    // সার্ভার এরর
                    messageArea.html('<div class="text-danger small font-weight-bold">Error!</div>');
                    button.prop('disabled', false).html('<i class="fas fa-cart-plus"></i> Add to Cart');
                    setTimeout(function() {
                        messageArea.html('');
                    }, 3000);
                }
            });
        });
    });
    </script>

</body>
</html>
