<?php
session_start();
include 'config.php';
if (!isset($_SESSION['student_id'])) { header("Location: index.php"); exit(); }

$sid = $_SESSION['student_id'];

// Handle Update Request
if (isset($_POST['update_request'])) {
    $rid = (int)$_POST['request_id'];
    $new_type = (int)$_POST['cert_type_id'];
    // Update only if status is still 'Pending'
    $conn->query("UPDATE request_logs SET cert_type_id=$new_type WHERE request_id=$rid AND status='Pending'");
    header("Location: user_dashboard.php?updated=1");
}

$sql = "SELECT r.*, c.cert_name FROM request_logs r 
        JOIN certificate_types c ON r.cert_type_id = c.cert_type_id 
        WHERE r.applicant_id = $sid ORDER BY r.request_id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Requests</title>
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <style>
        body { background: #0f172a; font-family: 'LEMON MILK', sans-serif; color: white; padding: 50px; }
        .container { max-width: 800px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .card { background: #1e293b; padding: 25px; border-radius: 25px; box-shadow: 20px 20px 60px #080e1a; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.05); }
        .status { padding: 5px 12px; border-radius: 10px; font-size: 10px; float: right; }
        .Pending { background: #f59e0b; } .Issued { background: #10b981; } .Rejected { background: #ef4444; }
        select, button { padding: 10px; border-radius: 12px; border: none; font-family: 'LEMON MILK'; margin-top: 10px; }
        .btn-update { background: #3b82f6; color: white; cursor: pointer; }
        .logout { color: #94a3b8; text-decoration: none; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Welcome, <?= $_SESSION['student_name'] ?></h1>
        <a href="logout_user.php" class="logout">LOGOUT</a>
    </div>
    
    <?php while($row = $result->fetch_assoc()): ?>
    <div class="card">
        <span class="status <?= $row['status'] ?>"><?= strtoupper($row['status']) ?></span>
        <h3>Request #<?= $row['request_id'] ?></h3>
        <p style="color: #94a3b8; font-size: 13px;">Current: <?= $row['cert_name'] ?></p>
        
        <?php if($row['status'] == 'Pending'): ?>
        <form method="POST">
            <input type="hidden" name="request_id" value="<?= $row['request_id'] ?>">
            <select name="cert_type_id">
                <option value="1">Transfer Certificate</option>
                <option value="2">Conduct Certificate</option>
                <option value="3">Degree Certificate</option>
                <option value="4">Migration Certificate</option>
                <option value="5">Course Completion</option>
            </select>
            <button type="submit" name="update_request" class="btn-update">Update Type</button>
        </form>
        <?php else: ?>
            <p style="font-size: 10px; color: #ef4444;">(LOCKED: Records with '<?= $row['status'] ?>' status cannot be modified)</p>
        <?php endif; ?>
    </div>
    <?php endwhile; ?>
</div>
</body>
</html>