<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_no = mysqli_real_escape_string($conn, $_POST['user_reg']);
    $pin = mysqli_real_escape_string($conn, $_POST['user_pin']);

    // Verify if student exists with that PIN
    $query = "SELECT * FROM applicants WHERE applicant_id = '$reg_no' AND access_pin = '$pin'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $student = mysqli_fetch_assoc($result);
        $_SESSION['student_id'] = $student['applicant_id'];
        $_SESSION['student_name'] = $student['full_name'];
        header("Location: user_dashboard.php");
    } else {
        echo "<script>alert('Invalid Registration Number or PIN'); window.location='index.php';</script>";
    }
}
?>