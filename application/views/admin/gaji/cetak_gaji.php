<!-- View cetak_gaji.php -->
<div class="container-fluid">
	<h3 class="text-center">Laporan Gaji Pegawai</h3>
	<h4 class="text-center font-weight-bold">PT Eka Teknindo Perkasa</h4>
	<!-- Menampilkan Bulan dan Tahun yang Dipilih -->
	<h6 class="text-center">
		<p><strong>Bulan:</strong>
			<?php
			$nama_bulan = [
				"01" => "Januari",
				"02" => "Februari",
				"03" => "Maret",
				"04" => "April",
				"05" => "Mei",
				"06" => "Juni",
				"07" => "Juli",
				"08" => "Agustus",
				"09" => "September",
				"10" => "Oktober",
				"11" => "November",
				"12" => "Desember"
			];
			echo $nama_bulan[$bulan];
			?>
			<strong>Tahun:</strong> <?php echo $tahun; ?>
		</p>
	</h6>
	<hr>
	<!-- Menampilkan Tabel Laporan Gaji -->
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">NIK</th>
				<th class="text-center">Nama Pegawai</th>
				<th class="text-center">Jabatan</th>
				<th class="text-center">Gaji Pokok</th>
				<th class="text-center">Tunjangan Transport</th>
				<th class="text-center">Uang Makan</th>
				<th class="text-center">Potongan Alpha</th>
				<th class="text-center">Total Gaji</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			foreach ($lap_gaji as $gaji):
				$potongan = $gaji->alpha * 100000; // Sesuaikan nilai potongan
				$total_gaji = $gaji->gaji_pokok + $gaji->tj_transport + $gaji->uang_makan - $potongan;
				?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $gaji->nik; ?></td>
					<td><?php echo $gaji->nama_pegawai; ?></td>
					<td><?php echo $gaji->nama_jabatan; ?></td>
					<td>Rp. <?php echo number_format($gaji->gaji_pokok, 0, ',', '.'); ?></td>
					<td>Rp. <?php echo number_format($gaji->tj_transport, 0, ',', '.'); ?></td>
					<td>Rp. <?php echo number_format($gaji->uang_makan, 0, ',', '.'); ?></td>
					<td>Rp. <?php echo number_format($potongan, 0, ',', '.'); ?></td>
					<td>Rp. <?php echo number_format($total_gaji, 0, ',', '.'); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>