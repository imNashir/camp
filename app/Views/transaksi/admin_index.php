<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
    <div class="container-fluid">

        <a href="<?= base_url('transaksi/tambah'); ?>" class="btn btn-primary mb-3 mr-2"><i
                class="fas fa-plus-circle mr-2"></i>Tambah Data</a>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif ?>

        <div class="card">
            <div class="card-body">
                <!-- Dropdown Filter Status -->
                <div class="mb-3">
                    <label for="statusFilter">Filter Status:</label>
                    <select id="statusFilter" class="form-control" onchange="filterTable()">
                        <option value="">Semua Status</option>
                        <option value="Tunggu">Ditunggu</option>
                        <option value="Disetujui">Setujui</option>
                        <option value="Tolak">Tolak</option>
                    </select>
                </div>

                <div class="table-responsive-sm">
                    <table class="table table-bordered text-center table-sm" style="width:100%" id="transaksiTable">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nama Alat</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Jumlah Alat</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Disimpan Oleh</th>
                                <th scope="col">Status</th>
                                <?php if (session()->get('role') == 'Admin') : ?>
                                    <th scope="col">Aksi</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (session()->get('role') == 'Pelanggan') : ?>
                                <?php foreach ($transaksi as $item) : ?>
                                    <?php if ($item['disimpan_oleh'] == $username) : ?>
                                        <?php if ($item['jumlah_trans_alat'] != 0): ?>

                                            <tr data-status="<?= esc($item['status']); ?>">
                                                <td><?= esc($item['tgl_trans_alat']); ?></td>
                                                <td><?= esc($item['nama_alat']); ?></td>
                                                <td><?= esc($item['nama_kategori']); ?></td>
                                                <td><?= esc($item['jumlah_trans_alat']); ?></td>
                                                <td>Rp. <?= esc(number_format($item['harga'], 0, ',', '.')); ?></td>
                                                <td>Rp.
                                                    <?= esc(number_format($item['jumlah_trans_alat'] * $item['harga'], 0, ',', '.')); ?>
                                                </td>
                                                <td><?= esc($item['disimpan_oleh']); ?></td>
                                                <td><?= esc($item['status']); ?></td>
                                            </tr>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>

                            <?php if (session()->get('role') == 'Admin') : ?>
                                <?php foreach ($transaksi as $item) : ?>
                                    <?php if ($item['jumlah_trans_alat'] != 0): ?>
                                        <tr data-status="<?= esc($item['status']); ?>">
                                            <td><?= esc($item['tgl_trans_alat']); ?></td>
                                            <td><?= esc($item['nama_alat']); ?></td>
                                            <td><?= esc($item['nama_kategori']); ?></td>
                                            <td><?= esc($item['jumlah_trans_alat']); ?></td>
                                            <td>Rp. <?= esc(number_format($item['harga'], 0, ',', '.')); ?></td>
                                            <td>Rp. <?= esc(number_format($item['total_harga'], 0, ',', '.')); ?></td>
                                            <td><?= esc($item['disimpan_oleh']); ?></td>
                                            <?php if (session()->get('role') == 'Admin') : ?>
                                                <td>
                                                    <form action="<?= base_url('transaksi/update_status/' . $item['id_trans_alat']); ?>"
                                                        method="POST">
                                                        <?= csrf_field(); ?>
                                                        <select name="status" class="form-control" onchange="this.form.submit()">
                                                            <option value="Tunggu"
                                                                <?= $item['status'] == 'Tunggu' ? 'selected' : ''; ?>>Ditunggu</option>
                                                            <option value="Disetujui"
                                                                <?= $item['status'] == 'Disetujui' ? 'selected' : ''; ?>>Setujui
                                                            </option>
                                                            <option value="Tolak" <?= $item['status'] == 'Tolak' ? 'selected' : ''; ?>>
                                                                Tolak</option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#modalEdit<?= $item['id_trans_alat']; ?>"
                                                        class="btn btn-sm btn-info">Selesai</a>
                                                    <a href="#" data-toggle="modal" data-target="#modal<?= $item['id_trans_alat']; ?>"
                                                        class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            <?php endif ?>
                                        <?php endif ?>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<?php foreach ($transaksi as $item) : ?>
    <div class="modal fade" id="modalEdit<?= $item['id_trans_alat']; ?>" tabindex="-1" aria-labelledby="modalEditLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Selesai</h5>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('transaksi/update/' . $item['id_trans_alat']); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id_alat" value="<?= esc($item['id_alat']); ?>">
                        <input type="hidden" name="disimpan_oleh" value="<?= esc($item['disimpan_oleh']); ?>">
                        <input type="hidden" name="tgl_pengemb_alat" value="<?= esc($item['tgl_trans_alat']); ?>">
                        <input type="hidden" name="total_harga" value="<?= esc($item['total_harga']); ?>">
                        <div class="mb-3">
                            <label for="jumlahAlat" class="form-label">Jumlah Alat</label>
                            <input type="number" class="form-control" id="jumlahAlat" name="jumlah_pengemb_alat"
                                value="<?= esc($item['jumlah_trans_alat']); ?>" required>
                        </div>
                        <input type="hidden" name="id_trans_alat" value="<?= esc($item['id_trans_alat']); ?>">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Selesai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>



<?php foreach ($transaksi as $trans) : ?>
    <div class="modal fade" id="modal<?= $trans['id_trans_alat']; ?>" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-info-circle text-danger mb-4" style="font-size: 70px;"></i>
                    <p>Apakah Anda Yakin untuk Menghapus Data Ini ?</p>
                    <form action="<?= base_url('transaksi/' . $trans['id_trans_alat']); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger">Yakin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<script>
    function filterTable() {
        var filter = document.getElementById('statusFilter').value;
        var table = document.getElementById('transaksiTable');
        var rows = table.getElementsByTagName('tr');

        for (var i = 1; i < rows.length; i++) { // Skip the header row
            var status = rows[i].getAttribute('data-status');

            if (filter === "" || status === filter) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }

    // Set default filter value and apply filter on page load
    window.onload = function() {
        var defaultFilter = 'Tunggu'; // Default filter status
        document.getElementById('statusFilter').value = defaultFilter;
        filterTable();
    }
</script>

<?= $this->endSection(); ?>