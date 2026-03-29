<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logged Out</title>
    <link href="https://fonts.cdnfonts.com/css/tactic-sans" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <style>
        :root { 
            --bg: #0f172a; 
            --card-bg: #1e293b; 
            --text-primary: #ffffff; 
            --text-secondary: #94a3b8;
            --clay-blue: #3b82f6;
            
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

        .logout-card { 
            background: var(--card-bg); 
            padding: 60px 40px; 
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
            margin-bottom: 20px; 
            text-transform: uppercase; 
            letter-spacing: 2px;
            color: var(--clay-blue);
        }

        p {
            color: var(--text-secondary);
            font-size: 13px;
            letter-spacing: 1px;
            margin-bottom: 35px;
            text-transform: uppercase;
        }

        .home-btn { 
            display: block;
            width: 100%; 
            padding: 18px; 
            background: #111827; 
            color: #ffffff; 
            border: none; 
            border-radius: 20px; 
            font-weight: 700; 
            font-size: 14px; 
            text-decoration: none;
            text-transform: uppercase; 
            box-shadow: var(--clay-inner);
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            letter-spacing: 2px;
            box-sizing: border-box;
        }
        
        .home-btn:hover { 
            background: var(--clay-blue);
            transform: translateY(-4px); 
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4); 
        }

        .home-btn:active { transform: scale(0.96); }
    </style>
</head>
<body>
    <div class="logout-card">
        <h1>Logged Out</h1>
        <p>Your session has been terminated safely.</p>

        <a href="index.php" class="home-btn">Return To Home</a>
    </div>
</body>
</html>