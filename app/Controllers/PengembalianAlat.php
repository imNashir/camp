<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\AlatModel;
use Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use App\Models\PengembalianAlatModel;


class PengembalianAlat extends BaseController
{
    protected $pengembalian;
    protected $alatModel;

    public function __construct()
    {
        $this->pengembalian = new PengembalianAlatModel();
        $this->alatModel = new AlatModel();
    }

    //index admin
    public function index()
    {
        $data = [
            'title' => 'Plinplan | Pengembalian',
            'judul' => 'Data Pengembalian',
            'pengembalian' => $this->pengembalian->getPengembAlat()
        ];

        return view('pengembalian/admin_index', $data);
    }

    //index pelanggan
    public function indexs()
    {
        $data = [
            'title' => 'Plinplan | Pengembalian',
            'judul' => 'Data Pengembalian',
            'pengembalian' => $this->pengembalian->getPengembAlat()
        ];

        return view('pengembalian/pelanggan_index', $data);
    }

    //server side untuk tampil data role admin
    public function dataPengembAlat_adm()
    {
        $db = db_connect();
        $builder = $db->table('pengembalian')
            ->select('id_pengemb_alat,  , nama_alat, nama_kategori, jumlah_pengemb_alat, harga_satuan, total_harga, disimpan_oleh')
            ->join('alat', 'alat.id_alat = pengembalian.id_pengemb_alat')
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori');
        return DataTable::of($builder)
            ->add('tgl_pengemb_alat', function ($row) {
                return date('d/m/Y', strtotime($row->tgl_pengemb_alat));
            })
            ->add('harga_satuan', function ($row) {
                return 'Rp. ' . number_format($row->harga_satuan, 0, ',', '.');
            })
            ->add('total_harga', function ($row) {
                return 'Rp. ' . number_format($row->total_harga, 0, ',', '.');
            })
            ->add('disimpan_oleh', function ($row) {
                return '<small class="badge badge-danger">' . esc($row->disimpan_oleh) . '</small>';
            })
            ->add('action', function ($row) {
                return '
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_pengemb_alat . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }

    //server side untuk tampil data role pelanggan
    public function dataPengembAlat_plg()
    {
        $db = db_connect();
        $builder = $db->table('pengembalian')
            ->select('id_pengemb_alat, tgl_pengemb_alat, nama_pengemb_alat, nama_kategori, jumlah_pengemb_alat, harga_satuan, total_harga')
            ->join('alat', 'alat.id_alat = pengembalian.id_alat')
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori');

        return DataTable::of($builder)
            ->add('tgl_pengemb_alat', function ($row) {
                return date('d/m/Y', strtotime($row->tgl_pengemb_alat));
            })

            ->add('harga_satuan', function ($row) {
                return 'Rp. ' . number_format($row->harga_satuan, 0, ',', '.');
            })

            ->add('total_harga', function ($row) {
                return 'Rp. ' . number_format($row->total_harga, 0, ',', '.');
            })

            ->add('action', function ($row) {
                return '
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_pengemb_alat . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }


    public function tambahPengembAlat()
    {
        $data = [
            'title' => 'Plinplan| Pengembalian',
            'judul' => 'Form Tambah Pengembalian',
            'alat' => $this->alatModel->getAlatAda()
        ];

        return view('pengembalian/tambah_pengemb_alat', $data);
    }

    public function simpanPengembAlat()
    {
        // dd($this->request);
        // dd($this->request->getVar('disimpanOleh'));
        $validate = $this->validate([
            'id_alat' => [
                'label' => 'Nama Alat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'jumlah_pengemb_alat' => [
                'label' => 'Jumlah Transaksi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'harga_satuan' => [
                'label' => 'Harga Satuan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],

            'tgl_pengemb_alat' => [
                'label' => 'Tanggal Pengembalian',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
        ]);

        if ($validate) {
            $alat = $this->alatModel->find($this->request->getVar('id_alat'));
            if ($alat) {
                $jumlahPengembalian = $this->request->getVar('jumlah_pengemb_alat');

                $stokBaru = $alat['jumlah'] + $jumlahPengembalian;
                $this->alatModel->update($this->request->getVar('id_alat'), ['jumlah' => $stokBaru]);
                $this->pengembalian->insert([
                    'id_alat' => $this->request->getVar('id_alat'),
                    'jumlah_pengemb_alat' => $jumlahPengembalian,
                    'harga_satuan' => $this->request->getVar('harga_satuan'),
                    'total_harga' => $this->request->getVar('total_harga'),
                    'tgl_pengemb_alat' => $this->request->getVar('tgl_pengemb_alat'),
                    'disimpan_oleh' => $this->request->getVar('disimpanOleh')
                ]);

                session()->setFlashdata('pesan', 'Data Berhasil Ditambah');
                return redirect()->to(base_url('pengembalian'));
            }
        } else {
            return redirect()->back()->with('errors', $this->validator->listErrors());
        }
    }

    public function hapusPengembAlat($id)
    {
        $this->pengembalian->delete($id);
        return redirect()->to(base_url('pengembalian'))
            ->with('pesan', 'Data berhasil dihapus');
    }

    public function repPengemb()
    {
        $data = [
            'title' => 'Plinplan | Pengembalian',
            'judul' => 'Laporan Pengembalian'
        ];

        return view('pengembalian/rep-pengembalian', $data);
    }

    public function filterData()
    {
        $dompdf = new Dompdf();
        $tglawal = $this->request->getVar('tgl_awal');
        $tglakhir = $this->request->getVar('tgl_akhir');

        $data =  [
            'tgl_awal' => $tglawal,
            'tgl_akhir' => $tglakhir,
            'result' => $this->pengembalian->filter($tglawal, $tglakhir)
        ];

        if (!empty($data['result'])) {
            $html = view('pengembalian/filtered-data', $data);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $filename = 'pengembalian' . date('YmdHis') . '.pdf';
            $dompdf->stream($filename, ['Attachment' => 0]);
            exit();
        } else {
            return redirect()->to(base_url('pengembalian/rep-pengembalian'))
                ->with('error', 'Tidak ada data yang terfilter');
        }
    }
}
