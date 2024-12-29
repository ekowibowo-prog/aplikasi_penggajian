<?php

class Laporan_Absensi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('hak_akses') != '1') {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Anda Belum Login!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('login');
		}
	}

	public function index()
	{
		$data['title'] = "Laporan Absensi Pegawai";

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/absensi/laporan_absensi');
		$this->load->view('template_admin/footer');
	}
	public function cetak_laporan_absensi()
	{
		// Ambil bulan dan tahun dari form
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		// Validasi apakah bulan dan tahun sudah dipilih
		if (!$bulan || !$tahun) {
			// Redirect atau tampilkan pesan jika bulan atau tahun tidak dipilih
			$this->session->set_flashdata('pesan', 'Silakan pilih bulan dan tahun terlebih dahulu.');
			redirect('admin/laporan_absensi');
			return;
		}

		// Gabungkan bulan dan tahun untuk mencari data
		$bulantahun = $bulan . $tahun;

		// Cek apakah ada data absensi untuk bulan dan tahun yang dipilih
		$this->db->select('*');
		$this->db->from('data_kehadiran');
		$this->db->where('bulan', $bulantahun);
		$query = $this->db->get();
		// Cek apakah ada data
		if ($query->num_rows() > 0) {
			// Ambil data kehadiran
			$data['lap_kehadiran'] = $query->result();
			$data['bulan'] = $bulan;  // Pastikan bulan dikirim ke view
			$data['tahun'] = $tahun;  // Pastikan tahun dikirim ke view

			// Tampilkan view cetak_absensi
			$this->load->view('admin/absensi/cetak_absensi', $data);
		} else {
			// Jika tidak ada data, beri pesan
			$this->session->set_flashdata('pesan', 'Data absensi untuk bulan dan tahun yang dipilih tidak ditemukan!');
			redirect('admin/laporan_absensi');
		}

	}

}

?>