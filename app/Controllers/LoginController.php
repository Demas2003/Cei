<?php

namespace App\Controllers;

use App\Models\MLogin;
use App\Models\MMember;

class LoginController extends RestfulController
{
    /**
     * Fungsi untuk login
     */
    public function login()
    {
        // Mengambil input email dan password
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Mencari member berdasarkan email
        $model = new MMember();
        $member = $model->where(['email' => $email])->first();

        // Validasi apakah email ditemukan
        if (!$member) {
            return $this->responseHasil(400, false, "Email tidak ditemukan");
        }

        // Validasi password
        if (!password_verify($password, $member['password'])) {
            return $this->responseHasil(400, false, "Password tidak valid");
        }

        // Membuat auth_key untuk token login
        $login = new MLogin();
        $auth_key = $this->RandomString();
        $login->save([
            'member_id' => $member['id'],
            'auth_key' => $auth_key
        ]);

        // Data response jika login berhasil
        $data = [
            'token' => $auth_key,
            'user' => [
                'id' => $member['id'],
                'email' => $member['email'],
            ],
        ];

        return $this->responseHasil(200, true, $data);
    }

    /**
     * Fungsi untuk menghasilkan string acak
     * 
     * @param int $length Panjang string yang dihasilkan
     * @return string
     */
    private function RandomString($length = 100)
    {
        $karakter = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $panjang_karakter = strlen($karakter);
        $str = '';

        // Loop untuk menghasilkan string acak
        for ($i = 0; $i < $length; $i++) {
            $str .= $karakter[rand(0, $panjang_karakter - 1)];
        }

        return $str;
    }
}
