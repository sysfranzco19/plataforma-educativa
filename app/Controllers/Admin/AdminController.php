<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourceController;

class AdminController extends ResourceController
{
    protected $modelName = 'App\Models\AdminModel';
    protected $format    = 'json';

    // GET /admin
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // POST /admin
    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['password'])) {
            return $this->failValidationError('El campo password es requerido');
        }

        // MD5 como en tu estructura
        $data['password'] = md5($data['password']);

        $this->model->insert($data);

        return $this->respondCreated([
            'message' => 'Admin creado correctamente',
            'id'      => $this->model->getInsertID()
        ]);
    }

    // GET /admin/{id}
    public function show($id = null)
    {
        $admin = $this->model->find($id);
        if (!$admin) return $this->failNotFound('No encontrado');

        return $this->respond($admin);
    }

    // PUT /admin/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (isset($data['password'])) {
            $data['password'] = md5($data['password']);
        }

        $this->model->update($id, $data);

        return $this->respond([
            'message' => 'Admin actualizado'
        ]);
    }

    // DELETE /admin/{id}
    public function delete($id = null)
    {
        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Admin eliminado'
        ]);
    }
}
