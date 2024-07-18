<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Infumum extends BaseController
{
    public function __construct()
    {
        // Periksa login dan level di sini atau gunakan Filter untuk menangani otentikasi
        if (!session()->get('loggedin') || session()->get('level') != 0) {
            return redirect()->to('auth/login');      
        }
    }

    public function index()
    {
        $data['breadcrumbs'] = 'infumum';
        $data['content'] = 'vw_informasi_umum';

        return view('vw_template', $data); 
    }
}