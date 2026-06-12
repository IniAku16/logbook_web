<?php
$activePage = 'monitoring';
$stats = $stats ?? [];
$totalAktivitas = $totalAktivitas ?? 0;

if (session_status() === PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Performa | Activity Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-body: #f8f6f4;
            --primary-dark: #2d1b14;
            --accent-gold: #b8860b;
            --accent-silver: #717171;
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

        .card-stat {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            transition: 0.3s;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-right: 20px;
            background: #fdf5e6;
            color: var(--accent-gold);
        }

        .main-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .table thead th {
            background: #faf9f7;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 800;
            padding: 20px;
            color: #888;
            border-bottom: 2px solid #f1f1f1;
        }

        .table td {
            padding: 18px 20px;
            vertical-align: middle;
        }

        .badge-piagam {
            padding: 10px 18px;
            border-radius: 14px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.5px;
        }

        .piagam-gold {
            background: linear-gradient(135deg, #fff9e6 0%, #ffebcc 100%);
            color: #b8860b;
            border: 2px solid #f0c040;
            box-shadow: 0 4px 12px rgba(184, 134, 11, 0.15);
        }

        .piagam-silver {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #4b5563;
            border: 2px solid #d1d5db;
        }

        .piagam-legend {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #1e40af;
            border: 2px solid #93c5fd;
            animation: shine 2s infinite;
        }

        @keyframes shine {

            0%,
            100% {
                opacity: 0.8;
            }

            50% {
                opacity: 1;
                transform: scale(1.02);
            }
        }

        .btn-detail {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f8f6f4;
            color: var(--primary-dark);
            border: 1px solid var(--border-color);
            transition: 0.2s;
        }

        .btn-detail:hover {
            background: var(--primary-dark);
            color: #fff;
        }

        .btn-export {
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 700;
            font-size: 13px;
        }

        .nav-pills-custom .btn {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-admin">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ACTIVITY<span>DIGITAL.</span></a>
            <div class="ms-auto d-flex align-items-center">
                <div class="text-end me-3 d-none d-md-block text-white">
                    <small class="text-white-50 d-block fw-bold" style="font-size: 10px;">MONITORING DASHBOARD</small>
                    <span class="fw-bold"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
                </div>
                <a href="index.php?page=logout" class="btn btn-outline-light border-0 rounded-circle">
                    <i class="bi bi-power fs-5"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h3 class="fw-800 mb-1">Monitoring Performa Tim</h3>
                <p class="text-muted small mb-0">Hanya menampilkan personil aktif (Admin tidak ditampilkan).</p>
            </div>
            <div class="d-flex gap-2">
                <a href="index.php?page=admin_dashboard&action=export_pdf" class="btn btn-export btn-light border shadow-sm text-danger">
                    <i class="bi bi-file-pdf-fill me-2"></i>Export PDF
                </a>
                <a href="index.php?page=admin_dashboard&action=export_excel" class="btn btn-export btn-light border shadow-sm text-success">
                    <i class="bi bi-file-earmark-excel-fill me-2"></i>Export Excel
                </a>
            </div>
        </div>

        <div class="nav-pills-custom d-flex gap-2 mb-4">
            <a href="index.php?page=admin_dashboard" class="btn btn-light text-muted border px-4">
                <i class="bi bi-people-fill me-2"></i>Manajemen User
            </a>
            <a href="index.php?page=admin_dashboard&action=monitoring" class="btn btn-dark px-4 shadow">
                <i class="bi bi-graph-up-arrow me-2"></i>Monitoring Aktivitas
            </a>
            <a href="index.php?page=admin_dashboard&action=system_logs" class="btn btn-dark px-4 shadow">
                <i class="bi bi-journal-text me-2"></i>Log Aktivitas
            </a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card-stat">
                    <div class="icon-circle">
                        <i class="bi bi-award"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold d-block">TOTAL INPUT SISTEM</small>
                        <h2 class="fw-800 mb-0"><?= number_format($totalAktivitas) ?> <small class="fs-6 text-muted">Notes</small></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Nama Personel</th>
                            <th class="text-center">Total Notes</th>
                            <th>Update Terakhir</th>
                            <th>Piagam Penghargaan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hasOperator = false;
                        foreach ($stats as $s):
                            if (isset($s['role']) && $s['role'] === 'admin') continue;

                            $hasOperator = true;
                        ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3 shadow-sm" style="width: 42px; height: 42px; font-size: 14px;">
                                            <?= strtoupper(substr($s['username'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= htmlspecialchars($s['username']) ?></div>
                                            <small class="text-muted" style="font-size: 11px;"><?= htmlspecialchars($s['email']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="fw-800 fs-5"><?= $s['total_aktivitas'] ?></span>
                                </td>
                                <td>
                                    <div class="small fw-600">
                                        <i class="bi bi-calendar-check me-1 text-muted"></i>
                                        <?= $s['aktivitas_terakhir'] ? date('d M Y', strtotime($s['aktivitas_terakhir'])) : '<span class="text-muted">No Data</span>' ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $count = $s['total_aktivitas'];
                                    if ($count >= 30) {
                                        echo '<span class="badge-piagam piagam-legend"><i class="bi bi-crown-fill"></i> ELITE MEMBER (PRO)</span>';
                                    } elseif ($count >= 15) {
                                        echo '<span class="badge-piagam piagam-gold"><i class="bi bi-trophy-fill"></i> GOLD MEMBER (ACTIVE)</span>';
                                    } else {
                                        echo '<span class="badge-piagam piagam-silver"><i class="bi bi-award-fill"></i> SILVER MEMBER (PEMULA)</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="index.php?page=admin_dashboard&action=user_detail&id=<?= $s['id_user'] ?>" class="btn-detail shadow-sm">
                                        <i class="bi bi-chevron-right fw-bold"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (!$hasOperator): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-person-x fs-1 text-muted d-block mb-2"></i>
                                    <span class="text-muted fw-bold">Tidak ada user yang ditemukan.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>