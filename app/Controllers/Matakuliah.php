<?php

namespace App\Controllers;

use App\Models\MatakuliahModel;
use CodeIgniter\Controller;

class Matakuliah extends BaseController
{
    protected $matakuliahModel;

    public function __construct()
    {
        $this->matakuliahModel = new MatakuliahModel();
        $this->session = \Config\Services::session();

        if (!$this->session->get('loggedin') || $this->session->get('level') != 0) {
            return redirect()->to('/auth/login');
        }
    }

    public function index()
    {
        $data['breadcrumbs'] = 'matakuliah';
        $data['content'] = 'vw_matakuliah';
        $data['data_semester'] = $this->matakuliahModel->getSemester();

        if ($this->request->getPost('pilih')) {
            $semester = $this->request->getPost('semester', FILTER_SANITIZE_STRING);
            $data['datas'] = $this->matakuliahModel->getSelectMatakuliah($semester);
        } else {
            $data['datas'] = $this->matakuliahModel->getMatakuliah();
        }

        echo view('vw_template', $data);
    }

    public function tambah()
    {
        $data['breadcrumbs'] = 'matakuliah';
        $data['content'] = 'matakuliah/tambah';
        $data['datas'] = $this->matakuliahModel->getSemester();

        echo view('vw_template', $data);
    }

    public function generateRandomString($length = 10)
    {
        return bin2hex(random_bytes($length / 2));
    }

    public function submit_tambah()
    {
        if ($this->request->getPost('simpan')) {
            $save_data = [
                'kode_mk' => str_replace(' ', '', $this->request->getPost('kode_mata_kuliah', FILTER_SANITIZE_STRING)),
                'nama_kode_2' => $this->request->getPost('kode_mata_kuliah', FILTER_SANITIZE_STRING),
                'id_semester' => $this->request->getPost('semester', FILTER_SANITIZE_STRING),
                'nama_mata_kuliah' => $this->request->getPost('nama_mata_kuliah', FILTER_SANITIZE_STRING),
                'sks' => $this->request->getPost('sks', FILTER_SANITIZE_STRING),
                'dosen' => $this->request->getPost('dosen', FILTER_SANITIZE_STRING),
            ];

            $name_image = '';
            if ($this->request->getFile('rps')->isValid()) {
                $name_image = date('Ymd') . '-' . $this->generateRandomString() . '.pdf';
            } else {
                $name_image = 'No Data upload';
            }

            $save_data['rps'] = $name_image;
            $query = $this->matakuliahModel->submitTambah($save_data);

            $cpmk = $this->matakuliahModel->getCpmk();
            foreach ($cpmk as $key) {
                $save_data_cpmk = [
                    'id_matakuliah_has_cpmk' => str_replace(' ', '', $this->request->getPost('kode_mata_kuliah', FILTER_SANITIZE_STRING)) . '_' . $key->id_cpmk_langsung,
                    'id_cpmk_langsung' => $key->id_cpmk_langsung,
                    'kode_mk' => str_replace(' ', '', $this->request->getPost('kode_mata_kuliah', FILTER_SANITIZE_STRING)),
                ];
                $this->matakuliahModel->submitTambahMatakuliahHasCpmk($save_data_cpmk);
            }

            if ($query) {
                $this->uploadRps($name_image);
                return redirect()->to('/Matakuliah');
            }
        }
    }

    private function uploadRps($fileName)
    {
        $file = $this->request->getFile('rps');
        if ($file->isValid() && !$file->hasMoved()) {
            $file->move('./uploads', $fileName);
        }
    }

    public function submit_edit()
    {
        if ($this->request->getPost('simpan')) {
            $save_data = [
                'nama_kode' => $this->request->getPost('kode_mata_kuliah', FILTER_SANITIZE_STRING),
                'nama_kode_2' => $this->request->getPost('kode_mata_kuliah_2', FILTER_SANITIZE_STRING),
                'nama_kode_3' => $this->request->getPost('kode_mata_kuliah_3', FILTER_SANITIZE_STRING),
                'id_semester' => $this->request->getPost('semester', FILTER_SANITIZE_STRING),
                'nama_mata_kuliah' => $this->request->getPost('nama_mata_kuliah', FILTER_SANITIZE_STRING),
                'sks' => $this->request->getPost('sks', FILTER_SANITIZE_STRING),
                'dosen' => $this->request->getPost('dosen', FILTER_SANITIZE_STRING),
            ];
            $id_edit = $this->request->getPost('kode_mk', FILTER_SANITIZE_STRING);

            $query = $this->matakuliahModel->submitEdit($save_data, $id_edit);
            if ($query) {
                return redirect()->to('/Matakuliah');
            }
        }
    }

    public function detail()
    {
        $data['breadcrumbs'] = 'matakuliah';
        $data['content'] = 'vw_matakuliah_detail';

        echo view('vw_template', $data);
    }

    public function edit($id)
    {
        $edit = $this->matakuliahModel->editMatakuliah($id);
        $data['data'] = $edit;
        $data['cpmk'] = $this->matakuliahModel->getMatakuliahHasCpmkByMk($id);
        $data['breadcrumbs'] = 'matakuliah';
        $data['content'] = 'matakuliah/edit';
		//dd($data);

        echo view('vw_template', $data);
    }

    public function cetak_edit($id)
    {
        $edit = $this->matakuliahModel->editMatakuliah($id);
        $data['data'] = $edit;
        $data['cpmk'] = $this->matakuliahModel->getMatakuliahHasCpmkByMk($id);
        $data['breadcrumbs'] = 'matakuliah';
        $data['content'] = 'matakuliah/cetak_edit';

        echo view('matakuliah/cetak_edit', $data);
    }

    public function edit_matakuliah_has_cpmk($id)
    {
        $edit = $this->matakuliahModel->editMatakuliahHasCpmk($id);
        $data['data'] = $edit;
        $data['data_cpmk'] = $this->matakuliahModel->getCpmk();
        $data['breadcrumbs'] = 'matakuliah';
        $data['content'] = 'matakuliah/edit_matakuliah_has_cpmk';

        echo view('vw_template', $data);
    }

    public function hapus($id)
    {
        $delete = $this->matakuliahModel->hapus($id);
        if ($delete) {
            return redirect()->to('/Matakuliah');
        }
    }

    public function lihat_rps($id)
    {
        $arr = $this->matakuliahModel->getRps($id);
        return $this->response->download('./uploads/' . $arr['rps'], null);
    }

    public function tambah_matakuliah_has_cpmk($id)
    {
        $edit = $this->matakuliahModel->editMatakuliah($id);
        $data['data'] = $edit;
        $data['data_cpmk'] = $this->matakuliahModel->getCpmk();
        $data['breadcrumbs'] = 'Matakuliah';
        $data['content'] = 'Matakuliah/tambah_matakuliah_has_cpmk';

        echo view('vw_template', $data);
    }

    public function submit_tambah_matakuliah_has_cpmk()
    {
        if ($this->request->getPost('simpan')) {
            $save_data = [
                'id_matakuliah_has_cpmk' => $this->request->getPost('mk', FILTER_SANITIZE_STRING) . '_' . $this->request->getPost('cpmk', FILTER_SANITIZE_STRING),
                'id_cpmk_langsung' => $this->request->getPost('cpmk', FILTER_SANITIZE_STRING),
                'kode_mk' => $this->request->getPost('mk', FILTER_SANITIZE_STRING),
                'deskripsi_matakuliah_has_cpmk' => $this->request->getPost('deskripsi', FILTER_SANITIZE_STRING),
            ];
            $kode_mk = $this->request->getPost('mk', FILTER_SANITIZE_STRING);

            $query = $this->matakuliahModel->submitTambahMatakuliahHasCpmk($save_data);
            if ($query) {
                return redirect()->to('/matakuliah/edit/' . $kode_mk);
            }
        }
    }

    public function submit_edit_matakuliah_has_cpmk()
    {
        if ($this->request->getPost('simpan')) {
            $save_data = [
                'id_cpmk_langsung' => $this->request->getPost('cpmk', FILTER_SANITIZE_STRING),
                'deskripsi_matakuliah_has_cpmk' => $this->request->getPost('deskripsi', FILTER_SANITIZE_STRING),
            ];
            $kode_mk = $this->request->getPost('mk', FILTER_SANITIZE_STRING);
            $id_edit = $this->request->getPost('id_matakuliah_has_cpmk', FILTER_SANITIZE_STRING);

            $query = $this->matakuliahModel->submitEditMatakuliahHasCpmk($save_data, $id_edit);
            if ($query) {
                return redirect()->to('/matakuliah/edit/' . $kode_mk);
            }
        }
    }

    public function hapus_matakuliah_has_cpmk($id)
    {
        $kode_mk = $this->matakuliahModel->getMkMatakuliahHasCpmk($id);
        $k = $kode_mk[0]->kode_mk;

        $delete = $this->matakuliahModel->hapusMatakuliahHasCpmk($id);
        if ($delete) {
            return redirect()->to('/matakuliah/edit/' . $k);
        }
    }
}
