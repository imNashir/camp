<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<?php if (session()->getFlashdata('error')) : ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Terjadi Kesalahan Inputan </strong>
				<?= session()->getFlashdata('error'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="<?= base_url('/user/simpan'); ?>" enctype="multipart/form-data">
							<?= csrf_field(); ?>
							<div class="form-row">
								<div class="col">
									<label class="col-form-label">Nama Lengkap </label>
									<input type="text" name="nama_lengkap" class="form-control" autocomplete="off" value="<?= old('nama_lengkap'); ?>">
								</div>
							</div>

							<div class="form-group ">
								<label for="Nama">Username : </label>
								<input type="text" name="username" class="form-control" autocomplete="off" value="<?= old('username'); ?>">
							</div>
							<div class="form-group ">
								<label for="Nama">Password : </label>
								<div class="input-group">
									<input type="password" id="password" name="password" class="form-control">
									<div class="input-group-append">
										<button type="button" id="togglePassword" class="btn btn-outline-secondary">
											<i class="fas fa-eye"></i>
										</button>
									</div>
								</div>
							</div>

							<div class="form-group ">
								<label for="select-roles">Roles : </label>
								<select name="role" class="form-control">
									<option value="">-- Pilih Role --</option>
									<option value="Admin">Admin</option>
									<option value="Pelanggan">Pelanggan</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Simpan Data</button>
							<a href="<?= base_url('user'); ?>" class="btn btn-secondary"> Kembali </a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
	const passwordInput = document.getElementById('password');
	const toggleButton = document.getElementById('togglePassword');

	toggleButton.addEventListener('click', function() {
		const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
		passwordInput.setAttribute('type', type);

		if (type === 'password') {
			toggleButton.querySelector('i').classList.remove('fa-eye-slash');
			toggleButton.querySelector('i').classList.add('fa-eye');
		} else {
			toggleButton.querySelector('i').classList.remove('fa-eye');
			toggleButton.querySelector('i').classList.add('fa-eye-slash');
		}
	});
</script>
<?= $this->endSection(); ?>