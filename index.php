<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate Portal</title>
    <link href="https://fonts.cdnfonts.com/css/tactic-sans" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <style>
        :root { 
            --bg: #0f172a; 
            --card-bg: #1e293b; 
            --text-primary: #ffffff; 
            --text-secondary: #94a3b8;
            --clay-blue: #3b82f6;
            --error-red: #ef4444;
            --clay-shadow: 20px 20px 60px #080e1a, -10px -10px 30px rgba(255, 255, 255, 0.05);
            --clay-inner: inset 8px 8px 16px rgba(255, 255, 255, 0.03), inset -8px -8px 16px rgba(0, 0, 0, 0.2);
        }

        body { 
            background-color: var(--bg); 
            font-family: 'LEMON MILK', sans-serif; 
            display: flex; align-items: center; justify-content: center; 
            min-height: 100vh; margin: 0; color: var(--text-primary); 
            overflow: hidden;
        }

        .portal-card { 
            background: var(--card-bg); 
            padding: 55px; 
            border-radius: 40px; 
            box-shadow: var(--clay-shadow);
            width: 100%; max-width: 420px; 
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s ease;
        }

        h1 { 
            font-family: 'Tactic Sans', sans-serif;
            font-weight: 900; 
            font-size: 32px; 
            margin-bottom: 30px; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
        }

        /* Toggle Switch Styling */
        .mode-toggle {
            display: flex;
            background: #111827;
            border-radius: 15px;
            padding: 5px;
            margin-bottom: 35px;
            box-shadow: var(--clay-inner);
        }

        .mode-btn {
            flex: 1;
            padding: 10px;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            font-family: 'LEMON MILK';
            font-size: 10px;
            cursor: pointer;
            border-radius: 12px;
            transition: 0.3s;
        }

        .mode-btn.active {
            background: var(--clay-blue);
            color: white;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }

        .input-group { text-align: left; margin-bottom: 25px; position: relative; }
        
        label { 
            display: block; 
            font-size: 11px; 
            font-weight: 600; 
            margin-bottom: 10px; 
            color: var(--text-secondary); 
            padding-left: 10px; 
            letter-spacing: 1.2px;
        }

        input, select { 
            width: 100%; padding: 16px; 
            background: #111827; 
            border: none; border-radius: 20px; 
            color: #fff; font-size: 14px; 
            font-family: 'LEMON MILK', sans-serif;
            outline: none; box-shadow: var(--clay-inner);
            box-sizing: border-box; transition: 0.2s;
        }

        .submit-btn { 
            width: 100%; padding: 18px; 
            background: var(--clay-blue); color: #ffffff; 
            border: none; border-radius: 20px; 
            font-weight: 700; font-size: 15px; text-transform: uppercase; 
            cursor: pointer; margin-top: 15px; 
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3), inset 4px 4px 8px rgba(255, 255, 255, 0.2);
            transition: 0.3s;
            letter-spacing: 1.5px;
            font-family: 'LEMON MILK', sans-serif;
        }
        
        .submit-btn:hover { transform: translateY(-4px); box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4); }

        .admin-link {
            display:block; margin-top:20px; padding: 15px; border-radius: 20px;
            background: #111827; color: var(--text-secondary);
            font-size: 10px; font-weight: 700; text-decoration: none; text-transform: uppercase;
            box-shadow: var(--clay-inner); transition: 0.3s;
            letter-spacing: 1.2px;
        }

        /* Form Visibility */
        .form-content { display: none; }
        .form-content.active { display: block; animation: fadeIn 0.4s ease; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #cyberModal { 
            display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.8); 
            z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(8px);
        }
        .modal-box { 
            background: var(--card-bg); padding: 50px; border-radius: 40px; text-align: center; 
            box-shadow: var(--clay-shadow); max-width: 340px; border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body>

    <div class="portal-card">
        <h1>Portal</h1>

        <div class="mode-toggle">
            <button class="mode-btn active" onclick="switchMode('request', this)">New Request</button>
            <button class="mode-btn" onclick="switchMode('login', this)">User Login</button>
        </div>

        <div id="requestMode" class="form-content active">
            <form id="requestForm" action="submit.php" method="POST">
                <div class="input-group">
                    <label>Registration Number</label>
                    <input type="number" id="applicant_id" name="applicant_id" placeholder="ID (MAX 50)" required>
                </div>
                <div class="input-group">
                    <label>Credential Type</label>
                    <select name="cert_type_id" required>
                        <option value="" disabled selected>SELECT...</option>
                        <option value="1">Transfer Certificate</option>
                        <option value="2">Conduct Certificate</option>
                        <option value="3">Degree Certificate</option>
                        <option value="4">Migration Certificate</option>
                        <option value="5">Course Completion</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="submit-btn">Submit Request</button>
            </form>
        </div>

        <div id="loginMode" class="form-content">
            <form action="user_auth.php" method="POST">
                <div class="input-group">
                    <label>Registration Number</label>
                    <input type="number" name="user_reg" placeholder="ENTER REG NO" required>
                </div>
                <div class="input-group">
                    <label>Access Pin</label>
                    <input type="password" name="user_pin" placeholder="••••" required>
                </div>
                <button type="submit" class="submit-btn">Login to Update</button>
            </form>
        </div>

        <a href="reports.php" style="display:block; margin-top:25px; color:var(--text-secondary); text-decoration:none; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px;">Public Dashboard →</a>
        <a href="admin_login.php" class="admin-link">Admin Access</a>
    </div>

    <div id="cyberModal">
        <div class="modal-box">
            <div style="color:#10b981; font-size:50px; margin-bottom:15px;">✓</div>
            <h2 style="font-weight:900; color:#fff; margin:0; font-size:18px; text-transform: uppercase;">Complete</h2>
            <p style="color:var(--text-secondary); font-size:12px; margin: 15px 0 25px; letter-spacing: 0.5px;">RECORD SYNCHRONIZED SUCCESSFULLY.</p>
            <button onclick="document.getElementById('cyberModal').style.display='none'" style="background:var(--clay-blue); border:none; color:white; padding:12px 35px; border-radius:15px; font-weight:700; cursor:pointer; width:100%; font-family: 'LEMON MILK', sans-serif;">Dismiss</button>
        </div>
    </div>

    <script>
        function switchMode(mode, btn) {
            // Update buttons
            document.querySelectorAll('.mode-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Update forms
            document.querySelectorAll('.form-content').forEach(f => f.classList.remove('active'));
            document.getElementById(mode + 'Mode').classList.add('active');
        }

        window.addEventListener('load', function() {
            if (window.location.search.indexOf('success=1') > -1) {
                document.getElementById('cyberModal').style.display = 'flex';
                const newUrl = window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>
</body>
</html>