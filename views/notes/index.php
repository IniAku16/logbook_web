<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Logbook Activity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>

    </style>
</head>

<body>

    <div class="wrapper">
        <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

        <div id="main-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-dark">Heyow Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></h2>
                        <p class="text-muted">Kelola renewal produk Anda di sini.</p>
                    </div>
                    <button class="btn btn-primary px-4 py-2 shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#createProductModal">
                        <i class="bi bi-plus-lg me-2"></i> Add New Product
                    </button>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card bg-white shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 text-primary">
                                    <i class="bi bi-box-seam fs-3"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0">Total Products</p>
                                    <h3 class="fw-bold mb-0"><?= $totalProducts ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card bg-white shadow-sm p-3 border-start border-4 border-success">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3 text-success">
                                    <i class="bi bi-check-circle fs-3"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0">Active</p>
                                    <h3 class="fw-bold mb-0 text-success"><?= $activeCount ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card bg-white shadow-sm p-3 border-start border-4 border-warning">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3 text-warning">
                                    <i class="bi bi-exclamation-triangle fs-3"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0">Expiring Soon</p>
                                    <h3 class="fw-bold mb-0 text-warning"><?= $expiringCount ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card bg-white shadow-sm p-3 border-start border-4 border-danger">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3 text-danger">
                                    <i class="bi bi-x-circle fs-3"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0">Expired</p>
                                    <h3 class="fw-bold mb-0 text-danger"><?= $expiredCount ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-custom mb-4">
                    <form action="/renewal-system/public/index.php" method="GET" class="row g-3 align-items-end">
                        <input type="hidden" name="action" value="exportExcel">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success w-100 fw-bold">
                                <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-container">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" id="searchProduct" class="form-control border-start-0" placeholder="Search product name or serial...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="filterExpired" class="form-select">
                                <option value="">All Status</option>
                                <option value="week">Expiring this week</option>
                                <option value="month">Expiring this month</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-end">
                            <div class="d-flex align-items-center justify-content-end">
                                <span class="me-2 small">Show:</span>
                                <select id="rowsPerPage" class="form-select w-auto">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="productTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Name</th>
                                    <th>Serial Number</th>
                                    <th>Last Quotation</th>
                                    <th>Expired Date</th>
                                    <th>Sisa Hari</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($products)) : $no = 1;
                                    foreach ($products as $product) :
                                        $statusClass = ($product['status'] == 'expired') ? 'danger' : (($product['status'] == 'expiring') ? 'warning text-dark' : 'success');
                                ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td class="fw-bold"><?= htmlspecialchars($product['product_name']) ?></td>
                                            <td><code><?= htmlspecialchars($product['serial_number']) ?></code></td>
                                            <td>Rp <?= number_format($product['harga_renewal'], 0, ',', '.') ?></td>
                                            <td><?= date('d M Y', strtotime($product['expired_date'])) ?></td>
                                            <td>
                                                <?php if ($product['sisa_hari'] < 0): ?>
                                                    <span class="text-danger small fw-bold">Expired <?= abs($product['sisa_hari']) ?> days ago</span>
                                                <?php else: ?>
                                                    <span class="text-primary small fw-bold"><?= $product['sisa_hari'] ?> days left</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><span class="badge bg-<?= $statusClass ?> badge-status"><?= ucfirst($product['status']) ?></span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-warning btn-update"
                                                        data-id="<?= $product['id'] ?>"
                                                        data-name="<?= htmlspecialchars($product['product_name']) ?>"
                                                        data-serial="<?= htmlspecialchars($product['serial_number']) ?>"
                                                        data-harga="<?= $product['harga_renewal'] ?>"
                                                        data-expired="<?= $product['expired_date'] ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-success done-btn" data-id="<?= $product['id'] ?>">
                                                        <i class="bi bi-check2-circle"></i> Renewal
                                                    </button>
                                                    <a href="?action=delete&id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No data found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div id="pagination" class="mt-3 d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content card-custom">
                <form id="productForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProductModalLabel">Add New Product</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"> <label for="product_name" class="form-label">Product Name</label> <input type="text" class="form-control" id="product_name" name="product_name" required /> </div>
                        <div class="mb-3"> <label for="serial_number" class="form-label">Serial Number</label> <input type="text" class="form-control" id="serial_number" name="serial_number" required /> </div>
                        <div class="mb-3"> <label for="harga_renewal" class="form-label">Last Quotation</label> <input type="number" class="form-control" id="harga_renewal" name="harga_renewal" required /> </div>
                        <div class="mb-3"> <label for="expired_date" class="form-label">Expired Date</label> <input type="date" class="form-control" id="expired_date" name="expired_date" required /> </div>
                    </div>
                    <div class="modal-footer"> <button type="submit" class="btn btn-primary">Save</button> </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content card-custom">
                <form id="editProductForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Update Product</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body"> <input type="hidden" id="edit_product_id" name="id" />
                        <div class="mb-3"> <label for="edit_product_name" class="form-label">Product Name</label> <input type="text" class="form-control" id="edit_product_name" name="product_name" required /> </div>
                        <div class="mb-3"> <label for="edit_serial_number" class="form-label">Serial Number</label> <input type="text" class="form-control" id="edit_serial_number" name="serial_number" required /> </div>
                        <div class="mb-3"> <label for="edit_harga_renewal" class="form-label">Last Quotation</label> <input type="number" class="form-control" id="edit_harga_renewal" name="harga_renewal" required /> </div>
                        <div class="mb-3"> <label for="edit_expired_date" class="form-label">Expired Date</label> <input type="date" class="form-control" id="edit_expired_date" name="expired_date" required /> </div>
                    </div>
                    <div class="modal-footer"> <button type="submit" class="btn btn-primary">Update</button> </div>
                </form>
            </div>
        </div>
    </div>

    <script>

    </script>
</body>

</html>