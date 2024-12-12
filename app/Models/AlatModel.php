<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table            = 'alat';
    protected $primaryKey       = 'id_alat';
    protected $allowedFields    = [
        'nama_alat',
        'id_kategori',
        'gambar',
        'ukuran',
        'warna',
        'jumlah',
        'harga',
        'deskripsi'
    ];
    public function updateJumlahAlat($id_alat, $jumlah_pengemb_alat)
    {
        return $this->set('jumlah', "jumlah + $jumlah_pengemb_alat", false)
                    ->where('id_alat', $id_alat)
                    ->update();
    }

    public function getAlat($id = false)
    {
        if ($id == false) {
            return $this->join('kategori', 'kategori.id_kategori = alat.id_kategori')
                ->findAll();
        }

        return $this->where(['id_alat' => $id])
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori')
            ->first();
    }

    public function getAlatAda()
    {
        return $this->join('kategori', 'kategori.id_kategori = alat.id_kategori')
            ->where(['jumlah >' => 0])
            ->findAll();
    }

    public function getAlatHabis()
    {
        return $this->join('kategori', 'kategori.id_kategori = alat.id_kategori')
            ->where(['jumlah =' => 0])
            ->findAll();
    }

    public function cekDuplikat($nama_alat, $id_kategori, $id_alat = null)
    {
        $this->where('nama_alat', $nama_alat)
            ->where('id_kategori', $id_kategori);

        if ($id_alat !== NULL) {
            $this->where('id_alat !=', $id_alat);
        }

        $result = $this->get()->getRow();
        return ($result !== null) ? true : false;
    }
}
