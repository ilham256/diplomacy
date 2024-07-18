<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
	protected $userModel;

	public function __construct()
	{
		$this->userModel = new UserModel();

		if (!session()->get('loggedin') || session()->get('level') != 3) {
			return redirect()->to('/auth/login');
		}
	}

	// User Admin
	public function admin()
	{
		$data['breadcrumbs'] = 'Dashboard';
		$data['content'] = 'login_operator/vw_admin';
		$data['datas'] = $this->userModel->getAdmin();
		return view('vw_template_operator', $data);
	}

	public function tambah_admin()
	{
		$data['breadcrumbs'] = 'Dashboard';
		$data['content'] = 'login_operator/vw_tambah_admin';
		return view('vw_template_operator', $data);
	}

	public function submit_tambah_admin()
	{
		if ($this->request->getPost('simpan')) {
			$save_data = [
				'id' => $this->request->getPost('username', true),
				'username' => $this->request->getPost('username', true),
				'email' => $this->request->getPost('email', true),
				'password' => password_hash($this->request->getPost('password', true), PASSWORD_DEFAULT),
				'level' => 0,
			];
			$query = $this->userModel->submitTambahAdmin($save_data);
			if ($query) {
				return redirect()->to('/User/admin')->with('refresh');
			}
		}
	}

	public function hapus_admin($id)
	{
		$hapus = $this->userModel->hapusUser($id);
		return redirect()->to('/User/admin')->with('refresh');
	}

	// User dosen
	public function dosen()
	{
		$data['breadcrumbs'] = 'Dashboard';
		$data['content'] = 'login_operator/vw_dosen';
		$data['datas'] = $this->userModel->getDosen();
		return view('vw_template_operator', $data);
	}

	public function tambah_dosen()
	{
		$data['breadcrumbs'] = 'Dashboard';
		$data['content'] = 'login_operator/vw_tambah_dosen';
		return view('vw_template_operator', $data);
	}

	public function submit_tambah_dosen()
	{
		if ($this->request->getPost('simpan')) {
			$save_data = [
				'id' => $this->request->getPost('username', true),
				'username' => $this->request->getPost('username', true),
				'email' => $this->request->getPost('email', true),
				'password' => password_hash($this->request->getPost('password', true), PASSWORD_DEFAULT),
				'level' => 1,
			];
			$query = $this->userModel->submitTambahDosen($save_data);
			if ($query) {
				return redirect()->to('/User/dosen')->with('refresh');
			}
		}
	}

	public function hapus_dosen($id)
	{
		$hapus = $this->userModel->hapusUser($id);
		return redirect()->to('/User/dosen')->with('refresh');
	}

	// User mahasiswa
	public function mahasiswa()
	{
		$data['breadcrumbs'] = 'Dashboard';
		$data['content'] = 'login_operator/vw_mahasiswa';
		$data['datas'] = $this->userModel->getMahasiswa();
		return view('vw_template_operator', $data);
	}

	public function tambah_mahasiswa()
	{
		$data['breadcrumbs'] = 'Dashboard';
		$data['content'] = 'login_operator/vw_tambah_mahasiswa';
		return view('vw_template_operator', $data);
	}

	public function submit_tambah_mahasiswa()
	{
		if ($this->request->getPost('simpan')) {
			$save_data = [
				'id' => $this->request->getPost('username', true),
				'username' => $this->request->getPost('username', true),
				'email' => $this->request->getPost('email', true),
				'password' => password_hash($this->request->getPost('password', true), PASSWORD_DEFAULT),
				'level' => 2,
			];
			$query = $this->userModel->submitTambahMahasiswa($save_data);
			if ($query) {
				return redirect()->to('/User/mahasiswa')->with('refresh');
			}
		}
	}

	public function hapus_mahasiswa($id)
	{
		$hapus = $this->userModel->hapusUser($id);
		return redirect()->to('/User/mahasiswa')->with('refresh');
	}
}