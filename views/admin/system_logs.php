<!DOCTYPE html>
<html lang="id">

<head>
    <title>System Logs | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #f8f6f4;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .log-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .badge-action {
            font-size: 0.75rem;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="bi bi-journal-text me-2"></i>Log Aktivitas Sistem</h4>
            <a href="index.php?page=admin_dashboard&action=monitoring" class="btn btn-sm btn-outline-secondary">Kembali</a>
        </div>

        <div class="log-card p-4">
            <div class="table-responsive">
                <table class="table table-hover border-light">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Modul</th>
                            <th>Deskripsi</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($log = $logs->fetch_assoc()): ?>
                            <tr>
                                <td class="small"><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?></td>
                                <td><strong><?= htmlspecialchars($log['username'] ?? 'System') ?></strong></td>
                                <td>
                                    <span class="badge badge-action bg-<?= $log['action'] == 'DELETE' ? 'danger' : ($log['action'] == 'CREATE' ? 'success' : 'primary') ?>">
                                        <?= $log['action'] ?>
                                    </span>
                                </td>
                                <td class="text-muted small"><?= $log['module'] ?></td>
                                <td><?= htmlspecialchars($log['description']) ?></td>
                                <td class="small text-muted"><?= $log['ip_address'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>