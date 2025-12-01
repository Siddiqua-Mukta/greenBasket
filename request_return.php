<?php
session_start();
include 'db_connect.php'; // Your database connection

// ✅ Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if(isset($_POST['submit'])){
    $order_id = $_POST['order_id'];
    $product_id = $_POST['product_id'];
    $reason = $_POST['reason'];
    $message = $_POST['message'];

    // Simple validation
    if(empty($order_id) || empty($product_id) || empty($reason)){
        $error = "Please select order, product, and reason.";
    } else {
        // Insert return request into database
        $stmt = $conn->prepare("INSERT INTO returns (order_id, user_id, product_id, reason, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $order_id, $user_id, $product_id, $reason, $message);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $success = "Your return request has been submitted successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}

// Fetch user's orders and products eligible for return
// Example: Only orders within 14 days are returnable
$orders_query = "
SELECT o.id AS order_id, oi.product_id, p.name AS product_name, o.created_at
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE o.user_id = ? AND o.created_at >= DATE_SUB(NOW(), INTERVAL 14 DAY)
ORDER BY o.created_at DESC
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

    <!-- Success / Error Messages -->
    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if(count($orders) > 0): ?>
        <form method="POST">
            <div class="mb-3">
                <label for="order_id" class="form-label">Select Order & Product</label>
                <select name="order_id" id="order_id" class="form-select" required>
                    <?php foreach($orders as $order): ?>
                        <option value="<?= $order['order_id'] ?>_<?= $order['product_id'] ?>">
                            <?= $order['product_name'] ?> (Order #<?= $order['order_id'] ?>)
                        </option>
                    <?php endforeach; ?>
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
    // Auto-split order_id and product_id when selecting
    const orderSelect = document.getElementById('order_id');
    const form = document.querySelector('form');

    form.addEventListener('submit', function(e){
        const selected = orderSelect.value.split('_');
        orderSelect.value = selected[0]; // order_id
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'product_id';
        input.value = selected[1];
        form.appendChild(input);
    });
</script>

</body>
</html>
