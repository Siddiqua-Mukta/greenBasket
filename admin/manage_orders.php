<?php
include '../db_connect.php';
include 'session.php';
include 'includes/header.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Count total orders
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders");
$total_orders = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_orders / $limit);

// Fetch orders with correct offset
$query = "SELECT * FROM orders ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

// Get grand total
$total_amount_result = mysqli_query($conn, "SELECT SUM(total) AS grand_total FROM orders");
$grand_total = mysqli_fetch_assoc($total_amount_result)['grand_total'] ?? 0;
?>

<div class="container mt-4">
  <h3 class="text-success fw-bold mb-3">Manage Orders</h3>

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-success">
        <tr>
          <th>Order ID</th>
          <th>User Name</th>
          <th>Products Ordered</th>
          <th>Total Qty</th>
          <th>Total Amount(৳)</th>
          <th>Order Date</th>
          <th>Status</th>
          <th>Delivery Type</th>
          <th>Address</th>
          <th>Contact</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {

                $status = $row['status'] ?? 'Pending';
                $qty = $row['total_quantity'] ?? 0;
                $delivery = $row['delivery_type'] ?? 'N/A';
                $address = $row['address'] ?? 'N/A';
                $contact = $row['phone'] ?? 'N/A';

                $order_id = $row['id'];

                // Correct fetch for order_items
                $items_query = mysqli_query($conn, "SELECT product_name, quantity FROM order_items WHERE order_id = $order_id");
                $products_list = [];
                $total_qty_check = 0;
                while($item = mysqli_fetch_assoc($items_query)){
                    $products_list[] = $item['product_name'] . " (" . $item['quantity'] . ")";
                    $total_qty_check += (int)$item['quantity'];
                }
                $products_text = implode(", ", $products_list);

                // Update total qty from sum of order_items to avoid mismatch
                $qty = $total_qty_check;

                echo "<tr>
                        <td>{$row['id']}</td>
                        <td class='text-start ps-3'>{$row['name']}</td>
                        <td class='text-start ps-3'>{$products_text}</td>
                        <td>{$qty}</td>
                        <td>{$row['total']}</td>
                        <td>{$row['order_date']}</td>
                        <td>{$status}</td>
                        <td>{$delivery}</td>
                        <td class='text-start'>{$address}</td>
                        <td>{$contact}</td>
                      </tr>";
            }

            echo "<tr style='background:#e8f5e9; font-weight:bold;'>
                    <td colspan='4' class='text-end'>Grand Total:</td>
                    <td colspan='6' class='text-start ps-3'>৳ ".number_format($grand_total,2)."</td>
                  </tr>";

        } else {
            echo "<tr><td colspan='10' class='text-muted'>No orders found!</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <nav>
    <ul class="pagination">
      <?php if($page > 1): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page-1 ?>">&laquo;</a></li>
      <?php endif; ?>
      <?php for($i=1; $i<=$total_pages; $i++): ?>
        <li class="page-item <?= ($i==$page)?'active':'' ?>">
          <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <?php if($page < $total_pages): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page+1 ?>">&raquo;</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</div>

<style>
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