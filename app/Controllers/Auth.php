<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $session;
    protected $authModel; // Tambahkan deklarasi properti untuk AuthModel
    protected $validation; // Tambahkan deklarasi properti untuk validation

    public function __construct()
    {
        $this->session = session();
        $this->authModel = new AuthModel(); // Inisialisasi AuthModel di konstruktor
        $this->validation = \Config\Services::validation(); // Inisialisasi validation di konstruktor
    }

    public function index()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function login()
    {
        if ($this->session->get('loggedin')) {
            return $this->redirectUserByLevel();
        } else {
            // Gunakan properti yang sudah dideklarasikan dan diinisialisasi di konstruktor
            $rules = $this->authModel->rules();
            $this->validation->setRules($rules);

            if (!$this->validate($rules)) {
                return view('login_form', ['validation' => $this->validation]);
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $arr['keterangan'] = 1;

            if ($this->authModel->login($username, $password)) {
                $this->session->set('loggedin', true);
                return $this->redirectUserByLevel();
            } else {
                $this->session->setFlashdata('message_login_error', 'Login Gagal, pastikan username dan password benar!');
            }

            $arr['keterangan'] = 0;
            return view('login_form', $arr);
        }
    }

    public function logout()
    {
        $this->session->destroy();
        $this->authModel->logout();
        return redirect()->to('Auth/login');
    }

    private function redirectUserByLevel()
    {
        switch ($this->session->get('level')) {
            case 1:
                return redirect()->to('DashboardDosen');
            case 2:
                return redirect()->to('DashboardMahasiswa');
            case 3:
                return redirect()->to('DashboardOperator');
            case 4:
                return redirect()->to('DashboardGuest');
            default:
                return redirect()->to('Dashboard');
        }
    }
}
