<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">
		<div class="card card-primary">
			<div class="card-body">
				<form action="<?= base_url('kategori/update/' . $kategori['id_kategori']); ?>" method="POST">

					<div class="text-danger">
						<?= session()->getFlashdata('errors'); ?>
					</div>

					<div class="form-group">
						<label>Nama Kategori</label>
						<input type="text" class="form-control" autocomplete="off" name="nama_kategori" value="<?= $kategori['nama_kategori']; ?>">
					</div>

					<button type="submit" class="btn btn-primary">Simpan Data</button>
					<a href="<?= base_url('kategori'); ?>" class="btn btn-secondary">Kembali</a>
				</form>

			</div>
			<!-- /.card -->

		</div>
</section>

<?= $this->endSection(); ?>