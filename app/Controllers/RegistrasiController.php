<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MRegistrasi;

class RegistrasiController extends ResourceController
{
    protected $format = 'json';

    public function registrasi()
    {
        // Debug: Cek apakah data diterima
        log_message('debug', 'Input Data: ' . json_encode($this->request->getPost()));
    
        $data = [
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];
    
        if (!$data['nama'] || !$data['email'] || !$data['password']) {
            return $this->respond(['status' => false, 'message' => 'Data tidak lengkap'], 400);
        }
    
        $model = new MRegistrasi();
        try {
            $model->insert($data);
            return $this->respond(['status' => true, 'message' => 'Registrasi berhasil'], 200);
        } catch (\Exception $e) {
            return $this->respond(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
}
