<?php
$activePage = 'monitoring';
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aktivitas | <?= htmlspecialchars($user['username'] ?? 'User') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --bg-body: #f8f6f4;
            --primary-dark: #2d1b14;
            --accent-gold: #b8860b;
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
            color: #fff !important;
        }

        .navbar-brand span {
            color: var(--accent-gold);
        }

        .card-profile {
            background: #fff;
            border-radius: 24px;
            padding: 30px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
        }

        .user-avatar-lg {
            width: 80px;
            height: 80px;
            background: var(--primary-dark);
            color: var(--accent-gold);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            margin-right: 25px;
        }

        .stat-box {
            background: #fafafa;
            border-radius: 16px;
            padding: 15px 25px;
            border: 1px solid #eee;
        }

        .piagam-badge {
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .piagam-gold {
            background: #fff9e6;
            color: #b8860b;
            border: 1px solid #ffe4b3;
        }

        .piagam-silver {
            background: #f1f3f4;
            color: #5f6368;
            border: 1px solid #dcdcdc;
        }

        .piagam-elite {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #dbeafe;
        }

        .table-card {
            background: #fff;
            border-radius: 24px;
            padding: 30px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
        }

        .table thead th {
            background: #faf9f7;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 800;
            padding: 15px 20px;
            color: #888;
            border-bottom: 2px solid #eee;
        }

        .table td {
            padding: 15px 20px;
            vertical-align: middle;
            font-size: 14px;
        }

        .btn-back {
            color: var(--primary-dark);
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            transition: 0.2s;
        }

        .btn-back:hover {
            color: var(--accent-gold);
            transform: translateX(-5px);
        }

        .photo-btn {
            padding: 5px 12px;
            font-size: 10px;
            font-weight: 800;
            border-radius: 8px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
            color: white !important;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-admin">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ACTIVITY<span>DIGITAL.</span></a>
            <div class="ms-auto d-flex align-items-center">
                <div class="text-end me-3 d-none d-md-block text-white">
                    <small class="text-white-50 d-block fw-bold" style="font-size: 10px;">ADMIN ACCESS</small>
                    <span class="fw-bold"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">

        <a href="index.php?page=admin_dashboard&action=monitoring" class="btn-back">
            <i class="bi bi-arrow-left"></i> KEMBALI KE MONITORING
        </a>

        <div class="card-profile d-flex flex-column flex-md-row align-items-center">
            <div class="user-avatar-lg shadow-sm">
                <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
            </div>
            <div class="flex-grow-1 mt-3 mt-md-0">
                <h3 class="fw-800 mb-1"><?= htmlspecialchars($user['username'] ?? 'User Profile') ?></h3>
                <p class="text-muted small mb-0"><i class="bi bi-envelope me-2"></i><?= htmlspecialchars($user['email'] ?? '-') ?></p>
                <div class="mt-2">
                    <?php
                    $count = isset($activities) ? $activities->num_rows : 0;
                    if ($count >= 30) {
                        echo '<span class="piagam-badge piagam-elite"><i class="bi bi-crown-fill"></i> Elite Member</span>';
                    } elseif ($count >= 15) {
                        echo '<span class="piagam-badge piagam-gold"><i class="bi bi-trophy-fill"></i> Pro Active</span>';
                    } else {
                        echo '<span class="piagam-badge piagam-silver"><i class="bi bi-award-fill"></i> Contributor</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="d-flex gap-3 mt-4 mt-md-0">
                <div class="stat-box text-center">
                    <small class="text-muted fw-bold d-block">TOTAL NOTES</small>
                    <h4 class="fw-800 mb-0"><?= $count ?></h4>
                </div>
                <div class="stat-box text-center">
                    <small class="text-muted fw-bold d-block">ROLE</small>
                    <h4 class="fw-800 mb-0 text-uppercase"><?= htmlspecialchars($user['role'] ?? 'USER') ?></h4>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-800 mb-0">Riwayat Aktivitas Lengkap</h5>
                <div style="width: 50px; height: 4px; background: var(--accent-gold); border-radius: 10px;"></div>
            </div>

            <div class="table-responsive">
                <table id="detailTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Area</th>
                            <th>Kegiatan</th>
                            <th>Material</th>
                            <th class="text-center">Dokumentasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($activities) && $activities->num_rows > 0): ?>
                            <?php while ($row = $activities->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= date('d/m/Y', strtotime($row['date'])) ?></div>
                                        <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;"><?= date('l', strtotime($row['date'])) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold" style="font-size: 11px;">
                                            <?= htmlspecialchars($row['nama_area']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($row['description']) ?></div>
                                        <small class="text-primary fw-bold"><?= htmlspecialchars($row['jenis']) ?></small>
                                    </td>
                                    <td class="text-muted small fw-semibold">
                                        <?= htmlspecialchars($row['material'] ?: '-') ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <?php if (!empty($row['foto_before'])): ?>
                                                <button class="btn btn-sm btn-outline-primary photo-btn view-img"
                                                    data-img="/logbook_web/public/uploads/<?= $row['foto_before'] ?>">B</button>
                                            <?php endif; ?>
                                            <?php if (!empty($row['foto_after'])): ?>
                                                <button class="btn btn-sm btn-outline-success photo-btn view-img"
                                                    data-img="/logbook_web/public/uploads/<?= $row['foto_after'] ?>">A</button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $s = $row['target'];
                                        $cls = ($s == 'Selesai') ? 'bg-success' : (($s == 'Lanjut') ? 'bg-warning text-dark' : 'bg-secondary');
                                        ?>
                                        <span class="badge <?= $cls ?> fw-bold px-3 py-2" style="font-size: 10px; border-radius: 8px;">
                                            <?= strtoupper($s) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imgModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 text-center">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                    <img src="" id="fullImg" class="img-fluid rounded-4 shadow-lg border border-4 border-white">
                </div>
                <div class="mt-3">
                    <a href="" id="downImg" download class="btn btn-warning fw-bold rounded-pill px-4">
                        <i class="bi bi-download me-2"></i>DOWNLOAD FOTO
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#detailTable').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Cari Riwayat:",
                    "lengthMenu": "Tampilkan _MENU_",
                    "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data"
                }
            });

            $('.view-img').on('click', function() {
                const src = $(this).data('img');
                $('#fullImg').attr('src', src);
                $('#downImg').attr('href', src);
                const myModal = new bootstrap.Modal(document.getElementById('imgModal'));
                myModal.show();
            });
        });
    </script>
</body>

</html>