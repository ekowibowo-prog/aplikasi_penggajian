<?php

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		// Cek apakah pengguna sudah login
		if (!$this->session->userdata('hak_akses') || $this->session->userdata('hak_akses') != 1) {
			// Jika belum login atau bukan admin, arahkan ke halaman login
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Anda harus login sebagai admin!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
			redirect('login');
		}

	}
	public function index()
	{

		$pegawai = $this->db->query("SELECT * FROM data_pegawai");
		$admin = $this->db->query("SELECT * FROM data_pegawai WHERE jabatan = 'Admin'");
		$jabatan = $this->db->query("SELECT * FROM data_jabatan");
		$kehadiran = $this->db->query("SELECT * FROM data_kehadiran");

		$data['title'] = "Dashboard";
		$data['pegawai'] = $pegawai->num_rows();
		$data['admin'] = $admin->num_rows();
		$data['jabatan'] = $jabatan->num_rows();
		$data['kehadiran'] = $kehadiran->num_rows();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/dashboard.php', $data);
		$this->load->view('template_admin/footer');
	}
}

