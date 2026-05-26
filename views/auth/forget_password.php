<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$frontController = preg_replace('#/views/auth/.*$#', '/public/index.php', $_SERVER['SCRIPT_NAME']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Activity Digital</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg-main: #fcfbfa; 
            --primary-gradient: linear-gradient(135deg, #4a2c1b 0%, #b8860b 100%);
            --text-dark: #2d1b14;
            --text-muted: #6e5d55;
            --card-bg: #ffffff;
            --input-border: #d7ccc8; 
            --shadow-bold-light: 0 20px 40px -5px rgba(74, 44, 27, 0.15), 
                                  0 0 25px 0 rgba(74, 44, 27, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--bg-main);
            overflow: hidden;
            position: relative;
            color: var(--text-dark);
        }

        body::before {
            content: "";
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(184, 134, 11, 0.08) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            z-index: 0;
        }

        .card {
            width: 440px;
            padding: 50px 40px;
            border-radius: 24px;
            background: var(--card-bg);
            border: 2px solid rgba(74, 44, 27, 0.25); 
            box-shadow: var(--shadow-bold-light);
            z-index: 2;
            position: relative;
        }

        .brand-text {
            text-align: center;
            font-weight: 800;
            font-size: 12px;
            color: #4a2c1b;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .title {
            text-align: center;
            font-size: 32px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 35px;
            letter-spacing: -1px;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: shake 0.5s ease-in-out;
        }

        .alert-error {
            background: #fff5f5;
            border: 2px solid #feb2b2;
            color: #9b2c2c;
        }

        .alert-success {
            background: #f0fff4;
            border: 2px solid #9ae6b4;
            color: #22543d;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .input-group {
            margin-bottom: 22px;
            position: relative;
        }

        label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 800;
            margin-bottom: 8px;
            display: block;
            margin-left: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input {
            width: 100%;
            padding: 16px 20px;
            border-radius: 12px;
            border: 2px solid var(--input-border);
            background: #ffffff;
            color: var(--text-dark);
            outline: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        input:focus {
            border-color: #4a2c1b;
            box-shadow: 0 0 0 4px rgba(74, 44, 27, 0.15); 
        }

        .toggle {
            position: absolute;
            right: 20px;
            top: 45px; 
            cursor: pointer;
            color: var(--text-muted);
            font-size: 20px;
            transition: 0.2s;
            z-index: 10;
        }

        .toggle:hover {
            color: #4a2c1b;
        }

        button {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            background: var(--primary-gradient);
            color: #ffffff;
            font-weight: 800;
            font-size: 15px;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(74, 44, 27, 0.2);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(74, 44, 27, 0.35);
            filter: brightness(1.1);
        }

        .footer-link {
            text-align: center;
            margin-top: 30px;
        }

        .footer-link a {
            font-size: 14px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 700;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .footer-link a:hover {
            color: #4a2c1b;
            text-decoration: underline;
        }

        ::placeholder {
            color: #bcaaa4;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="brand-text">Security Center</div>
        <div class="title">Reset Password</div>

        <?php if (!empty($_SESSION['error_msg'])): ?>
            <div class="alert alert-error">
                <i class="bi bi-exclamation-circle-fill" style="font-size: 18px;"></i>
                <span><?= htmlspecialchars($_SESSION['error_msg']) ?></span>
            </div>
            <?php unset($_SESSION['error_msg']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success_msg'])): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill" style="font-size: 18px;"></i>
                <span><?= htmlspecialchars($_SESSION['success_msg']) ?></span>
            </div>
            <?php unset($_SESSION['success_msg']); ?>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($frontController) ?>" method="POST">
            <input type="hidden" name="form" value="reset_password">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <div class="input-group">
                <label>Username / Email</label>
                <input type="text" name="identifier" placeholder="Masukkan akun Anda" required autocomplete="off">
            </div>

            <div class="input-group">
                <label>Password Baru</label>
                <input type="password" id="pass1" name="new_password" placeholder="••••••••" required>
                <i class="bi bi-eye-slash toggle" onclick="togglePass('pass1', this)"></i>
            </div>

            <div class="input-group">
                <label>Konfirmasi Password</label>
                <input type="password" id="pass2" name="confirm_password" placeholder="••••••••" required>
                <i class="bi bi-eye-slash toggle" onclick="togglePass('pass2', this)"></i>
            </div>

            <button type="submit">UPDATE PASSWORD</button>
        </form>

        <div class="footer-link">
            <a href="<?= htmlspecialchars($frontController) ?>">
                <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Login
            </a>
        </div>
    </div>

    <script>
        function togglePass(inputId, icon) {
            const passwordInput = document.getElementById(inputId);
            const isHidden = passwordInput.getAttribute("type") === "password";

            passwordInput.setAttribute("type", isHidden ? "text" : "password");

            icon.classList.toggle("bi-eye");
            icon.classList.toggle("bi-eye-slash");
        }
    </script>
</body>

</html>