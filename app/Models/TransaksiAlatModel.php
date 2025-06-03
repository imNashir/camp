<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiAlatModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_trans_alat';
    protected $allowedFields    = [
        'id_trans_alat',
        'id_alat',
        'jumlah_trans_alat',
        'total_harga',
        'status',
        'tgl_est',
        'tgl_trans_alat',
        'disimpan_oleh'
    ];

    public function kurangiJumlahTransAlat($id_trans_alat, $jumlah_pengemb_alat)
    {
        return $this->set('jumlah_trans_alat', "jumlah_trans_alat - $jumlah_pengemb_alat", false)
            ->where('id_trans_alat', $id_trans_alat)
            ->update();
    }

    public function getTransAlat()
    {
        return $this->db->table('transaksi')
            ->select('transaksi.*, alat.nama_alat, alat.harga, kategori.nama_kategori')
            ->join('alat', 'alat.id_alat = transaksi.id_alat')
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori')
            ->get()
            ->getResultArray();
    }

    public function filter($tglawal, $tglakhir)
    {
        return $this->where('tgl_trans_alat >=', $tglawal)
            ->where('tgl_trans_alat <=', $tglakhir)
            ->join('alat', 'alat.id_alat = transaksi.id_alat')
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori')
            ->select('transaksi.*, alat.*, kategori.*')
            ->findAll();
    }
}
