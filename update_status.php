<?php
session_start();
include 'config.php';

$id=$_GET['id'];
$status=$_GET['status'];

mysqli_query($conn,"UPDATE request_logs SET status='$status' WHERE request_id=$id");

header("Location: admin_requests.php");
exit;
