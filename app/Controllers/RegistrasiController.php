<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MRegistrasi;

class RegistrasiController extends ResourceController
{
    protected $format = 'json';

    public function registrasi()
    {
        // Ambil data input dari request
        $data = [
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
        ];

        // Validasi input
        if (!$data['nama'] || !$data['email'] || !$data['password']) {
            return $this->respond([
                'status' => false,
                'message' => 'Nama, email, dan password wajib diisi.'
            ], 400);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->respond([
                'status' => false,
                'message' => 'Format email tidak valid.'
            ], 400);
        }

        // Hash password sebelum disimpan
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $model = new MRegistrasi();

        try {
            // Simpan data ke database
            if ($model->insert($data)) {
                return $this->respond([
                    'status' => true,
                    'message' => 'Registrasi berhasil.'
                ], 201);
            } else {
                // Jika gagal menyimpan ke database
                return $this->respond([
                    'status' => false,
                    'message' => 'Gagal menyimpan data ke database.'
                ], 500);
            }
        } catch (\Exception $e) {
            // Tangkap error lainnya
            return $this->respond([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
