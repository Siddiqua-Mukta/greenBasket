<?php
include '../db_connect.php';
session_start();
include 'includes/header.php';
?>
<div class="container mt-4">
  <h3 class="text-success fw-bold mb-3">Manage Orders</h3>

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-success">
        <tr>
          <th>Order ID</th>
          <th>User ID</th>
          <th>Total (৳)</th>
          <th>Date</th>
          <th>Delivery Type</th>
          <th>Address</th>
          <th>Contact</th>

        </tr>
      </thead>
      <tbody>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['total']}</td>
                        <td>{$row['order_date']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-muted'>No orders found!</td></tr>";
            echo "<tr><td colspan='9' class='text-muted'>No orders found!</td></tr>";

        }
        ?>

        <!-- GRAND TOTAL Positioned under Total Amount Column -->
        <tr class="fw-bold bg-light">
            <td></td>
            <td></td>
            <td></td>
            
            <!-- Grand Total under Total Amount column -->
            <td class="text-success">=  <?= number_format($grand_total) ?>৳</td>

           <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            
        </tr>

      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
.table-hover tbody tr:hover { background-color: #d4edda; transition: 0.3s; }
.table-responsive { border-radius: 12px; overflow: hidden; }
</style>
