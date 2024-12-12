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

		<div class="card">
			<form action="<?= base_url('kategori/simpan'); ?>" method="POST" id="tambah-kategori">
				<div class="card-body">
					<div class="form-group">
						<label>Nama Kategori</label>
						<input type="text" class="form-control" autocomplete="off" name="nama_kategori">
						<span class="text-danger error-text nama_kategori_error text-small"></span>
					</div>
					<button type="submit" class="btn btn-primary">Simpan Data</button>
					<a href="<?= base_url('kategori'); ?>" class="btn btn-secondary">Kembali</a>
				</div>
			</form>
		</div>
		<!-- /.card -->

	</div>
</section>

<?= $this->endSection(); ?>