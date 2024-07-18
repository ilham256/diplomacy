<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardDosen extends Controller
{
    public function __construct()
    {
        // Memuat session service
        $this->session = \Config\Services::session();

        if (!$this->session->get('loggedin') || $this->session->get('level') != 1) {
            return redirect()->to('auth/login');
        }
    }

    public function index()
    {
        $data['breadcrumbs'] = 'Dashboard';
        $data['content'] = 'vw_Beranda';

        return view('vw_template_dosen', $data);
    }

    public function infumum()
    {
        $data['breadcrumbs'] = 'infumum';
        $data['content'] = 'vw_informasi_umum';

        return view('vw_template_dosen', $data);
    }
}
