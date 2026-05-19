<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Logbook System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #0f172a;
            --accent-blue: #3b82f6;
            --success-green: #10b981;
            --warning-orange: #f59e0b;
            --bg-body: #f8fafc;
            --text-main: #1e293b;
            --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            letter-spacing: -0.01em;
        }

        .top-navbar {
            background-color: var(--primary-dark);
            padding: 2rem 0 4rem 0;
            color: white;
            border-bottom: 4px solid var(--accent-blue);
        }

        .stats-overview {
            margin-top: -30px;
        }

        .main-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .table thead {
            background-color: #f1f5f9;
        }

        .table thead th {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 15px;
            border: none;
        }

        .table tbody tr {
            transition: all 0.2s;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            display: inline-block;
        }

        .bg-selesai {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .bg-proses {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .btn-action {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-tech {
            background-color: var(--accent-blue);
            border: none;
            color: white;
        }

        .btn-primary-tech:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-edit-tool {
            color: var(--accent-blue);
            background: #eff6ff;
            border: 1px solid #dbeafe;
        }

        .btn-edit-tool:hover {
            background: var(--accent-blue);
            color: white;
        }

        .form-control,
        .form-select {
            border: 1.5px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 0.95rem;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 6px;
            font-size: 0.85rem;
        }

        #welcome-text {
            font-weight: 800;
            font-size: 2.2rem;
            letter-spacing: -0.02em;
        }
    </style>
</head>

<body>

    <div class="top-navbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h1 id="welcome-text" class="mb-1 text-white">SYSTEM LOGBOOK</h1>
                    <p class="text-white-50 mb-0"><i class="bi bi-shield-check me-2"></i>Monitoring Aktivitas Operasional Real-time</p>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex justify-content-end align-items-center gap-2 flex-wrap">
                    <a href="index.php?page=logout" class="btn btn-action btn-outline-light border border-white border-opacity-25 text-white shadow-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                    <button class="btn btn-action btn-primary-tech shadow" data-bs-toggle="modal" data-bs-target="#createNoteModal">
                        <i class="bi bi-plus-lg"></i> ENTRY LOG BARU
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container stats-overview">
        <div class="card main-card">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                    <i class="bi bi-list-task me-2 text-primary"></i>Daftar Aktivitas Terkini
                </h6>
                <span class="badge bg-dark rounded-pill">Total: <?= mysqli_num_rows($notes) ?> Record</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">NO</th>
                            <th width="120">TANGGAL</th>
                            <th>DESKRIPSI KEGIATAN</th>
                            <th>AREA</th>
                            <th>JENIS</th>
                            <th>STATUS</th>
                            <th>MATERIAL</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($notes) > 0):
                            while ($note = mysqli_fetch_assoc($notes)):
                        ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted small"><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-bold"><?= date('d/m/Y', strtotime($note['date'])) ?></div>
                                        <small class="text-uppercase text-muted" style="font-size: 10px;"><?= date('l', strtotime($note['date'])) ?></small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= htmlspecialchars($note['description']) ?></div>
                                    </td>
                                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-1 px-2"><?= htmlspecialchars($note['nama_area'] ?? 'N/A') ?></span></td>
                                    <td class="small fw-medium"><?= htmlspecialchars($note['jenis']) ?></td>
                                    <td>
                                        <?php
                                        $target = $note['target'];
                                        $class = ($target == 'Selesai') ? 'bg-selesai' : 'bg-proses';
                                        echo "<span class='badge-status $class'>$target</span>";
                                        ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center small">
                                            <i class="bi bi-tools me-2 text-muted"></i>
                                            <?= htmlspecialchars($note['material']) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-edit-tool btn-edit"
                                                data-id="<?= $note['id'] ?>"
                                                data-date="<?= $note['date'] ?>"
                                                data-desc="<?= htmlspecialchars($note['description'], ENT_QUOTES) ?>"
                                                data-area="<?= $note['id_area'] ?>"
                                                data-jenis="<?= $note['jenis'] ?>"
                                                data-target="<?= $note['target'] ?>"
                                                data-material="<?= htmlspecialchars($note['material'], ENT_QUOTES) ?>"
                                                data-bs-toggle="modal" data-bs-target="#editNoteModal">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <a href="?page=user_dashboard&action=delete&id=<?= $note['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data secara permanen?')">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile;
                        else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3">
                                    <p class="text-muted fw-bold">Belum ada data aktivitas terdaftar.</p>
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
            <form action="?page=user_dashboard&action=create" method="POST" class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white border-0">
                    <h5 class="fw-bold mb-0 ml-2">FORM INPUT AKTIVITAS</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label>Tanggal Pelaksanaan</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Lokasi / Area Kerja</label>
                            <select name="id_area" class="form-select" required>
                                <option value="">- Pilih Area -</option>
                                <?php mysqli_data_seek($areas, 0);
                                while ($a = mysqli_fetch_assoc($areas)): ?>
                                    <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label>Deskripsi Detail Pekerjaan</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail aktivitas..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Klasifikasi Pekerjaan</label>
                            <select name="jenis" class="form-select" required>
                                <option value="">- Pilih Pekerjaan -</option>
                                <option value="Check List-Routine">Check List-Routine</option>
                                <option value="Complain">Complain</option>
                                <option value="Perbaikan/Perawatan">Perbaikan/Perawatan</option>
                                <option value="Ganti Baru">Ganti Baru</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Target Status</label>
                            <select name="target" class="form-select" required>
                                <option value="">- Pilih Status -</option>
                                <option value="Menunggu Proses">Menunggu Proses</option>
                                <option value="Lanjut">Lanjut</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label>Penggunaan Material / Suku Cadang</label>
                            <input type="text" name="material" class="form-control" placeholder="Contoh: Breaker 16A, Kabel NYM 2x1.5, dsb." required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-tech px-5">SIMPAN DATA</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editNoteModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="formEdit" method="POST" class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2"></i>UPDATE DATA LOGBOOK</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label>Tanggal</label>
                            <input type="date" name="date" id="edit_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Area</label>
                            <select name="id_area" id="edit_area" class="form-select" required>
                                <?php mysqli_data_seek($areas, 0);
                                while ($a = mysqli_fetch_assoc($areas)): ?>
                                    <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label>Deskripsi</label>
                            <textarea name="description" id="edit_desc" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Jenis</label>
                            <select name="jenis" id="edit_jenis" class="form-select" required>
                                <option value="">- Pilih Pekerjaan -</option>
                                <option value="Check List-Routine">Check List-Routine</option>
                                <option value="Complain">Complain</option>
                                <option value="Perbaikan/Perawatan">Perbaikan/Perawatan</option>
                                <option value="Ganti Baru">Ganti Baru</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Target Status</label>
                            <select name="target" id="edit_target" class="form-select" required>
                                <option value="">- Pilih Status -</option>
                                <option value="Menunggu Proses">Menunggu Proses</option>
                                <option value="Lanjut">Lanjut</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label>Material</label>
                            <input type="text" name="material" id="edit_material" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="submit" class="btn btn-primary-tech w-100 py-3 text-uppercase fw-bold">Update Perubahan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const welcomeText = document.getElementById('welcome-text');
            const now = new Date().getHours();
            let greeting = "LOGBOOK SYSTEM";

            if (now >= 5 && now < 11) greeting = "MORNING SHIFT";
            else if (now >= 11 && now < 15) greeting = "AFTERNOON SHIFT";
            else if (now >= 15 && now < 19) greeting = "EVENING SHIFT";
            else greeting = "NIGHT SHIFT";

            welcomeText.innerText = greeting;
        });

        document.querySelectorAll('.btn-edit').forEach(button => {
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