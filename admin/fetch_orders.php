<?php
include '../db_connect.php';
include 'session.php';

$limit = 10;
$page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = $_GET['search'] ?? '';

// Serial Number start
$serial = $offset + 1;

$where = '';
if(!empty($search)){
    $search_safe = mysqli_real_escape_string($conn, $search);

    // Check if search is dd/mm/yyyy
    $date_obj = DateTime::createFromFormat('d/m/Y', $search_safe);
    $date_mysql = $date_obj ? $date_obj->format('Y-m-d') : null;

    $where = "WHERE 
        id LIKE '%$search_safe%' OR
        name LIKE '%$search_safe%' OR
        phone LIKE '%$search_safe%' OR
        address LIKE '%$search_safe%'";

    if($date_mysql){
        $where .= " OR DATE(order_date) = '$date_mysql'";
    }
}

// Count total orders
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders $where");
$total_orders = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_orders / $limit);

// Fetch orders
$query = "SELECT * FROM orders $where ORDER BY order_date DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

// Grand total
$grand_total_result = mysqli_query($conn, "SELECT SUM(total) AS grand_total FROM orders $where");
$grand_total = mysqli_fetch_assoc($grand_total_result)['grand_total'] ?? 0;

// Table HTML
$html = '<table class="table table-striped table-hover align-middle text-center">
<thead class="table-success">
<tr>
<th>SL</th>
<th>Order ID</th>
<th>Customer Name</th>
<th>Contact</th>
<th>Order Date & Time</th>
<th>Status</th>
<th>Delivery Type</th>
<th>Total Qty</th>
<th>Total Amount (৳)</th>
<th>Action</th>
</tr>
</thead>
<tbody>';

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $order_id = $row['id'];

        // Fetch item count
        $items_query = mysqli_query($conn, "SELECT quantity FROM order_items WHERE order_id = $order_id");
        $total_qty = 0;
        while($item = mysqli_fetch_assoc($items_query)){
            $total_qty += (int)$item['quantity'];
        }

        $status = $row['status'] ?? 'Pending';
        $delivery = $row['delivery_type'] ?? 'N/A';
        $contact = $row['phone'] ?? 'N/A';

        $order_datetime = date('d/m/Y H:i', strtotime($row['order_date']));

        $html .= "<tr>
                    <td>{$serial}</td>
                    <td>{$row['id']}</td>
                    <td class='text-start ps-3'>{$row['name']}</td>
                    <td>{$contact}</td>
                    <td>{$order_datetime}</td>
                    <td>{$status}</td>
                    <td>{$delivery}</td>
                    <td>{$total_qty}</td>
                    <td>{$row['total']}</td>
                    <td>
                        <button class='btn btn-sm btn-primary detailsBtn' data-id='{$row['id']}'>Details</button>
                    </td>
                  </tr>";

        $serial++;
    }

    // Grand total row
    $html .= "<tr style='background:#e8f5e9; font-weight:bold;'>
                <td colspan='8' class='text-end'>Grand Total:</td>
                <td>৳ ".number_format($grand_total,2)."</td>
                <td></td>
              </tr>";
} else {
    $html .= "<tr><td colspan='10' class='text-muted'>No orders found!</td></tr>";
}

$html .= '</tbody></table>';

// Pagination
$html .= '<nav><ul class="pagination justify-content-center mt-2">';
if($page > 1){
    $html .= '<li class="page-item"><a class="page-link paginationBtn" href="#" data-page="'.($page-1).'">&laquo;</a></li>';
}
for($i=1; $i<=$total_pages; $i++){
    $active = ($i == $page) ? 'active' : '';
    $html .= '<li class="page-item '.$active.'"><a class="page-link paginationBtn" href="#" data-page="'.$i.'">'.$i.'</a></li>';
}
if($page < $total_pages){
    $html .= '<li class="page-item"><a class="page-link paginationBtn" href="#" data-page="'.($page+1).'">&raquo;</a></li>';
}
$html .= '</ul></nav>';

echo $html;
