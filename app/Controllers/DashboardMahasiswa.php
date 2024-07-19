<?php
 
namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardMahasiswa extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();

        // Check if the user is logged in and has the correct level
        if (!session()->get('loggedin') || session()->get('level') != 2) {
            return redirect()->to('/auth/login');
        }
    }
 
    public function index()
    {
        $data['breadcrumbs'] = 'Dashboard';
        $data['content'] = 'vw_Beranda';

        return view('vw_template_mahasiswa', $data);
    }

    public function akun()
    {
        $data['breadcrumbs'] = 'Dashboard';
        $data['content'] = 'akun/vw_akun';
        $data['id'] = session()->get('nama_user');
        $data['data'] = $this->userModel->getUserSelect($data['id']);

        return view('vw_template_mahasiswa', $data);
    }

    public function edit_password()
    {
        $data['breadcrumbs'] = 'Dashboard';
        $data['content'] = 'akun/vw_edit_password';
        $data['id'] = session()->get('nama_user');
        $data['data'] = $this->userModel->getUserSelect($data['id']);
        $data['keterangan'] = null;

        if ($this->request->getPost('simpan')) {
            $passwordLama = $this->request->getPost('password_lama');
            $passwordBaru = $this->request->getPost('password_baru');
            $passwordBaruVerifikasi = $this->request->getPost('password_baru_verifikasi');
            
            if (password_verify($passwordLama, $data['data'][0]->password)) {
                if ($passwordBaru == $passwordBaruVerifikasi) {
                    $saveData = [
                        'password' => password_hash($passwordBaru, PASSWORD_DEFAULT),
                    ];
                    $this->userModel->updatePassword($saveData, $data['id']);
                    $data['keterangan'] = "Password Baru Berhasil Disimpan";
                } else {
                    $data['keterangan'] = "Password Baru Tidak Sama";
                }
            } else {
                $data['keterangan'] = "Password Lama Salah";
            }
        }

        return view('vw_template_mahasiswa', $data);
    }
}
