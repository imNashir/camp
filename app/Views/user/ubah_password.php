<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="content">
	<div class="container-fluid">

		<?php if (session()->getFlashdata('pesan')) : ?>
			<div class="alert alert-success" role="alert">
				<?= session()->getFlashdata('pesan'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif ?>

		<?php if (session()->getFlashdata('error')) : ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Terjadi Kesalahan Inputan </strong>
				<?= session()->getFlashdata('error'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>

		<div class="card">
			<div class="card-body">
				<form action="<?= base_url('user/ubah-password'); ?>" method="POST">
					<?= csrf_field(); ?>
					<div class="form-group">
						<label for="current_password">Password Lama</label>
						<input type="password" class="form-control" name="password_lama" autocomplete="off" value="<?= old('password_lama'); ?>">
						<small class="text-danger"><?= session()->getFlashdata('passlama'); ?></small>
					</div>
					<div class="form-group">
						<label for="new_password">Password Baru</label>
						<input type="password" class="form-control" name="password_baru" autocomplete="off" value="<?= old('password_baru'); ?>">
					</div>
					<div class="form-group">
						<label for="re_password">Konfirmasi Password</label>
						<input type="password" class="form-control" name="re_password" autocomplete="off" value="<?= old('re_password'); ?>">
					</div>

					<button type="submit" class="btn btn-primary ">Simpan</button>
				</form>
			</div>
		</div>

	</div>
</section>



<?= $this->endSection(); ?>