<?php

namespace App\Controllers\Docente;

use CodeIgniter\RESTful\ResourceController;

class DocenteController extends ResourceController
{
    protected $modelName = 'App\Models\DocenteModel';
    protected $format    = 'json';

    // GET /docente
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // POST /docente
    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['password'])) {
            return $this->failValidationError('El campo password es requerido');
        }

        // MD5 en password
        $data['password'] = md5($data['password']);

        $this->model->insert($data);

        return $this->respondCreated([
            'message' => 'Docente creado correctamente',
            'id'      => $this->model->getInsertID()
        ]);
    }

    // GET /docente/{id}
    public function show($id = null)
    {
        $docente = $this->model->find($id);
        if (!$docente) return $this->failNotFound('Docente no encontrado');

        return $this->respond($docente);
    }

    // PUT /docente/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (isset($data['password'])) {
            $data['password'] = md5($data['password']);
        }

        $this->model->update($id, $data);

        return $this->respond([
            'message' => 'Docente actualizado'
        ]);
    }

    // DELETE /docente/{id}
    public function delete($id = null)
    {
        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Docente eliminado'
        ]);
    }
}
