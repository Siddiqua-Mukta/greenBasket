<?php
include '../db_connect.php';
include 'includes/header.php';

// Fetch all withdraw requests
$withdraws = mysqli_query($conn, "SELECT vw.*, v.name AS vendor_name FROM vendor_withdraws vw JOIN vendors v ON v.id = vw.vendor_id ORDER BY vw.created_at DESC");

// Approve / Reject action
if(isset($_GET['approve'])){
    $id = (int)$_GET['approve'];
    mysqli_query($conn, "UPDATE vendor_withdraws SET status='completed', approved_at=NOW() WHERE id='$id'");
    header("Location: admin_withdraw.php");
    exit();
}

if(isset($_GET['reject'])){
    $id = (int)$_GET['reject'];
    mysqli_query($conn, "UPDATE vendor_withdraws SET status='rejected', approved_at=NOW() WHERE id='$id'");
    header("Location: admin_withdraw.php");
    exit();
}
?>

<table class="table table-bordered">
<tr><th>ID</th><th>Vendor</th><th>Amount</th><th>Status</th><th>Requested At</th><th>Action</th></tr>
<?php while($row = mysqli_fetch_assoc($withdraws)){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['vendor_name']; ?></td>
<td><?php echo number_format($row['amount'],2); ?></td>
<td><?php echo ucfirst($row['status']); ?></td>
<td><?php echo $row['created_at']; ?></td>
<td>
<?php if($row['status']=='pending'){ ?>
    <a href="?approve=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Approve</a>
    <a href="?reject=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
<?php } else { echo '-'; } ?>
</td>
</tr>
<?php } ?>
</table>
