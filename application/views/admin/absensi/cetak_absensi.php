<!DOCTYPE html>
<html>

<head>
	<title>Laporan Absensi</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/all.css'); ?>">
</head>

<body>
	<center>
		<h1>PT Eka Teknindo Perkasa</h1>
		<h2>Laporan Kehadiran Pegawai</h2>
	</center>

	<!-- Menampilkan Bulan dan Tahun -->
	<table>
		<tr>
			<td>Bulan</td>
			<td>:</td>
			<td><?php echo isset($bulan) ? $bulan : ''; ?></td>
		</tr>
		<tr>
			<td>Tahun</td>
			<td>:</td>
			<td><?php echo isset($tahun) ? $tahun : ''; ?></td>
		</tr>
	</table>


	<!-- Menampilkan Tabel Kehadiran -->
	<table class="table table-bordered table-striped">
		<tr>
			<th class="text-center">No</th>
			<th class="text-center">NIK</th>
			<th class="text-center">Nama Pegawai</th>
			<th class="text-center">Jabatan</th>
			<th class="text-center">Hadir</th>
			<th class="text-center">Sakit</th>
			<th class="text-center">Alpha</th>
		</tr>

		<?php
		$no = 1;
		foreach ($lap_kehadiran as $l): ?>
			<tr>
				<td class="text-center"><?php echo $no++ ?></td>
				<td class="text-center"><?php echo $l->nik ?></td>
				<td class="text-center"><?php echo $l->nama_pegawai ?></td>
				<td class="text-center"><?php echo $l->nama_jabatan ?></td>
				<td class="text-center"><?php echo $l->hadir ?></td>
				<td class="text-center"><?php echo $l->sakit ?></td>
				<td class="text-center"><?php echo $l->alpha ?></td>
			</tr>
		<?php endforeach; ?>
	</table>

</body>

</html>

<script type="text/javascript">
	window.print();
</script>