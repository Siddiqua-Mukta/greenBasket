<?php
include '../db_connect.php';
include 'session.php';
include 'includes/header.php';

// ✅ Session check
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="container mt-5">
  <h2 class="mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?> 👋</h2>
  
  <div class="row g-4">
    <?php
    $tables = [
      ['products', 'Products', 'bi-box-seam', 'manage_products.php', 'bg-gradient-green-1'],
      ['category', 'Categories', 'bi-tags', 'manage_categories.php', 'bg-gradient-green-2'],
      ['users', 'Users', 'bi-people', 'manage_users.php', 'bg-gradient-green-3'],
      ['orders', 'Orders', 'bi-bag-check', 'manage_orders.php', 'bg-gradient-green-4'],
      ['contact_messages', 'Messages', 'bi-chat-left-text', 'manage_messages.php', 'bg-gradient-green-5']
    ];

    foreach ($tables as $t) {
      $query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM {$t[0]}");
      $data = mysqli_fetch_assoc($query);

      echo "
      <div class='col-12 col-sm-6 col-md-4 col-lg-3'>
        <a href='{$t[3]}' class='text-decoration-none'>
          <div class='card shadow h-100 border-0 card-hover {$t[4]}'>
            <div class='card-body d-flex flex-column justify-content-center align-items-center'>
              <div class='icon mb-2'>
                <i class='bi {$t[2]}' style='font-size:2.5rem;'></i>
              </div>
              <h3 class='fw-bold counter' data-target='{$data['total']}'>0</h3>
              <p class='mb-0 text-uppercase fw-semibold'>{$t[1]}</p>
            </div>
          </div>
        </a>
      </div>";
    }
    ?>
  </div>
</div>

<?php //include 'includes/footer.php'; ?>

<style>
.card-hover {
  transition: all 0.3s ease-in-out;
  border-radius: 15px;
}
.card-hover:hover {
  transform: translateY(-8px) scale(1.03);
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.icon {
  color: rgba(255,255,255,0.9);
}

/* Green gradient colors for each card */
.bg-gradient-green-1 { background: linear-gradient(135deg, #00b894, #55efc4); color: #fff; }
.bg-gradient-green-2 { background: linear-gradient(135deg, #00a86b, #43e97b); color: #fff; }
.bg-gradient-green-3 { background: linear-gradient(135deg, #009966, #33cc99); color: #fff; }
.bg-gradient-green-4 { background: linear-gradient(135deg, #00cc66, #66ff99); color: #fff; }
.bg-gradient-green-5 { background: linear-gradient(135deg, #009933, #33cc66); color: #fff; }

.card-hover:hover {
  /* Keep hover color effect if you had */
  /* এখানে আগে যেভাবে hover effect ছিল সেটাই থাকবে */
}

@media (max-width: 576px) {
  .card-hover { text-align: center; }
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
const counters = document.querySelectorAll('.counter');
counters.forEach(counter => {
    const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;
        const speed = 50;
        const increment = Math.ceil(target / speed);
        if(count < target){
            counter.innerText = count + increment;
            setTimeout(updateCount, 20);
        } else {
            counter.innerText = target;
        }
    };
    updateCount();
});
</script>
