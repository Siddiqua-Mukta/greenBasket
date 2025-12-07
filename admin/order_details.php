<?php
include '../db_connect.php';

$order_id = (int)($_GET['id'] ?? 0);

$order_result = mysqli_query($conn, "
$sql = "
SELECT 
    o.id AS order_id,
    o.customer_name,
    o.customer_phone,
    o.customer_address,
    o.total_amount,
    o.order_date,

    oi.product_id,
    oi.quantity,
    oi.price,

    p.name AS product_name,
    p.image AS product_image
FROM orders o
JOIN order_items oi ON oi.order_id = o.id
JOIN products p ON p.id = oi.product_id
WHERE o.id = '$order_id'
";


$order = mysqli_fetch_assoc($order_result);

// Products
$items_query = mysqli_query($conn, "SELECT product_id, quantity, price FROM order_items WHERE order_id = $order_id");

echo "<p><strong>Customer Name:</strong> {$order['name']}</p>";
echo "<p><strong>Phone:</strong> {$order['phone']}</p>";
echo "<p><strong>Delivery Type:</strong> {$order['delivery_type']}</p>";
echo "<p><strong>Order Date & Time:</strong> ".date('d/m/Y H:i', strtotime($order['order_date']))."</p>";
echo "<p><strong>Address:</strong><br>{$order['address']}</p>";

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
while($item = mysqli_fetch_assoc($order)){
    $subtotal = $item['quantity'] * $item['price'];
    $total_amount += $subtotal;

    echo "<tr>
            <td>{$order['product_name']}</td>
            <td>{$item['quantity']}</td>
            <td>{$item['price']}</td>
            <td>{$subtotal}</td>
          </tr>";
}

echo "</tbody></table></div>";
echo "<p><strong>Total Amount:</strong> ৳ {$order['total']}</p>";
