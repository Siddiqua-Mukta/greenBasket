<?php
include '../db_connect.php';
include 'session.php';
include 'includes/header.php';
?>

<div class="container mt-4">
  <h3 class="text-success fw-bold mb-3">Manage Users</h3>

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-success">
        <tr>
          <th>User ID</th>
          <th>User Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Address</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Pagination setup
        $limit = 10; // Users per page
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        // Get total number of users
        $total_users_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
        $total_users = mysqli_fetch_assoc($total_users_result)['total'];
        $total_pages = ceil($total_users / $limit);

        // Fetch users for current page
        $result = mysqli_query($conn, "SELECT * FROM users LIMIT $limit OFFSET $offset");

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td class='text-start ps-3'>{$row['name']}</td>
                        <td class='text-start ps-3'>{$row['email']}</td>
                        <td class='text-start ps-3'>{$row['phone']}</td>
                        <td class='text-start ps-3'>{$row['address']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-muted'>No users found!</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination links -->
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        <?php
        $adjacents = 2; // Pages around current page

        // Previous link
        if($page > 1){
            echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'">&laquo;</a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
        }

        // Page numbers with ellipsis
        $start = max(1, $page - $adjacents);
        $end = min($total_pages, $page + $adjacents);

        if($start > 1){
            echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
            if($start > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        for($i = $start; $i <= $end; $i++){
            if($i == $page){
                echo '<li class="page-item active"><span class="page-link">'.$i.'</span></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
            }
        }

        if($end < $total_pages){
            if($end < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            echo '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'">'.$total_pages.'</a></li>';
        }

        // Next link
        if($page < $total_pages){
            echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'">&raquo;</a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
        }
        ?>
    </ul>
  </nav>
</div>

<?php //include 'includes/footer.php'; ?>

<style>
.table-hover tbody tr:hover { background-color: #d4edda; transition: 0.3s; }
.table-responsive { border-radius: 12px; overflow: hidden; }
.page-link { font-weight: bold; }
.page-item.active .page-link { background-color: #28a745; border-color: #28a745; }
.page-item.disabled .page-link { color: #6c757d; }
</style>
