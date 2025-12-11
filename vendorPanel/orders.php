<?php
session_start();
if(!isset($_SESSION['vendor_id'])){
    header("Location: login.php");
    exit();
}

include '../db_connect.php';
include 'sidebar.php'; // Sidebar already prepared

// --- AJAX handler ---
if(isset($_GET['ajax']) && $_GET['ajax']==1){
    $vendor_id = $_SESSION['vendor_id'];
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Corrected query with proper column names and aliases
    $sql = "SELECT id, name AS customer_name, phone AS customer_phone, total AS total_amount, payment AS payment_method, order_status, order_date AS created_at
            FROM orders
            WHERE vendor_id='$vendor_id'";

    if($search != ''){
        $search = $conn->real_escape_string($search);
        $sql .= " AND (name LIKE '%$search%' OR id LIKE '%$search%' OR order_status LIKE '%$search%')";
    }

    $sql .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    // Count total rows for pagination
    $countSql = "SELECT COUNT(*) AS total FROM orders WHERE vendor_id='$vendor_id'";
    if($search != ''){
        $countSql .= " AND (name LIKE '%$search%' OR id LIKE '%$search%' OR order_status LIKE '%$search%')";
    }
    $totalRows = $conn->query($countSql)->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $limit);
    ?>

    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Total Amount (Tk)</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['customer_phone']); ?></td>
                        <td><?php echo number_format($row['total_amount'],2); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($row['order_status'])); ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="view_order.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">No orders found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if($totalPages > 1): ?>
    <nav>
        <ul class="pagination">
            <?php for($i=1; $i<=$totalPages; $i++): ?>
                <li class="page-item <?php echo ($i==$page)?'active':''; ?>">
                    <a href="#" class="page-link paginationBtn" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>

    <?php
    exit; // End AJAX response
}
?>

<!-- Normal Page Load -->
<div class="content-area" style="margin-left:250px; padding:20px;">
    <h2 class="text-success mb-4">Manage Orders</h2>

    <!-- Search -->
    <div class="input-group mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by customer, order ID, or status...">
    </div>

    <!-- Orders Table -->
    <div class="table-responsive shadow-sm rounded" id="ordersTableWrapper">
        <!-- AJAX will load table here -->
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function loadOrders(page = 1, search = '') {
    $.ajax({
        url: 'orders.php',
        method: 'GET',
        data: { ajax:1, page: page, search: search },
        success: function(data){
            $('#ordersTableWrapper').html(data);
        }
    });
}

// Initial load
loadOrders();

// Search
$('#searchInput').on('keyup', function(){
    loadOrders(1, $(this).val());
});

// Pagination
$(document).on('click', '.paginationBtn', function(e){
    e.preventDefault();
    loadOrders($(this).data('page'), $('#searchInput').val());
});
</script>

<style>
.table-hover tbody tr:hover { background-color: #d4edda; transition:0.3s; }
.table-responsive { border-radius:12px; overflow-x:auto; padding:0.5rem; background:#fff; }

@media(max-width:992px){ .content-area{margin-left:0;} h2{font-size:22px;} .table th,.table td{font-size:14px;padding:8px;} }
@media(max-width:768px){ h2{font-size:20px;} .table th,.table td{font-size:13px;padding:6px;} }
@media(max-width:576px){ h2{font-size:18px;} .table th,.table td{font-size:12px;padding:5px;} }
</style>
