<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
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
            $authModel = new AuthModel();
            $validation = \Config\Services::validation();

            $rules = $authModel->rules();
            $validation->setRules($rules);

            if (!$this->validate($rules)) {
                return view('login_form', ['validation' => $validation]);
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $arr['keterangan'] = 1;

            if ($authModel->login($username, $password)) {
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
        $authModel = new AuthModel();
        $this->session->destroy();
        $authModel->logout();
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
