<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    protected $format = 'json';

    // POST /auth/login
    public function login()
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->failValidationError('Email y password son requeridos');
        }

        $model = new AdminModel();

        // Buscar admin por email
        $admin = $model->where('email', $data['email'])->first();

        if (!$admin) {
            return $this->failNotFound('Administrador no encontrado');
        }

        // Comparar password md5
        if ($admin['password'] !== md5($data['password'])) {
            return $this->failUnauthorized('Password incorrecto');
        }

        // Crear token
        $token = createToken([
            'id'      => $admin['id'],
            'email'   => $admin['email'],
            'nombre'  => $admin['nombre'],
            'apellido'=> $admin['apellido'],
            'role'    => 'admin'
        ]);

        return $this->respond([
            'message' => 'Login correcto',
            'token'   => $token
        ]);
    }


    // GET /auth/verify
    public function verify()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');

        if (!$authHeader) {
            return $this->failUnauthorized('Token no enviado');
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $decoded = validateToken($token);
            return $this->respond([
                'valid' => true,
                'data'  => $decoded
            ]);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token inválido: ' . $e->getMessage());
        }
    }
}
