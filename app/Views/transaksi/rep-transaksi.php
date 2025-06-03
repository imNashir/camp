<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<?php if (session()->getFlashdata('error')) : ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?= session()->getFlashdata('error'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>

		<div class="col-lg-4">
			<div class="card text-white bg-primary mb-3">
				<div class="card-header">Pilih Periode</div>
				<div class="card-body bg-white">
					<p class="card-text">
					<form action="<?= base_url('transaksi/filtered-data'); ?>" method="GET">
						<?= csrf_field(); ?>
						<div class="form-group">
							<label for="">Tanggal Awal</label>
							<input type="date" name="tgl_awal" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="">Tanggal Akhir</label>
							<input type="date" name="tgl_akhir" class="form-control" required>
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block"><i
										class="fas fa-print mr-2"></i>Cetak Data</button>
							</div>
					</form>
					</p>
				</div>

			</div>
		</div>
	</div>
</section>

<?= $this->endSection(); ?>