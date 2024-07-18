<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\UserModel;

class AkunMahasiswa extends BaseController
{
    protected $dosenModel;
    protected $userModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->userModel = new UserModel();

        helper('session');

        if (!session()->get('loggedin')) {
            return redirect()->to('auth/login');
        }
    }

    public function index()
    {
        $data = [
            'breadcrumbs' => 'akun',
            'content' => 'vw_akun_mahasiswa',
            'datas' => session()->get()
        ];

        return view('vw_template_mahasiswa', $data);
    }

    public function ganti_password()
    {
        $data = [
            'breadcrumbs' => 'akun',
            'content' => 'vw_akun_ganti_password_mahasiswa',
            'konfirmasi' => 'masuk'
        ];

        return view('vw_template_mahasiswa', $data);
    }

    public function submit_ganti_password()
    {
        if ($this->request->getPost('simpan')) {

            $password_baru = $this->request->getPost('password_baru', FILTER_SANITIZE_STRING);
            $konfirmasi_password_baru = $this->request->getPost('konfirmasi_password_baru', FILTER_SANITIZE_STRING);

            if ($password_baru != $konfirmasi_password_baru) {
                $data['konfirmasi'] = 'salah';
            } else {
                $save_data = [
                    'password' => password_hash($password_baru, PASSWORD_DEFAULT),
                ];
                $id = session()->get('id');
                $this->userModel->update_password($save_data, $id);

                $data['konfirmasi'] = 'benar';
            }

            $data['breadcrumbs'] = 'akun';
            $data['content'] = 'vw_akun_ganti_password_mahasiswa';

            return view('vw_template_mahasiswa', $data);
        }
    }
}