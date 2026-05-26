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
    <title>Monitoring Aktivitas | Activity Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">

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
            padding: 20px 10px;
            border-bottom: 1px solid var(--border-solid);
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
            background: #FFE0B2;
            color: #E65100;
            font-size: 18px;
            text-decoration: none;
        }

        .btn-action:hover {
            border-color: #E65100;
            transform: scale(1.05);
        }

        .badge-piagam {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 900;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 2px solid transparent;
        }

        .badge-emas {
            background: #FFF9C4;
            color: #827717;
            border-color: #FBC02D;
            box-shadow: 0 4px 10px rgba(251, 192, 45, 0.2);
        }

        .badge-perak {
            background: #F5F5F5;
            color: #424242;
            border-color: #9E9E9E;
            box-shadow: 0 4px 10px rgba(158, 158, 158, 0.2);
        }

        .badge-pemula {
            background: #E1F5FE;
            color: #01579B;
            border-color: #03A9F4;
        }

        .notes-count {
            background: var(--espresso-dark);
            color: var(--accent-gold);
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 900;
            font-size: 13px;
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
            <a href="index.php?page=logout" class="btn-action bg-danger text-white border-0" onclick="return confirm('Apakah anda ingin logout?')">
                <i class="bi bi-power"></i>
            </a>
        </div>
    </nav>

    <div class="main-container">
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div class="header-title">
                <h1>Activity Monitoring</h1>
                <p class="mb-0 fw-bold" style="color: var(--caramel);">Pantau produktivitas dan performa kerja tim secara real-time.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="index.php?page=admin_dashboard&action=export_pdf" class="btn btn-danger fw-bold shadow-sm" style="border-radius: 12px; padding: 12px 20px;">
                    <i class="bi bi-file-pdf-fill me-2"></i> PDF
                </a>
                <a href="index.php?page=admin_dashboard&action=export_excel" class="btn btn-success fw-bold shadow-sm" style="border-radius: 12px; padding: 12px 20px;">
                    <i class="bi bi-file-earmark-excel-fill me-2"></i> EXCEL
                </a>
            </div>
        </div>

        <div class="container-fluid px-0 mb-4">
            <div class="d-flex gap-3">
                <a href="index.php?page=admin_dashboard" class="btn btn-outline-dark shadow-sm" style="font-weight: 800; border-radius: 12px; padding: 12px 25px; border-width: 2px;">
                    <i class="bi bi-people-fill me-2"></i> User Management
                </a>
                <a href="index.php?page=admin_dashboard&action=monitoring" class="btn btn-dark shadow-sm" style="font-weight: 800; border-radius: 12px; padding: 12px 25px;">
                    <i class="bi bi-graph-up-arrow me-2"></i> Monitoring Aktivitas
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-auto">
                <div class="stat-card" onclick="window.location.href='index.php?page=admin_dashboard&action=all_activities'" style="cursor:pointer;">
                    <div class="stat-icon" style="background: var(--caramel);"><i class="bi bi-journal-check"></i></div>
                    <div>
                        <div class="stat-label">Total Aktivitas Sistem</div>
                        <div class="stat-value"><?= $totalAktivitas ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table table-hover mb-0" id="tableMonitoring">
                <thead>
                    <tr>
                        <th>Nama Pengguna</th>
                        <th>Total Aktivitas</th>
                        <th>Aktivitas Terakhir</th>
                        <th>Status Performa</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats as $s): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 900; font-size: 16px;"><?= htmlspecialchars($s['username']) ?></div>
                                <div style="font-size: 13px; color: var(--caramel); font-weight: 600;"><?= htmlspecialchars($s['email']) ?></div>
                            </td>
                            <td>
                                <span class="notes-count">
                                    <i class="bi bi-pencil-square me-1"></i> <?= $s['total_aktivitas'] ?> Notes
                                </span>
                            </td>
                            <td style="font-size: 14px; font-weight: 800;">
                                <?= $s['aktivitas_terakhir'] ? date('d M Y', strtotime($s['aktivitas_terakhir'])) : '<span class="text-muted">Belum ada data</span>' ?>
                            </td>
                            <td>
                                <?php
                                $count = $s['total_aktivitas'];
                                if ($count >= 20) {
                                    echo '<div class="badge-piagam badge-emas"><i class="bi bi-trophy-fill"></i> Piagam Emas: Sangat Aktif</div>';
                                } elseif ($count >= 10) {
                                    echo '<div class="badge-piagam badge-perak"><i class="bi bi-award-fill"></i> Piagam Perak: Aktif</div>';
                                } else {
                                    echo '<div class="badge-piagam badge-pemula"><i class="bi bi-stars"></i> Kontributor Pemula</div>';
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <a href="index.php?page=admin_dashboard&action=user_detail&id=<?= $s['id_user'] ?>" class="btn-action shadow-sm" title="Lihat Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>