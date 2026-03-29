<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Specific credentials maintained
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "INVALID CREDENTIALS";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
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

        .login-card { 
            background: var(--card-bg); 
            padding: 55px; 
            border-radius: 45px; 
            box-shadow: var(--clay-shadow);
            width: 100%; max-width: 400px; 
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        h1 { 
            font-family: 'Tactic Sans', sans-serif;
            font-weight: 900; 
            font-size: 32px; 
            margin-bottom: 35px; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
        }

        input { 
            width: 100%; padding: 16px; 
            background: #111827; 
            border: none; border-radius: 20px; 
            color: #fff; font-size: 14px; 
            font-family: 'LEMON MILK', sans-serif;
            outline: none; box-shadow: var(--clay-inner);
            box-sizing: border-box; 
            margin-bottom: 20px;
            transition: transform 0.2s ease;
        }
        
        input:focus { transform: translateY(-2px); }

        .error-msg {
            background: rgba(239, 68, 68, 0.1);
            color: var(--clay-red);
            padding: 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .login-btn { 
            width: 100%; padding: 18px; 
            background: var(--clay-blue); color: #ffffff; 
            border: none; border-radius: 20px; 
            font-weight: 700; font-size: 15px; text-transform: uppercase; 
            cursor: pointer; 
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2), inset 4px 4px 8px rgba(255, 255, 255, 0.2);
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            letter-spacing: 2px;
            font-family: 'LEMON MILK', sans-serif;
        }
        
        .login-btn:hover { transform: translateY(-4px); box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4); }
        .login-btn:active { transform: scale(0.96); }

        .back-link {
            display:block; margin-top:25px; 
            color: var(--text-secondary);
            font-size: 10px; font-weight: 700; text-decoration: none; text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
        }
        .back-link:hover { color: #fff; }
    </style>
</head>

<body>
<div class="login-card">
    <h1>Admin Access</h1>

    <?php if (!empty($error)): ?>
        <div class="error-msg"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="USERNAME" required>
        <input type="password" name="password" placeholder="PASSWORD" required>
        <button type="submit" name="login" class="login-btn">Secure Login</button>
    </form>

    <a href="index.php" class="back-link">← Return to Portal</a>
</div>
</body>
</html>