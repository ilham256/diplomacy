<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\KatkinModel;
use App\Models\KinumumModel;

class Data extends BaseController
{
    protected $mahasiswaModel;
    protected $katkinModel;
    protected $kinumumModel;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->katkinModel = new KatkinModel();
        $this->kinumumModel = new KinumumModel();

        // Assuming you have a session library loaded in BaseController
        if (!session()->get('loggedin') || session()->get('level') != 0) {
            header('Location: ' . base_url('Auth/login'));
            exit(); 
        }
    }

    public function index()
    {
        $arr['breadcrumbs'] = 'data';
        $arr['content'] = 'vw_data';
        $arr['tahun_masuk'] = $this->mahasiswaModel->getTahunMasuk();

        $simpan_tahun = $this->mahasiswaModel->getTahunMasukMin();
        $tahun = 2017;

        $arr['simpanan_tahun'] = $tahun;
        $arr['t_simpanan_tahun'] = ($simpan_tahun[0]->tahun_masuk) + 1;
        $arr['data_cpl'] = $this->kinumumModel->getCpl();

        $rumus_cpl = $this->kinumumModel->getCplRumusDeskriptor();
        $rumus_deskriptor = $this->kinumumModel->getDeskriptorRumusCpmk();
        $nilai_cpmk = $this->kinumumModel->getNilaiCpmk();

        if ($this->request->getPost('pilih')) {
            $tahun = $this->request->getPost('tahun');
            $arr['simpanan_tahun'] = $tahun;
            $arr['t_simpanan_tahun'] = ((int)$tahun) + 1;
        }

        $nilai_std_max = [];
        $nilai_std_min = [];
        $nilai_cpl_average = [];
        $nilai_cpl_mahasiswa = [];

        $simpan = [];

        $mahasiswa_2 = $this->kinumumModel->getMahasiswaTahun($tahun);
        $mahasiswa = [];

        foreach ($mahasiswa_2 as $key) {
            $data_m = [
                "Nim" => $key->nim,
                "Nama" => $key->nama,
                "SemesterMahasiswa" => $key->SemesterMahasiswa,
                "StatusAkademik" => $key->StatusAkademik,
                "tahun" => $key->tahun_masuk
            ];
            $mahasiswa[] = $data_m;
        }
        $arr['data_mahasiswa'] = $mahasiswa;

        $data_nilai_cpl = [];
        foreach ($arr['data_cpl'] as $key_0) {
            foreach ($arr['data_mahasiswa'] as $key) {
                $n = 0;
                foreach ($nilai_cpmk as $key_2) {
                    if ($key["Nim"] == $key_2->nim) {
                        $n_1 = 0;
                        foreach ($rumus_cpl as $key_4) {
                            if ($key_0->id_cpl_langsung == $key_4->id_cpl_langsung) {
                                foreach ($rumus_deskriptor as $key_3) {
                                    if ($key_4->id_deskriptor == $key_3->id_deskriptor) {
                                        if ($key_2->id_matakuliah_has_cpmk == $key_3->id_matakuliah_has_cpmk) {
                                            $n_1 += $key_4->persentasi * $key_2->nilai_langsung * $key_3->persentasi;
                                        }
                                    }
                                }
                            }
                        }
                        $n += $n_1;
                    }
                }
                $save_data = [
                    'nim' => $key["Nim"],
                    'nama_mahasiswa' => $key["Nama"],
                    'id_cpl_langsung' => $key_0->id_cpl_langsung,
                    'nilai_cpl' => $n,
                ];
                $data_nilai_cpl[] = $save_data;
            }
        }

        $target = $this->katkinModel->getKatkin();
        $arr['target'] = $target[0]->nilai_target_pencapaian_cpl;
        $arr['datas'] = $data_nilai_cpl;

		//dd($arr);

        return view('vw_template', $arr);
    }

    public function export_excel()
    {
        $arr['tahun_masuk'] = $this->mahasiswaModel->getTahunMasuk();

        $simpan_tahun = $this->mahasiswaModel->getTahunMasukMin();
        $tahun = 2017;
        $arr['simpanan_tahun'] = $tahun;
        $arr['t_simpanan_tahun'] = ($simpan_tahun[0]->tahun_masuk) + 1;
        $arr['data_cpl'] = $this->kinumumModel->getCpl();
        $rumus_cpl = $this->kinumumModel->getCplRumusDeskriptor();
        $rumus_deskriptor = $this->kinumumModel->getDeskriptorRumusCpmk();
        $nilai_cpmk = $this->kinumumModel->getNilaiCpmk();

        if ($this->request->getPost('download')) {
            $tahun = $this->request->getPost('tahun');
            $arr['simpanan_tahun'] = $tahun;
            $arr['t_simpanan_tahun'] = ((int)$tahun) + 1;
        }

        $nilai_std_max = [];
        $nilai_std_min = [];
        $nilai_cpl_average = [];
        $nilai_cpl_mahasiswa = [];

        $simpan = [];

        $mahasiswa_2 = $this->kinumumModel->getMahasiswaTahun($tahun);
        $mahasiswa = [];

        foreach ($mahasiswa_2 as $key) {
            $data_m = [
                "Nim" => $key->nim,
                "Nama" => $key->nama,
                "SemesterMahasiswa" => $key->SemesterMahasiswa,
                "StatusAkademik" => $key->StatusAkademik,
                "tahun" => $key->tahun_masuk
            ];
            $mahasiswa[] = $data_m;
        }
        $arr['data_mahasiswa'] = $mahasiswa;

        $data_nilai_cpl = [];
        foreach ($arr['data_cpl'] as $key_0) {
            foreach ($arr['data_mahasiswa'] as $key) {
                $n = 0;
                foreach ($nilai_cpmk as $key_2) {
                    if ($key["Nim"] == $key_2->nim) {
                        $n_1 = 0;
                        foreach ($rumus_cpl as $key_4) {
                            if ($key_0->id_cpl_langsung == $key_4->id_cpl_langsung) {
                                foreach ($rumus_deskriptor as $key_3) {
                                    if ($key_4->id_deskriptor == $key_3->id_deskriptor) {
                                        if ($key_2->id_matakuliah_has_cpmk == $key_3->id_matakuliah_has_cpmk) {
                                            $n_1 += $key_4->persentasi * $key_2->nilai_langsung * $key_3->persentasi;
                                        }
                                    }
                                }
                            }
                        }
                        $n += $n_1;
                    }
                }
                $save_data = [
                    'nim' => $key["Nim"],
                    'nama_mahasiswa' => $key["Nama"],
                    'id_cpl_langsung' => $key_0->id_cpl_langsung,
                    'nilai_cpl' => $n,
                ];
                $data_nilai_cpl[] = $save_data;
            }
        }
        $target = $this->katkinModel->getKatkin();
        $arr['target'] = $target[0]->nilai_target_pencapaian_cpl;
        $arr['datas'] = $data_nilai_cpl;

        return view('vw_excel_cpl', $arr);
    }

    public function data_cpmk()
    {
        $arr['breadcrumbs'] = 'data_cpmk';
        $arr['content'] = 'vw_data_cpmk';

        $arr['data_cpl'] = $this->kinumumModel->getCpl();
        $rumus_cpl = $this->kinumumModel->getCplRumusDeskriptor();
        $arr['data_rumus_deskriptor'] = $this->kinumumModel->getDeskriptorRumusCpmk();
        $arr['nilai'] = [];
        $nim = "-";

        if ($this->request->getPost('pilih')) {
            $nim = $this->request->getPost('nim');
        }

        $arr['data_mahasiswa'] = $this->kinumumModel->getDataMahasiswa($nim);

        foreach ($arr['data_rumus_deskriptor'] as $key) {
            $nilai = $this->kinumumModel->getNilaiCpmkSelect($nim . "_" . $key->id_matakuliah_has_cpmk);
            $arr['nilai'][] = $nilai;
        }

        return view('vw_template', $arr);
    }
}
