<?php

namespace App\Models;

use CodeIgniter\Model;

class CountModel extends Model
{
    public function countAlat()
    {
        return $this->db->table('alat')->countAll();
    }

    public function countAlatAda()
    {
        return $this->db->table('alat')
            ->where(['jumlah >' => 0])
            ->countAllResults();
    }

    public function countAlatHabis()
    {
        return $this->db->table('alat')
            ->where(['jumlah =' => 0])
            ->countAllResults();
    }

    public function countKategori()
    {
        return $this->db->table('kategori')->countAll();
    }

      public  function countUser()
    {
        return $this->db->table('users')->countAll();
    }

    public function countTransAlat()
    {
        return $this->db->table('transaksi')->countAll();
    }

    public function countPengembAlat()
    {
        return $this->db->table('pengembalian')->countAll();
    }
}
