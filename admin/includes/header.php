<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body { min-height: 100vh; display: flex; flex-direction: column; }
    .sidebar {
        min-width: 200px;
        max-width: 200px;
        background-color: #198754;
        min-height: 100vh;
        color: white;
    }
    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 12px;
    }
    .sidebar a:hover {
        background-color: #145c36;
        text-decoration: none;
    }
    .content {
        flex: 1;
        padding: 20px;
    }
  </style>
</head>
<body>
<div class="d-flex">
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center py-3">Admin Panel</h4>
    <a href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="manage_products.php"><i class="bi bi-box"></i> Products</a>
    <a href="manage_categories.php"><i class="bi bi-tags"></i> Categories</a>
    <a href="manage_orders.php"><i class="bi bi-bag"></i> Orders</a>
    <a href="manage_users.php"><i class="bi bi-people"></i> Users</a>
    <a href="manage_messages.php"><i class="bi bi-envelope"></i> Messages</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="content flex-grow-1">
