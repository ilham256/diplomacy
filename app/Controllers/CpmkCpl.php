<?php

namespace App\Controllers;

use App\Models\CpmkCplModel;
use App\Models\FormulaModel;

class CpmkCpl extends BaseController
{
    protected $cpmkCplModel;
    protected $formulaModel;

    public function __construct() {
        $this->cpmkCplModel = new CpmkCplModel();
        $this->formulaModel = new FormulaModel();
        $session = session();
        if (!$session->get('loggedin') || $session->get('level') != 0) {
            header('Location: ' . base_url('Auth/login'));
            exit(); 
        }
    }

    public function index() { 
        $data['breadcrumbs'] = 'cpmk_cpl';
        $data['content'] = 'vw_cpmk_cpl';

        $data['data_cpl'] = $this->cpmkCplModel->getCpl();
        $data['data_cpmk'] = $this->cpmkCplModel->getCpmk();
        $data['rumus_deskriptor'] = $this->cpmkCplModel->getCplRumusDeskriptor();

        $data['status_aktif'] = 'show active';
        $data['naf'] = 'active';

        return view('vw_template', $data);
    }

    // CPL
    public function tambahCpl() {
        $data['breadcrumbs'] = 'cpmk_cpl';
        $data['content'] = 'cpl/tambah';
        return view('vw_template', $data);
    }

    public function submitTambahCpl() {
        if ($this->request->getPost('simpan')) {
            $saveData = [
                'id_cpl_langsung' => str_replace(' ', '_', $this->request->getPost('nama_cpl')),
                'nama' => $this->request->getPost('nama_cpl'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            if ($this->cpmkCplModel->submitTambahCpl($saveData)) {
                return redirect()->to('cpmkcpl');
            }
        }
    }

    public function editCpl($id) {

        // Validasi bahwa $id adalah string yang diharapkan
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $id)) {
            return redirect()->to('/error');
        }

        $edit = $this->cpmkCplModel->editCpl($id);
        $data['data'] = $edit;
        $data['breadcrumbs'] = 'cpmk_cpl';
        $data['content'] = 'cpl/edit';
        return view('vw_template', $data);
    }

    public function submitEditCpl() {
        if ($this->request->getPost('simpan')) {
            $saveData = [
                'nama' => $this->request->getPost('nama_cpl'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            $idEdit = $this->request->getPost('id');

            if ($this->cpmkCplModel->submitEditCpl($saveData, $idEdit)) {
                return redirect()->to('cpmkcpl');
            }
        }
    }

    public function hapusCpl($id) {

        // Validasi bahwa $id adalah string yang diharapkan
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $id)) {
            return redirect()->to('/error');
        }

        if ($this->cpmkCplModel->hapusCpl($id)) {
            return redirect()->to('cpmkcpl');
        }
    }

    // CPMK
    public function tambahCpmk() {
        $data['breadcrumbs'] = 'cpmk_cpl';
        $data['content'] = 'cpmk/tambah';
        return view('vw_template', $data);
    }

    public function submitTambahCpmk() {
        if ($this->request->getPost('simpan')) {
            $saveData = [
                'id_cpmk_langsung' => str_replace(' ', '_', $this->request->getPost('nama_cpmk')),
                'nama' => $this->request->getPost('nama_cpmk'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            if ($this->cpmkCplModel->submitTambahCpmk($saveData)) {
                return redirect()->to('cpmkcpl');
            }
        }
    }

    public function editCpmk($id) {

        // Validasi bahwa $id adalah string yang diharapkan
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $id)) {
            return redirect()->to('/error');
        }

        $edit = $this->cpmkCplModel->editCpmk($id);
        $data['data'] = $edit;
        $data['breadcrumbs'] = 'cpmk_cpl';
        $data['content'] = 'cpmk/edit';
        return view('vw_template', $data);
    }

    public function submitEditCpmk() {
        if ($this->request->getPost('simpan')) {
            $saveData = [
                'nama' => $this->request->getPost('nama_cpmk'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            $idEdit = $this->request->getPost('id');

            if ($this->cpmkCplModel->submitEditCpmk($saveData, $idEdit)) {
                return redirect()->to('cpmkcpl');
            }
        }
    }

    public function hapusCpmk($id) {

        // Validasi bahwa $id adalah string yang diharapkan
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $id)) {
            return redirect()->to('/error');
        }

        if ($this->cpmkCplModel->hapusCpmk($id)) {
            return redirect()->to('cpmkcpl');
        }
    }

    // Deskriptor
    public function tambahDeskriptor($id) {

        // Validasi bahwa $id adalah string yang diharapkan
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $id)) {
            return redirect()->to('/error');
        }
        
        $edit = $this->formulaModel->getDataCpl($id);
        $data['data'] = $edit;
        $data['breadcrumbs'] = 'formula_deskriptor';
        $data['content'] = 'formula_deskriptor/tambah_deskriptor';
        return view('vw_template', $data);
    }
}
