<?php
include '../db_connect.php';
include 'session.php';
include 'includes/header.php';
?>

<div class="container mt-4">
    <h3 class="text-success fw-bold mb-3">Manage Orders</h3>

    <!-- Search Bar -->
    <div class="input-group mb-3 w-100">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by order ID, name, phone, address, or date...">
    </div>

    <!-- Orders Table -->
    <div class="table-responsive shadow-sm rounded" id="ordersTableWrapper">
        <!-- Table content loaded via AJAX -->
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="orderDetailsContent"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function loadOrders(page = 1, search = '') {
    $.ajax({
        url: 'fetch_orders.php',
        method: 'GET',
        data: { page: page, search: search },
        success: function(data){
            $('#ordersTableWrapper').html(data);
        }
    });
}

// Initial load
loadOrders();

// Live search
$('#searchInput').on('keyup', function(){
    var search = $(this).val();
    loadOrders(1, search);
});

// Pagination click
$(document).on('click', '.paginationBtn', function(e){
    e.preventDefault();
    var page = $(this).data('page');
    var search = $('#searchInput').val();
    loadOrders(page, search);
});

// Details button click
$(document).on('click', '.detailsBtn', function(){
    var orderId = $(this).data('id');
    $.ajax({
        url: 'order_details.php',
        method: 'GET',
        data: { id: orderId },
        success: function(data){
            $('#orderDetailsContent').html(data);
            new bootstrap.Modal(document.getElementById('orderDetailsModal')).show();
        }
    });
});
</script>

<style>
.table-hover tbody tr:hover { background-color: #d4edda; transition: 0.3s; }
.table-responsive { border-radius: 12px; overflow: hidden; }
nav a { text-decoration:none; font-weight:bold; font-size:16px; }
nav a:hover { color:#28a745; }
@media(max-width:768px){
    h3 { font-size: 18px; }
    .table th, .table td { font-size: 14px; padding: 8px; }
    .btn { font-size: 13px; padding: 5px 10px; }
}
</style>
