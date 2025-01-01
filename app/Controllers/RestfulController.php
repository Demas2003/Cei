<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class RestfulController extends ResourceController
{
    protected $format = 'json';

    /**
     * Method untuk membuat response hasil.
     *
     * @param int $code
     * @param string $status
     * @param mixed $data
     * @return \CodeIgniter\HTTP\Response
     */
    protected function responseHasil($code, $status, $data)
    {
        return $this->respond([
            'code' => $code,
            'status' => $status,
            'data' => $data,
        ]);
    }
}
