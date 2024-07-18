<?php

namespace App\Models;

use CodeIgniter\Model;

class KinumumModel extends Model
{
    protected $tableKinerjaCplCpmk = 'kinerja_cpl_cpmk';
    protected $tableCplLangsung = 'cpl_langsung';
    protected $tableCplRumusDeskriptor = 'cpl_rumus_deskriptor';
    protected $tableDeskriptorRumusCpmk = 'deskriptor_rumus_cpmk';
    protected $tableMatakuliahHasCpmk = 'matakuliah_has_cpmk';
    protected $tableMataKuliah = 'mata_kuliah';
    protected $tableMahasiswa = 'mahasiswa';
    protected $tableNilaiCpmk = 'nilai_cpmk';

    public function getKinumum()  
    {
        return $this->db->table($this->tableKinerjaCplCpmk)
            ->select('*')
            ->get()
            ->getResult();
    } 

    public function submitEdit($saveData, $idEdit)
    {
        return $this->db->table($this->tableKinerjaCplCpmk)
            ->where('id', '1')
            ->update($saveData);
    }

    // Codingan Baru

    public function getCpl()  
    {
        return $this->db->table($this->tableCplLangsung)
            ->select('*')
            ->get()
            ->getResult();
    }

    public function getCplRumusDeskriptor()  
    {
        return $this->db->table($this->tableCplRumusDeskriptor)
            ->select('*')
            ->get()
            ->getResult();
    }

    public function getDeskriptorRumusCpmk()  
    {
        return $this->db->table($this->tableDeskriptorRumusCpmk)
            ->select('*')
            ->join($this->tableMatakuliahHasCpmk, 'deskriptor_rumus_cpmk.id_matakuliah_has_cpmk = matakuliah_has_cpmk.id_matakuliah_has_cpmk')
            ->join($this->tableMataKuliah, 'matakuliah_has_cpmk.kode_mk = mata_kuliah.kode_mk')
            ->get()
            ->getResult();
    }

    public function getMahasiswaTahun($tahun)  
    {
        $status = ['Aktif', 'Lulus'];
        return $this->db->table($this->tableMahasiswa)
            ->select('*')
            ->where('tahun_masuk', $tahun)
            ->whereIn('StatusAkademik', $status)
            ->get()
            ->getResult();
    }

    public function getMahasiswaTahuns($tahun)  
    {
        return $this->db->table($this->tableMahasiswa)
            ->select('*')
            ->where('tahun_masuk', $tahun)
            ->get()
            ->getResult();
    }

    public function getDataMahasiswa($nim)  
    {
        return $this->db->table($this->tableMahasiswa)
            ->select('*')
            ->where('nim', $nim)
            ->get()
            ->getResult();
    }

    public function getNilaiCpmk()  
    {
        return $this->db->table($this->tableNilaiCpmk)
            ->select('*')
            ->get()
            ->getResult();
    }

    public function getNilaiCpmkSelect($id)  
    {
        return $this->db->table($this->tableNilaiCpmk)
            ->select('*')
            ->where('id_nilai', $id)
            ->get()
            ->getResult();
    }
}

?>
