<?php
$activePage = 'admin';
$users = $users ?? [];

if (isset($_SESSION['id_user']) && isset($_GET['update_activity'])) {
    $userModel->updateLastActivity($_SESSION['id_user']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Panel | Activity Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-body: #ece3db;
            --milk-tea: #d4bda9;
            --caramel: #967259;
            --espresso: #2d1b14;
            --white: #ffffff;
            --accent-gold: #c6a664;
            --shadow-bold: 0 15px 35px rgba(45, 27, 20, 0.15);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--espresso);
        }

        .top-nav {
            background: var(--espresso);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .brand-logo {
            font-weight: 800;
            font-size: 22px;
            color: var(--white);
            text-decoration: none;
            letter-spacing: -1px;
        }

        .brand-logo span {
            color: var(--accent-gold);
        }

        .main-container {
            padding: 40px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-title h1 {
            font-weight: 800;
            font-size: 38px;
            color: var(--espresso);
            margin: 0;
            letter-spacing: -1.5px;
        }

        .stat-card {
            background: var(--white);
            border: 2px solid var(--milk-tea);
            border-radius: 24px;
            padding: 25px 35px;
            box-shadow: var(--shadow-bold);
            display: flex;
            align-items: center;
            gap: 25px;
            width: fit-content;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--espresso), var(--caramel));
            color: var(--white);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 8px 20px rgba(45, 27, 20, 0.3);
        }

        .stat-label {
            font-size: 14px;
            font-weight: 800;
            color: var(--caramel);
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 900;
            color: var(--espresso);
            line-height: 1;
        }

        .table-wrapper {
            background: var(--white);
            border-radius: 30px;
            padding: 35px;
            box-shadow: var(--shadow-bold);
            border: 1px solid rgba(255, 255, 255, 0.8);
            margin-top: 30px;
        }

        .table thead th {
            color: var(--espresso);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 13px;
            padding: 20px;
            background-color: #f8f5f2;
            border-bottom: 3px solid var(--milk-tea);
        }

        .table tbody td {
            padding: 20px;
            font-weight: 600;
            border-bottom: 1px solid #eeeae6;
            vertical-align: middle;
        }

        .role-badge {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .badge-admin {
            background: var(--espresso);
            color: var(--white);
        }

        .badge-user {
            background: var(--milk-tea);
            color: var(--espresso);
        }

        .status-active {
            color: #1b5e20;
            font-weight: 800;
            background: #e8f5e9;
            padding: 6px 14px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .dot-pulse {
            width: 8px;
            height: 8px;
            background: #4caf50;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(76, 175, 80, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(76, 175, 80, 0);
            }
        }

        .btn-add-user {
            background: var(--espresso);
            color: var(--white) !important;
            border-radius: 16px;
            padding: 15px 30px;
            font-weight: 800;
            border: none;
            box-shadow: 0 10px 20px rgba(45, 27, 20, 0.25);
            transition: 0.3s;
        }

        .btn-add-user:hover {
            background: var(--caramel);
            transform: translateY(-3px);
        }

        .btn-latte {
            background: var(--espresso);
            color: white;
            font-weight: 800;
            border-radius: 14px;
            padding: 12px;
            border: none;
            transition: 0.3s;
        }

        .btn-latte:hover {
            background: var(--caramel);
            color: white;
        }

        .btn-action {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: 0.3s;
            border: 2px solid transparent;
        }

        .btn-edit {
            background: #fff3e0;
            color: #ef6c00;
        }

        .btn-edit:hover {
            background: #ef6c00;
            color: white;
        }

        .btn-delete {
            background: #ffebee;
            color: #c62828;
        }

        .btn-delete:hover {
            background: #c62828;
            color: white;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid #eeeae6;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: var(--caramel);
            box-shadow: none;
        }

        .modal-content {
            border-radius: 28px;
            border: none;
            box-shadow: var(--shadow-bold);
        }
    </style>
</head>

<body>

    <nav class="top-nav">
        <a href="#" class="brand-logo">ACTIVITY <span>DIGITAL.</span></a>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-md-block text-white">
                <div style="font-size: 10px; font-weight: 800; color: var(--accent-gold); letter-spacing: 1px;">AUTHENTICATED ADMIN</div>
                <div style="font-size: 15px; font-weight: 800;"><?= htmlspecialchars($_SESSION['username']) ?></div>
            </div>
            <<a href="index.php?page=logout" class="btn-action btn-delete" onclick="return confirm('Apakah anda ingin logout?')">
                <i class="bi bi-power"></i>
                </a>
        </div>
    </nav>

    <div class="main-container">

        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div class="header-title">
                <h1>User Management</h1>
                <p class="mb-0" style="color: var(--caramel); font-weight: 700;">Pengaturan akses sistem dan monitoring aktivitas pengguna.</p>
            </div>
            <button class="btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-person-plus-fill me-2"></i> TAMBAH PENGGUNA
            </button>
        </div>

        <div class="container mt-4">
            <div class="d-flex gap-2">
                <a href="index.php?page=admin_dashboard" class="btn <?= !isset($_GET['action']) || $_GET['action'] == 'index' ? 'btn-latte' : 'btn-outline-dark' ?> shadow-sm">
                    <i class="bi bi-people me-2"></i> User Management
                </a>
                <a href="index.php?page=admin_dashboard&action=monitoring" class="btn <?= $_GET['action'] == 'monitoring' ? 'btn-latte' : 'btn-outline-dark' ?> shadow-sm">
                    <i class="bi bi-graph-up-arrow me-2"></i> Monitoring Aktivitas
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-auto">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="stat-label">Total Terdaftar</div>
                        <div class="stat-value" id="total-users-count"><?= count($users) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User Profile</th>
                            <th>Email Address</th>
                            <th>Access Role</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 48px; height: 48px; border-radius: 16px; background: var(--espresso); color: var(--white); display: flex; align-items: center; justify-content: center; font-weight: 800; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                            <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                        </div>
                                        <span style="font-weight: 800; font-size: 16px;"><?= htmlspecialchars($user['username']) ?></span>
                                    </div>
                                </td>
                                <td style="color: var(--caramel); font-weight: 700;"><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="role-badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                        <?= strtoupper($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $isOnline = ($user['last_activity'] && strtotime($user['last_activity']) > time() - 60);
                                    if ($isOnline): ?>
                                        <div class="status-active">
                                            <div class="dot-pulse"></div> Online
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted small fw-bold"><i class="bi bi-clock-history me-1"></i> Offline</div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn-action btn-edit edit-user-btn"
                                        data-id="<?= $user['id_user'] ?>"
                                        data-username="<?= $user['username'] ?>"
                                        data-email="<?= $user['email'] ?>"
                                        data-role="<?= $user['role'] ?>">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn-action btn-delete ms-1" onclick="deleteUser(<?= $user['id_user'] ?>)">
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
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-800" style="color: var(--espresso); font-size: 24px;">Buat Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addUserForm">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Contoh: biya " required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@website.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Role Access</label>
                            <select name="role" class="form-select">
                                <option value="-"> - Silahkan Pilih Role -</option>
                                <option value="user">User</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn-latte w-100">SIMPAN PENGGUNA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-800" style="color: var(--espresso); font-size: 24px;">Update Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm">
                    <input type="hidden" name="id_user" id="edit_id_user">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="modal-body p-4">
                        <div class="mb-3"><label class="form-label small fw-bold">Username</label><input type="text" name="username" id="edit_username" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label small fw-bold">Email Address</label><input type="email" name="email" id="edit_email" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label small fw-bold">Password (Kosongkan jika tidak diubah)</label><input type="password" name="password" class="form-control"></div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Role Access</label>
                            <select name="role" id="edit_role" class="form-select">
                                <option value="user">User</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn-latte w-100">SIMPAN PERUBAHAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const csrfToken = '<?= htmlspecialchars($_SESSION['csrf_token']) ?>';

        function initEditButtons() {
            document.querySelectorAll('.edit-user-btn').forEach(btn => {
                btn.onclick = function() {
                    document.getElementById('edit_id_user').value = this.dataset.id;
                    document.getElementById('edit_username').value = this.dataset.username;
                    document.getElementById('edit_email').value = this.dataset.email;
                    document.getElementById('edit_role').value = this.dataset.role;
                    new bootstrap.Modal(document.getElementById('editUserModal')).show();
                };
            });
        }

        function refreshData() {
            const currentUrl = window.location.href;
            const updateUrl = currentUrl + (currentUrl.includes('?') ? '&' : '?') + 'update_activity=1';
            fetch(updateUrl);
            fetch(currentUrl)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    document.getElementById('user-table-body').innerHTML = doc.getElementById('user-table-body').innerHTML;
                    document.getElementById('total-users-count').innerText = doc.getElementById('total-users-count').innerText;
                    initEditButtons();
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initEditButtons();
            setInterval(refreshData, 5000);

            document.getElementById('addUserForm').onsubmit = function(e) {
                e.preventDefault();
                fetch('index.php?page=admin_dashboard&action=add_user', {
                        method: 'POST',
                        body: new FormData(this)
                    })
                    .then(res => res.json()).then(data => {
                        alert(data.message);
                        if (data.status === 'success') location.reload();
                    });
            };

            document.getElementById('editUserForm').onsubmit = function(e) {
                e.preventDefault();
                const id = document.getElementById('edit_id_user').value;
                fetch('index.php?page=admin_dashboard&action=edit_user&id=' + id, {
                        method: 'POST',
                        body: new FormData(this)
                    })
                    .then(res => res.json()).then(data => {
                        alert(data.message);
                        if (data.status === 'success') location.reload();
                    });
            };
        });

        function deleteUser(id) {
            if (confirm('Hapus pengguna ini?')) {
                const fd = new FormData();
                fd.append('csrf_token', csrfToken);
                fetch('index.php?page=admin_dashboard&action=delete_user&id=' + id, {
                    method: 'POST',
                    body: fd
                }).then(res => res.json()).then(data => {
                    alert(data.message);
                    if (data.status === 'success') location.reload();
                }).catch(() => location.reload());
            }
        }
    </script>
</body>

</html>