<?php
include '../db_connect.php';

$order_id = (int)($_GET['id'] ?? 0);

// Order + Customer + Product Details
$order_result = mysqli_query($conn, "
SELECT o.id AS order_id, o.name, o.phone, o.delivery_type, o.order_date, o.address, 
p.name AS product_name, oi.quantity, oi.price
FROM orders o
JOIN order_items oi ON oi.order_id = o.id
JOIN products p ON p.id = oi.product_id
WHERE o.id = $order_id
") or die(mysqli_error($conn));

if(mysqli_num_rows($order_result) == 0){
    echo "<p>Order not found!</p>";
    exit;
}

echo "<p><strong>Customer Name:</strong> {$_GET['name']}</p>";
echo "<p><strong>Phone:</strong> {$_GET['phone']}</p>";

echo "<p><strong>Products Ordered:</strong></p>";
echo "<div class='table-responsive'><table class='table table-bordered'>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price (৳)</th>
                <th>Subtotal (৳)</th>
            </tr>
        </thead>
        <tbody>";

$total_amount = 0;
while($order = mysqli_fetch_assoc($order_result)){
    $subtotal = $order['quantity'] * $order['price'];
    $total_amount += $subtotal;

    echo "<tr>
            <td>{$order['product_name']}</td>
            <td>{$order['quantity']}</td>
            <td>{$order['price']}</td>
            <td>{$subtotal}</td>
          </tr>";
}

echo "</tbody></table></div>";
echo "<p><strong>Total Amount:</strong> ৳ {$total_amount}</p>"
?>
