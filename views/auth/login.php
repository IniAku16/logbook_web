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
    <title>Login | Activity Digital</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --bg-body: #ece3db;
            --milk-tea: #d4bda9;
            --caramel: #967259;
            --espresso: #2d1b14;
            --white: #ffffff;
            --accent-gold: #c6a664;
            --shadow-bold: 0 20px 50px rgba(45, 27, 20, 0.12);
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
            background-color: var(--bg-body);
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--milk-tea) 0%, transparent 70%);
            top: -200px;
            right: -100px;
            opacity: 0.4;
            z-index: 0;
        }

        body::after {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--caramel) 0%, transparent 70%);
            bottom: -150px;
            left: -100px;
            opacity: 0.2;
            z-index: 0;
        }

        .card {
            width: 420px;
            padding: 50px 40px;
            border-radius: 35px;
            background: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: var(--shadow-bold);
            z-index: 2;
            position: relative;
        }

        .brand-text {
            text-align: center;
            font-weight: 800;
            font-size: 14px;
            color: var(--accent-gold);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .title {
            text-align: center;
            font-size: 34px;
            font-weight: 800;
            color: var(--espresso);
            margin-bottom: 35px;
            letter-spacing: -1.5px;
        }

        .alert {
            background: #fff5f5;
            border: 2px solid #feb2b2;
            color: #c53030;
            padding: 14px 18px;
            border-radius: 16px;
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .input-group {
            margin-bottom: 24px;
            position: relative;
        }

        label {
            font-size: 13px;
            color: var(--caramel);
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
            border-radius: 16px;
            border: 2px solid #eeeae6;
            background: #fcfaf8;
            color: var(--espresso);
            outline: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: var(--caramel);
            background: var(--white);
            box-shadow: 0 0 0 5px rgba(150, 114, 89, 0.1);
        }

        .toggle {
            position: absolute;
            right: 20px;
            top: 45px;
            cursor: pointer;
            color: var(--milk-tea);
            font-size: 20px;
            transition: 0.2s;
            z-index: 10;
        }

        .toggle:hover {
            color: var(--espresso);
        }

        button {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 18px;
            background: var(--espresso);
            color: var(--white);
            font-weight: 800;
            font-size: 15px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 10px 25px rgba(45, 27, 20, 0.2);
        }

        button:hover {
            background: var(--caramel);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(150, 114, 89, 0.3);
        }

        .forgot {
            text-align: center;
            margin-top: 30px;
        }

        .forgot a {
            font-size: 14px;
            color: var(--caramel);
            text-decoration: none;
            font-weight: 800;
            transition: 0.3s;
        }

        .forgot a:hover {
            color: var(--espresso);
            text-decoration: underline;
        }

        ::placeholder {
            color: #ccc0b5;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="brand-text">Activity Digital</div>
        <div class="title">Selamat Datang</div>

        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert">
                <i class="bi bi-exclamation-circle-fill" style="font-size: 18px;"></i>
                <span><?= htmlspecialchars($_SESSION['error_msg']) ?></span>
            </div>
            <?php unset($_SESSION['error_msg']); ?>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($frontController) ?>" method="POST">
            <input type="hidden" name="form" value="login">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <div class="input-group">
                <label>Username / Email</label>
                <input type="text" name="login" placeholder="Masukkan akun Anda" required autocomplete="off">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                <i class="bi bi-eye-slash toggle" id="togglePassword"></i>
            </div>

            <button type="submit">MASUK SEKARANG</button>
        </form>

        <div class="forgot">
            <a href="<?= htmlspecialchars($frontController . '?page=forgot_password') ?>">Lupa password Anda?</a>
        </div>
    </div>

    <script>
        const password = document.getElementById("password");
        const toggle = document.getElementById("togglePassword");

        toggle.addEventListener("click", function() {
            const isHidden = password.getAttribute("type") === "password";
            password.setAttribute("type", isHidden ? "text" : "password");

            this.classList.toggle("bi-eye");
            this.classList.toggle("bi-eye-slash");
        });
    </script>

</body>

</html>