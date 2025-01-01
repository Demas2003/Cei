<?php

namespace App\Models;

use CodeIgniter\Model;

class MLogin extends Model
{
    // Nama tabel yang digunakan oleh model
    protected $table = 'member_token';

    // Daftar kolom yang diizinkan untuk diisi secara massal
    protected $allowedFields = ['member_id', 'auth_key'];
}
