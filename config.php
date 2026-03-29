<?php
// Database connection [cite: 2, 16]
$conn = mysqli_connect("localhost", "root", "", "certificatedb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>