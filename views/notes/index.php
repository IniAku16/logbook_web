<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-body: #f8f9fa;
            --primary-coffee: #2d1b14;
            --accent-gold: #c6a664;
            --soft-cream: #fdfaf7;
            --text-muted: #6c757d;
            --white: #ffffff;
            --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 30px rgba(45, 27, 20, 0.08);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--primary-coffee);
            line-height: 1.6;
        }

        .navbar-custom {
            background: var(--primary-coffee);
            padding: 1.5rem 0 5rem 0;
            margin-bottom: -4rem;
        }

        .brand-logo {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--white);
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo span {
            color: var(--accent-gold);
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 8px 15px;
            border-radius: 12px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: #dc3545;
            color: white;
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
        }

        .page-header {
            background: var(--white);
            padding: 2rem;
            border-radius: 24px;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .welcome-msg h2 {
            font-weight: 800;
            font-size: 24px;
            margin: 0;
            color: var(--primary-coffee);
        }

        .welcome-msg p {
            margin: 0;
            color: var(--text-muted);
            font-weight: 500;
        }

        .data-card {
            background: var(--white);
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            border: none;
        }

        .table-responsive {
            border-radius: 15px;
        }

        .table thead th {
            background: #fafafa;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px;
            border-bottom: 2px solid #f1f1f1;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            font-size: 14px;
            border-bottom: 1px solid #f8f9fa;
        }

        .badge-area {
            background: #f0f0f0;
            color: var(--primary-coffee);
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 11px;
        }

        .status-pill {
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
        }

        .status-selesai {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-proses {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-menunggu {
            background: #f5f5f5;
            color: #757575;
        }

        .btn-add {
            background: var(--accent-gold);
            color: var(--primary-coffee);
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 14px;
            border: none;
            transition: 0.3s;
        }

        .btn-add:hover {
            background: var(--primary-coffee);
            color: white;
            transform: translateY(-2px);
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-edit {
            background: #e3f2fd;
            color: #1976d2;
        }

        .btn-delete {
            background: #ffebee;
            color: #c62828;
        }

        .btn-edit:hover {
            background: #1976d2;
            color: white;
        }

        .btn-delete:hover {
            background: #c62828;
            color: white;
        }

        .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            background: var(--primary-coffee);
            color: white;
            border: none;
            padding: 20px 30px;
        }

        .modal-body {
            padding: 30px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #e0e0e0;
            background-color: #fcfcfc;
        }

        .form-control:focus {
            border-color: var(--accent-gold);
            box-shadow: none;
            background: #fff;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                text-align: center;
            }

            .btn-add {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar-custom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="brand-logo">
                    <i class="bi bi-journal-check"></i>
                    Activity<span>Digital.</span>
                </a>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white fw-medium d-none d-md-block">
                        <i class="bi bi-person-circle me-1 text-accent-gold"></i>
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </span>

                    <a href="index.php?page=logout" class="btn-logout" onclick="return confirm('Apakah anda ingin logout?')">
                        <i class="bi bi-power me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container content-wrapper">
        <div class="page-header">
            <div class="welcome-msg">
                <h2 id="shift-text">LOADING...</h2>
                <p>Selamat Datang, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> | Digital Activity System</p>
            </div>
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createNoteModal">
                <i class="bi bi-plus-lg me-2"></i>TAMBAH ACTIVITY BARU
            </button>
        </div>
        <div class="data-card">
            <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                <h6 class="fw-bold m-0"><i class="bi bi-list-task me-2"></i>Daftar Aktivitas Terkini</h6>
                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                    Total: <?= mysqli_num_rows($notes) ?> Data
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tanggal & Hari</th>
                            <th width="30%">Kegiatan</th>
                            <th>Area</th>
                            <th>Klasifikasi</th>
                            <th>Status</th>
                            <th>Material</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($notes) > 0):
                            while ($note = mysqli_fetch_assoc($notes)):
                                $target = $note['target'];
                                $statusClass = '';
                                if ($target == 'Selesai') $statusClass = 'status-selesai';
                                elseif ($target == 'Lanjut') $statusClass = 'status-proses';
                                else $statusClass = 'status-menunggu';
                        ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-bold"><?= date('d M Y', strtotime($note['date'])) ?></div>
                                        <div class="small text-muted text-uppercase"><?= date('l', strtotime($note['date'])) ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars($note['description']) ?></div>
                                    </td>
                                    <td><span class="badge-area"><?= htmlspecialchars($note['nama_area'] ?? 'N/A') ?></span></td>
                                    <td><span class="small fw-bold text-muted text-uppercase"><?= htmlspecialchars($note['jenis']) ?></span></td>
                                    <td>
                                        <span class="status-pill <?= $statusClass ?>"><?= $target ?></span>
                                    </td>
                                    <td>
                                        <div class="small fw-semibold">
                                            <i class="bi bi-box-seam me-1"></i><?= htmlspecialchars($note['material']) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="action-btn btn-edit btn-edit-trigger"
                                                data-id="<?= $note['id'] ?>"
                                                data-date="<?= $note['date'] ?>"
                                                data-desc="<?= htmlspecialchars($note['description'], ENT_QUOTES) ?>"
                                                data-area="<?= $note['id_area'] ?>"
                                                data-jenis="<?= $note['jenis'] ?>"
                                                data-target="<?= $note['target'] ?>"
                                                data-material="<?= htmlspecialchars($note['material'], ENT_QUOTES) ?>"
                                                data-bs-toggle="modal" data-bs-target="#editNoteModal">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="?page=user_dashboard&action=delete&id=<?= $note['id'] ?>"
                                                class="action-btn btn-delete"
                                                onclick="return confirm('Hapus data Activity ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile;
                        else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-25">
                                    <p class="text-muted fw-semibold">Belum ada aktivitas yang tercatat hari ini.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createNoteModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="?page=user_dashboard&action=create" method="POST" class="modal-content">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="modal-header">
                    <h5 class="fw-bold m-0">Entry Activity Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tanggal Aktivitas</label>
                            <input type="date" name="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Area Kerja</label>
                            <select name="id_area" class="form-select" required>
                                <option value="">Pilih Lokasi...</option>
                                <?php mysqli_data_seek($areas, 0);
                                while ($a = mysqli_fetch_assoc($areas)): ?>
                                    <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Deskripsi Pekerjaan</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Apa yang anda kerjakan?" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="jenis" class="form-select" required>
                                <option value="-">-Pilih Kategori-</option>
                                <option value="Check List-Routine">Routine Check</option>
                                <option value="Complain">Complain</option>
                                <option value="Perbaikan/Perawatan">Maintenance</option>
                                <option value="Ganti Baru">Replacement</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Status Target</label>
                            <select name="target" class="form-select" required>
                                <option value="-">-Pilih Status-</option>
                                <option value="Menunggu Proses">Menunggu</option>
                                <option value="Lanjut">Dalam Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Material / Suku Cadang</label>
                            <input type="text" name="material" class="form-control" placeholder="Contoh: Baut M6, Kabel, dsb." required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn-add w-100">SIMPAN ACTIVITY</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editNoteModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="formEdit" method="POST" class="modal-content">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="modal-header">
                    <h5 class="fw-bold m-0">Update Data Activity</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tanggal</label>
                            <input type="date" name="date" id="edit_date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Area</label>
                            <select name="id_area" id="edit_area" class="form-select" required>
                                <?php mysqli_data_seek($areas, 0);
                                while ($a = mysqli_fetch_assoc($areas)): ?>
                                    <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Deskripsi</label>
                            <textarea name="description" id="edit_desc" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Jenis</label>
                            <select name="jenis" id="edit_jenis" class="form-select" required>
                                <option value="-">-Pilih Kategori-</option>
                                <option value="Check List-Routine">Routine Check</option>
                                <option value="Complain">Complain</option>
                                <option value="Perbaikan/Perawatan">Maintenance</option>
                                <option value="Ganti Baru">Replacement</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="target" id="edit_target" class="form-select" required>
                                <option value="-">-Pilih Status-</option>
                                <option value="Menunggu Proses">Menunggu</option>
                                <option value="Lanjut">Dalam Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Material</label>
                            <input type="text" name="material" id="edit_material" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn-add w-100">UPDATE PERUBAHAN</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shiftText = document.getElementById('shift-text');
            const now = new Date().getHours();
            if (now >= 5 && now < 11) shiftText.innerHTML = '<i class="bi bi-brightness-high me-2 text-warning"></i>MORNING';
            else if (now >= 11 && now < 15) shiftText.innerHTML = '<i class="bi bi-sun-fill me-2 text-danger"></i>AFTERNOON';
            else if (now >= 15 && now < 19) shiftText.innerHTML = '<i class="bi bi-cloud-sun me-2 text-primary"></i>EVENING';
            else shiftText.innerHTML = '<i class="bi bi-moon-stars-fill me-2 text-indigo"></i>NIGHT SHIFT';
        });

        document.querySelectorAll('.btn-edit-trigger').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('formEdit').action = `?page=user_dashboard&action=update&id=${id}`;
                document.getElementById('edit_date').value = this.getAttribute('data-date');
                document.getElementById('edit_desc').value = this.getAttribute('data-desc');
                document.getElementById('edit_area').value = this.getAttribute('data-area');
                document.getElementById('edit_jenis').value = this.getAttribute('data-jenis');
                document.getElementById('edit_target').value = this.getAttribute('data-target');
                document.getElementById('edit_material').value = this.getAttribute('data-material');
            });
        });
    </script>
</body>

</html>