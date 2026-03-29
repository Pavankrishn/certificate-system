<?php
session_start();
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$trigger_error = "";

/* =========================
   HANDLE ACTIONS
========================= */
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];

    if ($_GET['action'] === 'approve') {
        $conn->query("UPDATE request_logs SET status='Issued' WHERE request_id=$id");
        header("Location: admin_requests.php");
        exit();
    }

    if ($_GET['action'] === 'reject') {
        $conn->query("UPDATE request_logs SET status='Rejected' WHERE request_id=$id");
        header("Location: admin_requests.php");
        exit();
    }

    if ($_GET['action'] === 'delete') {
        try {
            if (!$conn->query("DELETE FROM request_logs WHERE request_id=$id")) {
                throw new Exception($conn->error);
            }
            header("Location: admin_requests.php");
            exit();
        } catch (Exception $e) {
            $trigger_error = $e->getMessage();
        }
    }
}

/* =========================
   SORTING SYSTEM
========================= */
$allowed_sort = [
    'request_id' => 'r.request_id',
    'reg_no'     => 'r.applicant_id',
    'full_name'  => 'a.full_name',
    'cert_name'  => 'c.cert_name',
    'status'     => 'r.status',
    'created_at' => 'r.created_at'
];

$sort  = $_GET['sort']  ?? 'request_id';
$order = $_GET['order'] ?? 'DESC';

if (!array_key_exists($sort, $allowed_sort)) {
    $sort = 'request_id';
}

$order = ($order === 'ASC') ? 'ASC' : 'DESC';
$sort_column = $allowed_sort[$sort];

/* =========================
   MAIN QUERY
========================= */
$sql = "SELECT r.request_id, r.applicant_id, a.full_name,
        c.cert_name, r.status, r.created_at
        FROM request_logs r
        LEFT JOIN applicants a ON r.applicant_id = a.applicant_id
        LEFT JOIN certificate_types c ON r.cert_type_id = c.cert_type_id
        ORDER BY $sort_column $order";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage System Requests</title>

<style>
:root {
    --bg: #0f172a;
    --card-bg: #1e293b;
    --text-main: #ffffff;
    --text-dim: #94a3b8;
    --green: #10b981;
    --red: #ef4444;
    --orange: #f59e0b;
    --blue: #3b82f6;
}

body {
    background: var(--bg);
    font-family: Arial, sans-serif;
    padding: 40px;
    color: var(--text-main);
}

.header-area {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

h1 { margin: 0; }

.btn-back {
    background: #334155;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: bold;
    transition: background 0.3s;
}

.btn-back:hover {
    background: var(--blue);
}

.table-container {
    background: var(--card-bg);
    padding: 25px;
    border-radius: 12px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 14px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    text-align: left;
}

th a {
    color: var(--text-dim);
    text-decoration: none;
}

th a:hover {
    color: white;
}

.badge {
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: bold;
    color: white;
}

.pending { background: var(--orange); }
.issued { background: var(--green); }
.rejected { background: var(--red); }

.action-btn {
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    text-decoration: none;
    margin-right: 6px;
    color: white;
}

.btn-approve { background: var(--green); }
.btn-reject { background: var(--red); }
.btn-delete { background: #334155; }

.alert-box {
    background: rgba(239, 68, 68, 0.1);
    color: var(--red);
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}
</style>
</head>

<body>

<div class="header-area">
    <h1>Request Manager</h1>
    <a href="admin_dashboard.php" class="btn-back">← Back to Dashboard</a>
</div>

<?php if ($trigger_error): ?>
<div class="alert-box">
    <?= htmlspecialchars($trigger_error) ?>
</div>
<?php endif; ?>

<div class="table-container">
<table>
<thead>
<tr>
<th><a href="?sort=request_id&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">ID</a></th>
<th><a href="?sort=reg_no&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Reg No</a></th>
<th><a href="?sort=full_name&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Applicant</a></th>
<th><a href="?sort=cert_name&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Document</a></th>
<th><a href="?sort=status&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Status</a></th>
<th><a href="?sort=created_at&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">Date</a></th>
<th>Actions</th>
</tr>
</thead>

<tbody>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['request_id'] ?></td>
<td style="font-weight:bold; color:var(--blue);"><?= $row['applicant_id'] ?></td>
<td><?= strtoupper(htmlspecialchars($row['full_name'] ?? 'UNKNOWN')) ?></td>
<td><?= strtoupper(htmlspecialchars($row['cert_name'])) ?></td>
<td>
<span class="badge <?= strtolower($row['status']) ?>">
<?= $row['status'] ?>
</span>
</td>
<td>
<?= date("d M Y", strtotime($row['created_at'])) ?><br>
<span style="font-size:11px;color:#94a3b8;">
<?= date("h:i A", strtotime($row['created_at'])) ?>
</span>
</td>
<td>
<?php if ($row['status'] === 'Pending'): ?>
<a class="action-btn btn-approve" href="?action=approve&id=<?= $row['request_id'] ?>">Issue</a>
<a class="action-btn btn-reject" href="?action=reject&id=<?= $row['request_id'] ?>">Reject</a>
<?php endif; ?>
<a class="action-btn btn-delete" href="?action=delete&id=<?= $row['request_id'] ?>">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

</body>
</html>