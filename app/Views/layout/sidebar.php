<div class="sidebar">
	<nav class="mt-2" style="font-size:14px;">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

			<li class="nav-item">
				<a href="<?= base_url('dashboard'); ?>" class="nav-link">
					<i class="nav-icon fas fa-tachometer-alt"></i>
					<p>Dashboard</p>
				</a>
			</li>
			<li class="nav-header">Menu Data</li>
			
				<li class="nav-item">
					<a class="nav-link ">
						<i class="nav-icon fas fa-file-alt"></i>
						<p>
							Data Master
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" id="dropwdown">
						<li class="nav-item">
							<a href="<?= base_url('alat'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Alat</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="<?= base_url('kategori'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Kategori</p>
							</a>
						</li>
					</ul>
				</li>

			<li class="nav-item">
				<a class="nav-link ">
					<i class="nav-icon fas fa-money-check-alt"></i>
					<p>
						Data Penyewaan
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview" id="dropwdown">
				
				<?php if (session()->get('role') == 'Admin') : ?>
						<li class="nav-item">
							<a href="<?= base_url('transaksi'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Transaksi</p>
							</a>
							</li>
							<li class="nav-item">
								<a href="<?= base_url('pengembalian'); ?>" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Pengembalian</p>
								</a>
							</li>
						
					<?php elseif (session()->get('role') == 'Pelanggan') : ?>
						<li class="nav-item">
							<a href="<?= base_url('transaksi'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Transaksi</p>
							</a>
							</li>
								
									<!-- <li class="nav-item">
										<a href="<?= base_url('pengembalian/plg'); ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Pengembalian</p>
										</a>
									</li> -->
					<?php endif; ?>
				</ul>
			</li>

			<!-- laporan -->
			<?php if (session()->get('role') == 'Admin') : ?>
			<li class="nav-header">Menu Laporan</li>
			
			<li class="nav-item">
				<a class="nav-link ">
					<i class="nav-icon fas fa-file-pdf"></i>
					<p>
						Laporan
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview" id="dropwdown">
					<li class="nav-item">
						<a href="<?= base_url('transaksi/rep-transaksi'); ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Transaksi</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('pengembalian/rep-pengembalian'); ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Pengembalian</p>
						</a>
					</li>
				</ul>
			</li>


			<li class="nav-header">Menu User</li>
			
				<li class="nav-item">
					<a href="<?= base_url('user'); ?>" class="nav-link">
						<i class="nav-icon fas fa-users-cog"></i>
						<p>Kelola User</p>
					</a>
				</li>
			<?php endif; ?>

			<li class="nav-item">
				<a href="<?= base_url('user/ubah-password'); ?>" class="nav-link">
					<i class="nav-icon fas fa-lock"></i>
					<p>Ubah Password</p>
				</a>
			</li>


			</li>
			<li class="nav-item">
				<a href="<?= base_url('auth/logout'); ?>" class="nav-link">
					<i class="nav-icon fas fa-sign-out-alt"></i>
					<p>Logout</p>
				</a>
			</li>
		</ul>
	</nav>
</div>