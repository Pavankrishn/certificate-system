<?php
session_start();
// Security check to ensure only logged-in admins can access
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://fonts.cdnfonts.com/css/tactic-sans" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <style>
        :root { 
            --bg: #0f172a; 
            --card-bg: #1e293b; 
            --text-primary: #ffffff; 
            --text-secondary: #94a3b8;
            --clay-blue: #3b82f6;
            --clay-red: #ef4444;
            
            --clay-shadow: 20px 20px 60px #080e1a, 
                           -10px -10px 30px rgba(255, 255, 255, 0.05);
            --clay-inner: inset 8px 8px 16px rgba(255, 255, 255, 0.03), 
                          inset -8px -8px 16px rgba(0, 0, 0, 0.2);
        }

        body { 
            background-color: var(--bg); 
            font-family: 'LEMON MILK', sans-serif; 
            display: flex; align-items: center; justify-content: center; 
            min-height: 100vh; margin: 0; color: var(--text-primary); 
            overflow: hidden;
        }

        .dashboard-card { 
            background: var(--card-bg); 
            padding: 60px 40px; 
            border-radius: 45px; 
            box-shadow: var(--clay-shadow);
            width: 100%; 
            max-width: 500px; 
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        h1 { 
            font-family: 'Tactic Sans', sans-serif;
            font-weight: 900; 
            font-size: 30px; 
            margin-bottom: 45px; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
        }

        .nav-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .btn {
            display: inline-block;
            padding: 20px;
            border-radius: 20px;
            font-family: 'LEMON MILK', sans-serif;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 14px;
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .manage { 
            background: var(--clay-blue); 
            color: #ffffff; 
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2), inset 4px 4px 8px rgba(255, 255, 255, 0.2);
        }
        
        .manage:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4); 
        }

        .logout { 
            background: #111827; 
            color: var(--clay-red); 
            box-shadow: var(--clay-inner);
        }
        
        .logout:hover { 
            color: #fff;
            background: var(--clay-red);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
        }

        .btn:active { transform: scale(0.96); }
    </style>
</head>
<body>

<div class="dashboard-card">
    <h1>Admin Control</h1>
    <div class="nav-container">
        <a class="btn manage" href="admin_requests.php">Manage Requests</a>
        <a class="btn logout" href="logout.php">System Logout</a>
    </div>
</div>

</body>
</html>