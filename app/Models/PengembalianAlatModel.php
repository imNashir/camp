<?php

namespace App\Models;

use CodeIgniter\Model;

class pengembalianAlatModel extends Model
{
    protected $table            = 'pengembalian';
    protected $primaryKey       = 'id_pengemb_alat';

    protected $allowedFields    = [
        'id_pengemb_alat',
        'id_alat',
        'jumlah_pengemb_alat',
        'harga_satuan',
        'total_harga',
        'tgl_pengemb_alat',
        'disimpan_oleh',
        'id_trans_alat'
    ];
    public function tambahPengembalian($data)
    {
        return $this->insert($data);
    }
    
    public function getPengembAlat()
{
    return $this->select('pengembalian.*, alat.harga, alat.nama_alat, kategori.nama_kategori') // Pilih kolom-kolom yang dibutuhkan
        ->join('alat', 'alat.id_alat = pengembalian.id_alat')
        ->join('kategori', 'kategori.id_kategori = alat.id_kategori')
        ->findAll();
}

    public function filter($tglawal, $tglakhir)
    {
        return $this->where('tgl_pengemb_alat >=', $tglawal)
            ->where('tgl_pengemb_alat <=', $tglakhir)
            ->join('alat', 'alat.id_alat = pengembalian.id_alat')
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori')
            ->findAll();
    }
}
