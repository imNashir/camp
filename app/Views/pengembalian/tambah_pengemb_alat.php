<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<!-- validasi -->
		<?php if (session()->getFlashdata('errors')) : ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Terjadi Kesalahan Inputan </strong>
				<?= session()->getFlashdata('errors'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>
		<!-- end validasi -->

		<div class="card card-primary">
			<div class="card-body">
				<form action="<?= base_url('pengembalian/simpan'); ?>" method="POST">
					<?= csrf_field(); ?>
					<input type="hidden" name="disimpanOleh" value=<?= session()->get('username') ?>>
					<div class="form-row">
						<div class="col">
							<label class="col-form-label">Nama Alat</label>
							<select id="nama_alat" name="id_alat" class="form-control">
								<option value="">-- Pilih Alat --</option>
								<?php foreach ($alat as $alt) : ?>
									<option value="<?= $alt['id_alat']; ?>" jumlah="<?= $alt['jumlah'] ?>" harga_satuan="<?= $alt['harga'] ?>" <?= set_select('id_alat', $alt['id_alat']); ?>>
										<?= $alt['nama_alat'] . ' - ' . $alt['nama_kategori']; ?>
									</option>
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
							<label class="col-form-label">Jumlah Pengembalian </label>
							<input type="number" min="0" name="jumlah_pengemb_alat" id="jumlah_pengemb_alat" class="form-control" autocomplete="off" value="<?= old('jumlah_pengemb_alat'); ?> " onchange="calculateTotal()">
						</div>
						<div class="col">
							<label class="col-form-label">Harga Satuan </label>
							<input readonly min="0" name="harga_satuan" id="harga_satuan" class="form-control" ">
						</div>
					</div>

					<div class=" form-row mt-2">
							<div class="col">
								<label class="col-form-label">Tanggal Pengembalian</label>
								<input type="date" min="0" name="tgl_pengemb_alat" class="form-control" autocomplete="off" value="<?= old('tgl_pengemb_alat'); ?>">
								<input type="hidden" name="disimpan_oleh" value="<?= session()->get('nama_lengkap'); ?>">
							</div>
							<div class="col">
								<label class="col-form-label">Total Harga </label>
								<input readonly id="total_harga" name="total_harga" class="form-control" autocomplete="off">
							</div>
						</div>

						<div class="mt-3">
							<button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>

							<?php if (session()->get('role') == 'Admin') : ?>
								<a class="btn btn-secondary btn-sm" href="<?= base_url('pengembalian'); ?>">Kembali</a>
							<?php endif ?>

							<?php if (session()->get('role') == 'Pelanggan') : ?>
								<a class="btn btn-secondary btn-sm" href="<?= base_url('pengembalian/plg'); ?>">Kembali</a>
							<?php endif ?>
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

	function calculateTotal() {
		var jumlah_pengemb_alat = parseInt(document.getElementById("jumlah_pengemb_alat").value);
		var harga_satuan = document.getElementById("harga_satuan").value;
		var hargaSatuanInt = parseInt(harga_satuan.replace(/\./g, ''));
		var total_harga = jumlah_pengemb_alat * hargaSatuanInt;

		if (!isNaN(total_harga)) {
			document.getElementById("total_harga").value = formatHarga(total_harga);
		} else {
			document.getElementById("total_harga").value = "";
		}
	}
</script>

<?= $this->endSection(); ?>