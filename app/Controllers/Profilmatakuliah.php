<?php

namespace App\Controllers;

use App\Models\MatakuliahModel;
use App\Models\FormulaDeskriptorModel;
use CodeIgniter\Controller;

class ProfilMatakuliah extends BaseController
{
    protected $matakuliahModel;
    protected $formulaDeskriptorModel;
    protected $session;

    public function __construct()
    {
        $this->matakuliahModel = new MatakuliahModel();
        $this->formulaDeskriptorModel = new FormulaDeskriptorModel();
        $this->session = \Config\Services::session();

        if (!$this->session->get('loggedin') || $this->session->get('level') != 0) {
            return redirect()->to('auth/login');
        }
    }

    public function index()
    {
        $data['breadcrumbs'] = 'profil_matakuliah';
        $data['content'] = 'vw_profil_matakuliah';
        $data['data_semester'] = $this->matakuliahModel->getSemester();
        $data['rumus'] = $this->matakuliahModel->getMkMatakuliahHasCpmkAll();
        
        if ($this->request->getPost('pilih')) {
            $semester = $this->request->getPost('semester');
            $data['datas'] = $this->matakuliahModel->getSelectMatakuliah($semester);
        } else {
            $data['datas'] = $this->matakuliahModel->getMatakuliah();
        }

        echo view('vw_template', $data);
    }
}
