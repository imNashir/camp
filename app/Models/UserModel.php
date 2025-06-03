<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = [
        'nama_lengkap',
        'username',
        'password',
        'role'
    ];


    public function getUser($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id_user' => $id])->first();
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getUserByid($id)
    {
        return $this->where('id_user', $id)->first();
    }

    public function updatePassword($id, $npass)
    {
        return $this->where('id_user', $id)
            ->set('password', $npass)
            ->update();
    }
}
