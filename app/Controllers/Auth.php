<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index() //untuk halaman login
    {
        return view('auth/form_login');
    }

    public function login() // Login process
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsername($username);

        $validationRules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ]
        ];

      if (!$this->validate($validationRules)) {
        return redirect()->back()->withInput()->with('pesan', 'Username dan Password tidak boleh kosong.');
    }

   
    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('username', $username)->first();


    if ($user && password_verify($password, $user['password'])) {
        session()->set('isLogin', true);
        session()->set('id_user', $user['id_user']);
        session()->set('username', $user['username']);
        session()->set('role', $user['role']);
        return redirect()->to(base_url('dashboard'));
    } else {
        session()->setFlashdata('pesan', 'Username atau Password salah.');
        return redirect()->to(base_url('/'))->withInput();
    }
}


    public function logout() //untuk proses logout
    {
        session()->remove('isLogin');
        session()->remove('id_user');
        session()->remove('nama_lengkap');
        session()->remove('username');
        session()->remove('password');
        session()->remove('role');

        return redirect()->to(base_url('/'))->with('pesan', 'Anda Telah Logout');
    }
}
