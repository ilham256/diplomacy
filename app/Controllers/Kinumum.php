<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\KatkinModel;
use App\Models\KinumumModel;
use CodeIgniter\Controller;

class Kinumum extends Controller
{
    protected $mahasiswaModel;
    protected $katkinModel;
    protected $kinumumModel;
    protected $session;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->katkinModel = new KatkinModel();
        $this->kinumumModel = new KinumumModel();
        $this->session = session();

        if (!$this->session->get('loggedin') || $this->session->get('level') != 0) {
            header('Location: ' . base_url('Auth/login'));
            exit(); 
        }
    }

    public function index()
    {
        $data['breadcrumbs'] = 'kinumum';
        $data['content'] = 'vw_kinerja_umum_rev_3';
        $data['tahun_masuk'] = $this->mahasiswaModel->getTahunMasuk();

        $simpan_tahun = $this->mahasiswaModel->getTahunMasukMin();
        $tahun = 2018;

        $data['simpanan_tahun'] = $tahun;
        $data['t_simpanan_tahun'] = ($simpan_tahun[0]->tahun_masuk) + 1;
        $data['data_cpl'] = $this->kinumumModel->getCpl();

        $rumus_cpl = $this->kinumumModel->getCplRumusDeskriptor();
        $rumus_deskriptor = $this->kinumumModel->getDeskriptorRumusCpmk();
        $nilai_cpmk = $this->kinumumModel->getNilaiCpmk();

        if ($this->request->getPost('pilih')) {
            $tahun = $this->request->getPost('tahun_masuk');
            $data['simpanan_tahun'] = $tahun;
            $data['t_simpanan_tahun'] = ((int)$tahun) + 1;
        }

        $nilai_std_max = [];
        $nilai_std_min = [];
        $nilai_cpl_average = [];
        $nilai_cpl_mahasiswa = [];
        $data['jumlah'] = [];

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
            array_push($mahasiswa, $data_m);
        }

        foreach ($data['data_cpl'] as $key_0) {
            $dt = [];
            foreach ($mahasiswa as $key) {
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
                array_push($dt, $n);
            }
            $j = 0;
            foreach ($dt as $k) {
                if ($k > 0.0) {
                    $j += 1;
                }
            }

            if ($j == 0) {
                $j = 1;
            }

            $dt_avg = array_sum($dt) / $j;

            if ($dt_avg < 50) {
                $dt_avg = 50;
            }

            array_push($nilai_cpl_mahasiswa, $dt);
            array_push($nilai_cpl_average, $dt_avg);
            array_push($nilai_std_max, $dt_avg + 5);
            array_push($nilai_std_min, $dt_avg - 5);
            array_push($data['jumlah'], $j);
        }

        $target = $this->katkinModel->getKatkin();
        $data['target'] = ($target[0]->nilai_target_pencapaian_cpl);
        $data['target_cpl'] = $target;
        $data['nilai_cpl'] = $nilai_cpl_average;
        $data['nilai_std_max'] = $nilai_std_max;
        $data['nilai_std_min'] = $nilai_std_min;
        $data['nilai_cpl_mahasiswa'] = $nilai_cpl_mahasiswa;

        return view('vw_template', $data);
    }
}
