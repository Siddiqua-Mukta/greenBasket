<?php
include '../db_connect.php';
session_start();
include 'includes/header.php';

// Pagination setup
$limit = 10; // orders per page
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Count total orders
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders");
if(!$total_result){
    die("Query failed: " . mysqli_error($conn));
}
$total_row = mysqli_fetch_assoc($total_result);
$total_orders = $total_row['total'];
$total_pages = ceil($total_orders / $limit);

// Fetch orders for current page
$result = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC LIMIT $offset, $limit");
if(!$result){
    die("Query failed: " . mysqli_error($conn));
}
?>

<div class="container mt-4">
  <h3 class="text-success fw-bold mb-3">Manage Orders</h3>

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-success">
        <tr>
          <th>Order ID</th>
          <th>User Name</th>
          <th>Total (৳)</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
                $status = isset($row['status']) ? $row['status'] : 'Pending';
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td class='text-start ps-3'>{$row['name']}</td>
                        <td>{$row['total']}</td>
                        <td>{$row['order_date']}</td>
                        <td>{$status}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-muted'>No orders found!</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <nav>
    <ul class="pagination">
        <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page-1 ?>">&laquo;</a>
            </li>
        <?php endif; ?>

        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page+1 ?>">&raquo;</a>
            </li>
        <?php endif; ?>
    </ul>
  </nav>
</div>

<?php //include 'includes/footer.php'; ?>

<style>
.table {
  border-collapse: collapse !important;
  width: 100%;
}

.table th,
.table td {
  border: 1px solid #e0e0e0 !important;
  vertical-align: middle;
}

.table thead th {
  background-color: #e8f5e9 !important;
  font-weight: 600;
  text-align: center;
}

.table-hover tbody tr:hover {
  background-color: #f1f8f4 !important;
  transition: 0.3s;
}

.table-responsive {
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  overflow: hidden;
}

.shadow-sm {
  box-shadow: 0 1px 3px rgba(0,0,0,0.08) !important;
}

/* Plain number-only pagination */
.pagination {
  justify-content: center;
  list-style: none;
  padding: 0;
  margin-top: 20px;
}

.pagination .page-item {
  display: inline-block;
  margin: 0 5px;
}

.pagination .page-link {
  color: #000;
  text-decoration: none;
  padding: 0;
  border: none;
  background: none;
  font-weight: 500;
}

.pagination .page-item.active .page-link {
  color: #28a745;
  font-weight: 700;
}

.pagination .page-link:hover {
  color: #28a745;
}
</style>
