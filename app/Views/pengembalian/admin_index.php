<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<a href="<?= base_url('pengembalian/tambah'); ?>" class="btn btn-primary mb-3"><i class="fas fa-plus-circle mr-2"></i>Tambah Data</a>

		<?php if (session()->getFlashdata('pesan')) : ?>
			<div class="alert alert-success">
				<?= session()->getFlashdata('pesan'); ?>
			</div>
		<?php endif; ?>

		<div class="card">
			<div class="card-body">

				<div class="table-responsive-sm">
					<table class="table table-bordered text-center table-sm " id="tables" style="width:100%">
						<table class="table table-bordered text-center table-sm" id="tables">
							<thead>
								<tr>
									<th scope="col">Tanggal Pengembalian</th>
									<th scope="col">Nama Alat</th>
									<th scope="col">Kategori</th>
									<th scope="col">Jumlah Pengembalian</th>
									<th scope="col">Harga Satuan</th>
									<th scope="col">Total Harga</th>
									<th scope="col">Disimpan Oleh</th>
									<?php if (session()->get('role') == 'Admin') : ?>
									<th scope="col">Aksi</th>
									<?php endif;?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($pengembalian as $item) : ?>
									<tr>
										<td><?= esc($item['tgl_pengemb_alat']); ?></td>
										<td><?= esc($item['nama_alat']); ?></td>
										<td><?= esc($item['nama_kategori']); ?></td>
										<td><?= esc($item['jumlah_pengemb_alat']); ?></td>
										<td>Rp. <?= esc(number_format($item['harga'], 0, ',', '.')); ?></td>
										<td>Rp. <?= esc(number_format($item['total_harga'], 0, ',', '.')); ?></td>
										<td><?= esc($item['disimpan_oleh']); ?></td>

										<td>
											<a href="<?= base_url('pengembalian/delete/' . $item['id_pengemb_alat']); ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">Delete</a>
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

<?= $this->endSection(); ?>


<!-- modal hapus  -->
<?php foreach ($pengembalian as $plg) : ?>
	<div class="modal fade" id="modal<?= $plg['id_pengemb_alat']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
					<form action="<?= base_url('pengembalian/' . $plg['id_pengemb_alat']); ?>" method="POST">
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