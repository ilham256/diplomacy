<?php

namespace App\Controllers;

use App\Models\FormulaDeskriptorModel;
use App\Models\FormulaModel;
use CodeIgniter\Controller;

class FormulaDeskriptor extends BaseController
{
    protected $formulaDeskriptorModel;
    protected $formulaModel;
    protected $session;

    public function __construct()
    {
        $this->formulaDeskriptorModel = new FormulaDeskriptorModel();
        $this->formulaModel = new FormulaModel();
        $this->session = session();

        if (!$this->session->get('loggedin') || $this->session->get('level') != 0) {
            return redirect()->to('auth/login');
        }
    }

    public function index()
    {
        $data = [
            'breadcrumbs' => 'formula_deskriptor',
            'content' => 'vw_formula_deskriptor',
            'data_deskriptor' => $this->formulaDeskriptorModel->getdeskriptor(),
            'rumus' => $this->formulaDeskriptorModel->getdeskriptorrumuscpmk()
        ];

        return view('vw_template', $data);
    }

    public function tambah_formula_deskriptor($id)
    {
        $edit = $this->formulaDeskriptorModel->getdatadeskriptor($id);
        $data = [
            'data' => $edit,
            'data_formula_cpmk' => $this->formulaDeskriptorModel->getmatakuliahhascpmk(),
            'breadcrumbs' => 'formula_deskriptor',
            'content' => 'formula_deskriptor/tambah_formula'
        ];

        return view('vw_template', $data);
    }

    public function submit_tambah_deskriptor()
    {
        if ($this->request->getPost('simpan')) {
            $save_data = [
                'id_deskriptor' => str_replace(' ', '_', $this->request->getPost('nama')),
                'nama_deskriptor' => $this->request->getPost('nama'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            $query = $this->formulaDeskriptorModel->submittambahdeskriptor($save_data);

            $save_data = [
                'id_cpl_rumus_deskriptor' => $this->request->getPost('id_cpl') . '_' . str_replace(' ', '_', $this->request->getPost('nama')),
                'id_cpl_langsung' => $this->request->getPost('id_cpl'),
                'id_deskriptor' => str_replace(' ', '_', $this->request->getPost('nama')),
                'persentasi' => $this->request->getPost('persentasi')
            ];

            $query = $this->formulaModel->submittambahformuladeskriptor($save_data);

            if ($query) {
                return redirect()->to('cpmkcpl');
            }
        }
    }

    public function edit_deskriptor($id)
    {
        $edit = $this->formulaDeskriptorModel->editdeskriptor($id);
        $data = [
            'data' => $edit,
            'breadcrumbs' => 'formula_deskriptor',
            'content' => 'formula_deskriptor/edit_deskriptor'
        ];

        return view('vw_template', $data);
    }

    public function submit_edit_deskriptor()
    {
        if ($this->request->getPost('simpan')) {
            $save_data = [
                'nama_deskriptor' => $this->request->getPost('nama'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            $id_edit = $this->request->getPost('id');

            $query = $this->formulaDeskriptorModel->submiteditdeskriptor($save_data, $id_edit);
            if ($query) {
                return redirect()->to('cpmkcpl');
            }
        }
    }

    public function detail()
    {
        $data = [
            'breadcrumbs' => 'formula_deskriptor',
            'content' => 'vw_formula_detail'
        ];

        return view('vw_template', $data);
    }

    public function deskriptor()
    {
        $data = [
            'breadcrumbs' => 'formula_deskriptor',
            'content' => 'vw_formula_deskriptor'
        ];

        return view('vw_template', $data);
    }

    public function deskriptorn()
    {
        $data = [
            'breadcrumbs' => 'formula_deskriptor',
            'content' => 'vw_formula_deskriptorn'
        ];

        return view('vw_template', $data);
    }

    public function edit_formula_deskriptor($id)
    {
        $edit = $this->formulaDeskriptorModel->editformuladeskriptor($id);
        $data = [
            'data' => $edit,
            'data_formula' => $this->formulaDeskriptorModel->getmatakuliahhascpmk(),
            'breadcrumbs' => 'formula_deskriptor',
            'content' => 'formula_deskriptor/edit_formula'
        ];

        return view('vw_template', $data);
    }

    public function submit_tambah_formula()
    {
        if ($this->request->getPost('simpan')) {
            $save_data = [
                'id_deskriptor_rumus_cpmk' => $this->request->getPost('id') . '_' . $this->request->getPost('cpmk'),
                'id_matakuliah_has_cpmk' => $this->request->getPost('cpmk'),
                'id_deskriptor' => $this->request->getPost('id'),
                'persentasi' => $this->request->getPost('persentasi')
            ];

            $query = $this->formulaDeskriptorModel->submittambahformula($save_data);
            if ($query) {
                return redirect()->to('formula');
            }
        }
    }

    public function submit_edit_formula_deskriptor()
    {
        if ($this->request->getPost('simpan')) {
            $save_data = [
                'id_matakuliah_has_cpmk' => $this->request->getPost('cpmk'),
                'persentasi' => $this->request->getPost('persentasi')
            ];

            $id_edit = $this->request->getPost('id');

            $query = $this->formulaDeskriptorModel->submiteditformuladeskriptor($save_data, $id_edit);
            if ($query) {
                return redirect()->to('formula');
            }
        }
    }

    public function hapus_formula_deskriptor($id)
    {
        $delete = $this->formulaDeskriptorModel->hapusformuladeskriptor($id);
        if ($delete) {
            return redirect()->to('formula');
        }
    }

    public function hapus_deskriptor($id)
    {
        $delete = $this->formulaDeskriptorModel->hapusdeskriptor($id);
        if ($delete) {
            return redirect()->to('formula');
        }
    }
}
