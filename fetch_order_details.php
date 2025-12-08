<?php
include "db_connect.php";

$order_id = intval($_GET['id']);

// Fetch order details
$query = mysqli_query($conn, "
SELECT o.id, o.name, o.phone, o.address, o.delivery_type, o.order_date,
       p.name AS product_name, oi.quantity, oi.price
FROM orders o
JOIN order_items oi ON oi.order_id = o.id
JOIN products p ON p.id = oi.product_id
WHERE o.id = $order_id
");

if(mysqli_num_rows($query) == 0){
    echo "<p class='text-danger'>Order not found.</p>";
    exit;
}

// Customer info
$orderInfo = mysqli_fetch_assoc($query);
mysqli_data_seek($query, 0);

echo "<h5>Customer Information</h5>";
echo "<p><strong>Name:</strong> {$orderInfo['name']}</p>";
echo "<p><strong>Phone:</strong> {$orderInfo['phone']}</p>";
echo "<p><strong>Delivery Type:</strong> {$orderInfo['delivery_type']}</p>";
echo "<p><strong>Address:</strong> {$orderInfo['address']}</p>";
echo "<p><strong>Order Date:</strong> {$orderInfo['order_date']}</p>";

echo "<hr>";
echo "<h6>Products Ordered</h6>";
echo "<table class='table table-bordered table-sm'>
<tr>
<th>Product</th>
<th>Quantity</th>
<th>Price (৳)</th>
<th>Subtotal (৳)</th>
</tr>";

$total = 0;
while($row = mysqli_fetch_assoc($query)){
    $subtotal = $row['quantity'] * $row['price'];
    $total += $subtotal;
    echo "<tr>
            <td>{$row['product_name']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['price']}</td>
            <td>{$subtotal}</td>
          </tr>";
}

echo "</table>";
echo "<h5 class='text-end'>Total Amount: ৳ ".number_format($total,2)."</h5>";
?>
