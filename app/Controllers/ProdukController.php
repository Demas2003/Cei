<?php

namespace App\Controllers;

use App\Models\MProduk;
use CodeIgniter\RESTful\ResourceController;

class ProdukController extends ResourceController
{
    protected $format = 'json';

    public function create()
    {
        $data = [
            'kode_produk' => $this->request->getVar('kode_produk'),
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga' => $this->request->getVar('harga'),
        ];

        // Validasi input
        if (!$data['kode_produk'] || !$data['nama_produk'] || !$data['harga']) {
            return $this->fail('Semua data wajib diisi.', 400);
        }

        $model = new MProduk();

        try {
            $model->insert($data);
            $produk = $model->find($model->getInsertID());
            return $this->respond([
                'status' => true,
                'message' => 'Produk berhasil ditambahkan.',
                'data' => $produk
            ], 201);
        } catch (\Exception $e) {
            return $this->fail('Gagal menyimpan data: ' . $e->getMessage(), 500);
        }
    }

    public function list()
    {
        $model = new MProduk();
        $produk = $model->findAll();
        return $this->respond([
            'status' => true,
            'data' => $produk
        ], 200);
    }

    public function detail($id)
    {
        $model = new MProduk();
        $produk = $model->find($id);

        if (!$produk) {
            return $this->failNotFound('Produk tidak ditemukan.');
        }

        return $this->respond([
            'status' => true,
            'data' => $produk
        ], 200);
    }

    public function ubah($id)
    {
        $data = [
            'kode_produk' => $this->request->getVar('kode_produk'),
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga' => $this->request->getVar('harga'),
        ];

        // Validasi input
        if (!$data['kode_produk'] || !$data['nama_produk'] || !$data['harga']) {
            return $this->fail('Semua data wajib diisi.', 400);
        }

        $model = new MProduk();

        try {
            $model->update($id, $data);
            $produk = $model->find($id);
            return $this->respond([
                'status' => true,
                'message' => 'Produk berhasil diubah.',
                'data' => $produk
            ], 200);
        } catch (\Exception $e) {
            return $this->fail('Gagal mengubah data: ' . $e->getMessage(), 500);
        }
    }

    public function hapus($id)
    {
        $model = new MProduk();
        $produk = $model->find($id);

        if (!$produk) {
            return $this->failNotFound('Produk tidak ditemukan.');
        }

        try {
            $model->delete($id);
            return $this->respond([
                'status' => true,
                'message' => 'Produk berhasil dihapus.'
            ], 200);
        } catch (\Exception $e) {
            return $this->fail('Gagal menghapus data: ' . $e->getMessage(), 500);
        }
    }
}
