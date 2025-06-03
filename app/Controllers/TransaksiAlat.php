<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransaksiAlatModel;
use App\Models\PengembalianAlatModel;
use App\Models\AlatModel;
use Dompdf\Dompdf;
use Hermawan\DataTables\DataTable;

class TransaksiAlat extends BaseController
{
    protected $transaksiAlatModel;
    protected $alatModel;

    public function __construct()
    {
        $this->transaksiAlatModel = new TransaksiAlatModel();
        $this->alatModel = new AlatModel();
    }

    public function update($id_trans_alat)
    {
        $pengembalianAlatModel = new PengembalianAlatModel();
        $alatModel = new AlatModel();

        // Ambil data dari request
        $id_alat = $this->request->getPost('id_alat');
        $jumlah_pengemb_alat = $this->request->getPost('jumlah_pengemb_alat');
        $disimpan_oleh = $this->request->getPost('disimpan_oleh');
        $tgl_pengemb_alat = $this->request->getPost('tgl_pengemb_alat');
        $id_trans_alat = $this->request->getPost('id_trans_alat');
        $total_harga = $this->request->getPost('total_harga');

        $total = 0;
        $query = $this->transaksiAlatModel->where('id_alat', $id_alat)->findAll();
        foreach ($query as $row) {
            $total += $row['jumlah_trans_alat'];
        }
        $dataPengembalian = [
            'id_alat' => $id_alat,
            'jumlah_pengemb_alat' => $jumlah_pengemb_alat,
            'disimpan_oleh' => $disimpan_oleh,
            'tgl_pengemb_alat' => $tgl_pengemb_alat,
            'total_harga' => $total_harga,
            'id_trans_alat' => $id_trans_alat
        ];
        // Menambah data ke tabel pengembalian
        if ($jumlah_pengemb_alat > $total) {
            return redirect()->back()->with('error', 'Jumlah pengembalian alat tidak boleh lebih besar dari total alat');
        }

        // Menambah data ke tabel pengembalian
        if (!$pengembalianAlatModel->tambahPengembalian($dataPengembalian)) {
            return redirect()->back()->with('error', 'Gagal menambah data pengembalian');
        }

        // Mengupdate jumlah alat di tabel alat
        if (!$alatModel->updateJumlahAlat($id_alat, $jumlah_pengemb_alat)) {
            return redirect()->back()->with('error', 'Gagal memperbarui jumlah alat');
        }

        // Mengurangi jumlah transaksi alat di tabel transaksi
        if (!$this->transaksiAlatModel->kurangiJumlahTransAlat($id_trans_alat, $jumlah_pengemb_alat)) {
            return redirect()->back()->with('error', 'Gagal memperbarui jumlah transaksi alat');
        }

        // Redirect atau tampilkan pesan sukses
        return redirect()->to('/transaksi')->with('message', 'Data berhasil diupdate');
    }

    //admin index
    public function index()
    {
        $data = [
            'title' => 'Plinplan | Transaksi',
            'judul' => 'Data Transaksi',
            'transaksi' => $this->transaksiAlatModel->getTransAlat(),
            'username' => session()->get('username')
        ];

        return view('transaksi/admin_index', $data);
    }

    //pelanggan index
    public function indexs()
    {
        $data = [
            'title' => 'Plinplan | Transaksi',
            'judul' => 'Data Transaksi',
            'transaksi' => $this->transaksiAlatModel->getTransAlat()
        ];

        return view('transaksi/pelanggan_index', $data);
    }

    //server side untuk tampil data role admin
    public function dataTransAlat_adm()
    {
        $db = db_connect();
        $builder = $db->table('transaksi')
            ->select('id_trans_alat, tgl_trans_alat, nama_barang, nama_kategori, jumlah_trans_alat, harga_satuan, total_harga, nama, disimpan_oleh')
            ->join('alat', 'alat.id_alat = transaksi.id_alat')
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori');

        return DataTable::of($builder)
            ->add('tgl_trans_alat', function ($row) {
                return date('d/m/Y', strtotime($row->tgl_trans_alat));
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
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_trans_alat . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }

    //server side untuk tampil data role pelanggan
    public function dataTransAlat_plg()
    {
        $db = db_connect();
        $builder = $db->table('transaksi')
            ->select('id_trans_alat, tgl_trans_alat, nama_alat, nama_kategori, jumlah_trans_alat, harga_satuan, total_harga, nama')
            ->join('alat', 'alat.id_alat = transaksi.id_alat')
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori');

        return DataTable::of($builder)
            ->add('tgl_trans_alat', function ($row) {
                return date('d/m/Y', strtotime($row->tgl_trans_alat));
            })
            ->add('harga_satuan', function ($row) {
                return 'Rp. ' . number_format($row->harga_satuan, 0, ',', '.');
            })
            ->add('total_harga', function ($row) {
                return 'Rp. ' . number_format($row->total_harga, 0, ',', '.');
            })
            ->add('action', function ($row) {
                return '
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_trans_alat . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }

    public function tambahTransAlat()
    {
        $data = [
            'title' => 'Plinplan | Transaksi',
            'judul' => 'Form Tambah Transaksi',
            'alat' => $this->alatModel->getAlat(),
        ];

        return view('transaksi/tambah_trans_alat', $data);
    }

    public function simpanTransAlat()
    {
        $validate = $this->validate([
            'id_alat' => [
                'label' => 'Nama Alat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'jumlah_trans_alat' => [
                'label' => 'Jumlah Transaksi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'tgl_trans_alat' => [
                'label' => 'Tanggal Transaksi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
        ]);

        if ($validate) {
            $alat = $this->alatModel->find($this->request->getVar('id_alat'));

            if ($alat) {
                $jumlahTransaksi = $this->request->getVar('jumlah_trans_alat');
                $stokBaru = $alat['jumlah'] - $jumlahTransaksi;

                if ($alat['jumlah'] < $jumlahTransaksi) {
                    session()->setFlashdata('errors', 'Jumlah transaksi melebihi stok yang tersedia');
                    return redirect()->back();
                }

                $harga_satuan_str = $this->request->getVar('harga_satuan');
                $total_harga_str = $this->request->getVar('total_harga');

                $harga_satuan = (int) str_replace('.', '', $harga_satuan_str);
                $total_harga = (int) str_replace('.', '', $total_harga_str);

                $this->alatModel->where('id_alat', $this->request->getVar('id_alat'))->set(['jumlah' => $stokBaru])->update();

                $this->transaksiAlatModel->insert([
                    'id_alat' => $this->request->getVar('id_alat'),
                    'jumlah_trans_alat' => $jumlahTransaksi,
                    'total_harga' => $total_harga,
                    'tgl_est' => $this->request->getVar('tgl_est'),
                    'status' => $this->request->getVar('status'),
                    'tgl_trans_alat' => $this->request->getVar('tgl_trans_alat'),
                    'disimpan_oleh' => $this->request->getVar('disimpan_oleh')
                ]);

                session()->setFlashdata('pesan', 'Data Berhasil Ditambah');
                return redirect()->to(base_url('transaksi'));
            }
        } else {
            return redirect()->back()
                ->with('errors', $this->validator->listErrors())
                ->withInput();
        }
    }

    public function hapusTransAlat($id)
    {
        $this->transaksiAlatModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to(base_url('transaksi'));
    }

    public function update_status($id)
    {
        $status = $this->request->getPost('status');
        $data = [
            'status' => $status,
        ];

        $this->transaksiAlatModel->update($id, $data);

        return redirect()->to(base_url('transaksi'))->with('pesan', 'Status berhasil diupdate.');
    }

    public function repTrans()
    {
        $data = [
            'title' => 'Plinplan | Transaksi',
            'judul' => 'Laporan Transaksi'
        ];

        return view('transaksi/rep-transaksi', $data);
    }

    public function filter()
    {
        $dompdf = new Dompdf();

        $tglawal = $this->request->getVar('tgl_awal');
        $tglakhir = $this->request->getVar('tgl_akhir');

        $data = [
            'tgl_awal' => $tglawal,
            'tgl_akhir' => $tglakhir,
            'result' => $this->transaksiAlatModel->filter($tglawal, $tglakhir)
        ];
        if (!empty($data['result'])) {
            $html = view('transaksi/filtered-data', $data);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $filename = 'transaksi' . date('YmdHis') . '.pdf';
            $dompdf->stream($filename, ['Attachment' => 0]); // Display in the browser
        } else {
            return redirect()->to(base_url('transaksi/rep-transaksi'))
                ->with('error', 'Tidak ada data yang terfilter');
        }
    }
}
