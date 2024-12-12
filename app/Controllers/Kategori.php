<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use \Hermawan\DataTables\DataTable;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data  = [
            'title' => 'Plinplan | Kategori',
            'judul' => 'Data Kategori',
            'kategori' => $this->kategoriModel->findAll(),
        ];

        return view('kategori/index', $data);
    }

    public function dataKategori()
    {
        $db = db_connect();
        $builder = $db->table('kategori')->select('id_kategori, nama_kategori');

        return DataTable::of($builder)
            ->add('action', function ($row) {
                return '<a class="btn btn-warning btn-sm" href="' . base_url('kategori/edit/' . $row->id_kategori) . '"><i class="fas fa-edit"></i></a>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_kategori . '">
                <i class="fas fa-trash"></i>
            </button>';
            })
            ->addNumbering('no')
            ->toJson(true);
    }

    public function tambahKategori()
    {
        $data  = [
            'title' => 'Kategori',
            'judul' => 'Form Tambah Kategori',
        ];

        return view('kategori/tambah_kategori', $data);
    }

    public function simpanKategori()
    {
        $validate = $this->validate([
            'nama_kategori' => [
                'label' => 'Nama Kategori',
                'rules' => 'required|is_unique[kategori.nama_kategori]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'is_unique' => 'Data sudah ada !!!'
                ]
            ]
        ]);
        if ($validate) {
            $this->kategoriModel->insert([
                'nama_kategori' => esc($this->request->getVar('nama_kategori'))
            ]);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
            return redirect()->to(base_url('kategori'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function editKategori($id)
    {
        $data  = [
            'title' => 'Kategori',
            'judul' => 'Form Ubah Kategori',
            'kategori' => $this->kategoriModel->getKategori($id),
        ];

        return view('kategori/edit_kategori', $data);
    }

    public function updateKategori($id)
    {
        $validate = $this->validate([
            'nama_kategori' => [
                'label' => 'Nama Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ]
        ]);
        if ($validate) {
            $this->kategoriModel->save([
                'id_kategori' => $id,
                'nama_kategori' => esc($this->request->getVar('nama_kategori'))
            ]);
            session()->setFlashdata('pesan', 'Data Berhasil Diubah');
            return redirect()->to(base_url('kategori'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function hapusKategori($id)
    {
        $this->kategoriModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to('kategori');
    }
}
