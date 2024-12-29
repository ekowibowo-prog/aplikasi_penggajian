<?php if (empty($pegawai)): ?>
	<p>Data tidak ditemukan.</p>
	<a href="<?php echo base_url('admin/data_pegawai'); ?>" class="btn btn-warning">Kembali</a>
	<?php return; ?>
<?php endif; ?>

<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<div class="card" style="width: 60%; margin-bottom: 100px">
		<div class="card-body">

			<form method="POST" action="<?php echo base_url('admin/data_pegawai/update_data_aksi'); ?>"
				enctype="multipart/form-data">

				<!-- Hidden ID Pegawai -->
				<input type="hidden" name="id_pegawai" value="<?php echo $pegawai->id_pegawai; ?>">

				<!-- NIK -->
				<div class="form-group">
					<label>NIK</label>
					<input type="number" name="nik" class="form-control" value="<?php echo $pegawai->nik; ?>" required>
				</div>

				<!-- Nama Pegawai -->
				<div class="form-group">
					<label>Nama Pegawai</label>
					<input type="text" name="nama_pegawai" class="form-control"
						value="<?php echo $pegawai->nama_pegawai; ?>" required>
				</div>

				<!-- Username -->
				<div class="form-group">
					<label>Username</label>
					<input type="text" name="username" class="form-control" value="<?php echo $pegawai->username; ?>"
						required>
				</div>

				<!-- Password -->
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" name="password"
						placeholder="Kosongkan jika tidak ingin merubah password">

					<!-- Jenis Kelamin -->
					<div class="form-group">
						<label>Jenis Kelamin</label>
						<select name="jenis_kelamin" class="form-control" required>
							<option value="Laki-Laki" <?php echo ($pegawai->jenis_kelamin == 'Laki-Laki') ? 'selected' : ''; ?>>Laki-Laki</option>
							<option value="Perempuan" <?php echo ($pegawai->jenis_kelamin == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
						</select>
					</div>

					<div class="form-group">
						<label>Jabatan</label>
						<select name="jabatan" class="form-control" required>
							<?php foreach ($jabatan as $j): ?>
								<option value="<?php echo $j->nama_jabatan ?>" <?php echo ($j->nama_jabatan == $pegawai->jabatan) ? 'selected' : '' ?>>
									<?php echo $j->nama_jabatan ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>


					<!-- Tanggal Masuk -->
					<div class="form-group">
						<label>Tanggal Masuk</label>
						<input type="date" name="tanggal_masuk" class="form-control"
							value="<?php echo $pegawai->tanggal_masuk; ?>" required>
					</div>

					<!-- Status -->
					<div class="form-group">
						<label>Status</label>
						<select name="status" class="form-control" required>
							<option value="Karyawan Tetap" <?php echo ($pegawai->status == 'Karyawan Tetap') ? 'selected' : ''; ?>>Karyawan Tetap</option>
							<option value="Karyawan Tidak Tetap" <?php echo ($pegawai->status == 'Karyawan Tidak Tetap') ? 'selected' : ''; ?>>Karyawan Tidak Tetap</option>
						</select>
					</div>

					<!-- Hak Akses -->
					<div class="form-group">
						<label>Hak Akses</label>
						<select name="hak_akses" class="form-control" required>
							<option value="1" <?php echo ($pegawai->hak_akses == '1') ? 'selected' : ''; ?>>Admin</option>
							<option value="2" <?php echo ($pegawai->hak_akses == '2') ? 'selected' : ''; ?>>Pegawai
							</option>
						</select>
					</div>

					<div class="form-group">
						<label>Photo</label>
						<input type="file" name="photo" class="form-control">

						<!-- Menampilkan gambar jika sudah ada di database -->
						<?php if (!empty($pegawai->photo)): ?>
							<div class="mt-2">
								<img src="<?php echo base_url('photo/' . $pegawai->photo); ?>" alt="Foto Pegawai"
									width="150px" style="border: 1px solid #ddd; padding: 5px;">
							</div>
							<p class="text-muted mt-2"></p>
						<?php else: ?>
							<p class="text-muted mt-2">Belum ada foto yang diunggah</p>
						<?php endif; ?>

						<!-- Input hidden untuk menyimpan nama file foto lama -->
						<input type="hidden" name="photo_lama" value="<?php echo $pegawai->photo; ?>">
					</div>

					<!-- Buttons -->
					<button type="submit" class="btn btn-success">Simpan</button>
					<a href="<?php echo base_url('admin/data_pegawai'); ?>" class="btn btn-warning">Kembali</a>

			</form>

		</div>
	</div>

</div>