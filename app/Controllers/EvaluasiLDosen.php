<?php

namespace App\Controllers;

use App\Models\MatakuliahModel;
use App\Models\MahasiswaModel;
use App\Models\EvaluasiLModel;
use App\Models\KatkinModel;
use App\Models\KinumumModel;
use App\Models\KincplModel;
use App\Models\ReportModel;

class EvaluasiLDosen extends BaseController {

    public function __construct()
    { 
        $this->matakuliahModel = new MatakuliahModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->evaluasiLModel = new EvaluasiLModel();
        $this->katkinModel = new KatkinModel();
        $this->kinumumModel = new KinumumModel();
        $this->kincplModel = new KincplModel();
        $this->reportModel = new ReportModel();

        $session = session();
        if ($session->get('loggedin') !== true || $session->get('level') != 1) {
            header('Location: ' . base_url('Auth/login'));
            exit(); 
        }
    }
     
    public function index()
    {
        $data['breadcrumbs'] = 'evaluasi_l';
        $data['content'] = 'analisis_evaluasi_pengukuran_langsung/analisis_kinerja_cpl_vw';

        $data['data_semester'] = $this->matakuliahModel->getSemester();
        $data['tahun_masuk'] = $this->mahasiswaModel->getTahunMasuk();
        $data['tahun_masuk_max'] = $this->mahasiswaModel->getTahunMasukMax();
        $data['katkin'] = $this->katkinModel->getKatkin();

        $data['data_cpl'] = $this->kinumumModel->getCpl();
        $data['nama_cpl'] = array_map(function($cpl) {
            return $cpl->nama;
        }, $data['data_cpl']);

        $rumus_cpl = $this->kinumumModel->getCplRumusDeskriptor();
        $rumus_deskriptor = $this->kinumumModel->getDeskriptorRumusCpmk();
        $nilai_cpmk = $this->kinumumModel->getNilaiCpmk();

        $tahun_min = 2017;
        $tahun_max = 2019;

        $target = $this->katkinModel->getKatkin();

        $data['simpanan_tahun_min'] = $tahun_min;
        $data['t_simpanan_tahun_min'] = ((int)$tahun_min) + 1;
        $data['simpanan_tahun_max'] = $tahun_max;
        $data['t_simpanan_tahun_max'] = ((int)$tahun_max) + 1;

        if ($this->request->getPost('pilih')) {
            $tahun_min = $this->request->getPost('tahun_masuk_min');
            $data['simpanan_tahun_min'] = $tahun_min;
            $data['t_simpanan_tahun_min'] = ((int)$tahun_min) + 1;

            $tahun_max = $this->request->getPost('tahun_masuk_max');
            $data['simpanan_tahun_max'] = $tahun_max;
            $data['t_simpanan_tahun_max'] = ((int)$tahun_max) + 1;
        }

        $data['tahun_masuk_select'] = range($tahun_min, $tahun_max - 1);

        $select_tahun = [];
        $simpan = [];
        $nilai_std_max = [];
        $nilai_std_min = [];
        $nilai_cpl_average = [];
        $nilai_cpl_mahasiswa = [];
        $nilai_target = [];

        function curl($url){
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
   
        foreach ($data['tahun_masuk_select'] as $tahun) {
            
            $nilai_std_max_1 = [];
            $nilai_std_min_1 = [];
            $nilai_cpl_average_1 = []; 
            $nilai_cpl_mahasiswa_1 = [];
            $target_1 = [];
        
            $send = curl("https://api.ipb.ac.id/v1/Mahasiswa/DaftarMahasiswa/PerDepartemen?departemenId=160&strata=S1&tahunMasuk=".$tahun); 

            $mahasiswa = json_decode($send, TRUE);

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
                $j = count(array_filter($dt, function($k) { return $k > 0.0; }));

                $j = $j == 0 ? 1 : $j;

                $dt_avg = array_sum($dt) / $j;
            
                array_push($nilai_cpl_mahasiswa_1, $dt);
                array_push($nilai_cpl_average_1, round($dt_avg));
                array_push($nilai_std_max_1, $dt_avg + 5);
                array_push($nilai_std_min_1, $dt_avg - 5);
                array_push($target_1, $target[0]->nilai_target_pencapaian_cpl);
            }

            array_push($nilai_cpl_mahasiswa, $nilai_cpl_mahasiswa_1);
            array_push($nilai_cpl_average, $nilai_cpl_average_1);
            array_push($nilai_std_max, $nilai_std_max_1);
            array_push($nilai_std_min, $nilai_std_min_1);
            array_push($nilai_target, $target_1);
        }

        $data['target'] = $nilai_target;
        $data['nilai_cpl'] = $nilai_cpl_average;
        $data['nilai_std_max'] = $nilai_std_max;
        $data['nilai_std_min'] = $nilai_std_min;

        return view('vw_template_dosen', $data);
    }

     private function curl($url)
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

     public function evaluasiKinerjaCpl()
    {
        $arr['breadcrumbs'] = 'evaluasi_l';
        $arr['content'] = 'analisis_evaluasi_pengukuran_langsung/evaluasi_kinerja_cpl_vw';

        $arr['semester'] = $this->kincplModel->getSemester();
        $arr['cpl'] = $this->kincplModel->getCpl();
        $arr['simpanan_cpl'] = $arr['cpl'][7]->id_cpl_langsung;

        $rumus_cpl = $this->kinumumModel->getCplRumusDeskriptor();
        $rumus_deskriptor = $this->kinumumModel->getDeskriptorRumusCpmk();
        $nilai_cpmk = $this->kinumumModel->getNilaiCpmk();

        $arr['tahun_masuk'] = $this->mahasiswaModel->getTahunMasuk();
        $arr['simpanan_tahun'] = $arr['tahun_masuk'][0]->tahun_masuk;
        $arr['t_simpanan_tahun'] = $arr['tahun_masuk'][0]->tahun_masuk + 1;

        $target = $this->katkinModel->getKatkin();
        $target_cpl = $target[0]->nilai_target_pencapaian_cpl;

        $arr['tahun'] = 2017;

        if ($this->request->getPost('pilih')) {
            $tahun = $this->request->getPost('tahun');
            $arr['tahun'] = $tahun;
            $cpl_1 = $this->request->getPost('cpl');
            $arr['simpanan_cpl'] = $cpl_1;
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

        $send = curl("https://api.ipb.ac.id/v1/Mahasiswa/DaftarMahasiswa/PerDepartemen?departemenId=160&strata=S1&tahunMasuk=" . $arr['tahun']);
        $mahasiswa = json_decode($send, true);

        // perhitungan nilai target
        $nilai_target = [];
        $persentase_nilai_target = [];

        foreach ($arr['semester'] as $key_0) {
            $n_target = 0;
            foreach ($rumus_cpl as $key_4) {
                if ($arr['simpanan_cpl'] == $key_4->id_cpl_langsung) {
                    foreach ($rumus_deskriptor as $key_3) {
                        if ($key_4->id_deskriptor == $key_3->id_deskriptor && $key_0->id_semester == $key_3->id_semester) {
                            $n_target += $key_4->persentasi * $target_cpl * $key_3->persentasi;
                        }
                    }
                }
            }
            $nilai_target[] = $n_target;
        }

        for ($i = 0; $i < count($nilai_target); $i++) {
            $pnt = 0;
            for ($p = 0; $p <= $i; $p++) {
                $pnt += $nilai_target[$p];
            }
            $persentase_nilai_target[] = $pnt;
        }

        // perhitungan nilai maksimal
        $nilai_maksimal = [];
        $persentase_nilai_maksimal = [];

        foreach ($arr['semester'] as $key_0) {
            $n_m = 0;
            foreach ($rumus_cpl as $key_4) {
                if ($arr['simpanan_cpl'] == $key_4->id_cpl_langsung) {
                    foreach ($rumus_deskriptor as $key_3) {
                        if ($key_4->id_deskriptor == $key_3->id_deskriptor && $key_0->id_semester == $key_3->id_semester) {
                            $n_m += $key_4->persentasi * 100 * $key_3->persentasi;
                        }
                    }
                }
            }
            $nilai_maksimal[] = $n_m;
        }

        for ($i = 0; $i < count($nilai_maksimal); $i++) {
            $pnt = 0;
            for ($p = 0; $p <= $i; $p++) {
                $pnt += $nilai_maksimal[$p];
            }
            $persentase_nilai_maksimal[] = $pnt;
        }

        // perhitungan nilai mahasiswa
        $nilai_cpl_average = [];
        $nilai_cpl_mahasiswa = [];
        $nilai_capaian_mahasiswa = [];

        foreach ($arr['semester'] as $key_0) {
            $dt = [];
            foreach ($mahasiswa as $key) {
                $n = 0;
                foreach ($nilai_cpmk as $key_2) {
                    if ($key['Nim'] == $key_2->nim) {
                        $n_1 = 0;
                        foreach ($rumus_cpl as $key_4) {
                            if ($arr['simpanan_cpl'] == $key_4->id_cpl_langsung) {
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
                $dt[] = $n;
            }

            $j = count(array_filter($dt, fn($k) => $k > 0.0));
            $j = $j ?: 1;
            $dt_avg = array_sum($dt) / $j;

            $nilai_cpl_mahasiswa[] = $dt;
            $nilai_cpl_average[] = $dt_avg;
        }

        for ($i = 0; $i < count($nilai_cpl_average); $i++) {
            $pnt = 0;
            for ($p = 0; $p <= $i; $p++) {
                $pnt += $nilai_cpl_average[$p];
            }
            $nilai_capaian_mahasiswa[] = $pnt;
        }

        $arr['capaian'] = $nilai_capaian_mahasiswa;
        $arr['target'] = $persentase_nilai_target;
        $arr['nilai_tertinggi'] = $persentase_nilai_maksimal;
        $arr['nama_semester'] = array_map(fn($key_0) => "Semester " . $key_0->nama, $arr['semester']);

        return view('vw_template_dosen', $arr);
    } 


    public function evaluasiKinerjaCpmk()
    {
        $arr['simpanan_mk'] = 'TIN370';
        $arr['tahun_mk'] = 2018;

        if ($this->request->getPost('pilih_4')) {
            $th = $this->request->getPost('tahun');
            $arr['tahun_mk'] = $th;

            $mk_1 = $this->request->getPost('mk');
            $arr['simpanan_mk'] = $mk_1;

            $arr['status_aktif'] = '';
            $arr['status_aktif_2'] = '';
            $arr['status_aktif_4'] = 'show active';

            $arr['naf'] = '';
            $arr['naf_2'] = '';
            $arr['naf_4'] = 'active';
        }

        $arr['data_mk'] = $this->reportModel->getDataMk($arr['simpanan_mk']);

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

        $send = curl("https://api.ipb.ac.id/v1/Mahasiswa/DaftarMahasiswa/PerDepartemen?departemenId=160&strata=S1&tahunMasuk=" . $arr['tahun_mk']);
        $mahasiswa = json_decode($send, true);

        $mk_raport = $this->reportModel->getMkCpmk($arr['simpanan_mk']);
        $arr['mk_raport'] = [];
        $arr['nilai_mk_raport'] = [];
        $arr['nilai_mk_raport_tl'] = [];

        foreach ($mk_raport as $key_0) {
            $arr['mk_raport'][] = $key_0->id_cpmk_langsung;
        }

        foreach ($mk_raport as $key) {
            $nilai_mk_raport_s = [];
            $nilai_mk_raport_s_tl = [];
            foreach ($mahasiswa as $key_2) {
                $nilai_mahasiswa = $this->reportModel->getNilaiCpmk($key->id_matakuliah_has_cpmk, $key_2['Nim']);

                if (empty($nilai_mahasiswa)) {
                    $nilai_mahasiswa = 0;
                }

                if ($nilai_mahasiswa == 0) {
                    $nilai_mk_raport_s[] = $nilai_mahasiswa;
                } else {
                    $nilai_sementara = [];
                    $nilai_sementara_tl = [];
                    foreach ($nilai_mahasiswa as $key_2) {
                        $nilai_sementara[] = $key_2->nilai_langsung;
                        $nilai_sementara_tl[] = $key_2->nilai_tak_langsung;
                    }

                    $average = array_sum($nilai_sementara) / count($nilai_sementara);
                    $average_tl = array_sum($nilai_sementara_tl) / count($nilai_sementara_tl);
                    $nilai_mk_raport_s[] = $average;
                    $nilai_mk_raport_s_tl[] = $average_tl;
                }
            }

            $j = count(array_filter($nilai_mk_raport_s, fn($k) => $k > 0.0)) ?: 1;
            $j_tl = count(array_filter($nilai_mk_raport_s_tl, fn($k_tl) => $k_tl > 0.0)) ?: 1;

            $dt_avg = array_sum($nilai_mk_raport_s) / $j;
            $dt_avg_tl = array_sum($nilai_mk_raport_s_tl) / $j_tl;

            $arr['nilai_mk_raport'][] = $dt_avg;
            $arr['nilai_mk_raport_tl'][] = $dt_avg_tl;
        }

        // Return atau render view di sini jika diperlukan
    }


} 
