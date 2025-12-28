<?php
session_start();
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}

include '../db_connect.php';
include 'sidebar.php';

if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {

    $vendor_id = $_SESSION['vendor_id'];
    $search = $_GET['search'] ?? '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    // ===== MAIN ORDER QUERY (Vendor wise) =====
    $sql = "
        SELECT 
            o.id AS order_id,
            o.name AS customer_name,
            o.phone,
            o.payment,
            o.order_status,
            o.payment_status,
            o.total,
            o.vendor_receive_amount,
            o.order_date
        FROM orders o
        WHERE o.vendor_id = '$vendor_id'
    ";

    if ($search != '') {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (o.name LIKE '%$search%' OR o.id LIKE '%$search%')";
    }

    $sql .= " ORDER BY o.id DESC LIMIT $limit OFFSET $offset";
    $orders = $conn->query($sql);

    // ===== COUNT FOR PAGINATION =====
    $countSql = "SELECT COUNT(*) AS total FROM orders WHERE vendor_id='$vendor_id'";
    $totalRows = $conn->query($countSql)->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $limit);
    ?>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-success">
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Products</th>
                <th>Total (৳)</th>
                <th>Vendor Receive</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>

        <?php if ($orders->num_rows > 0): ?>
            <?php while ($order = $orders->fetch_assoc()): ?>

            <?php
            // ===== FETCH PRODUCTS OF THIS ORDER (ONLY THIS VENDOR) =====
            $itemsSql = "
                SELECT 
                    p.name,
                    oi.quantity,
                    oi.price,
                    oi.total_price_per_item
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = '{$order['order_id']}'
                AND oi.vendor_id = '$vendor_id'
            ";
            $items = $conn->query($itemsSql);
            ?>

            <tr>
                <td>#<?= $order['order_id']; ?></td>
                <td><?= htmlspecialchars($order['customer_name']); ?></td>
                <td><?= htmlspecialchars($order['phone']); ?></td>

                <td>
                    <ul class="mb-0 ps-3">
                        <?php while ($item = $items->fetch_assoc()): ?>
                            <li>
                                <?= htmlspecialchars($item['name']); ?>
                                (<?= $item['quantity']; ?> × <?= $item['price']; ?>)
                                = <strong><?= $item['total_price_per_item']; ?>৳</strong>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </td>

                <td><?= number_format($order['total'], 2); ?></td>
                <td class="text-success fw-bold">
                    <?= number_format($order['vendor_receive_amount'], 2); ?>
                </td>
                <td><?= ucfirst($order['payment']); ?></td>
                <td>
                    <span class="badge bg-info">
                        <?= ucfirst($order['order_status']); ?>
                    </span>
                </td>
                <td><?= date('d M Y', strtotime($order['order_date'])); ?></td>
            </tr>

            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" class="text-center text-muted">No orders found</td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>

    <!-- PAGINATION -->
    <?php if ($totalPages > 1): ?>
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a href="#" class="page-link paginationBtn" data-page="<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>

<?php
exit;
}
?>

<!-- ===== PAGE UI ===== -->
<div class="content-area" style="margin-left:250px; padding:20px;">
    <h3 class="text-success mb-3">My Orders</h3>

    <input type="text" id="searchInput" class="form-control mb-3"
           placeholder="Search by order ID or customer name">

    <div id="ordersTableWrapper"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadOrders(page = 1, search = '') {
    $.get('orders.php', { ajax: 1, page: page, search: search }, function (data) {
        $('#ordersTableWrapper').html(data);
    });
}

loadOrders();

$('#searchInput').keyup(function () {
    loadOrders(1, $(this).val());
});

$(document).on('click', '.paginationBtn', function (e) {
    e.preventDefault();
    loadOrders($(this).data('page'), $('#searchInput').val());
});
</script>
