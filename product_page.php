<?php
// Include the connection file
include 'db_connect.php';

// Query all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Products</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .product-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      transition: 0.3s;
    }
    .product-card:hover {
      transform: scale(1.05);
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }
    .product-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2 class="text-center mb-4">Our Products</h2>
  <div class="row">

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="col-md-4 mb-4">
              <div class="product-card">
                <img src="' . $row['image'] . '" alt="' . $row['name'] . '" class="product-img">
                <h5 class="mt-3">' . $row['name'] . '</h5>
                <p class="text-muted">' . $row['details'] . '</p>
                <p class="text-success font-weight-bold">৳ ' . $row['price'] . '</p>
              </div>
            </div>';
        }
    } else {
        echo "<p class='text-center'>No products found!</p>";
    }

    $conn->close();
    ?>

  </div>
</div>




</body>
</html>
