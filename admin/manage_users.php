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
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM users");
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td class='text-start ps-3'>{$row['name']}</td>
                        <td class='text-start ps-3'>{$row['email']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3' class='text-muted'>No users found!</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
.table-hover tbody tr:hover { background-color: #d4edda; transition: 0.3s; }
.table-responsive { border-radius: 12px; overflow: hidden; }
</style>
