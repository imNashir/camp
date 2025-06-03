<?php

namespace App\Controllers;

use App\Models\AlatModel;
use App\Controllers\BaseController;
use App\Models\KategoriModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Hermawan\DataTables\DataTable;

class Alat extends BaseController
{
    protected $alatModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->alatModel = new AlatModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Plinplan | Alat',
            'judul' => 'Data Alat',
            'alat' => $this->alatModel->getAlat(),
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('alat/index', $data);
    }

    public function dataAlat()
    {
        $db = db_connect();
        $builder = $db->table('alat')
            ->select('id_alat, nama_alat, nama_kategori, ukuran, warna, jumlah')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori');

        return DataTable::of(builder: $builder)
            ->add('status', function ($row) {
                if ($row->jumlah == 0) {
                    return '<small class="badge badge-danger"> Habis</small>';
                } else {
                    return '<small class="badge badge-success"> Masih Ada</small>';
                }
            })
            ->add('action', function ($row) {
                return '
                <a class="btn btn-success btn-sm" href="' . base_url('alat/detail/' . $row->id_alat) . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-warning btn-sm" href="' . base_url('alat/edit/' . $row->id_alat) . '"><i class="fas fa-edit"></i></a>
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_alat . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }

    public function detailAlat($id)
    {
        $data = [
            'title' => 'Alat',
            'judul' => 'Detail Alat',
            'alat' => $this->alatModel->getAlat($id)
        ];

        if (empty($data['alat'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alat dengan id : ' . $id .  ' Tidak Ditemukan');
        }

        return view('alat/detail_alat', $data);
    }

    public function tambahAlat()
    {
        $data  = [
            'title' => 'Alat',
            'judul' => 'Form Tambah Alat',
            'kategori' => $this->kategoriModel->findAll(),
        ];
        // dd($data);
        return view('alat/tambah_alat', $data);
    }
    public function simpanAlat()
    {

        $nama_alat = esc($this->request->getVar('nama_alat'));
        $id_kategori = (int)$this->request->getVar('id_kategori');
        // dd($id_kategori);

        if ($this->alatModel->cekDuplikat($nama_alat, $id_kategori)) {
            return redirect()->back()->with('dupl', 'Alat dengan kategori yang sama sudah terdaftar.');
        }
        $validate = $this->validate([
            'nama_alat' => [
                'label' => 'Nama Alat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'id_kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'gambar' => [
                'label' => 'Gambar',
                'rules' => 'is_image[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar !!!',
                    'is_image' => 'File yang diupload bukan gambar !!!',
                    'mime_in' => 'File yang diupload harus berformat (JPG/JPEG/PNG)'
                ]
            ],
            'warna' => [
                'label' => 'Warna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'ukuran' => [
                'label' => 'Ukuran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
        ]);

        if ($validate) {
            $file_gambar = $this->request->getFile('gambar');
            if ($file_gambar->getError() == 4) {
                $nama_gambar = 'default_image.jpg';
            } else {
                if ($file_gambar->isValid()) {
                    $nama_gambar = $file_gambar->getRandomName();
                    $file_gambar->move('img_data', $nama_gambar);
                } else {
                    return redirect()->back()->with('errors', $this->validator->listErrors());
                }
            }
            $this->alatModel->insert([
                'nama_alat' => esc($this->request->getVar('nama_alat')),
                'id_kategori' => $id_kategori,
                'gambar' => $nama_gambar,
                'ukuran' => esc($this->request->getVar('ukuran')),
                'warna' => esc($this->request->getVar('warna')),
                'harga' => esc($this->request->getVar('harga')),
                'jumlah' => esc($this->request->getVar('jumlah')),
                'deskripsi' => esc($this->request->getVar('deskripsi')),
            ]);

            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
            return redirect()->to(base_url('alat'));
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->listErrors());
        }
    }

    public function hapusAlat($id)
    {
        $alat = $this->alatModel->getAlat($id);

        if ($alat['gambar'] != 'default_image.jpg') {
            unlink('img_data/' . $alat['gambar']);
        }

        $this->alatModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to(base_url('alat'));
    }

    public function editAlat($id)
    {
        $data = [
            'title' => 'Alat',
            'judul' => 'Form Ubah Alat',
            'alat' => $this->alatModel->getAlat($id),
            'kategori' => $this->kategoriModel->findAll(),
        ];
        return view('alat/edit_alat', $data);
    }

    public function updateAlat($id)
    {
        $validate = $this->validate([
            'nama_alat' => [
                'label' => 'Nama Alat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'id_kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'gambar' => [
                'label' => 'Gambar',
                'rules' => 'is_image[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar !!!',
                    'is_image' => 'File yang diupload bukan gambar !!!',
                    'mime_in' => 'File yang diupload harus berformat (JPG/JPEG/PNG)'
                ]
            ],
            'warna' => [
                'label' => 'Warna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'ukuran' => [
                'label' => 'Ukuran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
        ]);
        if ($validate) {
            $file_gambar = $this->request->getFile('gambar');
            if ($file_gambar->getError() == 4) {
                $nama_gambar = 'default_image.jpg';
            } else {
                $nama_gambar = $file_gambar->getRandomName();
                $file_gambar->move('img_data', $nama_gambar);
            }
            $this->alatModel->save([
                'id_alat' => $id,
                'nama_alat' => esc($this->request->getVar('nama_alat')),
                'id_kategori' => $this->request->getVar('id_kategori'),
                'gambar' => $nama_gambar,
                'ukuran' => esc($this->request->getVar('ukuran')),
                'warna' => esc($this->request->getVar('warna')),
                'jumlah' => esc($this->request->getVar('jumlah')),
                'harga' => esc($this->request->getVar('harga')),
                'deskripsi' => esc($this->request->getVar('deskripsi')),
            ]);
            session()->setFlashdata('pesan', 'Data Berhasil Diubah');
            return redirect()->to(base_url('alat'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function cetakAlatHabis()
    {
        $options = new Options();
        $options->set('enabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $data['habis'] =  $this->alatModel->getAlatHabis();
        if (!empty($data['habis'])) {
            $html = view('alat/rep-alat-habis', $data);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'potrait');
            $dompdf->render();
            $filename = 'alat-habis_' . date('YmdHis') . '.pdf';
            $dompdf->stream($filename);
        } else {
            return redirect()->back()->with('empty', 'Tidak ada alat habis');
        }
    }
}
