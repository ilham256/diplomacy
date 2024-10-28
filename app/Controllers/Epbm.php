<?php
namespace App\Controllers;

use App\Models\EpbmModel;
use App\Models\MatakuliahModel;
use App\Models\MahasiswaModel; 

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Epbm extends BaseController
{
    protected $epbmModel;
    protected $matakuliahModel; 
    protected $mahasiswaModel;
    protected $session;

    public function __construct()
    {
        $this->epbmModel = new EpbmModel();
        $this->matakuliah_model = new MatakuliahModel();
        $this->mahasiswa_model = new MahasiswaModel();
        $this->session = \Config\Services::session();

        if (!$this->session->get('loggedin') || $this->session->get('level') != 0) {
            return redirect()->to('auth/login');
        }
    }

    public function index()
    {
        $data = [
            'breadcrumbs' => 'epbm',
            'content' => 'vw_epbm'
        ];
        $data['datas_psd'] = $this->epbmModel->getPsd();
        $data['Epbm'] = $this->epbmModel->getDataEpbm();

        //dd($data['datas_psd'],$data['Epbm']);

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
                } elseif ('xls' == $extension){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else { 
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
            $objPHPExcel = $reader->load($_FILES['file']['tmp_name']);
            //$sheetData = $spreadsheet->getActiveSheet()->toArray();
            //$sheetData2 = $spreadsheet->getSheet(2)->toArray(); 
            $highestSheet = $objPHPExcel->getSheetCount();
            //echo "<pre>";
            //print_r($sheetData2);
            //echo '<pre>';  var_dump($highestSheet); echo '</pre>';

            //konfersi dari funsion uploads
            $arr['datas'] = [];
            $arr['datas_epbm'] = [];
            $arr['datas_epbm_mk'] = [];
            $arr['datas_epbm_dosen'] = [];
            $arr['datas_psd'] = $this->epbmModel->getPsd();


            $sheet_tahun = $objPHPExcel->getSheet(0);
 
            // Menyimpan Data EPBM Matakuliah has Dosen
            //$kode_mk = str_replace(":", "", $kode_mk_2 );
            $row_tahun_semester = $sheet_tahun->rangeToArray('A' . 2 . ':' . 'C' . 2,
                                                NULL,
                                                TRUE,
                                                FALSE);
            //mencari data tahun

            $data_tahun_semester = $row_tahun_semester[0][0];
            $data_tahun1 = preg_replace("/[^0-9]/","",$data_tahun_semester);
            $data_tahun = substr($data_tahun1,0,4);
            

        //Menyimpan Data Persheet
        for ($p=0; $p < $highestSheet; $p++) { 
            
            $sheet = $objPHPExcel->getSheet($p);
  
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            // Menyimpan Data EPBM Matakuliah has Dosen
            //echo '<pre>';  var_dump($row_tahun_semester); echo '</pre>'; 
            // mencari data semester
            if (strpos($data_tahun_semester, 'Ganjil')) {
                $data_semester = 'Ganjil';
            }else {
                $data_semester = 'Genap'; // akan masuk kesini
            }



            // Menyimpan Data EPMB Matakuliah
            for ($row = 5; $row <= $highestRow; $row++)
            {
                $rowMk = $sheet->rangeToArray('A' . $row  . ':' . 'B' . $row,
                                                        NULL,
                                                        TRUE,
                                                        FALSE);

                $data_cek = [];
                $data_cek =  $this->epbmModel->cekEpbmMataKuliah($rowMk[0][0]);
                $data_cek_kode_mk = substr($rowMk[0][0],0,-4);
                

                if ($rowMk[0][0] != NULL and $rowMk[0][0] != "Mata Kuliah" and $rowMk[0][0] != "NIP" and $rowMk[0][0] != "Departemen Teknologi Industri Pertanian") {
                    if (empty($data_cek)) {
                        $data_cek3 = [];
                        $data_cek3 =  $this->epbmModel->cekMataKuliahKode3($data_cek_kode_mk);

                        if (empty($data_cek3)) {
                        $data_cek2 = [];
                        $data_cek2 =  $this->epbmModel->cekMataKuliahKode2($data_cek_kode_mk);

                            if (empty($data_cek2)) {
                            $data_cek1 = [];
                            $data_cek1 =  $this->epbmModel->cekMataKuliahKode1($data_cek_kode_mk);

                                if (!empty($data_cek1)) {
                                
                                    $kode_mk = $data_cek1[0]->kode_mk;

                                    $save_data = array(
                                        "kode_epbm_mk"=> $rowMk[0][0],
                                        "no"=> substr($rowMk[0][0],-1),
                                        "kode_mk"=> $kode_mk
                                    );
                                    $insert1 = $this->epbmModel->updateExcelEpbmMataKuliah($save_data);
                                    if ($insert1) {
                                        # code...
                                    }
                                    //echo '<pre>';  var_dump($save_data); echo '</pre>'; 
                                
                                }
                            } else {

                            $kode_mk = $data_cek2[0]->kode_mk;

                            $save_data = array(
                                        "kode_epbm_mk"=> $rowMk[0][0],
                                        "no"=> substr($rowMk[0][0],-1),
                                        "kode_mk"=> $kode_mk
                                    );
                            $insert2 = $this->epbmModel->updateExcelEpbmMataKuliah($save_data);
                            }
                        } else {

                        $kode_mk = $data_cek3[0]->kode_mk;

                        $save_data = array(
                            "kode_epbm_mk"=> $rowMk[0][0],
                            "no"=> substr($rowMk[0][0],-1),
                            "kode_mk"=> $kode_mk
                        );
                        $insert3 = $this->epbmModel->updateExcelEpbmMataKuliah($save_data);

                        }
                    }
                }

            }

            // Menyimpan Data Dosen
            /*
            for ($row = 5; $row <= $highestRow; $row++)
            {
                $rowMk = $sheet->rangeToArray('A' . $row  . ':' . 'B' . $row,
                                                        NULL,
                                                        TRUE,
                                                        FALSE);

                $data_cek = [];
                $data_cek =  $this->epbmModel->cek_epbm_mata_kuliah($rowMk[0][0]);
                //echo '<pre>';  var_dump(substr($rowMk[0][0],0,-4)); echo '</pre>'; 

                if ($rowMk[0][0] != NULL and $rowMk[0][0] != "Mata Kuliah" and $rowMk[0][0] != "NIP" and $rowMk[0][0] != "Departemen Teknologi Industri Pertanian") {
                    if (empty($data_cek)) {
                        $data_cek3 = [];
                        $data_cek3 =  $this->epbmModel->cek_dosen($rowMk[0][0]);

                        if (empty($data_cek3)) {

                            $nip_cek = substr($rowMk[0][0],0,1);
                            if (is_numeric($nip_cek)) {

                                $save_data = array(
                                    "NIP"=> $rowMk[0][0],
                                    "nama_dosen"=> $rowMk[0][1],
                                    "password"=> "123456"
                                );

                                $insert = $this->epbmModel->update_excel_dosen($save_data);                      
                            }                
                        } 

                    }
                }
            } */
            // Menyimpan Data EPMB Matakuliah has dosen

            for ($row = 5; $row <= $highestRow; $row++)
            {
                $rowMk = $sheet->rangeToArray('A' . $row  . ':' . 'B' . $row,
                                                        NULL,
                                                        TRUE,
                                                        FALSE);
 
                $data_cek = [];
                $data_cek =  $this->epbmModel->cekEpbmMataKuliah($rowMk[0][0]);
                //echo '<pre>';  var_dump(substr($rowMk[0][0],0,-4)); echo '</pre>'; 
 
                if ($rowMk[0][0] != NULL and $rowMk[0][0] != "Mata Kuliah" and $rowMk[0][0] != "NIP" and $rowMk[0][0] != "Departemen Teknologi Industri Pertanian") {
                    if (empty($data_cek)) {
                        $data_cek3 = [];
                        $data_cek3 =  $this->epbmModel->cekEpbmMataKuliahHasDosen($d.'_'.$rowMk[0][0]);

                        if (empty($data_cek3)) {

                            $data_cek2 = [];
                            $data_cek2 =  $this->epbmModel->cekDosen($rowMk[0][0]);

                            if (!empty($data_cek2)) {
                                $save_data = array(
                                    "kode_epbm_mk_has_dosen"=> $d.'_'.$rowMk[0][0],
                                    "kode_epbm_mk"=> $d,
                                    "NIP"=> $rowMk[0][0]
                                );
                                $insert = $this->epbmModel->updateExcelEpbmMataKuliahHasDosen($save_data);
                            }
                        } 

                    } else {
                        $d = $rowMk[0][0];
                    }
                }                
            }


            // Menyimpan Nilai Epbm
            
            $row_psd = $sheet->rangeToArray('C' . 4 . ':' . 'Q' . 10,
                                                NULL,
                                                TRUE,
                                                FALSE);
            if ($row_psd[0][0] == NULL) {
                $row_nilai_psd = $row_psd[6];
            } else {
                $row_nilai_psd = $row_psd[0];
            }
            //$row_nilai_psd = array_reduce($row_psd, 'array_merge', array());
            //echo '<pre>';  var_dump($row_nilai_psd); echo '</pre>'; 
            $i = 0;
             foreach ($row_nilai_psd as $key) {
                if ($key != NULL and $key != "Semua") {
                    for ($row = 5; $row <= $highestRow; $row++){

                        $rowData = $sheet->rangeToArray('A' . $row  . ':' . 'B' . $row,
                                                        NULL,
                                                        TRUE,
                                                        FALSE);
                        $rowNilai = $sheet->rangeToArray('C' . $row . ':' . 'Q' . $row,
                                                        NULL,
                                                        TRUE,
                                                        FALSE);

                        if ($rowData[0][0] != NULL) {

                            $data_cek1 = [];
                            $data_cek1 =  $this->epbmModel->cekEpbmMataKuliah($rowData[0][0]);

                            if (empty($data_cek1)) {
                                    $data_cek2 = []; 
                                    $data_cek2 =  $this->epbmModel->cekEpbmMataKuliahHasDosen($d.'_'.$rowData[0][0]);
                                    if (empty($data_cek2)) {
                                            $save_data = array(
                                                "kode_nilai_epbm_mk_has_dosen"=>"Data_nilai_Kosong",
                                                "kode_epbm_mk_has_dosen"=> 0,
                                                "kode_psd"=> 0,
                                                "tahun"=> 0,
                                                "semester"=> 0,                                        
                                                "nilai"=>  0
                                            );
                                        }
                                    else {                            
                                         $save_data = array(                            
                                            "kode_nilai_epbm_mk_has_dosen"=>$data_tahun.'_'.$data_semester.'_'.$d.'_'.$rowData[0][0].'_'.$key,
                                            "kode_epbm_mk_has_dosen"=> $d.'_'.$rowData[0][0],
                                            "kode_psd"=> $key,
                                            "tahun"=> $data_tahun,
                                            "semester"=> $data_semester, 
                                            "nilai"=>  $rowNilai[0][0+$i]
                                            );                         
                                        }
                                        array_push($arr['datas_epbm_dosen'],$save_data);
                                        $insert = $this->epbmModel->updateExcelNilaiEpbmDosen($save_data);
                                } 
                            else {                            
                                 $save_data = array(                            
                                    "kode_nilai_epbm_mk"=>$data_tahun.'_'.$data_semester.'_'.$rowData[0][0].'_'.$key,
                                    "kode_epbm_mk"=> $rowData[0][0],
                                    "kode_psd"=> $key,
                                    "tahun"=> $data_tahun,
                                    "semester"=> $data_semester,  
                                    "nilai"=>  $rowNilai[0][0+$i]
                                    );
                                 $d = $rowData[0][0];

                                 array_push($arr['datas_epbm_mk'],$save_data);
                                 $insert = $this->epbmModel->updateExcelNilaiEpbmMataKuliah($save_data);
                                }
                            $masukan = $save_data;
                            array_push($arr['datas'],$masukan);
                        }                    
                                        
                        //sesuaikan nama dengan nama tabel
                         
                    
                        
                        //delete_files($media['file_path']);
                             
                        }
                    }
                    $i++;
                }
            }

        } else {
            //echo $_FILES['upload_file']['type'];
            echo '<pre>';  var_dump($_FILES['file']['type']); echo '</pre>';

        }
        //session()->setFlashdata('success', 'Data berhasil disimpan!');
        //dd($arr['datas_epbm_mk'],$arr['datas_epbm_dosen']);
        $arr['breadcrumbs'] = 'epbm';
        $arr['content'] = 'vw_data_nilai_berhasil_disimpan_epbm'; 
        return view('vw_template', $arr);

    }
}