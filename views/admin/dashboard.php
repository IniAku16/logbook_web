<?php
$activePage = 'admin';
$users = $users ?? [];
$totalAktivitasSistem = $totalAktivitasSistem ?? 0;

if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION['username'] = $_SESSION['username'] ?? 'Admin Master';
$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Activity Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-body: #f8f6f4;
            --primary-dark: #2d1b14;
            --accent-gold: #b8860b;
            --soft-gold: #fdf5e6;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --border-color: #e9e2db;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #443c39;
        }

        .navbar-admin {
            background: var(--primary-dark);
            padding: 0.8rem 2rem;
            border-bottom: 3px solid var(--accent-gold);
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff !important;
        }

        .navbar-brand span {
            color: var(--accent-gold);
        }

        .notif-compact {
            background: #fff;
            border-left: 5px solid var(--accent-gold);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 12px 20px;
            margin-bottom: 20px;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card-stat {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            transition: transform 0.2s;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 15px;
        }

        .main-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .table thead th {
            background: #faf9f7;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 15px 20px;
            border-bottom: 2px solid #eee;
        }

        .table td {
            padding: 15px 20px;
            vertical-align: middle;
            font-size: 14px;
        }

        .status-pill {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .online {
            background: #e6f4ea;
            color: #1e7e34;
        }

        .offline {
            background: #f1f3f4;
            color: #5f6368;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
        }

        .dot-pulse {
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% {
                box-shadow: 0 0 0 0 rgba(30, 126, 52, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(30, 126, 52, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(30, 126, 52, 0);
            }
        }

        .btn-primary-custom {
            background: var(--primary-dark);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-primary-custom:hover {
            background: #000;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: 0.2s;
        }

        .action-edit {
            background: #fff8e1;
            color: #f57f17;
        }

        .action-delete {
            background: #ffebee;
            color: #c62828;
        }

        .action-edit:hover {
            background: #f57f17;
            color: #fff;
        }

        .action-delete:hover {
            background: #c62828;
            color: #fff;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--milk-tea);
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-admin">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ACTIVITY<span>DIGITAL.</span></a>
            <div class="ms-auto d-flex align-items-center">
                <div class="text-end me-3 d-none d-md-block">
                    <small class="text-white-50 d-block fw-bold" style="font-size: 10px;">ADMINISTRATOR</small>
                    <span class="text-white fw-bold"><?= htmlspecialchars($_SESSION['username']) ?></span>
                </div>
                <a href="index.php?page=logout" class="btn btn-outline-light border-0 rounded-circle" onclick="return confirm('Logout?')">
                    <i class="bi bi-power fs-5"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">

        <?php if (isset($requests) && count($requests) > 0): ?>
            <div id="notif-wrapper">
                <div class="notif-compact d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-subtle text-warning p-2 rounded-3 me-3">
                            <i class="bi bi-shield-lock-fill fs-5"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-800">Permintaan Reset Password</h6>
                            <small class="text-muted">Ada <strong><?= count($requests) ?></strong> user meminta pengaturan ulang kata sandi.</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-dark fw-bold px-3 rounded-pill" data-bs-toggle="collapse" data-bs-target="#notifDetail">
                            LIHAT DAFTAR
                        </button>
                    </div>
                    <div class="collapse w-100 mt-2" id="notifDetail">
                        <div class="table-responsive bg-light p-2 rounded">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr class="small text-muted">
                                        <th>USER EMAIL</th>
                                        <th>WAKTU</th>
                                        <th class="text-end">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($requests as $req): ?>
                                        <tr>
                                            <td class="fw-bold small"><?= htmlspecialchars($req['username_email']) ?></td>
                                            <td class="small text-muted"><?= date('H:i', strtotime($req['created_at'])) ?></td>
                                            <td class="text-end">
                                                <button class="btn btn-link btn-sm text-decoration-none fw-bold p-0 me-2" onclick="prosesResetNotif(null, '<?= $req['username_email'] ?>')">Detail</button>
                                                <a href="index.php?page=admin_dashboard&action=hapus_notif_reset&id=<?= $req['id'] ?>" class="text-danger small"><i class="bi bi-x-circle"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-800 mb-1">Manajemen Pengguna</h4>
                <p class="text-muted small mb-0">Pantau aktivitas dan kelola akses akun seluruh personel.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="index.php?page=admin_dashboard&action=monitoring" class="btn btn-light fw-bold border rounded-pill px-3">
                    <i class="bi bi-activity me-2"></i>Monitoring
                </a>
                <button class="btn-primary-custom rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-lg me-2"></i>Tambah User
                </button>
            </div>
        </div>

        <div class="stat-grid">
            <div class="card-stat shadow-sm">
                <div class="icon-box bg-primary text-white">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold d-block">TOTAL USER</small>
                    <h3 class="fw-800 mb-0" id="stat-total-users"><?= count($users) ?></h3>
                </div>
            </div>
            <div class="card-stat shadow-sm" onclick="window.location.href='index.php?page=admin_dashboard&action=all_activities'" style="cursor:pointer">
                <div class="icon-box bg-success text-white">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold d-block">TOTAL AKTIVITAS</small>
                    <h3 class="fw-800 mb-0" id="stat-total-activities"><?= $totalAktivitasSistem ?></h3>
                </div>
            </div>
            <div class="card-stat shadow-sm">
                <div class="icon-box bg-warning text-white">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold d-block">ADMIN AKTIF</small>
                    <h4 class="fw-800 mb-0">
                        <?php
                        $admCount = 0;
                        foreach ($users as $u) if ($u['role'] == 'admin') $admCount++;
                        echo $admCount;
                        ?>
                    </h4>
                </div>
            </div>
        </div>

        <div class="main-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>User Info</th>
                            <th>Email Address</th>
                            <th>Role Access</th>
                            <th>Status Akun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px; font-size: 14px;">
                                            <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= htmlspecialchars($user['username']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-semibold text-muted"><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="badge <?= $user['role'] == 'admin' ? 'bg-dark' : 'bg-light text-dark border' ?> px-3 py-2 rounded-pill">
                                        <?= strtoupper($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['last_activity'] && strtotime($user['last_activity']) > time() - 60): ?>
                                        <span class="status-pill online">
                                            <div class="dot dot-pulse"></div> ONLINE
                                        </span>
                                    <?php else: ?>
                                        <span class="status-pill offline">
                                            <div class="dot"></div> OFFLINE
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn-action action-edit edit-user-btn"
                                        data-id="<?= $user['id_user'] ?>"
                                        data-username="<?= htmlspecialchars($user['username']) ?>"
                                        data-email="<?= htmlspecialchars($user['email']) ?>"
                                        data-role="<?= $user['role'] ?>">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn-action action-delete ms-1" onclick="deleteUser(<?= $user['id_user'] ?>)">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
                <div class="modal-header border-0 px-4 pt-4">
                    <h5 class="fw-bold"><i class="bi bi-person-plus me-2"></i>Tambah Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addUserForm">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Username</label>
                            <input type="text" name="username" class="form-control rounded-3" placeholder="Masukkan username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="nama@perusahaan.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Role Akses</label>
                            <select name="role" class="form-select rounded-3" required>
                                <option value="user">User / Operator</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div class="alert alert-info py-2 small border-0 shadow-none">
                            <i class="bi bi-info-circle me-1"></i> Password akan di-generate otomatis.
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-primary-custom w-100 py-3">SIMPAN & GENERATE AKSES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successAccountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 25px;">
                <div class="modal-body p-5 text-center">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-check-lg fs-1"></i>
                    </div>
                    <h4 class="fw-800">Akun Berhasil Dibuat</h4>
                    <p class="text-muted mb-4">Harap salin detail login di bawah ini untuk pengguna:</p>

                    <div class="text-start bg-light p-3 rounded-4 mb-4">
                        <div class="mb-2">
                            <small class="text-muted fw-bold">Username:</small>
                            <input type="text" id="res_username" class="form-control border-0 bg-transparent fw-bold p-0" readonly>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted fw-bold">Email:</small>
                            <input type="text" id="res_email" class="form-control border-0 bg-transparent fw-bold p-0" readonly>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted fw-bold">Password:</small>
                            <input type="text" id="res_password" class="form-control border-0 bg-transparent fw-bold p-0 text-primary" readonly>
                        </div>
                    </div>

                    <button type="button" id="btnCopyAll" class="btn btn-dark w-100 py-3 rounded-pill fw-bold mb-2">
                        <i class="bi bi-clipboard me-2"></i> SALIN DETAIL
                    </button>
                    <button class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
                <div class="modal-header border-0 px-4 pt-4">
                    <h5 class="fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm">
                    <input type="hidden" name="id_user" id="edit_id_user">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="email" id="edit_email" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Role Access</label>
                            <select name="role" id="edit_role" class="form-select rounded-3">
                                <option value="user">User</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="button" id="btnResetPassword" class="btn btn-outline-warning fw-bold py-2 rounded-3">
                                <i class="bi bi-key me-2"></i> RESET PASSWORD USER
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-dark w-100 py-3">SIMPAN PERUBAHAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const csrfToken = '<?= $_SESSION['csrf_token'] ?>';

        function prosesResetNotif(id, identifier) {
            alert("Silahkan cari user '" + identifier + "' pada tabel, lalu klik tombol Edit (Kuning) > Reset Password.");
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-user-btn').forEach(btn => {
                btn.onclick = function() {
                    document.getElementById('edit_id_user').value = this.dataset.id;
                    document.getElementById('edit_username').value = this.dataset.username;
                    document.getElementById('edit_email').value = this.dataset.email;
                    document.getElementById('edit_role').value = this.dataset.role;
                    new bootstrap.Modal(document.getElementById('editUserModal')).show();
                };
            });

            document.getElementById('addUserForm').onsubmit = function(e) {
                e.preventDefault();
                const btn = this.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerText = "Memproses...";

                fetch('index.php?page=admin_dashboard&action=add_user', {
                        method: 'POST',
                        body: new FormData(this)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();

                            document.getElementById('res_username').value = data.data.username;
                            document.getElementById('res_password').value = data.data.password;
                            document.getElementById('res_email').value = data.data.email;

                            new bootstrap.Modal(document.getElementById('successAccountModal')).show();

                            document.getElementById('addUserForm').reset();
                        } else {
                            alert(data.message);
                        }
                    }).finally(() => {
                        btn.disabled = false;
                        btn.innerText = "SIMPAN & GENERATE AKSES";
                    });
            };

            const successModalEl = document.getElementById('successAccountModal');
            successModalEl.addEventListener('hidden.bs.modal', function() {
                location.reload();
            });

            document.getElementById('editUserForm').onsubmit = function(e) {
                e.preventDefault();
                fetch('index.php?page=admin_dashboard&action=edit_user&id=' + document.getElementById('edit_id_user').value, {
                    method: 'POST',
                    body: new FormData(this)
                }).then(res => res.json()).then(data => {
                    if (data.status === 'success') location.reload();
                    else alert(data.message);
                });
            };

            document.getElementById('btnResetPassword').onclick = function() {
                if (confirm("Reset password user ini?")) {
                    const fd = new FormData();
                    fd.append('csrf_token', csrfToken);
                    fetch('index.php?page=admin_dashboard&action=reset_password&id=' + document.getElementById('edit_id_user').value, {
                        method: 'POST',
                        body: fd
                    }).then(res => res.json()).then(data => {
                        if (data.status === 'success') {
                            bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
                            document.getElementById('res_username').value = data.data.username;
                            document.getElementById('res_email').value = data.data.email;
                            document.getElementById('res_password').value = data.data.password;
                            new bootstrap.Modal(document.getElementById('successAccountModal')).show();
                        }
                    });
                }
            };
            document.getElementById('btnCopyAll').onclick = function() {
                const text = `Detail Akun Activity Digital:\n` +
                    `Username : ${document.getElementById('res_username').value}\n` +
                    `Email    : ${document.getElementById('res_email').value}\n` +
                    `Password : ${document.getElementById('res_password').value}`;

                navigator.clipboard.writeText(text).then(() => {
                    this.innerHTML = '<i class="bi bi-check-circle me-2"></i>BERHASIL DISALIN';
                    setTimeout(() => {
                        this.innerHTML = '<i class="bi bi-clipboard me-2"></i>SALIN DETAIL';
                    }, 2000);
                });
            };
        });

        function deleteUser(id) {
            if (confirm('Hapus pengguna secara permanen?')) {
                const fd = new FormData();
                fd.append('csrf_token', csrfToken);
                fetch('index.php?page=admin_dashboard&action=delete_user&id=' + id, {
                        method: 'POST',
                        body: fd
                    })
                    .then(res => res.json()).then(data => {
                        if (data.status === 'success') location.reload();
                    });
            }
        }

        function updateRealtimeData() {
            fetch('index.php?page=admin_dashboard&action=get_json')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('stat-total-users').innerText = data.users.length;
                    document.getElementById('stat-total-activities').innerText = data.totalAktivitas;

                    let tableHtml = '';
                    data.users.forEach(user => {
                        const isOnline = (new Date().getTime() / 1000) - new Date(user.last_activity).getTime() / 1000 < 60;

                        tableHtml += `
                    <tr>
                        <td>... susun kembali HTML kolom User Info sesuai desain ...</td>
                        <td>${user.email}</td>
                        <td>... Badge Role ...</td>
                        <td>
                            ${isOnline ? 
                                '<span class="status-pill online"><div class="dot dot-pulse"></div> ONLINE</span>' : 
                                '<span class="status-pill offline"><div class="dot"></div> OFFLINE</span>'}
                        </td>
                        <td class="text-center">... Tombol Aksi ...</td>
                    </tr>`;
                    });
                    document.getElementById('user-table-body').innerHTML = tableHtml;

                    const notifWrapper = document.getElementById('notif-wrapper');
                    if (data.requests.length > 0) {
                        notifWrapper.innerHTML = `... susun kembali HTML notif-compact Anda ...`;
                    } else {
                        notifWrapper.innerHTML = '';
                    }
                });
        }

        setInterval(updateRealtimeData, 5000);
    </script>
</body>

</html>