<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'dosen'; // Nama tabel
    protected $primaryKey = 'nim'; // Primary key
    protected $allowedFields = ['NIP', 'nama_dosen', 'password']; // Sesuaikan dengan kolom tabel Anda

    public function getDosen()
    {
        return $this->findAll();
    }

    public function submitTambah($KL)
    {
        //dd($saveData);

        return $this->insert($KL);
        return true;
    }

    public function updateExcel($saveData)
    {
        return $this->replace($saveData);
    }

    public function editDosen($id)
    {
        return $this->where('NIP', $id)->findAll();
    }
    public function editDosen2($id)  
    {
        return $this->db->table($this->table)
            ->select('*')
            ->where('NIP', $id)
            ->get()
            ->getResult();
    }

    public function submitEdit($saveData, $idEdit)
    {
        return $this->db->table($this->table)
            ->where('NIP', $idEdit)
            ->update($saveData);
    }

    public function updateDosen($saveData)
    {
        return $this->replace($saveData);
    }

    public function hapus($id)
    {
        return $this->where('NIP', $id)->delete();
    }
}
?>
