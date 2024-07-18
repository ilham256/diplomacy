<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }  

    public function login()
    {
        $session = session();

        if ($session->get('loggedin')) {
            if ($session->get('level') == 1) {
                return redirect()->to('DashboardDosen');
            } elseif ($session->get('level') == 2) {
                return redirect()->to('DashboardMahasiswa');
            } elseif ($session->get('level') == 3) {
                return redirect()->to('DashboardOperator');
            } elseif ($session->get('level') == 4) {
                return redirect()->to('DashboardGuest');
            } else {
                return redirect()->to('Dashboard');                
            }
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
                $session->set('loggedin', true);

                if ($session->get('level') == 1) {
                    return redirect()->to('DashboardDosen');
                } elseif ($session->get('level') == 2) {
                    return redirect()->to('DashboardMahasiswa');
                } elseif ($session->get('level') == 3) {
                    return redirect()->to('DashboardOperator');
                } elseif ($session->get('level') == 4) {
                    return redirect()->to('DashboardGuest'); 
                } else {
                    return redirect()->to('Dashboard');                
                }
            } else {
                $session->setFlashdata('message_login_error', 'Login Gagal, pastikan username dan password benar!');
            }

            $arr['keterangan'] = 0;
            return view('login_form', $arr);  
        }
    }

    public function logout()
    {
        $session = session();
        $authModel = new AuthModel();
        $session->destroy();
        $authModel->logout();
        return redirect()->to('Auth/login');
    }
}