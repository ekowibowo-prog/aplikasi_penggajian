<?php

class Data_Pegawai extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelPenggajian');
		$this->load->library('form_validation');

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
	public function index()
	{

		// Menampilkan halaman
		$data['title'] = 'Data Pegawai';
		$data['pegawai'] = $this->ModelPenggajian->get_data('data_pegawai')->result();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/pegawai/data_pegawai', $data);
		$this->load->view('template_admin/footer');
	}
	public function tambah_data()
	{
		$data['title'] = "Tambah Data Pegawai";
		$data['jabatan'] = $this->ModelPenggajian->get_data('data_jabatan')->result();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/pegawai/tambah_dataPegawai', $data);
		$this->load->view('template_admin/footer');
	}

	public function tambah_data_aksi()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->tambah_data();
		} else {
			$nik = $this->input->post('nik', TRUE);
			$nama_pegawai = $this->input->post('nama_pegawai', TRUE);
			$username = $this->input->post('username', TRUE);
			$password = md5($this->input->post('password', TRUE));
			$jenis_kelamin = $this->input->post('jenis_kelamin', TRUE);
			$jabatan = $this->input->post('jabatan', TRUE);
			$tanggal_masuk = $this->input->post('tanggal_masuk', TRUE);
			$status = $this->input->post('status', TRUE);
			$hak_akses = $this->input->post('hak_akses', TRUE);

			// Proses upload foto
			$photo = $_FILES['photo']['name'];
			if ($photo) {
				$config['upload_path'] = './photo';
				$config['allowed_types'] = 'jpg|jpeg|png|tiff';
				$config['max_size'] = 2048;
				$config['file_name'] = 'pegawai-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

				$this->load->library('upload', $config);
				if ($this->upload->do_upload('photo')) {
					$photo = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Foto gagal diupload!</strong> ' . $this->upload->display_errors() . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>');
					redirect('admin/data_pegawai/tambah_data');
				}
			}

			$data = array(
				'nik' => $nik,
				'nama_pegawai' => $nama_pegawai,
				'username' => $username,
				'password' => $password,
				'jenis_kelamin' => $jenis_kelamin,
				'jabatan' => $jabatan, // Jabatan dari dropdown
				'tanggal_masuk' => $tanggal_masuk,
				'status' => $status,
				'hak_akses' => $hak_akses,
				'photo' => $photo,
			);

			$this->ModelPenggajian->insert_data($data, 'data_pegawai');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data berhasil ditambahkan!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
			redirect('admin/data_pegawai');
		}
	}

	public function update_data($id)
	{
		// Ambil data pegawai berdasarkan ID
		$where = array('id_pegawai' => $id);
		$data['jabatan'] = $this->ModelPenggajian->get_data('data_jabatan')->result();
		$data['pegawai'] = $this->ModelPenggajian->get_data_pegawai_by_id($id);

		if (empty($data['pegawai'])) {
			show_error('Data pegawai tidak ditemukan!', 404);
		}

		$data['title'] = "Update Data Pegawai";

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/pegawai/update_dataPegawai', $data);
		$this->load->view('template_admin/footer');
	}

	public function update_data_aksi()
	{
		$this->_rules();

		$id = $this->input->post('id_pegawai');
		if ($this->form_validation->run() == FALSE) {
			$this->update_data($id);
		} else {
			$nik = $this->input->post('nik');
			$nama_pegawai = $this->input->post('nama_pegawai');
			$jenis_kelamin = $this->input->post('jenis_kelamin');
			$username = $this->input->post('username');

			// Ambil data pegawai berdasarkan ID untuk mendapatkan password lama
			$pegawai = $this->ModelPenggajian->get_data_pegawai_by_id($id);
			$password_lama = $pegawai->password; // Password lama dari database

			// Cek apakah ada password baru yang dimasukkan
			$password_baru = $this->input->post('password');
			if (!empty($password_baru)) {
				$password = md5($password_baru); // Enkripsi password baru
			} else {
				// Jika tidak ada password baru, gunakan password lama yang ada di database
				$password = $password_lama;
			}

			$jabatan = $this->input->post('jabatan');
			$tanggal_masuk = $this->input->post('tanggal_masuk');
			$status = $this->input->post('status');
			$hak_akses = $this->input->post('hak_akses');
			$photo_lama = $this->input->post('photo_lama'); // Foto lama

			// Cek apakah ada file foto baru yang diunggah
			$photo_baru = $_FILES['photo']['name'];
			if ($photo_baru) {
				$config['upload_path'] = './photo/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = '2048'; // Maksimum 2 MB
				$config['file_name'] = time() . '_' . $photo_baru; // Beri nama unik

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('photo')) {
					$photo_baru = $this->upload->data('file_name');

					// Hapus foto lama jika ada
					if ($photo_lama) {
						unlink('./photo/' . $photo_lama);
					}
				} else {
					echo $this->upload->display_errors();
					die; // Atau tampilkan error di flashdata
				}
			} else {
				$photo_baru = $photo_lama; // Jika tidak ada foto baru, gunakan foto lama
			}

			$data = array(
				'nik' => $nik,
				'nama_pegawai' => $nama_pegawai,
				'jenis_kelamin' => $jenis_kelamin,
				'username' => $username,
				'password' => $password, // Simpan password yang sudah di-hash
				'jabatan' => $jabatan,
				'tanggal_masuk' => $tanggal_masuk,
				'status' => $status,
				'hak_akses' => $hak_akses,
				'photo' => $photo_baru // Simpan foto baru atau lama
			);

			$where = array('id_pegawai' => $id);
			$this->ModelPenggajian->update_data('data_pegawai', $data, $where);

			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data berhasil diupdate!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
			redirect('admin/data_pegawai');
		}
	}


	public function delete_data($id)
	{
		$where = array('id_pegawai' => $id);
		$this->ModelPenggajian->delete_data($where, 'data_pegawai');
		$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data berhasil dihapus!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
		redirect('admin/data_pegawai');
	}

	public function _rules()
	{
		$this->form_validation->set_rules('nik', 'NIK', 'required|numeric|max_length[16]');
		$this->form_validation->set_rules('nama_pegawai', 'Nama Pegawai', 'required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
	}
}
?>