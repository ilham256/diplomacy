<?php

namespace App\Controllers;

use App\Models\CpmktlangModel;
use App\Models\MatakuliahModel;
use App\Models\MahasiswaModel;
use CodeIgniter\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Cpmktlang extends BaseController {

    protected $cpmktlangModel;
    protected $matakuliahModel;
    protected $mahasiswaModel;

    public function __construct() {
        $this->cpmktlangModel = new CpmktlangModel();
        $this->matakuliahModel = new MatakuliahModel();
        $this->mahasiswaModel = new MahasiswaModel();
        
        $session = \Config\Services::session();
        if (!$session->get('loggedin') || $session->get('level') != 0) {
            return redirect()->to('auth/login');
        }
    }

    public function index() {
        $data = [
            'breadcrumbs' => 'cpmktlang',
            'content' => 'vw_cpmktlang',
            'mata_kuliah' => $this->matakuliahModel->getMatakuliah(),
            'tahun_masuk' => $this->mahasiswaModel->getTahunMasuk(),
            'simpanan_tahun' => " - Pilih Tahun - ",
            'tahun' => 2019,
            't_simpanan_tahun' => " ",
            'simpanan_mk' => " - Pilih Mata Kuliah - ",
            'simpanan_nama_mk' => " - Pilih Mata Kuliah - ",
        ];

        if ($this->request->getPost('pilih')) {
            $data_tahun_masuk = $this->request->getPost('tahun_masuk');
            $data_mata_kuliah = $this->request->getPost('mata_kuliah');
            $data['datas'] = $this->cpmktlangModel->getCpmktlang($data_mata_kuliah);
            $data['data_matakuliah_has_cpmk'] = $this->cpmktlangModel->getMatakuliahHasCpmk($data_mata_kuliah);
            $data['data_mahasiswa'] = $this->cpmktlangModel->getMahasiswa($data_tahun_masuk);
            $data['tahun'] = $data_tahun_masuk;
            $data_tahun = $data_tahun_masuk + 1;
            $data['simpanan_tahun'] = $data_tahun_masuk;
            $data['t_simpanan_tahun'] = "/" . $data_tahun;
            $data['simpanan_mk'] = $data_mata_kuliah;
            $nama_mk = $this->matakuliahModel->getNamaMk($data_mata_kuliah);
            $data['simpanan_nama_mk'] = $nama_mk[0]->nama_kode . ' (' . $nama_mk[0]->nama_mata_kuliah . ')';
            $data['th'] = $data_tahun_masuk;
            $data['mk'] = $data_mata_kuliah;
        } else {
            $data_mata_kuliah = 'TIN211';
            $data_tahun_masuk = 2019;
            $data['data_matakuliah_has_cpmk'] = $this->cpmktlangModel->getMatakuliahHasCpmk($data_mata_kuliah);
            $data['data_mahasiswa'] = $this->cpmktlangModel->getMahasiswa($data_tahun_masuk);
            $data['datas'] = $this->cpmktlangModel->getCpmktlang($data_mata_kuliah);
            $data['th'] = $data_tahun_masuk;
            $data['mk'] = $data_mata_kuliah;
        }

        function curl($url) {
            $ch = curl_init();
            $headers = array(
                'accept: text/plain',
                'X-IPBAPI-TOKEN: Bearer 86f2760d-7293-36f4-833f-1d29aaace42e'
            );
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        }

        $send = curl("https://api.ipb.ac.id/v1/Mahasiswa/DaftarMahasiswa/PerDepartemen?departemenId=160&strata=S1&tahunMasuk=" . $data['tahun']);
        $mahasiswa = json_decode($send, TRUE);
        $data['data_mahasiswa'] = $mahasiswa;

        return view('vw_template', $data);
    }


    public function import(){
    //echo "dkf";
    $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   // echo '<pre>';  var_dump($_FILES); echo '</pre>'; 
        if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
 
            $arr_file = explode('.', $_FILES['file']['name']);
            //echo '<pre>';  var_dump($arr_file); echo '</pre>'; 
            $extension = end($arr_file);
            if('csv' == $extension){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else { 
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            //$sheetData = $spreadsheet->getActiveSheet()->toArray();
            //$sheetData2 = $spreadsheet->getSheet(2)->toArray();
            $highestSheet = $spreadsheet->getSheetCount();
            //echo "<pre>";
            //print_r($sheetData2);
            //echo '<pre>';  var_dump($highestSheet); echo '</pre>';

            //konfersi dari funsion uploads
            $arr['datas'] = [];

            for ($p=0; $p < $highestSheet; $p++) { 
                    
                $sheet = $spreadsheet->getSheet($p);

                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $row_mk = $sheet->rangeToArray('A' . 13 . ':' . $highestColumn . 13,
                                                    NULL,
                                                    TRUE,
                                                    FALSE); 
                $kode_mk_1 = $row_mk[0][2];
                $kode_mk_2 = str_replace(" ", "", $kode_mk_1 );
                $kode_mk = str_replace(":", "", $kode_mk_2 );

                $cek_kode_mk = $this->cpmktlang_model->cekmatakuliahkode2($kode_mk);

                if (!empty($cek_kode_mk)) {
                    $kode_mk = $cek_kode_mk["0"]->kode_mk;
                }else {
                    $cek_kode_mk = $this->cpmktlang_model->cekmatakuliahkode3($kode_mk);
                } 

                if (!empty($cek_kode_mk)) {
                    $kode_mk = $cek_kode_mk["0"]->kode_mk;
                }else {
                    $cek_kode_mk = $this->cpmktlang_model->cekmatakuliahkode1($kode_mk);
                }

                if (!empty($cek_kode_mk)) {
                    $kode_mk = $cek_kode_mk["0"]->kode_mk;
                }

                $row_cpmk = $sheet->rangeToArray('D' . 19 . ':' . $highestColumn . 19,
                                                    NULL,
                                                    TRUE,
                                                    FALSE);
                $row_cpmk_1 = array_reduce($row_cpmk, 'array_merge', array());
                $row_cpmk_2 = str_replace("CMPK", "CPMK", $row_cpmk_1);
                $row_nilai_cpmk = str_replace(" ", "_", $row_cpmk_2);

                


                 $i = 0;
                 foreach ($row_nilai_cpmk as $key) {
                     # code...
                     
                    for ($row = 20; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                        NULL,
                                                        TRUE,
                                                        FALSE);
                        $rowNilai = $sheet->rangeToArray('D' . $row . ':' . $highestColumn . $row,
                                                        NULL,
                                                        TRUE,
                                                        FALSE);
                        //Sesuaikan sama nama kolom tabel di database 

                        $data_cek =  $this->cpmktlang_model->cekmatakuliahhascpmk($kode_mk.'_'.$key);

                        if (empty($data_cek)) {
                            $save_data = array(
                                "id_nilai"=> "Data_CPMK_Kosong",
                                "nim"=> 0,
                                "id_matakuliah_has_cpmk"=> 0,
                                "nilai_tak_langsung"=> 0

                            );
                            $masukan = array(
                                "id_nilai"=> "Data_CPMK_Kosong",
                                "nim"=> 0,
                                "id_matakuliah_has_cpmk"=> $kode_mk.'_'.$key,
                                "nilai_tak_langsung"=> 0

                            );
                        }
                        elseif ($rowData[0][1] == NULL) {
                            $save_data = array(
                                "id_nilai"=> "Data_Kosong",
                                "nim"=> 0,
                                "id_matakuliah_has_cpmk"=> 0,
                                "nilai_tak_langsung"=> 0

                        );
                        $masukan = $save_data;
                        }else {                            
                             $save_data = array(
                                "id_nilai"=> $rowData[0][1].'_'.$kode_mk.'_'.$key,
                                "nim"=> $rowData[0][1],
                                "id_matakuliah_has_cpmk"=> $kode_mk.'_'.$key,
                                "nilai_tak_langsung"=> $rowData[0][3+$i]

                        );
                         $masukan = $save_data;
                        }
                        //sesuaikan nama dengan nama tabel
                         
                        array_push($arr['datas'],$masukan);
                        $insert = $this->cpmktlang_model->updateexcel($save_data);
                        //delete_files($media['file_path']);                   
                        }
                        $i++;
                    }
                }

        } else {
            //echo $_FILES['upload_file']['type'];
            echo '<pre>';  var_dump($_FILES['file']['type']); echo '</pre>';

        }
        //echo '<pre>';  var_dump($arr['datas']); echo '</pre>';
        $arr['breadcrumbs'] = 'cpmklang';
        $arr['content'] = 'vw_data_nilai_berhasil_disimpan2'; 
        $this->load->view('vw_template', $arr);


    }

}