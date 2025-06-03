<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="content">
	<div class="container-fluid">
		<div class="card card-primary">
			<div class="card-body">
				<a href="<?= base_url('alat'); ?>" class="btn btn-dark mb-4">Kembali</a>
				<div class="card card-solid">
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-sm-6">
								<div class="col-12">
									<img src="<?= base_url('img_data/' . (!empty($alat['gambar']) ? $alat['gambar'] : 'default_image.jpg')) ?>"
										class="product-image" alt="Product Image">
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<h3 class="my-3"><?= esc($alat['nama_alat']); ?></h3>
								<hr>
								<div class="col-sm-13 invoice-col">
									<b>Kategori : </b><?= esc($alat['nama_kategori']); ?><br>
									<br>
									<b>Ukuran : </b><?= esc($alat['ukuran']); ?><br>
									<b>Warna : </b><?= esc($alat['warna']); ?><br>
									<b>Harga : </b>Rp. <?= esc(number_format($alat['harga'], 0, ',', '.')); ?><br>
									<b>Jumlah : </b><?= esc($alat['jumlah']); ?><br>
									<b>Deskripsi : </b><?= esc($alat['deskripsi']); ?><br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?= $this->endSection(); ?>