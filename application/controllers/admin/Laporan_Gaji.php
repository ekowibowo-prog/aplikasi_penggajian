<?php

class Laporan_Gaji extends CI_Controller
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
		$data['title'] = "Laporan Gaji Pegawai";

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/laporan_gaji');
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_gaji()
	{
		$data['title'] = "Cetak Laporan Gaji Pegawai";
		$data['potongan'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();

		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$bulantahun = $bulan . $tahun;

		$data['lap_gaji'] = $this->db->query("
			SELECT 
				data_pegawai.nik,
				data_pegawai.nama_pegawai,
				data_jabatan.nama_jabatan,
				data_jabatan.gaji_pokok,
				data_jabatan.tj_transport,
				data_jabatan.uang_makan,
				data_kehadiran.alpha
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
			WHERE data_kehadiran.bulan = '$bulantahun'
		")->result();

		// Kirim bulan dan tahun ke view
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		// Cek apakah ada data
		if (empty($data['lap_gaji'])) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Data gaji untuk bulan dan tahun yang dipilih tidak ditemukan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('admin/laporan_gaji');
		} else {
			$this->load->view('template_admin/header', $data);
			$this->load->view('admin/gaji/cetak_gaji', $data);
		}
	}
}
?>