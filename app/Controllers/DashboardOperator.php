<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardOperator extends BaseController
{
    public function __construct()
    {
        // Memuat session service
        $this->session = \Config\Services::session();

        if (!$this->session->get('loggedin') || $this->session->get('level') != 3) {
            return redirect()->to('auth/login');
        }
    }

    public function index()
    {
        $data['breadcrumbs'] = 'Dashboard';
        $data['content'] = 'vw_Beranda';

        return view('vw_template_operator', $data);
    }
}
