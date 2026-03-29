<?php
// Establish connection with your existing database
include 'config.php';

if (isset($_POST['submit'])) {
    // Sanitize inputs to ensure data integrity
    $applicant_id = mysqli_real_escape_string($conn, $_POST['applicant_id']);
    $cert_type_id = mysqli_real_escape_string($conn, $_POST['cert_type_id']);
    $request_date = date("Y-m-d"); // Capture current date
    $status = "Pending";

    // Prepare the SQL command for the Request_Logs table
    $query = "INSERT INTO Request_Logs (applicant_id, cert_type_id, request_date, status) 
              VALUES ('$applicant_id', '$cert_type_id', '$request_date', '$status')";

    if (mysqli_query($conn, $query)) {
        // Redirect back to index.php with the success flag for the Claymorphic modal
        header("Location: index.php?success=1");
        exit();
    } else {
        // Fallback error handler if the database rejects the request
        die("<div style='font-family:sans-serif; padding:20px; color:#ef4444;'>
                <b>Transmission Error:</b> " . mysqli_error($conn) . "
             </div>");
    }
}
?>