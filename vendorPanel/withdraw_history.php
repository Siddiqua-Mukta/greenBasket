<?php
session_start();
if(!isset($_SESSION['vendor_id'])){
    header("Location: login.php");
    exit();
}
include '../db_connect.php';
include 'sidebar.php';
$vendor_id = $_SESSION['vendor_id'];

$withdraw_q = mysqli_query($conn, "SELECT * FROM vendor_withdraws WHERE vendor_id='$vendor_id' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Withdraw History</title>
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

/* Content area */
.content-area {
    margin-left: 250px;
    width: calc(100% - 250px);
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

/* Card-style table container */
.table-card {
    background: #fff;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Table hover */
.table-hover tbody tr:hover {
    background-color: #d4edda;
    transition: 0.3s;
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
    <h2 class="text-success fw-bold mb-4">Withdraw History</h2>

    <div class="table-card table-responsive shadow-sm rounded">
        <table class="table table-hover">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if(mysqli_num_rows($withdraw_q) > 0){
                    while($row = mysqli_fetch_assoc($withdraw_q)){
                        echo "<tr>
                            <td>{$i}</td>
                            <td>৳".number_format($row['amount'],2)."</td>
                            <td>{$row['status']}</td>
                            <td>".date("Y-m-d H:i", strtotime($row['created_at']))."</td>
                        </tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No withdraw requests yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
