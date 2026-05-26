<?php
$activePage = 'monitoring'; 
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aktivitas User | Activity Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
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

        .header-title span {
            color: var(--caramel);
        }

        .btn-back {
            background: var(--espresso-dark);
            color: var(--white);
            font-weight: 800;
            border-radius: 12px;
            padding: 12px 24px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            margin-bottom: 30px;
            box-shadow: var(--shadow-bold);
        }

        .btn-back:hover {
            background: var(--caramel);
            color: white;
            transform: translateX(-5px);
        }

        .stat-card-mini {
            background: var(--white);
            border: 2px solid var(--border-solid);
            border-radius: 20px;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: var(--shadow-bold);
            height: 100%;
        }

        .stat-icon-mini {
            width: 55px;
            height: 55px;
            background: var(--espresso);
            color: var(--white);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
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
            font-size: 13px;
            letter-spacing: 0.5px;
            border-bottom: 3px solid var(--espresso-dark);
            padding-bottom: 15px;
        }

        .table td {
            vertical-align: middle;
            font-weight: 700;
            color: var(--espresso-dark);
            padding: 18px 10px;
            border-bottom: 1px solid var(--border-solid);
        }

        .badge-piagam {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 900;
            font-size: 13px;
            text-transform: uppercase;
            border: 2px solid transparent;
        }

        .badge-emas {
            background: #FFF9C4;
            color: #827717;
            border-color: #FBC02D;
        }

        .badge-perak {
            background: #F5F5F5;
            color: #424242;
            border-color: #9E9E9E;
        }

        .badge-pemula {
            background: #E1F5FE;
            color: #01579B;
            border-color: #03A9F4;
        }

        .badge-area {
            background: var(--espresso-dark);
            color: var(--accent-gold);
            font-weight: 800;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 12px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid var(--border-solid);
            border-radius: 8px;
            padding: 6px 12px;
            font-family: inherit;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: var(--caramel);
            box-shadow: 0 0 0 0.2rem rgba(163, 107, 70, 0.25);
        }
        .dataTables_wrapper .dataTables_length select {
            border: 2px solid var(--border-solid);
            border-radius: 8px;
            padding: 6px 30px 6px 12px;
            font-family: inherit;
        }
        .page-item.active .page-link {
            background-color: var(--espresso-dark) !important;
            border-color: var(--espresso-dark) !important;
            color: var(--white) !important;
        }
        .page-link {
            color: var(--espresso-dark) !important;
            font-weight: 700;
        }
        .page-link:hover {
            background-color: var(--milk-tea) !important;
            color: var(--espresso-dark) !important;
        }
    </style>
</head>

<body>
    <nav class="top-nav">
        <a href="#" class="brand-logo">ACTIVITY <span>DIGITAL.</span></a>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-md-block text-white">
                <div style="font-size: 11px; font-weight: 900; color: var(--accent-gold); letter-spacing: 1.5px;">AUTHENTICATED ADMIN</div>
                <div style="font-size: 16px; font-weight: 900;"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></div>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <a href="index.php?page=admin_dashboard&action=monitoring" class="btn-back">
            <i class="bi bi-arrow-left-circle-fill"></i> KEMBALI KE MONITORING
        </a>

        <div class="header-title mb-5">
            <h1>Detail Aktivitas: <span><?= htmlspecialchars($user['username'] ?? 'User') ?></span></h1>
            <p class="mb-0 fw-bold" style="color: var(--caramel);">Laporan riwayat pekerjaan lengkap dan analisis kontribusi pengguna.</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card-mini">
                    <div class="stat-icon-mini"><i class="bi bi-journal-text"></i></div>
                    <div>
                        <div style="font-size: 12px; font-weight: 900; color: var(--caramel); text-transform: uppercase; letter-spacing: 1px;">Total Kontribusi</div>
                        <div style="font-size: 28px; font-weight: 900;"><?= isset($activities) ? $activities->num_rows : 0 ?> <small style="font-size: 14px; color: var(--milk-tea);">Notes</small></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="stat-card-mini">
                    <div class="stat-icon-mini" style="background: var(--accent-gold);"><i class="bi bi-award-fill"></i></div>
                    <div>
                        <div style="font-size: 12px; font-weight: 900; color: var(--caramel); text-transform: uppercase; letter-spacing: 1px;">Status Pencapaian</div>
                        <div>
                            <?php
                            $count = isset($activities) ? $activities->num_rows : 0;
                            if ($count >= 20) {
                                echo '<div class="badge-piagam badge-emas"><i class="bi bi-trophy-fill"></i> Piagam Emas: Sangat Aktif</div>';
                            } elseif ($count >= 10) {
                                echo '<div class="badge-piagam badge-perak"><i class="bi bi-award-fill"></i> Piagam Perak: Aktif</div>';
                            } else {
                                echo '<div class="badge-piagam badge-pemula"><i class="bi bi-stars"></i> Kontributor Pemula</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width: 5px; height: 30px; background: var(--accent-gold); border-radius: 10px;"></div>
                <h5 class="mb-0" style="font-weight: 900; color: var(--espresso-dark); letter-spacing: -0.5px;">RIWAYAT LOG PEKERJAAN</h5>
            </div>
            
            <div class="table-responsive overflow-hidden">
                <table id="activityTable" class="table table-hover w-100">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Area Kerja</th>
                            <th>Jenis Aktivitas</th>
                            <th>Deskripsi Pekerjaan</th>
                            <th>Target Luaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($activities) && $activities->num_rows > 0): ?>
                            <?php while ($row = $activities->fetch_assoc()): ?>
                                <tr>
                                    <td style="font-weight: 800; color: var(--caramel); white-space: nowrap;">
                                        <i class="bi bi-calendar3 me-2"></i> <?= date('d M Y', strtotime($row['date'])) ?>
                                    </td>
                                    <td>
                                        <span class="badge-area"><?= htmlspecialchars($row['nama_area']) ?></span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 900; font-size: 15px;"><?= htmlspecialchars($row['jenis']) ?></div>
                                    </td>
                                    <td style="max-width: 350px; font-weight: 600; color: #555;">
                                        <?= htmlspecialchars($row['description']) ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2" style="font-weight: 800;">
                                            <i class="bi bi-bullseye text-danger"></i>
                                            <?= htmlspecialchars($row['target']) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#activityTable').DataTable({
                "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                "pageLength": 10, 
                "language": {
                    "search": "Pencarian:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "info": "Menampilkan _START_ sampai _END_ dari total _TOTAL_ riwayat",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 riwayat",
                    "infoFiltered": "(disaring dari _MAX_ total riwayat)",
                    "emptyTable": "Belum ada riwayat aktivitas yang tercatat untuk user ini.",
                    "zeroRecords": "Pencarian tidak menemukan hasil yang sesuai.",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": " <i class='bi bi-chevron-right'></i>",
                        "previous": "<i class='bi bi-chevron-left'></i> "
                    }
                },
                "order": [] 
            });
        });
    </script>
</body>

</html>