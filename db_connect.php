<?php
$servername = "localhost";   // usually 'localhost'
$username = "root";          // your MySQL username
$password = "";              // your MySQL password (keep empty if none)
$database = "ecom_db";       // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
} else {
    //echo "✅ Successfully connected to the database!";
}
?>
