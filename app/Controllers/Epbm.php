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

        return view('vw_template', $data);
    }



    public function import()
    {
        $fileMimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

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
            $arr = [];
            $arr['datas'] = [];
            $arr['datas_epbm'] = [];
            $arr['datas_psd'] = $this->epbmModel->getPsd();

            $sheetTahun = $spreadsheet->getSheet(0);
            $rowTahunSemester = $sheetTahun->rangeToArray('A2:C2', NULL, TRUE, FALSE);
            $dataTahunSemester = $rowTahunSemester[0][0];
            $dataTahun = substr(preg_replace("/[^0-9]/", "", $dataTahunSemester), 0, 4);
            $dataSemester = (strpos($dataTahunSemester, 'Ganjil') !== false) ? 'Ganjil' : 'Genap';

            for ($p = 0; $p < $highestSheet; $p++) {
                $sheet = $spreadsheet->getSheet($p);
                $highestRow = $sheet->getHighestRow();

                for ($row = 5; $row <= $highestRow; $row++) {
                    $rowMk = $sheet->rangeToArray('A' . $row . ':B' . $row, NULL, TRUE, FALSE);
                    $dataCekKodeMk = substr($rowMk[0][0], 0, -4);

                    if (!empty($rowMk[0][0]) && $rowMk[0][0] != "Mata Kuliah" && $rowMk[0][0] != "NIP" && $rowMk[0][0] != "Departemen Teknologi Industri Pertanian") {
                        $dataCek = $this->epbmModel->cekEpbmMataKuliah($rowMk[0][0]);
                        
                        if (empty($dataCek)) {
                            $dataCek3 = $this->epbmModel->cekMataKuliahKode3($dataCekKodeMk);
                            if (empty($dataCek3)) {
                                $dataCek2 = $this->epbmModel->cekMataKuliahKode2($dataCekKodeMk);
                                if (empty($dataCek2)) {
                                    $dataCek1 = $this->epbmModel->cekMataKuliahKode1($dataCekKodeMk);
                                    if (!empty($dataCek1)) {
                                        $kodeMk = $dataCek1[0]->kode_mk;
                                        $saveData = [
                                            "kode_epbm_mk" => $rowMk[0][0],
                                            "no" => substr($rowMk[0][0], -1),
                                            "kode_mk" => $kodeMk
                                        ];
                                        $this->epbmModel->updateExcelEpbmMataKuliah($saveData);
                                    }
                                } else {
                                    $kodeMk = $dataCek2[0]->kode_mk;
                                    $saveData = [
                                        "kode_epbm_mk" => $rowMk[0][0],
                                        "no" => substr($rowMk[0][0], -1),
                                        "kode_mk" => $kodeMk
                                    ];
                                    $this->epbmModel->updateExcelEpbmMataKuliah($saveData);
                                }
                            } else {
                                $kodeMk = $dataCek3[0]->kode_mk;
                                $saveData = [
                                    "kode_epbm_mk" => $rowMk[0][0],
                                    "no" => substr($rowMk[0][0], -1),
                                    "kode_mk" => $kodeMk
                                ];
                                $this->epbmModel->updateExcelEpbmMataKuliah($saveData);
                            }
                        }
                    }
                }

                for ($row = 5; $row <= $highestRow; $row++) {
                    $rowMk = $sheet->rangeToArray('A' . $row . ':B' . $row, NULL, TRUE, FALSE);
                    $dataCek = $this->epbmModel->cekEpbmMataKuliah($rowMk[0][0]);

                    if (!empty($rowMk[0][0]) && $rowMk[0][0] != "Mata Kuliah" && $rowMk[0][0] != "NIP" && $rowMk[0][0] != "Departemen Teknologi Industri Pertanian") {

                        if (empty($dataCek)) {
                            $dataCek3 = $this->epbmModel->cekEpbmMataKuliahHasDosen($d . '_' . $rowMk[0][0]);
                            if (empty($dataCek3)) {
                                $dataCek2 = $this->epbmModel->cekDosen($rowMk[0][0]);
                                if (!empty($dataCek2)) {
                                    $saveData = [
                                        "kode_epbm_mk_has_dosen" => $d . '_' . $rowMk[0][0],
                                        "kode_epbm_mk" => $d,
                                        "NIP" => $rowMk[0][0]
                                    ];
                                    $this->epbmModel->updateExcelEpbmMataKuliahHasDosen($saveData);
                                }
                            }
                        } else {
                            $d = $rowMk[0][0];
                        }
                    }
                }

                $rowPsd = $sheet->rangeToArray('C4:Q10', NULL, TRUE, FALSE);
                $rowNilaiPsd = $rowPsd[0][0] == NULL ? $rowPsd[6] : $rowPsd[0];
                $i = 0;
                foreach ($rowNilaiPsd as $key) {
                    if ($key != NULL && $key != "Semua") {
                        for ($row = 5; $row <= $highestRow; $row++) {
                            $rowData = $sheet->rangeToArray('A' . $row . ':B' . $row, NULL, TRUE, FALSE);
                            $rowNilai = $sheet->rangeToArray('C' . $row . ':Q' . $row, NULL, TRUE, FALSE);

                            if (!empty($rowData[0][0])) {
                                $dataCek1 = $this->epbmModel->cekEpbmMataKuliah($rowData[0][0]);
                                if (empty($dataCek1)) {
                                    $dataCek2 = $this->epbmModel->cekEpbmMataKuliahHasDosen($d . '_' . $rowData[0][0]);
                                    if (empty($dataCek2)) {
                                        $saveData = [
                                            "kode_nilai_epbm_mk_has_dosen" => "Data_nilai_Kosong",
                                            "kode_epbm_mk_has_dosen" => 0,
                                            "kode_psd" => 0,
                                            "tahun" => 0,
                                            "semester" => 0,
                                            "nilai" => 0
                                        ];
                                    } else {
                                        $saveData = [
                                            "kode_nilai_epbm_mk_has_dosen" => $dataTahun . '_' . $dataSemester . '_' . $d . '_' . $rowData[0][0] . '_' . $key,
                                            "kode_epbm_mk_has_dosen" => $d . '_' . $rowData[0][0],
                                            "kode_psd" => $key,
                                            "tahun" => $dataTahun,
                                            "semester" => $dataSemester,
                                            "nilai" => $rowNilai[0][0 + $i]
                                        ];
                                    }
                                    $this->epbmModel->updateExcelNilaiEpbmDosen($saveData);
                                } else {
                                    $saveData = [
                                        "kode_nilai_epbm_mk" => $dataTahun . '_' . $dataSemester . '_' . $rowData[0][0] . '_' . $key,
                                        "kode_epbm_mk" => $rowData[0][0],
                                        "kode_psd" => $key,
                                        "tahun" => $dataTahun,
                                        "semester" => $dataSemester,
                                        "nilai" => $rowNilai[0][0 + $i]
                                    ];
                                    $d = $rowData[0][0];
                                    $this->epbmModel->updateExcelNilaiEpbmMataKuliah($saveData);
                                }
                                $arr['datas'][] = $saveData;
                            }
                        }
                        $i++;
                    }
                }
            }
        } else {
            echo '<pre>';
            var_dump($_FILES['file']['type']);
            echo '</pre>';
        }
        $arr['breadcrumbs'] = 'epbm';
        $arr['content'] = 'vw_epbm';
        return view('vw_template', $arr);
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
                    if ($highestRow == 1000) {
                        $highestRow = 100 ;
                    }

                    $row_mk = $sheet->rangeToArray('A' . 13 . ':' . $highestColumn . 13,
                                                        NULL,
                                                        TRUE,
                                                        FALSE); 
                    $kode_mk_1 = $row_mk[0][2];
                    $kode_mk_2 = str_replace(" ", "", $kode_mk_1 );
                    $kode_mk = str_replace(":", "", $kode_mk_2 );

                    $cek_kode_mk = $this->cpmklang_model->cekmatakuliahkode2($kode_mk);

                    if (!empty($cek_kode_mk)) {
                        $kode_mk = $cek_kode_mk["0"]->kode_mk;
                    }else {
                        $cek_kode_mk = $this->cpmklang_model->cekmatakuliahkode3($kode_mk);
                    }  

                    if (!empty($cek_kode_mk)) {
                        $kode_mk = $cek_kode_mk["0"]->kode_mk;
                    }else {
                        $cek_kode_mk = $this->cpmklang_model->cekmatakuliahkode1($kode_mk);
                    }

                    if (!empty($cek_kode_mk)) {
                        $kode_mk = $cek_kode_mk["0"]->kode_mk;
                    }


                    $row_cpmk = $sheet->rangeToArray('F' . 19 . ':' . $highestColumn . 19,
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
                            $rowNilai = $sheet->rangeToArray('F' . $row . ':' . $highestColumn . $row,
                                                            NULL,
                                                            TRUE,
                                                            FALSE);
                            //Sesuaikan sama nama kolom tabel di database 

                            $data_cek =  $this->cpmklang_model->cekmatakuliahhascpmk($kode_mk.'_'.$key);

                            if (empty($data_cek)) {
                                $save_data = array(
                                    "id_nilai"=> "Data_CPMK_Kosong",
                                    "nim"=> 0,
                                    "id_matakuliah_has_cpmk"=> 0,
                                    "nilai_langsung"=> 0

                                );
                                $masukan = array(
                                    "id_nilai"=> "Data_CPMK_Kosong",
                                    "nim"=> 0,
                                    "id_matakuliah_has_cpmk"=> $kode_mk.'_'.$key,
                                    "nilai_langsung"=> 0

                                );
                            }
                            elseif ($rowData[0][1] == NULL) {
                                $save_data = array(
                                    "id_nilai"=> "Data_Kosong",
                                    "nim"=> 0,
                                    "id_matakuliah_has_cpmk"=> 0,
                                    "nilai_langsung"=> 0

                            );
                            $masukan = $save_data;
                            }else {                            
                                 $save_data = array(
                                    "id_nilai"=> $rowData[0][1].'_'.$kode_mk.'_'.$key,
                                    "nim"=> $rowData[0][1],
                                    "id_matakuliah_has_cpmk"=> $kode_mk.'_'.$key,
                                    "nilai_langsung"=> $rowData[0][5+$i]

                            );
                             $masukan = $save_data;
                            }
                            //sesuaikan nama dengan nama tabel
                             
                            array_push($arr['datas'],$masukan);
                            $insert = $this->cpmklang_model->updateexcel($save_data);
                            //delete_files($media['file_path']);
                                 
                        }
                        $i++;
                     }
                }

        } else {
            //echo $_FILES['upload_file']['type'];
            echo '<pre>';  var_dump($_FILES['file']['type']); echo '</pre>';

        }
        //echo '<pre>';  var_dump($highestRow); echo '</pre>';
        $arr['breadcrumbs'] = 'cpmklang';
        $arr['content'] = 'vw_data_nilai_berhasil_disimpan'; 
        return view('vw_template', $arr);


    }

}