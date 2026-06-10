<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$frontController = preg_replace('#/views/auth/.*$#', '/public/index.php', $_SERVER['SCRIPT_NAME']);
$isLoggedIn = isset($_SESSION['id_user']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isLoggedIn ? 'Keamanan Akun' : 'Bantuan Akses' ?> | Activity Digital</title>

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
            --caramel: #a36b46;
            --shadow: 0 20px 40px -5px rgba(74, 44, 27, 0.15), 0 0 25px 0 rgba(74, 44, 27, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--bg-main);
            position: relative;
            color: var(--text-dark);
            padding: 20px;
            overflow-x: hidden;
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
            width: 100%;
            max-width: 440px;
            padding: 45px 40px;
            border-radius: 28px;
            background: var(--card-bg);
            border: 1px solid rgba(74, 44, 27, 0.1);
            box-shadow: var(--shadow);
            z-index: 2;
            position: relative;
        }

        .brand-text {
            text-align: center;
            font-weight: 800;
            font-size: 11px;
            color: var(--caramel);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .title {
            text-align: center;
            font-size: 26px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 25px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            line-height: 1.5;
        }

        .alert-info {
            background: #f0f7ff;
            border: 1px solid #cfe2ff;
            color: #084298;
        }

        .alert-warning {
            background: #fff8eb;
            border: 1px solid #ffeeba;
            color: #856404;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 800;
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-left: 4px;
        }

        input {
            width: 100%;
            padding: 15px 18px;
            border-radius: 14px;
            border: 2px solid var(--input-border);
            font-size: 15px;
            font-weight: 600;
            outline: none;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        input:focus {
            border-color: var(--caramel);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(163, 107, 70, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 40px;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 18px;
            transition: 0.2s;
        }

        .validation-box {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 20px;
            border: 1px solid #eee;
        }

        .v-item {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .v-item:last-child {
            margin-bottom: 0;
        }

        .v-item.invalid {
            color: #dc3545;
        }

        .v-item.valid {
            color: #198754;
        }

        button {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 14px;
            background: var(--primary-gradient);
            color: #fff;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(74, 44, 27, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(74, 44, 27, 0.3);
            filter: brightness(1.1);
        }

        button:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            box-shadow: none;
        }

        .footer-link {
            text-align: center;
            margin-top: 25px;
        }

        .footer-link a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 14px;
            transition: 0.2s;
        }

        .footer-link a:hover {
            color: var(--caramel);
        }

        .admin-contact-card {
            text-align: center;
            background: #fffaf0;
            border: 2px dashed #eebc8d;
            padding: 20px;
            border-radius: 20px;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="brand-text">Security Center</div>

        <?php if ($isLoggedIn): ?>
            <div class="title">Buat Password Baru</div>

            <div class="alert alert-info">
                <i class="bi bi-shield-lock-fill" style="font-size: 20px;"></i>
                <span>Halo <b><?= htmlspecialchars($_SESSION['username']) ?></b>, demi keamanan akun, silakan buat password pribadi Anda sendiri.</span>
            </div>

            <form action="<?= htmlspecialchars($frontController) ?>" method="POST" id="formReset">
                <input type="hidden" name="form" value="reset_password">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <div class="input-group">
                    <label>Password Baru</label>
                    <input type="password" id="pass1" name="new_password" placeholder="Ketik password baru..." required onkeyup="validatePassword()">
                    <i class="bi bi-eye-slash toggle-password" onclick="togglePass('pass1', this)"></i>
                </div>

                <div class="validation-box">
                    <div id="v-length" class="v-item invalid"><i class="bi bi-x-circle-fill"></i> Minimal 8 Karakter</div>
                    <div id="v-upper" class="v-item invalid"><i class="bi bi-x-circle-fill"></i> Minimal 1 Huruf Besar (A-Z)</div>
                    <div id="v-symbol" class="v-item invalid"><i class="bi bi-x-circle-fill"></i> Minimal 1 Simbol (!@#$*)</div>
                    <div id="v-match" class="v-item invalid"><i class="bi bi-x-circle-fill"></i> Konfirmasi Password Cocok</div>
                </div>

                <div class="input-group">
                    <label>Ulangi Password Baru</label>
                    <input type="password" id="pass2" name="confirm_password" placeholder="Ulangi password baru..." required onkeyup="validatePassword()">
                    <i class="bi bi-eye-slash toggle-password" onclick="togglePass('pass2', this)"></i>
                </div>

                <button type="submit" id="btnSubmit" disabled>
                    <i class="bi bi-check2-circle"></i> SIMPAN & MASUK DASHBOARD
                </button>
            </form>

        <?php else: ?>
            <div class="title">Lupa Password?</div>

            <div class="alert alert-warning">
                <i class="bi bi-info-circle-fill" style="font-size: 20px;"></i>
                <span>Untuk menjaga keamanan data, proses reset password hanya dapat dilakukan oleh <b>Administrator Sistem</b>.</span>
            </div>

            <div class="admin-contact-card">
                <p style="font-size: 14px; font-weight: 600; color: #856404; margin-bottom: 15px;">Silakan isi formulir di bawah untuk meminta reset password otomatis:</p>

                <div class="input-group" style="text-align: left;">
                    <label>Username / Email Anda</label>
                    <input type="text" id="req_user">
                </div>

                <button type="button" id="btnKirimRequest" onclick="requestReset()">
                    <i class="bi bi-send-fill"></i> KIRIM PERMINTAAN RESET
                </button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function togglePass(id, icon) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            }
        }

        function validatePassword() {
            const p1 = document.getElementById('pass1').value;
            const p2 = document.getElementById('pass2').value;
            const btn = document.getElementById('btnSubmit');

            const checks = {
                length: p1.length >= 8,
                upper: /[A-Z]/.test(p1),
                symbol: /[\W_]/.test(p1),
                match: (p1 === p2 && p1 !== "")
            };

            updateStatus('v-length', checks.length);
            updateStatus('v-upper', checks.upper);
            updateStatus('v-symbol', checks.symbol);
            updateStatus('v-match', checks.match);

            btn.disabled = !(checks.length && checks.upper && checks.symbol && checks.match);
        }

        function updateStatus(id, isValid) {
            const el = document.getElementById(id);
            const icon = el.querySelector('i');
            if (isValid) {
                el.className = "v-item valid";
                icon.className = "bi bi-check-circle-fill";
            } else {
                el.className = "v-item invalid";
                icon.className = "bi bi-x-circle-fill";
            }
        }

        function requestReset() {
            const user = document.getElementById('req_user').value;
            const btn = document.getElementById('btnKirimRequest');

            if (!user) {
                alert("Silakan masukkan Username/Email Anda.");
                return;
            }

            btn.disabled = true;
            btn.innerText = "MENGIRIM...";

            const fd = new FormData();
            fd.append('input_user', user);

            fetch('index.php?page=forget_password', {
                    method: 'POST',
                    body: fd
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert("Permintaan terkirim! Silahkan tunggu admin memproses password baru Anda.");
                        document.getElementById('req_user').value = "";
                    } else {
                        alert("Gagal mengirim permintaan.");
                    }
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-send-fill"></i> KIRIM PERMINTAAN RESET';
                });
        }
    </script>
</body>

</html>