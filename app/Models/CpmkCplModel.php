<?php

namespace App\Models;

use CodeIgniter\Model;

class CpmkCplModel extends Model
{
    protected $table = 'cpl_langsung'; // Default table
    protected $primaryKey = 'id_cpl_langsung';
    protected $allowedFields = ['field1', 'field2', 'field3']; // Sesuaikan dengan kolom tabel Anda

    public function getCpmk()
    {
        return $this->db->table('cpmk_langsung')
                        ->get()
                        ->getResult();
    }

    public function getCpl()
    {
        return $this->db->table('cpl_langsung')
                        ->get()
                        ->getResult();
    }

    public function getCplRumusDeskriptor()
    {
        return $this->db->table('cpl_rumus_deskriptor')
                        ->select('*')
                        ->join('deskriptor', 'deskriptor.id_deskriptor = cpl_rumus_deskriptor.id_deskriptor')
                        ->get()
                        ->getResult();
    }

    public function editCpl($id)
    {
        return $this->db->table('cpl_langsung')
                        ->where('id_cpl_langsung', $id)
                        ->get()
                        ->getResult();
    }

    public function submitTambahCpl($data)
    {
        return $this->db->table('cpl_langsung')
                        ->insert($data);
    }

    public function submitEditCpl($data, $id)
    {
        return $this->db->table('cpl_langsung')
                        ->where('id_cpl_langsung', $id)
                        ->update($data);
    }

    public function hapusCpl($id)
    {
        return $this->db->table('cpl_langsung')
                        ->where('id_cpl_langsung', $id)
                        ->delete();
    }

    public function editCpmk($id)
    {
        return $this->db->table('cpmk_langsung')
                        ->where('id_cpmk_langsung', $id)
                        ->get()
                        ->getResult();
    }

    public function submitTambahCpmk($data)
    {
        return $this->db->table('cpmk_langsung')
                        ->insert($data);
    }

    public function submitEditCpmk($data, $id)
    {
        return $this->db->table('cpmk_langsung')
                        ->where('id_cpmk_langsung', $id)
                        ->update($data);
    }

    public function hapusCpmk($id)
    {
        return $this->db->table('cpmk_langsung')
                        ->where('id_cpmk_langsung', $id)
                        ->delete();
    }
}
?>
