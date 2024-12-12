<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CountModel;

class Dashboard extends BaseController
{
    protected $countModel;

    public function __construct()
    {
        $this->countModel = new CountModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard | Plinplan',
            'judul' => 'Dashboard',
            'countAlat' => $this->countModel->countAlat(),
            'countAlatAda' => $this->countModel->countAlatAda(),
            'countAlatHabis' => $this->countModel->countAlatHabis(),
            'countKategori' => $this->countModel->countKategori(),
            'countUser' => $this->countModel->countUser(),
            'countTransaksi' => $this->countModel->countTransAlat(),
            'countPengembalian' => $this->countModel->countPengembAlat()
        ];

        return view('dashboard/index', $data);
    }
}
