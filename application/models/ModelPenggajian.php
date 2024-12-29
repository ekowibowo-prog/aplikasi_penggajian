<?php

class ModelPenggajian extends CI_model
{
	public function get_data($table)
	{
		return $this->db->get($table);
	}

	public function get_data_by_id($table, $where)
	{
		return $this->db->get_where($table, $where); // Pastikan tabel dan kondisi benar
	}
	public function get_data_pegawai_by_id($id)
	{
		$this->db->where('id_pegawai', $id);
		$query = $this->db->get('data_pegawai');
		return $query->row(); // Gunakan row() untuk satu data, atau result() untuk banyak data
	}

	public function insert_data($data, $table)
	{
		$this->db->insert($table, $data);
	}

	public function update_data($table, $data, $whare)
	{
		$this->db->update($table, $data, $whare);
	}

	public function delete_data($whare, $table)
	{
		$this->db->where($whare);
		$this->db->delete($table);
	}

	public function insert_batch($table = null, $data = array())
	{
		$jumlah = count($data);
		if ($jumlah > 0) {
			$this->db->insert_batch($table, $data);
		}
	}

	public function cek_login($username, $password)
	{
		// Hash password yang dimasukkan oleh pengguna
		$password_hashed = md5($password);

		// Query untuk mengecek apakah username dan password yang di-hash cocok dengan yang ada di database
		$this->db->where('username', $username);
		$this->db->where('password', $password_hashed);
		$query = $this->db->get('data_pegawai');

		if ($query->num_rows() > 0) {
			return $query->row();  // Mengembalikan data pegawai yang ditemukan
		} else {
			return false;  // Username atau password salah
		}


	}
	public function get_laporan_gaji($bulan, $tahun)
	{
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$query = $this->db->get('data_gaji'); // Ganti 'data_gaji' dengan nama tabel Anda

		if ($query->num_rows() > 0) {
			return $query->result(); // Jika data ditemukan
		} else {
			return []; // Jika data tidak ditemukan
		}
	}

}

?>