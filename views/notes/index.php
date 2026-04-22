<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Logbook Website</title>
</head>
<body class="container mt-4">
    <h2 class="mb-4">Logbook Activity</h2>
    <a href="index.php?action=create" class="btn btn-primary mb-3">+ Tambah Data</a>
    <table class="table table-bordered table-striped">
        <thead class="table-info">
            <tr>
                <th>Hari/Tanggal</th>
                <th>Description</th>
                <th>Area</th>
                <th>Jenis</th>
                <th>Target</th>
                <th>Material</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($notes)): ?>
            <tr>
                <td><?= $row['date'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['nama_area'] ?></td>
                <td><?= $row['jenis'] ?></td>
                <td><span class="badge bg-secondary"><?= $row['target'] ?></span></td>
                <td><?= $row['material'] ?></td>
                <td>
                    <a href="index.php?action=edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="index.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Del</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>