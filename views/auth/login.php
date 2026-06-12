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
            width: 420px;
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
            background: #fff5f5;
            border: 2px solid #feb2b2;
            color: #9b2c2c;
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

        .forgot {
            text-align: center;
            margin-top: 30px;
        }

        .forgot a {
            font-size: 14px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 700;
            transition: 0.2s;
        }

        .forgot a:hover {
            color: #4a2c1b;
            text-decoration: underline;
        }

        ::placeholder {
            color: #bcaaa4;
        }

        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }

        input::-webkit-contacts-auto-fill-button,
        input::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            display: none !important;
            pointer-events: none;
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
            <div class="forgot" style="margin-top: 20px; text-align: center;">
                <a href="javascript:void(0)" onclick="openForgotModal()" style="color: var(--caramel); font-size: 13px; font-weight: 700;">
                    <i class="bi bi-question-circle me-1"></i> Lupa Password? Hubungi Admin
                </a>
            </div>
        </form>

        <div id="modalForgot" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
            <div class="card" style="width:380px; padding:30px;">
                <div class="brand-text">Bantuan Akses</div>
                <div class="title" style="font-size:20px; margin-bottom:15px;">Lupa Password?</div>
                <p style="font-size:13px; color:var(--text-muted); margin-bottom:20px;">Masukkan Email Anda. Admin akan mereset password Anda.</p>

                <form id="formForgotRequest">
                    <div class="input-group">
                        <label>Email</label>
                        <input type="text" id="req_input" placeholder="Masukkan detail akun" required>
                    </div>
                    <button type="button" id="btnSubmitReset" onclick="sendRequestToDB()">KIRIM PERMINTAAN</button>
                    <button type="button" onclick="closeModal()" style="background:none; color:var(--text-muted); box-shadow:none; margin-top:5px;">BATAL</button>
                </form>
            </div>
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

        function openForgotModal() {
            document.getElementById('modalForgot').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modalForgot').style.display = 'none';
        }

        function sendRequestToDB() {
            const input = document.getElementById('req_input').value;
            const btn = document.getElementById('btnSubmitReset');

            const csrf = document.querySelector('input[name="csrf_token"]').value;

            if (!input) return alert('Isi Username/Email Anda');

            btn.disabled = true;
            btn.innerText = 'Mengirim...';

            const fd = new FormData();
            fd.append('action', 'submit_forget_password');
            fd.append('input_user', input);
            fd.append('csrf_token', csrf);

            fetch('index.php', {
                    method: 'POST',
                    body: fd
                })
                .then(res => {
                    if (!res.ok) throw new Error('Server Error');
                    return res.json();
                })
                .then(data => {
                    alert(data.message);
                    if (data.status === 'success') {
                        closeModal();
                        document.getElementById('req_input').value = '';
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal menghubungi server. Pastikan Anda tidak sedang offline.');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerText = 'KIRIM PERMINTAAN';
                });
        }
    </script>

</body>

</html>