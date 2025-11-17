<?php
include '../db_connect.php';

if(isset($_POST['id'], $_POST['message'])){
    $id = $_POST['id'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Save reply to DB
    mysqli_query($conn, "UPDATE contact_messages SET reply='$message' WHERE id='$id'");

    // Send email to user
    $emailResult = mysqli_query($conn, "SELECT email FROM contact_messages WHERE id='$id'");
    $emailRow = mysqli_fetch_assoc($emailResult);
    $to = $emailRow['email'];
    $subject = "Reply to your message";
    $headers = "From: support@yourdomain.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    mail($to, $subject, $message, $headers);

    echo "success";
}
?>
