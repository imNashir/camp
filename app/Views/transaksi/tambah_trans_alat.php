<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
    <div class="container-fluid">

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Terjadi Kesalahan Inputan </strong>
                <?= session()->getFlashdata('errors'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="card card-primary">
            <div class="card-body">
                <form action="<?= base_url('transaksi/simpan'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="disimpan_oleh" value=<?= session()->get('username') ?>>
					<input type="hidden" name="status" value="Tunggu" id="">
                    <div class="form-row">
                        <div class="col">
                            <label class="col-form-label">Nama Alat </label>
                            <select id="nama_alat" name="id_alat" class="form-control">
                                <option value="">-- Pilih Alat--</option>
                                <?php foreach ($alat as $alt) : ?>
                                    <option value="<?= $alt['id_alat']; ?>" jumlah="<?= $alt['jumlah'] ?>" harga_satuan="<?= $alt['harga'] ?>"><?= $alt['nama_alat'] . ' - ' . $alt['nama_kategori']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <label class="col-form-label">Jumlah alat </label>
                            <input min="0" readonly name="jumlah_alat" id="jumlah_alat" class="form-control" autocomplete="off" value="<?= old('jumlah_alat'); ?>">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col">
                            <label class="col-form-label">Jumlah Transaksi </label>
                            <input type="number" min="0" name="jumlah_trans_alat" id="jumlah_trans_alat" class="form-control" autocomplete="off" value="<?= old('jumlah_trans_alat'); ?>" onchange=calculateTotal()>
                        </div>
                        <div class="col">
                            <label class="col-form-label">Harga Satuan </label>
                            <input readonly min="0" name="harga_satuan" id="harga_satuan" class="form-control"">
                        </div>
                    </div>

                    <div class=" form-row mt-2">
                        <div class="col-3">
                            <label class="col-form-label">Tanggal Transaksi</label>
                            <input type="date" min="0" name="tgl_trans_alat" id="tgl_trans_alat" class="form-control" autocomplete="off" value="<?= old('tgl_trans_alat'); ?>" onchange=calculateTotal()>
                        </div>
                        <div class="col-3">
                            <label class="col-form-label">Tanggal Estimasi Kembali</label>
                            <input type="date" min="0" name="tgl_est" id="tgl_est" class="form-control" autocomplete="off" value="<?= old('tgl_est'); ?>" onchange=calculateTotal()>
                        </div>
                        <div class="col">
                            <label class="col-form-label">Total Harga </label>
                            <input readonly id="total_harga" name="total_harga" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>

                        <?php if (session()->get('role') == 'Admin') : ?>
                            <a class="btn btn-secondary btn-sm" href="<?= base_url('transaksi'); ?>">Kembali</a>
                        <?php endif; ?>

                        <?php if (session()->get('role') == 'Pelanggan') : ?>
                            <a class="btn btn-secondary btn-sm" href="<?= base_url('transaksi/plg'); ?>">Kembali</a>
                        <?php endif; ?>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
    function formatHarga(harga) {
        return harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    document.getElementById('nama_alat').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var harga_satuan = selectedOption.getAttribute('harga_satuan');
        var jumlah_alat = selectedOption.getAttribute('jumlah');

        document.getElementById('harga_satuan').value = formatHarga(harga_satuan);
        document.getElementById('jumlah_alat').value = jumlah_alat;
        calculateTotal();
    });

    function calculateDaysDifference(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const oneDay = 24 * 60 * 60 * 1000;
        const diffDays = Math.round(Math.abs((end - start) / oneDay)) + 1; // include the start day
        return diffDays;
    }

    function calculateTotal() {
        var jumlah_trans_alat = parseInt(document.getElementById("jumlah_trans_alat").value);
        var harga_satuan = document.getElementById("harga_satuan").value;
        var tgl_trans_alat = document.getElementById("tgl_trans_alat").value;
        var tgl_est = document.getElementById("tgl_est").value;

        if (tgl_trans_alat && tgl_est) {
            var daysDifference = calculateDaysDifference(tgl_trans_alat, tgl_est);
            var hargaSatuanInt = parseInt(harga_satuan.replace(/\./g, ''));
            var total_harga = jumlah_trans_alat * hargaSatuanInt * daysDifference;

            if (!isNaN(total_harga)) {
                document.getElementById("total_harga").value = formatHarga(total_harga);
            } else {
                document.getElementById("total_harga").value = "";
            }
        }
    }
</script>

<?= $this->endSection(); ?>
