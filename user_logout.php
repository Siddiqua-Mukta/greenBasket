<?php
session_start();

// If user is not logged in → redirect to home
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Logout Confirmation</title>
</head>
<body>

<script>
// Show English confirmation popup
let ask = confirm("Are you sure you want to logout?");

if (ask) {
    // YES → Go to logout.php
    window.location.href = "user__logout.php";
} else {
    // NO → Stay in the previous page
    window.history.back();
}
</script>

</body>
</html>
