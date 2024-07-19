<?php

namespace App\Controllers;

use App\Models\MatakuliahModel;
use App\Models\SemesterModel;

class Kurikulum extends BaseController
{
    protected $matakuliahModel;
    protected $semesterModel;

    public function __construct() {
        $this->matakuliahModel = new MatakuliahModel();
        $this->semesterModel = new SemesterModel();
        $session = session();
        if (!$session->get('loggedin') || $session->get('level') != 0) {
            header('Location: ' . base_url('Auth/login'));
            exit(); 
    }

    public function index() {
        $data['breadcrumbs'] = 'kurikulum';
        $data['content'] = 'vw_kurikulum';

        $semesters = $this->semesterModel->getSemesters("asc"); 
        $dictionary = [];

        foreach($semesters as $semester) {
            $mata_kuliah = $this->matakuliahModel->getSelectMatakuliah($semester->id_semester);
            $dictionary[$semester->id_semester] = $mata_kuliah;
        }

        $data['dictionary'] = $dictionary; 
        $data['semesters'] = $semesters;

        return view('vw_template', $data);
    }
}
