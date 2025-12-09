<?php
include '../db_connect.php';
include 'session.php';
include 'includes/header.php';

// Session check
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Search functionality
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Count total rows
$count_sql = "SELECT COUNT(*) AS total FROM returns
              WHERE order_id LIKE '%$search%'
              OR user_id LIKE '%$search%'
              OR product_id LIKE '%$search%'
              OR reason LIKE '%$search%'
              OR status LIKE '%$search%'
              OR message LIKE '%$search%'";
$count_result = mysqli_query($conn, $count_sql);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);

// Fetch rows
$sql = "SELECT * FROM returns
        WHERE order_id LIKE '%$search%'
        OR user_id LIKE '%$search%'
        OR product_id LIKE '%$search%'
        OR reason LIKE '%$search%'
        OR status LIKE '%$search%'
        OR message LIKE '%$search%'
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2 class="text-left text-success fw-bold mb-4">Return Product Requests</h2>

    <!-- Search Form -->
    <div class="mb-3">
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-success">Search</button>
        </form>
    </div>

    <div class="table-responsive shadow p-3 bg-white rounded">
        <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Product ID</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['product_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['reason']); ?></td>
                            <td>
                                <?php
                                $status = strtolower($row['status']);
                                $badgeClass = 'bg-secondary';
                                if ($status === 'pending') $badgeClass = 'bg-warning text-dark';
                                elseif ($status === 'approved') $badgeClass = 'bg-success';
                                elseif ($status === 'rejected') $badgeClass = 'bg-danger';
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>">
                                    <?php echo ucfirst($status); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['updated_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center text-danger fw-bold">No Return Requests Found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center mt-3">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<style>
.table th, .table td { vertical-align: middle; }
</style>

<?php //include 'includes/footer.php'; ?>
