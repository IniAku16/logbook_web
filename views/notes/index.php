<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logbook Activity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Logbook Activity</h2>
        
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNoteModal">
                <i class="bi bi-plus-lg"></i> Add New Note
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Area</th>
                        <th>Jenis</th>
                        <th>Target</th>
                        <th>Material</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($notes) > 0): 
                        while($note = mysqli_fetch_assoc($notes)): 
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y', strtotime($note['date'])) ?></td>
                            <td><?= htmlspecialchars($note['description']) ?></td>
                            <td><?= htmlspecialchars($note['nama_area'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($note['jenis']) ?></td>
                            <td><?= htmlspecialchars($note['target']) ?></td>
                            <td><?= htmlspecialchars($note['material']) ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning btn-edit" 
                                    data-id="<?= $note['id'] ?>"
                                    data-date="<?= $note['date'] ?>"
                                    data-desc="<?= htmlspecialchars($note['description']) ?>"
                                    data-area="<?= $note['id_area'] ?>"
                                    data-jenis="<?= $note['jenis'] ?>"
                                    data-target="<?= $note['target'] ?>"
                                    data-material="<?= htmlspecialchars($note['material']) ?>"
                                    data-bs-toggle="modal" data-bs-target="#editNoteModal">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <a href="?action=delete&id=<?= $note['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="8" class="text-center">No data found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="createNoteModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="?action=create" method="POST" class="modal-content">
                <div class="modal-header"><h5>Add New Note</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Date</label><input type="date" name="date" class="form-control" required></div>
                    <div class="mb-3"><label>Description</label><textarea name="description" class="form-control" required></textarea></div>
                    <div class="mb-3">
                        <label>Area</label>
                        <select name="id_area" class="form-select" required>
                            <?php mysqli_data_seek($areas, 0); while($a = mysqli_fetch_assoc($areas)): ?>
                                <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jenis</label>
                        <select name="jenis" class="form-select">
                            <option value="-">-</option>
                            <option value="Check List-Routine">Check List-Routine</option>
                            <option value="Complain">Complain</option>
                            <option value="Perbaikan/Perawatan">Perbaikan/Perawatan</option>
                            <option value="Ganti Baru">Ganti Baru</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Target</label>
                        <select name="target" class="form-select">
                            <option value="-">-</option>
                            <option value="Menunggu Proses">Menunggu Proses</option>
                            <option value="Lanjut">Lanjut</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Material</label><input type="text" name="material" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editNoteModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="formEdit" method="POST" class="modal-content">
                <div class="modal-header"><h5>Update Note</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Date</label><input type="date" name="date" id="edit_date" class="form-control" required></div>
                    <div class="mb-3"><label>Description</label><textarea name="description" id="edit_desc" class="form-control" required></textarea></div>
                    <div class="mb-3">
                        <label>Area</label>
                        <select name="id_area" id="edit_area" class="form-select" required>
                            <?php mysqli_data_seek($areas, 0); while($a = mysqli_fetch_assoc($areas)): ?>
                                <option value="<?= $a['id_area'] ?>"><?= $a['nama_area'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jenis</label>
                        <select name="jenis" id="edit_jenis" class="form-select">
                            <option value="Check List-Routine">Check List-Routine</option>
                            <option value="Complain">Complain</option>
                            <option value="Perbaikan/Perawatan">Perbaikan/Perawatan</option>
                            <option value="Ganti Baru">Ganti Baru</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Target</label>
                        <select name="target" id="edit_target" class="form-select">
                            <option value="Menunggu Proses">Menunggu Proses</option>
                            <option value="Lanjut">Lanjut</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Material</label><input type="text" name="material" id="edit_material" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Update</button></div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('formEdit').action = `?action=update&id=${id}`;
                document.getElementById('edit_date').value = this.getAttribute('data-date');
                document.getElementById('edit_desc').value = this.getAttribute('data-desc');
                document.getElementById('edit_area').value = this.getAttribute('data-area');
                document.getElementById('edit_jenis').value = this.getAttribute('data-jenis');
                document.getElementById('edit_target').value = this.getAttribute('data-target');
                document.getElementById('edit_material').value = this.getAttribute('data-material');
            });
        });
    </script>
</body>
</html>