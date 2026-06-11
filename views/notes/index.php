<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Digital | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-body: #f8f9fa;
            --primary-coffee: #2d1b14;
            --deep-coffee: #4a2c1b;
            --accent-gold: #b8860b;
            --soft-gold: #fdf5e6;
            --primary-gradient: linear-gradient(135deg, #4a2c1b 0%, #b8860b 100%);
            --text-dark: #2d1b14;
            --text-muted: #7d6b63;
            --white: #ffffff;
            --input-border: #e2d9d5;
            --shadow-sm: 0 5px 15px rgba(74, 44, 27, 0.05);
            --shadow-md: 0 10px 25px rgba(74, 44, 27, 0.08);
            --shadow-bold: 0 20px 40px -5px rgba(74, 44, 27, 0.12);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .navbar-custom {
            background: var(--primary-coffee);
            padding: 1rem 0 3.5rem 0;
            border-bottom: 4px solid var(--accent-gold);
        }

        .brand-logo {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo span {
            color: var(--accent-gold);
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            transition: 0.3s;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-logout:hover {
            background: #e63946;
            color: white;
            transform: translateY(-2px);
        }

        .content-wrapper {
            margin-top: -2.5rem;
            padding-bottom: 50px;
        }

        .page-header {
            background: var(--white);
            padding: 1.5rem 2rem;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .welcome-msg h2 {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--deep-coffee);
            margin-bottom: 5px;
        }

        .data-card {
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow-bold);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .filter-section {
            padding: 1.5rem;
            background: #fff;
            border-bottom: 1px solid #eee;
        }

        .search-box .form-control {
            border-radius: 12px;
            padding: 12px 15px 12px 45px;
            border: 2px solid #f1f1f1;
            font-weight: 600;
        }

        .table thead th {
            background: #fafafa;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 15px;
            border-bottom: 2px solid #eee;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f8f9fa;
        }

        .status-pill {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 10px;
            text-transform: uppercase;
        }

        .status-selesai {
            background: #dcfce7;
            color: #15803d;
        }

        .status-proses {
            background: #fef9c3;
            color: #a16207;
        }

        .status-menunggu {
            background: #f1f5f9;
            color: #475569;
        }

        .row-number {
            width: 32px;
            height: 32px;
            background: var(--soft-gold);
            color: var(--accent-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: 800;
        }

        .btn-add {
            background: var(--primary-gradient);
            color: white;
            font-weight: 700;
            padding: 12px 25px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(74, 44, 27, 0.2);
            transition: 0.3s;
        }

        .btn-add:hover {
            transform: translateY(-3px);
            color: white;
            filter: brightness(1.1);
        }

        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-edit {
            background: #fffbeb;
            color: #d97706;
        }

        .btn-delete {
            background: #fef2f2;
            color: #dc2626;
        }

        .btn-edit:hover {
            background: #d97706;
            color: #fff;
        }

        .btn-delete:hover {
            background: #dc2626;
            color: #fff;
        }

        .modal-content {
            border-radius: 24px;
            border: none;
        }

        .modal-header {
            border-radius: 24px 24px 0 0;
            padding: 20px 30px;
        }

        .photo-btn {
            padding: 4px 10px;
            font-weight: 800;
            font-size: 11px;
            border-radius: 6px;
        }

        #imgPreview {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 12px;
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
                    <div class="text-white d-none d-md-block text-end">
                        <small class="d-block opacity-50 fw-bold" style="font-size: 10px;">USER</small>
                        <span class="fw-bold"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                    </div>
                    <a href="index.php?page=logout" class="btn-logout" onclick="return confirm('Logout dari sistem?')">
                        <i class="bi bi-box-arrow-right me-2"></i>LOGOUT
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container content-wrapper">
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="welcome-msg">
                <h2 id="shift-text">LOADING...</h2>
                <p class="text-muted mb-0 fw-semibold">Kelola dan pantau aktivitas maintenance harian Anda.</p>
            </div>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-light border fw-bold rounded-pill px-4 dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-download me-2"></i>EXPORT
                    </button>
                    <ul class="dropdown-menu shadow border-0">
                        <li><a class="dropdown-item fw-600" href="index.php?page=user_dashboard&action=export_excel"><i class="bi bi-file-earmark-excel text-success me-2"></i>Excel Spreadsheets</a></li>
                        <li><a class="dropdown-item fw-600" href="index.php?page=user_dashboard&action=export_pdf"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>PDF Document</a></li>
                    </ul>
                </div>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createNoteModal">
                    <i class="bi bi-plus-lg me-2"></i>TAMBAH AKTIVITAS
                </button>
            </div>
        </div>

        <div class="data-card">
            <div class="filter-section d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="search-box flex-grow-1" style="max-width: 400px; position: relative;">
                    <i class="bi bi-search" style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari kegiatan atau area...">
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted fw-bold small">Tampilkan:</span>
                    <select id="entriesPerPage" class="form-select form-select-sm fw-bold border-0 bg-light rounded-3" style="width: 80px;">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th width="150">Waktu</th>
                            <th width="30%">Aktivitas</th>
                            <th>Area</th>
                            <th>Material</th>
                            <th>Dokumentasi</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php
                        if (mysqli_num_rows($notes) > 0):
                            $no = 1;
                            while ($note = mysqli_fetch_assoc($notes)):
                                $statusClass = ($note['target'] == 'Selesai') ? 'status-selesai' : (($note['target'] == 'Lanjut') ? 'status-proses' : 'status-menunggu');
                        ?>
                                <tr class="data-row">
                                    <td class="text-center"><span class="row-number"><?= $no++ ?></span></td>
                                    <td>
                                        <div class="fw-bold"><?= date('d/m/Y', strtotime($note['date'])) ?></div>
                                        <small class="text-muted fw-bold text-uppercase"><?= date('l', strtotime($note['date'])) ?></small>
                                    </td>
                                    <td>
                                        <div class="fw-bold mb-1"><?= htmlspecialchars($note['description']) ?></div>
                                        <span class="badge bg-light text-muted border fw-bold" style="font-size: 9px;"><?= htmlspecialchars($note['jenis']) ?></span>
                                    </td>
                                    <td><span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill fw-bold" style="font-size: 11px;"><?= htmlspecialchars($note['nama_area'] ?? 'N/A') ?></span></td>
                                    <td class="text-muted fw-semibold small"><?= htmlspecialchars($note['material']) ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if (!empty($note['foto_before'])): ?>
                                                <button type="button" class="btn btn-sm btn-outline-primary photo-btn view-foto-btn"
                                                    data-img="/logbook_web/public/uploads/<?= $note['foto_before'] ?>" title="Lihat Foto Before">
                                                    BEFORE
                                                </button>
                                            <?php endif; ?>
                                            <?php if (!empty($note['foto_after'])): ?>
                                                <button type="button" class="btn btn-sm btn-outline-success photo-btn view-foto-btn"
                                                    data-img="/logbook_web/public/uploads/<?= $note['foto_after'] ?>" title="Lihat Foto After">
                                                    AFTER
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted opacity-50 small fw-bold">No After</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><span class="status-pill <?= $statusClass ?>"><?= $note['target'] ?></span></td>
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
                                                data-foto-before="<?= $note['foto_before'] ?>"
                                                data-bs-toggle="modal" data-bs-target="#editNoteModal">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="?page=user_dashboard&action=delete&id=<?= $note['id'] ?>" class="action-btn btn-delete" onclick="return confirm('Hapus permanen data ini?')">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile;
                        else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/amber/no-data-found.svg" style="width: 150px;" class="mb-3 opacity-50">
                                    <div class="text-muted fw-bold">Belum ada data aktivitas hari ini.</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination-footer p-4 border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="pagination-info fw-bold text-muted small" id="paginationInfo">
                    Menampilkan 0 - 0 dari 0 data
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0 gap-1" id="paginationControls"></ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createNoteModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="?page=user_dashboard&action=create" method="POST" class="modal-content" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="modal-header bg-dark text-white">
                    <h5 class="fw-800 m-0"><i class="bi bi-plus-circle me-2 text-warning"></i>Input Aktivitas Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">TANGGAL</label>
                            <input type="date" name="date" class="form-control" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">AREA KERJA</label>
                            <select name="id_area" class="form-select" required>
                                <option value="">Pilih Area...</option>
                                <?php mysqli_data_seek($areas, 0);
                                while ($a = mysqli_fetch_assoc($areas)): ?>
                                    <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">DESKRIPSI PEKERJAAN</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan detail pekerjaan..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">KATEGORI</label>
                            <select name="jenis" class="form-select" required>
                                <option value="Check List-Routine">Check List-Routine</option>
                                <option value="Complain">Complain</option>
                                <option value="Perbaikan/Perawatan">Perbaikan/Perawatan</option>
                                <option value="Ganti Baru">Ganti Baru</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">STATUS AWAL</label>
                            <select name="target" class="form-select" required>
                                <option value="Menunggu Proses">Menunggu Proses</option>
                                <option value="Lanjut">Lanjut</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">FOTO BEFORE</label>
                            <input type="file" class="form-control" name="foto_before" accept="image/*" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">MATERIAL / SPAREPART</label>
                            <input type="text" name="material" class="form-control" placeholder="Gunakan tanda koma (,) jika lebih dari satu" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-add w-100 mt-4 py-3">SIMPAN DATA AKTIVITAS</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editNoteModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="formEdit" method="POST" class="modal-content" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="modal-header" style="background: var(--accent-gold);">
                    <h5 class="fw-800 m-0 text-dark"><i class="bi bi-pencil-square me-2"></i>Update Aktivitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">TANGGAL</label>
                            <input type="date" name="date" id="edit_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">AREA</label>
                            <select name="id_area" id="edit_area" class="form-select" required>
                                <?php mysqli_data_seek($areas, 0);
                                while ($a = mysqli_fetch_assoc($areas)): ?>
                                    <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">DESKRIPSI</label>
                            <textarea name="description" id="edit_desc" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">JENIS</label>
                            <select name="jenis" id="edit_jenis" class="form-select" required>
                                <option value="Check List-Routine">Check List-Routine</option>
                                <option value="Complain">Complain</option>
                                <option value="Perbaikan/Perawatan">Perbaikan/Perawatan</option>
                                <option value="Ganti Baru">Ganti Baru</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">STATUS PROGRES</label>
                            <select name="target" id="edit_target" class="form-select" required>
                                <option value="Menunggu Proses">Menunggu Proses</option>
                                <option value="Lanjut">Lanjut</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">FOTO BEFORE (PREVIEW)</label>
                            <div id="preview_before_container" class="mb-2">
                                <img id="edit_view_before" src="" class="img-thumbnail" style="height: 100px; display: none;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-success">UPLOAD FOTO AFTER (FINISH)</label>
                            <input type="file" class="form-control border-success" name="foto_after" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">MATERIAL</label>
                            <input type="text" name="material" id="edit_material" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-add w-100 mt-4 py-3">SIMPAN PERUBAHAN</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 text-center">
                <div class="modal-body p-0 position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" style="z-index: 999;"></button>
                    <img src="" id="imgPreview" alt="Foto Aktivitas" class="shadow-lg border border-3 border-white">
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <a href="" id="downloadBtn" download class="btn btn-warning fw-bold px-4 rounded-pill shadow">
                        <i class="bi bi-cloud-download me-2"></i>DOWNLOAD FOTO
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let allRows = [];
        let filteredRows = [];
        let currentPage = 1;
        let entriesPerPage = 10;

        document.addEventListener('DOMContentLoaded', function() {
            const shiftText = document.getElementById('shift-text');
            const hrs = new Date().getHours();
            if (hrs >= 5 && hrs < 11) shiftText.innerHTML = '<i class="bi bi-brightness-high me-2 text-warning"></i>GOOD MORNING';
            else if (hrs >= 11 && hrs < 15) shiftText.innerHTML = '<i class="bi bi-sun-fill me-2 text-danger"></i>GOOD AFTERNOON';
            else if (hrs >= 15 && hrs < 19) shiftText.innerHTML = '<i class="bi bi-cloud-sun me-2 text-primary"></i>GOOD EVENING';
            else shiftText.innerHTML = '<i class="bi bi-moon-stars-fill me-2 text-indigo"></i>NIGHT SHIFT';

            const tableBody = document.getElementById('tableBody');
            allRows = Array.from(tableBody.querySelectorAll('tr.data-row'));
            filteredRows = [...allRows];
            updatePagination();

            document.getElementById('searchInput').addEventListener('input', function() {
                const q = this.value.toLowerCase();
                filteredRows = allRows.filter(row => row.textContent.toLowerCase().includes(q));
                currentPage = 1;
                updatePagination();
            });

            document.querySelectorAll('.view-foto-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const imgSrc = this.getAttribute('data-img');
                    const modalImg = document.getElementById('imgPreview');
                    const downloadBtn = document.getElementById('downloadBtn');

                    modalImg.src = imgSrc;
                    downloadBtn.href = imgSrc;

                    const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
                    photoModal.show();
                });
            });

            document.querySelectorAll('.btn-edit-trigger').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const fotoBefore = this.getAttribute('data-foto-before');

                    document.getElementById('formEdit').action = `?page=user_dashboard&action=update&id=${id}`;
                    document.getElementById('edit_date').value = this.getAttribute('data-date');
                    document.getElementById('edit_desc').value = this.getAttribute('data-desc');
                    document.getElementById('edit_area').value = this.getAttribute('data-area');
                    document.getElementById('edit_jenis').value = this.getAttribute('data-jenis');
                    document.getElementById('edit_target').value = this.getAttribute('data-target');
                    document.getElementById('edit_material').value = this.getAttribute('data-material');

                    const previewImg = document.getElementById('edit_view_before');
                    if (fotoBefore && fotoBefore !== 'null') {
                        previewImg.src = "/logbook_web/public/uploads/" + fotoBefore;
                        previewImg.style.display = 'block';
                    } else {
                        previewImg.style.display = 'none';
                    }
                });
            });
        });

        function updatePagination() {
            const totalPages = Math.ceil(filteredRows.length / entriesPerPage);
            if (currentPage > totalPages) currentPage = totalPages || 1;

            const start = (currentPage - 1) * entriesPerPage;
            const end = start + entriesPerPage;

            allRows.forEach(row => row.style.display = 'none');
            filteredRows.slice(start, end).forEach((row, i) => {
                row.style.display = '';
                row.querySelector('.row-number').textContent = start + i + 1;
            });

            renderControls(totalPages);
            document.getElementById('paginationInfo').textContent =
                `Menampilkan ${filteredRows.length ? start + 1 : 0} - ${Math.min(end, filteredRows.length)} dari ${filteredRows.length} data`;
        }

        function renderControls(total) {
            const container = document.getElementById('paginationControls');
            container.innerHTML = '';
            if (total <= 1) return;

            let html = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link shadow-sm border-0" href="#" onclick="changePage(${currentPage-1})">‹</a></li>`;
            for (let i = 1; i <= total; i++) {
                html += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link shadow-sm border-0" href="#" onclick="changePage(${i})">${i}</a></li>`;
            }
            html += `<li class="page-item ${currentPage === total ? 'disabled' : ''}"><a class="page-link shadow-sm border-0" href="#" onclick="changePage(${currentPage+1})">›</a></li>`;
            container.innerHTML = html;
        }

        function changePage(p) {
            currentPage = p;
            updatePagination();
            window.scrollTo({
                top: document.querySelector('.data-card').offsetTop - 100,
                behavior: 'smooth'
            });
        }

        document.getElementById('entriesPerPage').addEventListener('change', function() {
            entriesPerPage = parseInt(this.value);
            currentPage = 1;
            updatePagination();
        });
    </script>
</body>

</html>