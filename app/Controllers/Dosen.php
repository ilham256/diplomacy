<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Dosen extends Controller {

	public function __construct()
  	{
  		$this->dosen_model = new \App\Models\DosenModel();
  		$this->user_model = new \App\Models\UserModel();
    	
    	if (session()->get('loggedin') != true || session()->get('level') != 0) {
      		return redirect()->to('auth/login');
    	}
  	}

	public function index()
	{ 
		$data['breadcrumbs'] = 'dosen'; 
		$data['content'] = 'vw_dosen';
		$data['datas'] =  $this->dosen_model->getdosen();
		
		return view('vw_template', $data); 
	}
 
	public function tambah()
	{
		$data['breadcrumbs'] = 'dosen'; 
		$data['content'] = 'dosen/tambah';
		
		return view('vw_template', $data);
	}

	public function submit_tambah()
	{ 
		if ($this->request->getPost('simpan')) {
			$nip = $this->request->getPost('nip');
			$nama_dosen = $this->request->getPost('nama_dosen');
			
			if (!empty($nip) && !empty($nama_dosen)) {
				$KL = [
					'NIP' => $nip,
					'nama_dosen' => $nama_dosen,
					'password' => "123456",
				];
				
				//dd($saveData);
				$query = $this->dosen_model->submitTambah($KL); 

				//dd($query);
				
                return redirect()->to('dosen/suksesSimpan');
			} else {
				// Handle case where required fields are empty
				// You can add a flash message or redirect with an error
				return redirect()->back()->withInput()->with('error', 'Data tidak lengkap.');
			}
		} 
	}

	public function export_excel()
	{
		$data_dosen = $this->dosen_model->getdosen();
        $data = [
            'title' => 'Data dosen',
            'data' => $data_dosen
        ];

        return view('vw_excel_dosen', $data);
    } 

	public function suksesSimpan()
    {
        $arr['breadcrumbs'] = 'dosen';
        $arr['content'] = 'vw_data_berhasil_disimpan';

        echo view('vw_template', $arr);
    }
}
