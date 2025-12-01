<?php
include '../db_connect.php';

$order_id = (int)($_GET['id'] ?? 0);

$order_result = mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id");
if(mysqli_num_rows($order_result) == 0){
    echo "<p>Order not found!</p>";
    exit;
}

$order = mysqli_fetch_assoc($order_result);

// Products
$items_query = mysqli_query($conn, "SELECT product_name, quantity, price FROM order_items WHERE order_id = $order_id");

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
while($item = mysqli_fetch_assoc($items_query)){
    $subtotal = $item['quantity'] * $item['price'];
    $total_amount += $subtotal;

    echo "<tr>
            <td>{$item['product_name']}</td>
            <td>{$item['quantity']}</td>
            <td>{$item['price']}</td>
            <td>{$subtotal}</td>
          </tr>";
}

echo "</tbody></table></div>";
echo "<p><strong>Total Amount:</strong> ৳ {$order['total']}</p>";
