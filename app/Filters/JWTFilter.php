<?php

namespace App\Filters;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class JWTFilter implements FilterInterface
{
    public function before($request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON(['message' => 'Token no enviado']);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            validateToken($token);  // Usa tu helper
        } catch (\Exception $e) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON(['message' => 'Token inválido: ' . $e->getMessage()]);
        }
    }

    public function after($request, $response, $arguments = null)
    {
        return $response;
    }
}
