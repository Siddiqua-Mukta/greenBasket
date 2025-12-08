<?php
session_start();
include 'db_connect.php'; 

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

// Handle form submission
if(isset($_POST['submit'])){
    $order_id = $_POST['order_id'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $message = $_POST['message'] ?? '';

    if(empty($order_id) || empty($product_id) || empty($reason)){
        $error = "Please select order, product, and reason.";
    } else {
        $stmt = $conn->prepare("INSERT INTO returns (order_id, user_id, product_id, reason, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $order_id, $user_id, $product_id, $reason, $message);
        if($stmt->execute()){
            $success = "Your return request has been submitted successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}

// Fetch eligible orders with products
$orders_query = "
SELECT o.id AS order_id, oi.product_id, p.name AS product_name, o.order_date
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE o.user_id = ? AND o.order_date >= DATE_SUB(NOW(), INTERVAL 14 DAY)
ORDER BY o.order_date DESC
";

$stmt = $conn->prepare($orders_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Request Return</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Request a Return</h3>

    <?php if($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if(count($orders) > 0): ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Select Order & Product</label>
            <select name="order_id" id="order_id" class="form-select" required>
                <option value="">-- Select Order --</option>
                <?php 
                $order_ids = [];
                foreach($orders as $order){
                    if(!in_array($order['order_id'], $order_ids)){
                        echo '<option value="'.$order['order_id'].'">Order #'.$order['order_id'].'</option>';
                        $order_ids[] = $order['order_id'];
                    }
                }
                ?>
            </select>

            <select name="product_id" id="product_id" class="form-select mt-2" required>
                <option value="">-- Select Product --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="reason" class="form-label">Reason for Return</label>
            <select name="reason" id="reason" class="form-select" required>
                <option value="">-- Select Reason --</option>
                <option value="Defective">Defective</option>
                <option value="Wrong Item">Wrong Item</option>
                <option value="Changed Mind">Changed Mind</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Additional Message (Optional)</label>
            <textarea name="message" id="message" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-success">Submit Return Request</button>
    </form>
    <?php else: ?>
        <div class="alert alert-info">No eligible orders available for return.</div>
    <?php endif; ?>
</div>

<script>
// Pass PHP orders array to JS
const orders = <?= json_encode($orders) ?>;

const orderSelect = document.getElementById('order_id');
const productSelect = document.getElementById('product_id');

orderSelect.addEventListener('change', function(){
    const selectedOrder = this.value;

    // Clear previous products
    productSelect.innerHTML = '<option value="">-- Select Product --</option>';

    // Filter products for selected order
    const filteredProducts = orders.filter(o => o.order_id == selectedOrder);

    filteredProducts.forEach(p => {
        const option = document.createElement('option');
        option.value = p.product_id;
        option.textContent = p.product_name;
        productSelect.appendChild(option);
    });
});
</script>

</body>
</html>
