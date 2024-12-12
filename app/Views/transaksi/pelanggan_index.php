<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">
		
		<a href="<?= base_url('/transaksi/tambah'); ?>" class="btn btn-primary mb-3"><i class="fas fa-plus-circle mr-2"></i>Tambah Data</a>

		<?php if (session()->getFlashdata('pesan')) : ?>
			<div class="alert alert-success" role="alert">
				<?= session()->getFlashdata('pesan'); ?>
			</div>
		<?php endif ?>

		<div class="card">
			<div class="card-body">
				<div class="table-responsive-sm">
					<table class="table table-bordered text-center table-sm " id="tables" style="width:100%">
						<thead>
							<tr>
								<th scope="col">Tanggal</th>
								<th scope="col">Nama Alat </th>
								<th scope="col">Kategori </th>
								<th scope="col">Jumlah Transaksi</th>
								<th scope="col">Harga Satuan</th>
								<th scope="col">Total Harga</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<!-- data ditampilkan dengan server side  -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<?php foreach ($transaksi as $trans) : ?>
	<div class="modal fade" id="modal<?= $trans['id_trans_alat']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
					<form action="<?= base_url('transaksi/' . $trans['id_trans_alat']); ?>" method="POST">
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

<?= $this->section('script'); ?>
<script>
	$(function() {
		$("#tables").DataTable({
			responsive: true,
			lengthChange: true,
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('transaksi/data-pengembalian-alat-plg'); ?>',
			columns: [{
					data: 'tgl_trans_alat',
					orderable: false
				},
				{
					data: 'nama_alat'
				},
				{
					data: 'nama_kategori'
				},
				{
					data: 'jumlah_trans_alat'
				},
				{
					data: 'harga_satuan'
				},
				{
					data: 'total_harga'
				},
				{
					data: 'nama'
				},
				{
					data: 'action',
					orderable: false
				}
			]
		});
	});
</script>
<?= $this->endSection(); ?>