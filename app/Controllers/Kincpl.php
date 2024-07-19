<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\KatkinModel;
use App\Models\KincplModel;
use App\Models\KinumumModel;
use CodeIgniter\Controller;

class Kincpl extends Controller
{
    protected $mahasiswaModel;
    protected $katkinModel;
    protected $kincplModel;
    protected $kinumumModel;
    protected $session;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->katkinModel = new KatkinModel();
        $this->kincplModel = new KincplModel();
        $this->kinumumModel = new KinumumModel();
        $this->session = session();

        if (!$this->session->get('loggedin') || $this->session->get('level') != 0) {
            header('Location: ' . base_url('Auth/login'));
            exit(); 
        }
    }

    public function index()
    {
        $data['breadcrumbs'] = 'kincpl';
        $data['content'] = 'vw_kinerja_cpl';
        $data['semester'] = $this->kincplModel->getSemester();
        $data['cpl'] = $this->kincplModel->getCpl();
        $data['simpanan_cpl'] = $data['cpl'][7]->id_cpl_langsung;

        $rumus_cpl = $this->kinumumModel->getCplRumusDeskriptor();
        $rumus_deskriptor = $this->kinumumModel->getDeskriptorRumusCpmk();
        $nilai_cpmk = $this->kinumumModel->getNilaiCpmk();

        $data['tahun_masuk'] = $this->mahasiswaModel->getTahunMasuk();
        $data['simpanan_tahun'] = $data['tahun_masuk'][0]->tahun_masuk;
        $data['t_simpanan_tahun'] = $data['tahun_masuk'][0]->tahun_masuk + 1;

        $target = $this->katkinModel->getKatkin();
        $target_cpl = $target[0]->nilai_target_pencapaian_cpl;

        $data['tahun'] = 2017;

        if ($this->request->getPost('pilih')) {
            $tahun = $this->request->getPost('tahun');
            $data['tahun'] = $tahun;
            $cpl_1 = $this->request->getPost('cpl');
            $data['simpanan_cpl'] = $cpl_1;
        }

        function curl($url)
        {
            $ch = curl_init();
            $headers = [
                'accept: text/plain',
                'X-IPBAPI-TOKEN: Bearer 86f2760d-7293-36f4-833f-1d29aaace42e'
            ];
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        }

        $send = curl("https://api.ipb.ac.id/v1/Mahasiswa/DaftarMahasiswa/PerDepartemen?departemenId=160&strata=S1&tahunMasuk=" . $data['tahun']);
        $mahasiswa = json_decode($send, true);

        $nilai_target = [];
        $persentase_nilai_target = [];

        foreach ($data['semester'] as $key_0) {
            $n_target = 0;
            foreach ($rumus_cpl as $key_4) {
                if ($data['simpanan_cpl'] == $key_4->id_cpl_langsung) {
                    foreach ($rumus_deskriptor as $key_3) {
                        if ($key_4->id_deskriptor == $key_3->id_deskriptor && $key_0->id_semester == $key_3->id_semester) {
                            $n_target += $key_4->persentasi * $target_cpl * $key_3->persentasi;
                        }
                    }
                }
            }
            array_push($nilai_target, $n_target);
        }

        for ($i = 0; $i < count($nilai_target); $i++) {
            $pnt = 0;
            for ($p = 0; $p < $i + 1; $p++) {
                $pnt += $nilai_target[$p];
            }
            array_push($persentase_nilai_target, $pnt);
        }

        $nilai_maksimal = [];
        $persentase_nilai_maksimal = [];

        foreach ($data['semester'] as $key_0) {
            $n_m = 0;
            foreach ($rumus_cpl as $key_4) {
                if ($data['simpanan_cpl'] == $key_4->id_cpl_langsung) {
                    foreach ($rumus_deskriptor as $key_3) {
                        if ($key_4->id_deskriptor == $key_3->id_deskriptor && $key_0->id_semester == $key_3->id_semester) {
                            $n_m += $key_4->persentasi * 100 * $key_3->persentasi;
                        }
                    }
                }
            }
            array_push($nilai_maksimal, $n_m);
        }

        for ($i = 0; $i < count($nilai_maksimal); $i++) {
            $pnt = 0;
            for ($p = 0; $p < $i + 1; $p++) {
                $pnt += $nilai_maksimal[$p];
            }
            array_push($persentase_nilai_maksimal, $pnt);
        }

        $nilai_cpl_average = [];
        $nilai_cpl_mahasiswa = [];
        $nilai_capaian_mahasiswa = [];

        foreach ($data['semester'] as $key_0) {
            $dt = [];
            foreach ($mahasiswa as $key) {
                $n = 0;
                foreach ($nilai_cpmk as $key_2) {
                    if ($key["Nim"] == $key_2->nim) {
                        $n_1 = 0;
                        foreach ($rumus_cpl as $key_4) {
                            if ($data['simpanan_cpl'] == $key_4->id_cpl_langsung) {
                                foreach ($rumus_deskriptor as $key_3) {
                                    if ($key_4->id_deskriptor == $key_3->id_deskriptor && $key_0->id_semester == $key_3->id_semester && $key_2->id_matakuliah_has_cpmk == $key_3->id_matakuliah_has_cpmk) {
                                        $n_1 += $key_4->persentasi * $key_2->nilai_langsung * $key_3->persentasi;
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
            array_push($nilai_cpl_mahasiswa, $dt);
            array_push($nilai_cpl_average, $dt_avg);
        }

        for ($i = 0; $i < count($nilai_cpl_average); $i++) {
            $pnt = 0;
            for ($p = 0; $p < $i + 1; $p++) {
                $pnt += $nilai_cpl_average[$p];
            }
            array_push($nilai_capaian_mahasiswa, $pnt);
        }

        $data['capaian'] = $nilai_capaian_mahasiswa;
        $data['target'] = $persentase_nilai_target;
        $data['nilai_tertinggi'] = $persentase_nilai_maksimal;
        $data['nama_semester'] = [];
        foreach ($data['semester'] as $key_0) {
            array_push($data['nama_semester'], "Semester " . $key_0->nama);
        }

        return view('vw_template', $data);
    }
}
