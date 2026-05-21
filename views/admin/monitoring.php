
<div class="main-container">
    <div class="header-title mb-5">
        <h1>Activity Monitoring</h1>
        <p style="color: var(--caramel); font-weight: 700;">Pantau produktivitas dan performa kerja tim Anda.</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-journal-check"></i></div>
                <div>
                    <div class="stat-label">Total Aktivitas Sistem</div>
                    <div class="stat-value"><?= $totalAktivitas ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Total Aktivitas</th>
                    <th>Aktivitas Terakhir</th>
                    <th>Status Performa</th>
                    <th class="text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats as $s): ?>
                <tr>
                    <td>
                        <div class="fw-bold"><?= htmlspecialchars($s['username']) ?></div>
                        <small class="text-muted"><?= $s['email'] ?></small>
                    </td>
                    <td><span class="badge bg-dark rounded-pill"><?= $s['total_aktivitas'] ?> Notes</span></td>
                    <td><?= $s['aktivitas_terakhir'] ?? '<span class="text-muted">Belum ada data</span>' ?></td>
                    <td>
                        <?php 
                        if($s['total_aktivitas'] > 10) {
                            echo '<span class="badge bg-success"><i class="bi bi-star-fill"></i> Sangat Produktif</span>';
                        } elseif($s['total_aktivitas'] > 0) {
                            echo '<span class="badge bg-info">Aktif</span>';
                        } else {
                            echo '<span class="badge bg-warning text-dark">Tidak Aktif</span>';
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <a href="index.php?page=admin_dashboard&action=user_detail&id=<?= $s['id_user'] ?>" class="btn-action btn-edit">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>