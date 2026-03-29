<?php
include 'config.php';

$applicant_id = null;
$rows = [];
$counts = ['total' => 0, 'issued' => 0, 'pending' => 0, 'rejected' => 0];
$error = '';

if (isset($_GET['applicant_id']) && $_GET['applicant_id'] !== '') {
    $applicant_id = (int) $_GET['applicant_id'];

    // MANDATORY AGGREGATE FUNCTIONS - Required by PDF [cite: 626]
    $agg_sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Issued' THEN 1 ELSE 0 END) as issued,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected
                FROM request_logs 
                WHERE applicant_id = $applicant_id";
    
    $agg_result = mysqli_query($conn, $agg_sql);
    if ($agg_result) { $counts = mysqli_fetch_assoc($agg_result); }

    // ORIGINAL STABLE JOIN - No more 'Unknown column' errors
    $sql = "SELECT r.request_id, r.applicant_id, c.cert_name, r.status
            FROM request_logs r
            JOIN certificate_types c ON r.cert_type_id = c.cert_type_id
            WHERE r.applicant_id = $applicant_id
            ORDER BY r.request_id DESC";

    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { $rows[] = $row; }
    } else {
        $error = "No requests found for Applicant ID $applicant_id.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Status</title>
    <link href="https://fonts.cdnfonts.com/css/tactic-sans" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <style>
        :root { 
            --bg: #0f172a; --card-bg: #1e293b; --text-primary: #ffffff; --text-secondary: #94a3b8;
            --clay-blue: #3b82f6; --clay-green: #10b981; --clay-orange: #f59e0b; --clay-red: #ef4444;
            --clay-shadow: 20px 20px 60px #080e1a, -10px -10px 30px rgba(255, 255, 255, 0.05);
            --clay-inner: inset 8px 8px 16px rgba(255, 255, 255, 0.03), inset -8px -8px 16px rgba(0, 0, 0, 0.2);
        }
        body { margin:0; background:var(--bg); color:var(--text-primary); font-family:'LEMON MILK', sans-serif; padding:40px; }
        h1 { font-family:'Tactic Sans', sans-serif; font-weight:900; margin-bottom:40px; text-transform:uppercase; letter-spacing: 2px; }
        .search-box { display:flex; gap:15px; margin-bottom:40px; }
        input { padding:16px; background:#111827; border:none; border-radius:18px; color:#fff; font-family:'LEMON MILK'; box-shadow: var(--clay-inner); outline:none; }
        button { padding:16px 25px; border-radius:18px; background:var(--clay-blue); border:none; color:#fff; font-family:'LEMON MILK'; cursor:pointer; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2), inset 4px 4px 8px rgba(255,255,255,0.1); transition: 0.3s; }
        .cards { display:grid; grid-template-columns:repeat(auto-fit, minmax(150px, 1fr)); gap:25px; margin-bottom:40px; }
        .card { background:var(--card-bg); padding:25px; border-radius:25px; text-align:center; box-shadow: var(--clay-shadow); }
        .card h2 { margin:0; font-size:28px; color:var(--clay-blue); }
        .card p { margin:8px 0 0; color:var(--text-secondary); font-size:10px; letter-spacing:1px; }
        .table-wrap { background:var(--card-bg); border-radius:35px; padding:30px; box-shadow: var(--clay-shadow); }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:18px; text-align:center; }
        th { color:var(--text-secondary); font-size:11px; letter-spacing:1.5px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        td { border-bottom:1px solid rgba(255,255,255,0.02); font-size:13px; }
        .badge { padding:8px 16px; border-radius:14px; font-size:11px; font-weight:700; display:inline-block; box-shadow: var(--clay-inner); }
        .pending { background:var(--clay-orange); color:#fff; }
        .issued { background:var(--clay-green); color:#fff; }
        .rejected { background:var(--clay-red); color:#fff; }
        .error { background: rgba(239, 68, 68, 0.1); padding: 20px; border-radius: 15px; color: var(--clay-red); font-weight: 700; margin-top: 30px; }
        .back { margin-top:40px; display:inline-block; color:var(--text-secondary); text-decoration:none; font-size:11px; font-weight:700; }
    </style>
</head>
<body>
    <h1>Request Status</h1>
    <form class="search-box" method="GET">
        <input type="number" name="applicant_id" placeholder="APPLICANT ID" required>
        <button type="submit">CHECK STATUS</button>
    </form>
    <?php if ($applicant_id && !$error): ?>
    <div class="cards">
        <div class="card"><h2><?= (int)$counts['total'] ?></h2><p>TOTAL</p></div>
        <div class="card"><h2><?= (int)$counts['issued'] ?></h2><p>ISSUED</p></div>
        <div class="card"><h2><?= (int)$counts['pending'] ?></h2><p>PENDING</p></div>
        <div class="card"><h2><?= (int)$counts['rejected'] ?></h2><p>REJECTED</p></div>
    </div>
    <div class="table-wrap">
    <table>
        <thead><tr><th>ID</th><th>APPLICANT ID</th><th style="text-align:left">CERTIFICATE TYPE</th><th>STATUS</th></tr></thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= $r['request_id'] ?></td>
                <td><?= $r['applicant_id'] ?></td>
                <td style="text-align:left"><?= strtoupper($r['cert_name']) ?></td>
                <td><span class="badge <?= strtolower($r['status']) ?>"><?= strtoupper($r['status']) ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php endif; ?>
    <?php if ($error): ?><div class="error"><?= strtoupper($error) ?></div><?php endif; ?>
    <a class="back" href="index.php">← RETURN TO REQUEST PORTAL</a>
</body>
</html>