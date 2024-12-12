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

		<?php if (session()->getFlashdata('dupl')) : ?>
			<div class="alert alert-danger">
				<?= session()->getFlashdata('dupl'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>
		<!-- end validasi -->

		<div class="card card-primary">
			<div class="card-body">
				<form method="POST" action="<?= base_url('alat/simpan'); ?>" enctype="multipart/form-data" class="no-style">
					<?= csrf_field(); ?>
					<div class="form-row">
						<div class="col">
							<label class="col-form-label">Nama Alat </label>
							<input type="text" name="nama_alat" class="form-control" autocomplete="off" value="<?= old('nama_alat'); ?>">
						</div>
						<div class="col">
							<label class="col-form-label">Kategori </label>
							<select name="id_kategori" class="form-control">
								<option value="">-- Pilih Kategori --</option>
								<?php foreach ($kategori as $ktg) : ?>
									<option value="<?= $ktg['id_kategori']; ?>"><?= $ktg['nama_kategori']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group mt-3">
						<label class="col-form-label">Gambar </label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="gambar" id="gambarInput" onchange="updateFileName()">
							<label class="custom-file-label" for="gambarInput">Pilih Gambar...</label>
						</div>
					</div>

					<div class="form-row">
						<div class="col">
							<label class="col-form-label">Ukuran </label>
							<input type="text" name="ukuran" class="form-control" min=0 autocomplete="off" value="<?= old('ukuran'); ?>">
						</div>

						<div class="col">
							<label class="col-form-label">Warna </label>
							<input type="text" name="warna" class="form-control" autocomplete="off" value="<?= old('warna'); ?>">
						</div>

						<div class="col">
							<label class="col-form-label">Jumlah </label>
							<input type="number" name="jumlah" class="form-control" min=0 autocomplete="off" value="<?= old('jumlah'); ?>">
						</div>
						<div class="col">
							<label class="col-form-label">Harga </label>
							<input type="number" name="harga" class="form-control" min=0 autocomplete="off" value="<?= old('harga'); ?>">
						</div>
					</div>

					<div class="form-row mt-3 mb-3">
						<label class="col-form-label">Deskripsi </label>
						<div class="col-sm-12">
							<textarea class="form-control" rows="3" name="deskripsi"></textarea>
						</div>
					</div>


					<button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>
					<a href="/alat" class="btn btn-secondary btn-sm">Kembali</a>

				</form>
			</div>
		</div>
	</div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
	function updateFileName() {
		var input = document.getElementById('gambarInput');

		var fileName = input.files[0].name;

		var label = document.querySelector('.custom-file-label');
		label.innerHTML = fileName;
	}
</script>
<?= $this->endSection(); ?>