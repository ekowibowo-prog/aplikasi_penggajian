<?php
defined('BASEPATH') or exit('No direct script access allowed');

function cek_login($role = null)
{
    $ci = &get_instance();

    // Jika belum login, redirect ke halaman login
    if (!$ci->session->userdata('hak_akses')) {
        $ci->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Anda harus login terlebih dahulu!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        redirect('login');
    }

    // Jika role diatur, cek apakah user sesuai
    if ($role && $ci->session->userdata('hak_akses') != $role) {
        $ci->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Akses ditolak!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        redirect('login');
    }
}
