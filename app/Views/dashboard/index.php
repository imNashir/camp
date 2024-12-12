<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<!-- Admin -->
		<div class="row">
			
				<div class="col-lg-3 col-6">
					<div class="small-box bg-warning">
						<div class="inner">
							<h3><?= $countAlat; ?></h3>
							<p>Total Semua Alat</p>
						</div>
						<div class="icon">
							<i class="fas fa-box"></i>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?= $countAlatAda; ?></h3>
							<p>Alat Tersedia</p>
						</div>
						<div class="icon">
							<i class="fas fa-check"></i>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?= $countAlatHabis; ?></h3>
							<p>Alat Habis</p>
						</div>
						<div class="icon">
							<i class="fas fa-times-circle"></i>	
						</div>
					</div>
				</div>

				<?php if (session()->get('role') == 'Admin') : ?> 
				<div class="col-lg-3 col-6">
					<div class="small-box bg-dark">
						<div class="inner">
							<h3><?= $countKategori; ?></h3>
							<p>Kategori</p>
						</div>
						<div class="icon">
							<i class="fas fa-tags"></i>
						</div>
					</div>
				</div>

				
				<div class="col-lg-3 col-6">
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?= $countUser; ?></h3>
							<p>User</p>
						</div>
						<div class="icon">
							<i class="fas fa-user"></i>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<!-- Admin & Pelanggan-->
			<div class="col-lg-3 col-6">
				<div class="small-box bg-secondary">
					<div class="inner">
						<h3><?= $countTransaksi; ?></h3>
						<p>Transaksi</p>
					</div>
					<div class="icon">
						<i class="fas fa-inbox"></i>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-6">
				<div class="small-box bg-dark">
					<div class="inner">
						<h3><?= $countPengembalian; ?></h3>
						<p>Pengembalian</p>
					</div>
					<div class="icon">
						<i class="fas fa-external-link-square-alt"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?= $this->endSection(); ?>