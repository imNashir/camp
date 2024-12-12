<style>
	table,
	td,
	th {
		border: 1px solid black;
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}

	th,
	td {
		padding: 2px;
	}

	th {
		background-color: #CCC;
	}
</style>

<h1>Data Alat Habis | Plinplan</h1>

<table>
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Alat</th>
			<th>Kategori</th>
			<th>Ukuran</th>
			<th>Warna</th>
			<th>Deskripsi</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1 ?>
		<?php foreach ($habis as $hbs) : ?>
			<tr>
				<td><?= $no++; ?></td>
				<td><?= esc($hbs['nama_alat']); ?></td>
				<td><?= esc($hbs['nama_kategori']); ?></td>
				<td><?= esc($hbs['ukuran']); ?></td>
				<td><?= esc($hbs['warna']); ?></td>
				<td><?= esc($hbs['deskripsi']); ?></td>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>