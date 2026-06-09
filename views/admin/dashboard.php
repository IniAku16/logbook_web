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
    <title>Dashboard Admin | Activity Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --bg-body: #F2EAE1;
            --milk-tea: #D4BDA9;
            --caramel: #A36B46;
            --espresso: #3A2318;
            --espresso-dark: #1F110B;
            --white: #FFFFFF;
            --accent-gold: #D4A352;
            --shadow-bold: 0 10px 25px rgba(31, 17, 11, 0.15);
            --border-solid: #C9B39F;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--espresso-dark);
            -webkit-font-smoothing: antialiased;
        }

        .top-nav {
            background: var(--espresso-dark);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-bottom: 4px solid var(--accent-gold);
        }

        .brand-logo {
            font-weight: 900;
            font-size: 24px;
            color: var(--white);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .brand-logo span {
            color: var(--accent-gold);
        }

        .main-container {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-title h1 {
            font-weight: 900;
            font-size: 40px;
            color: var(--espresso-dark);
            margin: 0;
            letter-spacing: -1px;
        }

        .header-title p {
            color: var(--caramel);
            font-weight: 700;
            font-size: 16px;
        }

        .btn-tambah {
            background: linear-gradient(90deg, #4F321C 0%, #A67C00 100%);
            color: var(--white);
            font-weight: 900;
            border-radius: 12px;
            padding: 14px 28px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 6px 15px rgba(79, 50, 28, 0.3);
            transition: all 0.3s ease;
        }

        .btn-tambah:hover {
            background: linear-gradient(90deg, #3A2318 0%, #8C6800 100%);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 50, 28, 0.4);
        }

        .stat-card {
            background: var(--white);
            border: 3px solid var(--border-solid);
            border-radius: 20px;
            padding: 25px 35px;
            box-shadow: var(--shadow-bold);
            display: flex;
            align-items: center;
            gap: 25px;
            width: fit-content;
            transition: transform 0.3s ease, border-color 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--caramel);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            background: var(--espresso);
            color: var(--white);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 900;
            color: var(--caramel);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .stat-value {
            font-size: 40px;
            font-weight: 900;
            color: var(--espresso-dark);
            line-height: 1;
            margin-top: 5px;
        }

        .table-wrapper {
            background: var(--white);
            border-radius: 24px;
            padding: 35px;
            box-shadow: var(--shadow-bold);
            border: 2px solid var(--border-solid);
            margin-top: 30px;
        }

        .table th {
            font-weight: 900;
            color: var(--espresso-dark);
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
            border-bottom: 3px solid var(--espresso-dark);
            padding-bottom: 15px;
        }

        .table td {
            vertical-align: middle;
            font-weight: 700;
            color: var(--espresso-dark);
            padding: 15px 10px;
            border-bottom: 1px solid var(--border-solid);
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--espresso-dark);
            color: var(--accent-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 20px;
        }

        .btn-action {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: 0.3s;
            border: 2px solid transparent;
        }

        .btn-edit {
            background: #FFE0B2;
            color: #E65100;
            font-size: 18px;
        }

        .btn-edit:hover {
            border-color: #E65100;
        }

        .btn-delete {
            background: #FFCDD2;
            color: #B71C1C;
            font-size: 18px;
        }

        .btn-delete:hover {
            border-color: #B71C1C;
        }

        .status-active {
            color: #1B5E20;
            font-weight: 900;
            background: #C8E6C9;
            padding: 8px 16px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            border: 2px solid #4CAF50;
        }

        .status-offline {
            color: #424242;
            font-weight: 900;
            background: #E0E0E0;
            padding: 8px 16px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            font-size: 13px;
            border: 2px solid #9E9E9E;
        }

        .dot-pulse {
            width: 10px;
            height: 10px;
            background: #4CAF50;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(76, 175, 80, 1);
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

        .badge-role {
            font-size: 13px;
            padding: 8px 14px;
            font-weight: 900;
            border-radius: 8px;
            text-transform: uppercase;
        }

        .modal-content {
            border: 3px solid var(--espresso);
            border-radius: 20px;
        }

        .modal-title {
            color: var(--espresso-dark);
            font-weight: 900;
            font-size: 24px;
        }

        .form-label {
            font-weight: 800;
            color: var(--espresso-dark);
        }

        .form-control,
        .form-select {
            border: 2px solid var(--border-solid);
            font-weight: 600;
            color: var(--espresso-dark);
            border-radius: 10px;
            padding: 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--caramel);
            box-shadow: none;
        }

        .dataTables_length select {
            padding: 5px 30px 5px 10px !important;
        }

        .dataTables_filter input {
            border: 2px solid var(--border-solid) !important;
            border-radius: 10px !important;
        }

        .paginate_button.active .page-link {
            background-color: var(--espresso) !important;
            border-color: var(--espresso) !important;
        }
    </style>
</head>

<body>
    <nav class="top-nav">
        <a href="#" class="brand-logo">ACTIVITY <span>DIGITAL.</span></a>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-md-block text-white">
                <div style="font-size: 11px; font-weight: 900; color: var(--accent-gold); letter-spacing: 1.5px;">AUTHENTICATED ADMIN</div>
                <div style="font-size: 16px; font-weight: 900;"><?= htmlspecialchars($_SESSION['username']) ?></div>
            </div>
            <a href="index.php?page=logout" class="btn-action btn-delete" onclick="return confirm('Apakah anda ingin logout?')">
                <i class="bi bi-power"></i>
            </a>
        </div>
    </nav>

    <div class="main-container">
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div class="header-title">
                <h1>User Management</h1>
                <p class="mb-0">Pengaturan akses sistem dan monitoring aktivitas pengguna.</p>
            </div>
            <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus-lg me-2 fw-bold"></i> TAMBAH PENGGUNA
            </button>
        </div>

        <div class="container-fluid px-0 mb-4">
            <div class="d-flex gap-3">
                <a href="index.php?page=admin_dashboard" class="btn btn-dark shadow-sm" style="font-weight: 800; border-radius: 12px; padding: 12px 25px;">
                    <i class="bi bi-people-fill me-2"></i> User Management
                </a>
                <a href="index.php?page=admin_dashboard&action=monitoring" class="btn btn-outline-dark shadow-sm" style="font-weight: 800; border-radius: 12px; padding: 12px 25px; border-width: 2px;">
                    <i class="bi bi-graph-up-arrow me-2"></i> Monitoring Aktivitas
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-auto d-flex flex-wrap gap-4">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="stat-label">Total Terdaftar</div>
                        <div class="stat-value" id="total-users-count"><?= count($users) ?></div>
                    </div>
                </div>
                <div class="stat-card" onclick="window.location.href='index.php?page=admin_dashboard&action=all_activities'">
                    <div class="stat-icon" style="background: var(--caramel);"><i class="bi bi-journal-check"></i></div>
                    <div>
                        <div class="stat-label">Total Aktivitas</div>
                        <div class="stat-value"><?= $totalAktivitasSistem ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table id="userTable" class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>User Profile</th>
                        <th>Email Address</th>
                        <th>Access Role</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar">
                                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                    </div>
                                    <span style="font-weight: 900; font-size: 16px;"><?= htmlspecialchars($user['username']) ?></span>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><span class="badge <?= $user['role'] == 'admin' ? 'bg-dark' : 'bg-secondary' ?> badge-role"><?= strtoupper($user['role']) ?></span></td>
                            <td id="status-container-<?= $user['id_user'] ?>">
                                <?php if ($user['last_activity'] && strtotime($user['last_activity']) > time() - 60): ?>
                                    <div class="status-active">
                                        <div class="dot-pulse"></div> ONLINE
                                    </div>
                                <?php else: ?>
                                    <div class="status-offline">OFFLINE</div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn-action btn-edit edit-user-btn"
                                    data-id="<?= $user['id_user'] ?>"
                                    data-username="<?= htmlspecialchars($user['username']) ?>"
                                    data-email="<?= htmlspecialchars($user['email']) ?>"
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

    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 mt-2 mx-2">
                    <h5 class="modal-title">Buat Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addUserForm">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Contoh: andi_setiawan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@website.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role Access</label>
                            <select name="role" class="form-select" required>
                                <option value="">- Silahkan Pilih Role -</option>
                                <option value="user">User</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn-tambah w-100" style="padding: 16px;">SIMPAN PENGGUNA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" style="color: #1F110B;">Detail Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Detail akun berikut siap dikirimkan kepada pengguna:</p>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Username</label>
                        <input type="text" id="res_username" class="form-control bg-light border-0 py-2" readonly style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Email</label>
                        <input type="text" id="res_email" class="form-control bg-light border-0 py-2" readonly style="border-radius: 10px;">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-secondary">Password Default</label>
                        <input type="text" id="res_password" class="form-control bg-light border-0 py-2 fw-bold" readonly style="border-radius: 10px; color: #A36B46;">
                    </div>

                    <button class="btn w-100 py-3 text-white fw-bold mb-2 shadow-sm"
                        style="border-radius: 12px; background: #A36B46; border:none;"
                        onclick="copyToClipboard()">
                        <i class="bi bi-clipboard-check me-2"></i> Salin Semua Detail Akun
                    </button>
                    <button class="btn btn-light w-100 py-3 fw-bold border" style="border-radius: 12px;" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 mt-2 mx-2">
                    <h5 class="modal-title">Update Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm">
                    <input type="hidden" name="id_user" id="edit_id_user">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span> <br><small class="text-muted fw-normal">Kosongkan jika tidak diubah</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role Access</label>
                            <select name="role" id="edit_role" class="form-select">
                                <option value="user">User</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn-tambah w-100" style="padding: 16px;">SIMPAN PERUBAHAN</button>
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
                    const newTableBody = doc.getElementById('user-table-body');
                    const newTotalUsers = doc.getElementById('total-users-count');

                    if (newTableBody) {
                        document.getElementById('user-table-body').innerHTML = newTableBody.innerHTML;
                        initEditButtons();
                    }
                    if (newTotalUsers) {
                        document.getElementById('total-users-count').innerText = newTotalUsers.innerText;
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initEditButtons();

            navigator.clipboard.writeText(text).then(() => {
                const btn = event.currentTarget;
                const originalHtml = btn.innerHTML;
                btn.style.background = "#38a169";
                btn.innerHTML = '<i class="bi bi-check-all me-2"></i> Berhasil Disalin!';
                setTimeout(() => {
                    btn.style.background = "#A36B46";
                    btn.innerHTML = originalHtml;
                }, 2000);
            });


            document.getElementById('addUserForm').onsubmit = function(e) {
                e.preventDefault();
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerText = "MEMPROSES...";

                fetch('index.php?page=admin_dashboard&action=add_user', {
                        method: 'POST',
                        body: new FormData(this)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
                            document.getElementById('res_username').value = data.data.username;
                            document.getElementById('res_email').value = data.data.email;
                            document.getElementById('res_password').value = data.data.password;

                            new bootstrap.Modal(document.getElementById('successAccountModal')).show();
                            this.reset();
                        } else {
                            alert(data.message);
                        }
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerText = "SIMPAN PENGGUNA";
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
                    }).catch(() => console.log('Simulasi edit submit'));
            };
        });

        function deleteUser(id) {
            if (confirm('Hapus pengguna ini secara permanen?')) {
                const fd = new FormData();
                fd.append('csrf_token', csrfToken);
                fetch('index.php?page=admin_dashboard&action=delete_user&id=' + id, {
                    method: 'POST',
                    body: fd
                }).then(res => res.json()).then(data => {
                    alert(data.message);
                    if (data.status === 'success') location.reload();
                }).catch(() => console.log('Simulasi delete'));
            }
        }
    </script>
</body>

</html>