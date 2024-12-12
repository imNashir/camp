	<?= $this->extend('layout/template'); ?>

	<?= $this->section('content'); ?>
	<section class="content">
		<div class="container-fluid">

			<?php if (session()->get('role') == "Admin") : ?>
				<a href="<?= base_url('alat/tambah'); ?>" class="btn btn-primary mb-3">
					<i class="fas fa-plus-circle mr-2"></i> Tambah Data
				</a>
				<a href="<?= base_url('alat/rep-alat-habis'); ?>" class="btn btn-danger mb-3"><i class="fas fa-print mr-2"></i>Cetak Alat </a>
			<?php endif; ?>

			<?php if (session()->getFlashdata('pesan')) : ?>
				<div class="alert alert-success" role="alert">
					<?= session()->getFlashdata('pesan'); ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif ?>

			<?php if (session()->getFlashdata('empty')) : ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= session()->getFlashdata('empty'); ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>

			<div class="card">
				<div class="card-body">
					<div class="table-responsive-sm">
						<table class="table table-bordered text-center table-sm" style="width:100%">
							<thead>
								<tr>
									<th>Nama Alat</th>
									<th>Kategori</th>
									<th>Harga</th>
									<th>Jumlah</th>
									<th>Ukuran</th>
									<th>Warna</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($alat as $a) : ?>
									<tr>
										<td><?= esc($a['nama_alat']); ?></td>
										<td>
											<?php
											// Find the category name by id_kategori
											foreach ($kategori as $k) {
												if ($k['id_kategori'] == $a['id_kategori']) {
													echo esc($k['nama_kategori']);
													break;
												}
											}
											?>
										</td>
										<td>Rp. <?= esc(number_format($a['harga'], 0, ',', '.')); ?></td>
										<td><?= esc($a['jumlah']); ?></td>
										<td><?= esc($a['ukuran']); ?></td>
										<td><?= esc($a['warna']); ?></td>
										<td>
											<?php if ($a['jumlah'] > 0) : ?>
												Tersedia
											<?php else : ?>
												Habis
											<?php endif; ?>
										</td>
										<td>
											<a href="<?= base_url('alat/detail/' . $a['id_alat']); ?>" class="btn btn-sm btn-primary">Detail</a>
											<?php if (session()->get('role') == "Admin") : ?>
												<a href="<?= base_url('alat/edit/' . $a['id_alat']); ?>" class="btn btn-sm btn-warning">Edit</a>
												<a href="<?= base_url('alat/delete/' . $a['id_alat']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- modal hapus -->
	<?php foreach ($alat as $alt) : ?>
		<div class="modal fade" id="modal<?= $alt['id_alat']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header justify-content-center">
						<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body text-center">
						<i class="fas fa-info-circle text-danger mb-4" style="font-size: 70px;"></i>
						<p>Apakah Anda Yakin untuk Menghapus <strong><?= $alt['nama_alat']; ?></strong> ?</p>
						<form action="<?= base_url('alat/' . $alt['id_alat']); ?>" method="POST">
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

	<?= $this->endSection(); ?>

	<!-- <?= $this->section('script'); ?>
<script>
	$(function() {
		$("#tables").DataTable({
			responsive: true,
			lengthChange: true,
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('alat/data-alat'); ?>',
			columns: [{
					data: 'nama_alat',
					name: 'alat.nama_alat'
				},
				{
					data: 'nama_kategori',
					name: 'kategori.nama_kategori'
				},
				{
					data: 'jumlah',
					name: 'alat.jumlah'
				},
				{
					data: 'ukuran',
					name: 'alat.ukuran'
				},
				{
					data: 'warna',
					name: 'alat.warna'
				},
				{
					data: 'status',
					orderable: false
				},
				{
					data: 'action',
					orderable: false
				}
			]
		});
	});
</script>
<?= $this->endSection(); ?> -->