<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\DocenteModel;
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

        $email = $data['email'];
        $password = $data['password']; // NO MD5

        // =============================
        // 1. Buscar Admin
        // =============================
        $adminModel = new AdminModel();
        $admin = $adminModel->where('email', $email)->first();

        if ($admin && password_verify($password, $admin['password'])) {

            $token = createToken([
                'id'      => $admin['id'],
                'email'   => $admin['email'],
                'nombre'  => $admin['nombre'],
                'apellido'=> $admin['apellido'],
                'role'    => 'admin'
            ]);

            return $this->respond([
                'message' => 'Login correcto (Admin)',
                'role'    => 'admin',
                'token'   => $token
            ]);
        }

        // =============================
        // 2. Buscar Docente
        // =============================
        $docenteModel = new DocenteModel();
        $docente = $docenteModel->where('email', $email)->first();

        if ($docente && password_verify($password, $docente['password'])) {

            $token = createToken([
                'id'      => $docente['id'],
                'email'   => $docente['email'],
                'nombre'  => $docente['nombre'],
                'apellido'=> $docente['apellido'],
                'role'    => 'docente'
            ]);

            return $this->respond([
                'message' => 'Login correcto (Docente)',
                'role'    => 'docente',
                'token'   => $token
            ]);
        }

        // ======================================
        // No coincide con Admin ni Docente
        // ======================================
        return $this->failUnauthorized('Credenciales inválidas');
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
