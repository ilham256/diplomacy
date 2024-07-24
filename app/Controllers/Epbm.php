<?php
namespace App\Controllers;

use App\Models\EpbmModel;
use App\Models\MatakuliahModel;
use App\Models\MahasiswaModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

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

        if ($this->request->getFile('file') && in_array($this->request->getFile('file')->getMimeType(), $fileMimes)) {
            $file = $this->request->getFile('file');
            $extension = $file->getClientExtension();

            if ($extension == 'csv') {
                $reader = new Csv();
            } elseif ($extension == 'xls') {
                $reader = new Xls();
            } else {
                $reader = new ReaderXlsx();
            }

            $spreadsheet = $reader->load($file->getTempName());
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
}