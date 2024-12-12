<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Hermawan\DataTables\DataTable;

class User extends BaseController
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Footwears | User',
            'judul' => 'Data User',
            'user' => $this->userModel->findAll()
        ];

        return view('user/index', $data);
    }

    public function dataUser()
    {
        $db = db_connect();
        $builder = $db->table('users')->select('id_user, nama_lengkap, username, role');

        return DataTable::of($builder)
            ->add('action', function ($row) {
                return '
            <a class="btn btn-warning btn-sm" href="' . base_url('user/edit/' . $row->id_user) . '"><i class="fas fa-edit"></i></a>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_user . '">
                <i class="fas fa-trash"></i> 
            </button>';
            })
            ->addNumbering('no')
            ->toJson(true);
    }

    public function tambahUser()
    {
        $data = [
            'title' => 'Plinplan | User',
            'judul' => 'Form Tambah User'
        ];

        return view('user/tambah_user', $data);
    }

    public function simpanUser()
    {

        if ($this->validate([
            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|is_unique[users.nama_lengkap]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'is_unique' => '{field} Sudah Terdaftar.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s])[\w\d\W]{8,}$/]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'min_length' => 'Password harus memuat minimal 8 karakter.',
                    'regex_match' => 'Password harus berisi minimal satu angka, satu huruf besar, satu huruf kecil, dan satu karakter khusus'
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ]
        ])) {
            $password = esc($this->request->getVar('password'));
            $password = password_hash("$password", PASSWORD_BCRYPT);

            $data = [
                'nama_lengkap' => esc($this->request->getPost('nama_lengkap')),
                'username' => esc($this->request->getPost('username')),
                'password' => $password,
                'role' => esc($this->request->getPost('role'))
            ];

            $this->userModel->insert($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
            return redirect()->to(base_url('user'));
        } else {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function editUser($id)
    {
        $data = [
            'title' => 'Plinplan | User',
            'judul' => 'Form Ubah User',
            'usr' => $this->userModel->getUser($id)
        ];

        return view('user/edit_user', $data);
    }

    public function updateUser($id)
    {
        $validate = $this->validate([
            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'is_unique' => '{field} Sudah Terdaftar.'
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ]
        ]);

        if ($validate) {
            $data = [
                'id_user' => $id,
                'nama_lengkap' => esc($this->request->getPost('nama_lengkap')),
                'username' => esc($this->request->getPost('username')),
                'role' => esc($this->request->getPost('role'))
            ];
            $this->userModel->save($data);
            return redirect()->to(base_url('user'))->with('pesan', 'Data Berhasil Diubah');
        } else {
            return redirect()->back()->with('errors', $this->validator->listErrors());
        }
    }

    public function hapusUser($id)
    {
        $this->userModel->delete($id);
        return redirect()->back()->with('pesan', 'Data Berhasil Dihapus');
    }

    public function ubahPassword()
    {
        $data = [
            'title' => 'Plinplan',
            'judul' => 'Ubah Password'
        ];

        return view('user/ubah_password', $data);
    }

    public function updatePassword()
    {
        $id = session()->get('id_user');

        $validate = $this->validate([
            'password_lama' => [
                'label' => 'Password Lama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                ]
            ],
            'password_baru' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s])[\w\d\W]{8,}$/]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'min_length' => '{field} minimal 8 karakter.',
                    'regex_match' => '{field} mengandung huruf besar, huruf kecil, angka, dan karakter khusus '
                ]
            ],
            're_password' => [
                'label' => 'Konfirmasi Password Baru',
                'rules' => 'required|matches[password_baru]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'matches' => 'Konfirmasi password tidak sesuai dengan password baru.',
                ]
            ]
        ]);
        if ($validate) {
            $currentPassword = esc($this->request->getPost('password_lama'));
            $newPassword = esc($this->request->getPost('password_baru'));

            $users = $this->userModel->getUserByid($id);

            if ($users && $currentPassword) {
                $hashedPassword = password_hash("$newPassword", PASSWORD_DEFAULT);

                // Update password dalam database
                $this->userModel->updatePassword($id, $hashedPassword);
                return redirect()->back()->with('pesan', 'Password berhasil diperbarui.');
            } else {
                return redirect()->back()->with('passlama', 'Password lama salah.')->withInput();
            }
        } else {
            return redirect()->back()->with('error', $this->validator->listErrors())->withInput();
        }
    }
}
