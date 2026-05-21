<div class="main-container">
    <a href="index.php?page=admin_dashboard&action=monitoring" class="btn btn-sm btn-outline-secondary mb-4">
        <i class="bi bi-arrow-left"></i> Kembali ke Monitoring
    </a>
    
    <div class="header-title mb-4">
        <h1>Detail Aktivitas: <?= htmlspecialchars($user['username']) ?></h1>
    </div>

    <div class="table-wrapper">
        <h5 class="mb-4 fw-bold"><i class="bi bi-clock-history"></i> Riwayat Pekerjaan</h5>
        <div class="table-responsive">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Area</th>
                        <th>Jenis</th>
                        <th>Deskripsi</th>
                        <th>Target</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($activities->num_rows > 0): ?>
                        <?php while($row = $activities->fetch_assoc()): ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($row['date'])) ?></td>
                            <td><span class="badge bg-secondary"><?= $row['nama_area'] ?></span></td>
                            <td><?= $row['jenis'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td><?= $row['target'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">User ini belum mencatat aktivitas apapun.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>