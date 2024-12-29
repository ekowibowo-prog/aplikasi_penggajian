<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Penggajian extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();


		// Validasi jika pengguna belum login atau tidak memiliki hak akses
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

	private function get_bulan_tahun()
	{
		// Mendapatkan bulan dan tahun dari GET request atau default ke bulan dan tahun saat ini
		$bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
		$tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
		return $bulan . $tahun;
	}

	public function index()
	{
		$data['title'] = "Data Gaji Pegawai";

		// Format bulan dan tahun
		$bulantahun = $this->get_bulan_tahun();

		// Query data potongan dan data gaji
		$data['potongan'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();
		$data['gaji'] = $this->db->query("SELECT data_pegawai.nik, data_pegawai.nama_pegawai, 
            data_pegawai.jenis_kelamin, data_jabatan.nama_jabatan, data_jabatan.gaji_pokok, 
            data_jabatan.tj_transport, data_jabatan.uang_makan, data_kehadiran.alpha
            FROM data_pegawai
            INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
            INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
            WHERE data_kehadiran.bulan = '$bulantahun'
            ORDER BY data_pegawai.nama_pegawai ASC")->result();

		// Jika data gaji kosong, tambahkan pesan
		if (empty($data['gaji'])) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data tidak ditemukan!</strong> Tidak ada data untuk bulan dan tahun yang dipilih.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
		}

		// Load view
		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/data_gaji', $data);
		$this->load->view('template_admin/footer');
	}

	public function cetak_gaji()
	{
		$data['title'] = "Cetak Data Gaji Pegawai";

		// Format bulan dan tahun
		$bulantahun = $this->get_bulan_tahun();

		// Query data potongan dan data gaji
		$data['potongan'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();
		$data['cetak_gaji'] = $this->db->query("SELECT data_pegawai.nik, data_pegawai.nama_pegawai, 
            data_pegawai.jenis_kelamin, data_jabatan.nama_jabatan, data_jabatan.gaji_pokok, 
            data_jabatan.tj_transport, data_jabatan.uang_makan, data_kehadiran.alpha
            FROM data_pegawai
            INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
            INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
            WHERE data_kehadiran.bulan = '$bulantahun'
            ORDER BY data_pegawai.nama_pegawai ASC")->result();

		// Jika data cetak gaji kosong, tambahkan pesan dan redirect
		if (empty($data['cetak_gaji'])) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Tidak ada data untuk bulan dan tahun yang dipilih.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
			redirect('admin/data_penggajian');
		}

		// Load view cetak gaji
		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_gaji', $data);
	}
}
?>