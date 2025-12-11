<?php
session_start();
if(!isset($_SESSION['vendor_id'])){
    header("Location: login.php");
    exit();
}
include '../db_connect.php';
include 'sidebar.php';
$vendor_id = $_SESSION['vendor_id'];

// Handle form submission
$success_msg = '';
$error_msg = '';
if(isset($_POST['amount'])){
    $amount = $_POST['amount'];
    if($amount <= 0){
        $error_msg = "Amount must be greater than zero!";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO vendor_withdraws (vendor_id, amount) VALUES ('$vendor_id','$amount')");
        if($insert){
            $success_msg = "Withdraw request submitted successfully!";
        } else {
            $error_msg = "Failed to submit request. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Withdraw Request</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
body {
    display: flex;
    min-height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
}

/* Sidebar width */
.sidebar {
    width: 250px;
    min-height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: #343a40;
    color: #fff;
}

/* Content area next to sidebar */
.content-area {
    margin-left: 250px;
    width: calc(100% - 250px);
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

/* Card style */
.withdraw-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 2rem;
    max-width: 500px;
    margin: auto;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        position: relative;
        width: 100%;
        min-height: auto;
    }
    .content-area {
        margin-left: 0;
        width: 100%;
        padding: 1rem;
    }
}
</style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<div class="content-area">
    <h2 class="text-success text-center fw-bold mb-4">Withdraw Request</h2>

    <div class="withdraw-card">
        <?php if($success_msg): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif($error_msg): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" id="withdrawForm">
            <div class="mb-3">
                <label class="form-label">Amount (৳)</label>
                <input type="number" name="amount" class="form-control" placeholder="Enter amount to withdraw" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Request Withdraw</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Optional: Prevent submitting zero or negative amount
document.getElementById('withdrawForm').addEventListener('submit', function(e){
    let amt = parseFloat(this.amount.value);
    if(amt <= 0){
        e.preventDefault();
        alert('Amount must be greater than zero!');
    }
});
</script>
</body>
</html>
