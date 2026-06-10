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
            --bg-body: #fcfbfa;
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
            --shadow-md: 0 15px 35px rgba(74, 44, 27, 0.08);
            --shadow-bold: 0 20px 40px -5px rgba(74, 44, 27, 0.12);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        .navbar-custom {
            background: var(--primary-coffee);
            padding: 1rem 0 4rem 0;
            margin-bottom: -3.5rem;
            border-bottom: 4px solid var(--accent-gold);
        }

        .brand-logo {
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--white);
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo span {
            color: var(--accent-gold);
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            padding: 8px 18px;
            border-radius: 10px;
            transition: 0.3s;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-logout:hover {
            background: #e63946;
            border-color: #e63946;
            color: white;
            transform: translateY(-2px);
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            padding-bottom: 60px;
        }

        .page-header {
            background: var(--white);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(74, 44, 27, 0.05);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .welcome-msg h2 {
            font-weight: 800;
            font-size: 24px;
            color: var(--deep-coffee);
            margin: 0;
        }

        .welcome-msg p {
            margin: 0;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 14px;
        }

        .data-card {
            background: var(--white);
            border-radius: 24px;
            padding: 0;
            box-shadow: var(--shadow-bold);
            border: 1px solid rgba(74, 44, 27, 0.05);
            overflow: hidden;
        }

        .filter-section {
            padding: 1.5rem 2rem;
            background: #fdfaf8;
            border-bottom: 1px solid #f1ece9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 300px;
        }

        .search-box .form-control {
            border: 2px solid var(--input-border);
            border-radius: 12px;
            padding: 10px 15px 10px 45px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }

        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-box .form-control:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 4px rgba(184, 134, 11, 0.1);
        }

        .entries-control {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 13px;
            color: var(--text-muted);
        }

        .entries-control select {
            border: 2px solid var(--input-border);
            border-radius: 10px;
            padding: 5px 10px;
            outline: none;
            cursor: pointer;
        }

        .table-container {
            padding: 0 1rem;
        }

        .table thead th {
            background: transparent;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 20px 15px;
            border-bottom: 2px solid #f1ece9;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            font-size: 14px;
            font-weight: 600;
            border-bottom: 1px solid #f8f5f2;
        }

        .row-number {
            width: 30px;
            height: 30px;
            background: var(--soft-gold);
            color: var(--accent-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: 800;
            font-size: 12px;
        }

        .badge-area {
            background: #f0f4f8;
            color: #475569;
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 11px;
        }

        .status-pill {
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        .pagination-footer {
            padding: 1.5rem 2rem;
            background: #fdfaf8;
            border-top: 1px solid #f1ece9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-info {
            font-weight: 700;
            font-size: 13px;
            color: var(--text-muted);
        }

        .pagination {
            gap: 5px;
            margin: 0;
        }

        .pagination a,
        .pagination span {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 2px solid var(--input-border);
            background: white;
            color: var(--deep-coffee);
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            transition: 0.2s;
        }

        .pagination a:hover {
            border-color: var(--accent-gold);
            color: var(--accent-gold);
            transform: translateY(-2px);
        }

        .pagination .active a {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 5px 15px rgba(74, 44, 27, 0.2);
        }

        .btn-add {
            background: var(--primary-gradient);
            color: white;
            font-weight: 800;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 20px rgba(74, 44, 27, 0.15);
            transition: 0.3s;
            font-size: 13px;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            color: white;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-edit {
            background: #fef3c7;
            color: #d97706;
        }

        .btn-edit:hover {
            background: #d97706;
            color: white;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background: #dc2626;
            color: white;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-bold);
        }

        .modal-header {
            background: var(--primary-coffee);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px 30px;
        }

        .modal-body {
            padding: 30px;
        }

        @media (max-width: 768px) {
            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }

            .pagination-footer {
                flex-direction: column;
                text-align: center;
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
                    <div class="text-white d-none d-md-block text-end">
                        <small class="d-block opacity-50 fw-bold" style="font-size: 9px; letter-spacing: 1px;">SISTEM AKTIVITAS</small>
                        <span class="fw-bold" style="font-size: 14px;"><?= htmlspecialchars($_SESSION['username']) ?></span>
                    </div>
                    <a href="index.php?page=logout" class="btn-logout" onclick="return confirm('Logout dari sistem?')">
                        <i class="bi bi-box-arrow-right me-2"></i>LOGOUT
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container content-wrapper">
        <div class="page-header">
            <div class="welcome-msg">
                <h2 id="shift-text">LOADING...</h2>
                <p>Monitor dan catat aktivitas harian Anda dengan mudah.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="index.php?page=user_dashboard&action=export_excel" class="btn btn-light border fw-bold rounded-pill px-3" style="font-size: 12px;">
                    <i class="bi bi-file-earmark-excel text-success me-1"></i> EXCEL
                </a>
                <a href="index.php?page=user_dashboard&action=export_pdf" class="btn btn-light border fw-bold rounded-pill px-3" style="font-size: 12px;">
                    <i class="bi bi-file-earmark-pdf text-danger me-1"></i> PDF
                </a>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createNoteModal">
                    <i class="bi bi-plus-lg me-2"></i>TAMBAH ACTIVITY
                </button>
            </div>
        </div>

        <div class="data-card">
            <div class="filter-section">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari aktivitas, area, material, atau status...">
                    <button id="clearSearch" style="display:none; position:absolute; right:10px; top:50%; transform:translateY(-50%); border:none; background:none; color:gray;"><i class="bi bi-x-circle"></i></button>
                </div>

                <div class="entries-control">
                    <span>Tampilkan</span>
                    <select id="entriesPerPage">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>data per halaman</span>
                </div>
            </div>

            <div class="table-container table-responsive">
                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Waktu & Hari</th>
                            <th width="35%">Kegiatan / Aktivitas</th>
                            <th>Area</th>
                            <th>Kategori</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php
                        if (mysqli_num_rows($notes) > 0):
                            $no = 1;
                            while ($note = mysqli_fetch_assoc($notes)):
                                $target = $note['target'];
                                $statusClass = ($target == 'Selesai') ? 'status-selesai' : (($target == 'Lanjut') ? 'status-proses' : 'status-menunggu');
                        ?>
                                <tr class="data-row">
                                    <td class="text-center"><span class="row-number"><?= $no++ ?></span></td>
                                    <td>
                                        <div class="text-dark fw-800"><?= date('d M Y', strtotime($note['date'])) ?></div>
                                        <div class="small text-muted fw-bold text-uppercase" style="font-size: 10px;"><?= date('l', strtotime($note['date'])) ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= htmlspecialchars($note['description']) ?></div>
                                        <div class="small text-muted fw-semibold">
                                            <i class="bi bi-tools me-1"></i><?= htmlspecialchars($note['material']) ?>
                                        </div>
                                    </td>
                                    <td><span class="badge-area"><?= htmlspecialchars($note['nama_area'] ?? 'N/A') ?></span></td>
                                    <td><span class="small fw-800 text-muted"><?= htmlspecialchars($note['jenis']) ?></span></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <?php if (!empty($note['foto_before'])): ?>
                                                <button class="btn btn-sm btn-outline-primary view-foto-btn" data-img="/logbook_web/public/uploads/<?= $note['foto_before'] ?>" title="Before">
                                                    B
                                                </button>
                                            <?php endif; ?>

                                            <?php if (!empty($note['foto_after'])): ?>
                                                <button class="btn btn-sm btn-outline-success view-foto-btn" data-img="/logbook_web/public/uploads/<?= $note['foto_after'] ?>" title="After">
                                                    A
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted" style="font-size: 10px;">No After</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><span class="status-pill <?= $statusClass ?>"><?= $target ?></span></td>
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
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <a href="?page=user_dashboard&action=delete&id=<?= $note['id'] ?>" class="action-btn btn-delete" onclick="return confirm('Hapus aktivitas ini?')">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile;
                        else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted fw-bold">Tidak ada data aktivitas ditemukan.</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination-footer" id="paginationWrapperBottom">
                <div class="pagination-info" id="paginationInfo">
                    Menampilkan <span id="startRange">0</span> sampai <span id="endRange">0</span> dari <span id="totalCount">0</span> data
                </div>
                <ul class="pagination" id="paginationControls">
                </ul>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createNoteModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="?page=user_dashboard&action=create" method="POST" class="modal-content">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="modal-header">
                    <h5 class="fw-800 m-0">Input Aktivitas Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">TANGGAL</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">AREA KERJA</label>
                            <select name="id_area" class="form-select" required>
                                <option value="">Pilih Area...</option>
                                <?php mysqli_data_seek($areas, 0);
                                while ($a = mysqli_fetch_assoc($areas)): ?>
                                    <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">DESKRIPSI PEKERJAAN</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Apa yang Anda kerjakan?" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">KATEGORI</label>
                            <select name="jenis" class="form-select" required>
                                <option value="Check List-Routine">Routine Check</option>
                                <option value="Complain">Complain</option>
                                <option value="Perbaikan/Perawatan">Maintenance</option>
                                <option value="Ganti Baru">Replacement</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Foto Before (Awal)</label>
                            <input type="file" class="form-control" name="foto_before" accept="image/*" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">STATUS</label>
                            <select name="target" class="form-select" required>
                                <option value="Menunggu Proses">Menunggu</option>
                                <option value="Lanjut">Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">MATERIAL / SPAREPART</label>
                            <input type="text" name="material" class="form-control" placeholder="Contoh: Kabel, Lampu, Baut..." required>
                        </div>
                    </div>
                    <button type="submit" class="btn-add w-100 mt-4 py-3">SIMPAN AKTIVITAS</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editNoteModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="formEdit" method="POST" class="modal-content">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="modal-header" style="background: var(--accent-gold);">
                    <h5 class="fw-800 m-0 text-dark">Update Aktivitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    < class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">TANGGAL</label>
                            <input type="date" name="date" id="edit_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">AREA</label>
                            <select name="id_area" id="edit_area" class="form-select" required>
                                <?php mysqli_data_seek($areas, 0);
                                while ($a = mysqli_fetch_assoc($areas)): ?>
                                    <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">DESKRIPSI</label>
                            <textarea name="description" id="edit_desc" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">JENIS</label>
                            <select name="jenis" id="edit_jenis" class="form-select" required>
                                <option value="Check List-Routine">Routine Check</option>
                                <option value="Complain">Complain</option>
                                <option value="Perbaikan/Perawatan">Maintenance</option>
                                <option value="Ganti Baru">Replacement</option>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">FOTO BEFORE</label>
                                <div id="preview_before_container" class="mb-2">
                                    <img id="edit_view_before" src="" class="img-thumbnail" style="height: 100px; display: none;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-success">UPLOAD FOTO AFTER</label>
                                <input type="file" class="form-control border-success" name="foto_after" accept="image/*">
                                <small class="text-muted">Pilih foto jika pekerjaan selesai/progres</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">STATUS</label>
                            <select name="target" id="edit_target" class="form-select" required>
                                <option value="Menunggu Proses">Menunggu</option>
                                <option value="Lanjut">Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">MATERIAL</label>
                            <input type="text" name="material" id="edit_material" class="form-control" required>
                        </div>
                </div>
                <button type="submit" class="btn-add w-100 mt-4 py-3">SIMPAN PERUBAHAN</button>
        </div>
        </form>
    </div>

    <div class="modal fade" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 text-center">
                <div class="img-container rounded shadow-lg bg-white">
                    <img src="" id="imgPreview" alt="Foto">
                </div>
                <div class="mt-3">
                    <a href="" id="downloadBtn" download class="btn btn-light btn-sm px-3"><i class="bi bi-download me-2"></i>Download</a>
                    <button type="button" class="btn btn-danger btn-sm px-3 ms-2" data-bs-dismiss="modal">Tutup</button>
                </div>
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
            const now = new Date().getHours();
            if (now >= 5 && now < 11) shiftText.innerHTML = '<i class="bi bi-brightness-high me-2 text-warning"></i>MORNING';
            else if (now >= 11 && now < 15) shiftText.innerHTML = '<i class="bi bi-sun-fill me-2 text-danger"></i>AFTERNOON';
            else if (now >= 15 && now < 19) shiftText.innerHTML = '<i class="bi bi-cloud-sun me-2 text-primary"></i>EVENING';
            else shiftText.innerHTML = '<i class="bi bi-moon-stars-fill me-2 text-indigo"></i>NIGHT SHIFT';

            const tableBody = document.getElementById('tableBody');
            allRows = Array.from(tableBody.querySelectorAll('tr.data-row'));
            filteredRows = [...allRows];
            updatePagination();

            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                filteredRows = allRows.filter(row => row.textContent.toLowerCase().includes(searchValue));
                currentPage = 1;
                updatePagination();
            });

            document.addEventListener('click', function(e) {
                const editBtn = e.target.closest('.btn-edit-trigger');
                if (editBtn) {
                    const id = editBtn.getAttribute('data-id');
                    const fotoBeforeName = editBtn.getAttribute('data-foto-before');

                    document.getElementById('formEdit').action = `?page=user_dashboard&action=update&id=${id}`;

                    document.getElementById('edit_date').value = editBtn.getAttribute('data-date');
                    document.getElementById('edit_desc').value = editBtn.getAttribute('data-desc');
                    document.getElementById('edit_area').value = editBtn.getAttribute('data-area');
                    document.getElementById('edit_jenis').value = editBtn.getAttribute('data-jenis');
                    document.getElementById('edit_target').value = editBtn.getAttribute('data-target');
                    document.getElementById('edit_material').value = editBtn.getAttribute('data-material');

                    const imgPreviewEdit = document.getElementById('edit_view_before');
                    if (fotoBeforeName && fotoBeforeName !== '') {
                        imgPreviewEdit.src = "/logbook_web/public/uploads/" + fotoBeforeName;
                        imgPreviewEdit.style.display = 'block';
                    } else {
                        imgPreviewEdit.style.display = 'none';
                    }
                }

                const viewBtn = e.target.closest('.view-foto-btn');
                if (viewBtn) {
                    const src = viewBtn.getAttribute('data-img');
                    const img = document.getElementById('imgPreview');
                    img.src = src;
                    document.getElementById('downloadBtn').href = src;

                    const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
                    photoModal.show();
                }
            });
        });

        function updatePagination() {
            const totalPages = Math.ceil(filteredRows.length / entriesPerPage);
            if (currentPage > totalPages) currentPage = totalPages || 1;
            displayPageRows();
            renderPaginationControls(totalPages);
            updatePaginationInfo();
        }

        function displayPageRows() {
            const start = (currentPage - 1) * entriesPerPage;
            const end = start + entriesPerPage;
            const visibleRows = filteredRows.slice(start, end);
            allRows.forEach(row => row.style.display = 'none');
            visibleRows.forEach((row, index) => {
                row.style.display = '';
                const rowNumElement = row.querySelector('.row-number');
                if (rowNumElement) rowNumElement.textContent = start + index + 1;
            });
        }

        function renderPaginationControls(totalPages) {
            const controls = document.getElementById('paginationControls');
            controls.innerHTML = '';
            if (totalPages <= 1) return;

            let html = `<li><a href="#" onclick="changePage(${currentPage - 1}, event)"><i class="bi bi-chevron-left"></i></a></li>`;
            for (let i = 1; i <= totalPages; i++) {
                html += `<li class="${i === currentPage ? 'active' : ''}"><a href="#" onclick="changePage(${i}, event)">${i}</a></li>`;
            }
            html += `<li><a href="#" onclick="changePage(${currentPage + 1}, event)"><i class="bi bi-chevron-right"></i></a></li>`;
            controls.innerHTML = html;
        }

        function updatePaginationInfo() {
            const start = filteredRows.length === 0 ? 0 : (currentPage - 1) * entriesPerPage + 1;
            const end = Math.min(currentPage * entriesPerPage, filteredRows.length);
            document.getElementById('startRange').textContent = start;
            document.getElementById('endRange').textContent = end;
            document.getElementById('totalCount').textContent = filteredRows.length;
        }

        function changePage(page, event) {
            if (event) event.preventDefault();
            const totalPages = Math.ceil(filteredRows.length / entriesPerPage);
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                updatePagination();
            }
        }

        document.getElementById('entriesPerPage').addEventListener('change', function() {
            entriesPerPage = parseInt(this.value);
            currentPage = 1;
            updatePagination();
        });
    </script>
</body>

</html>