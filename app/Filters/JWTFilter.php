<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class JWTFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader || !str_contains($authHeader, 'Bearer ')) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON(['message' => 'Token no enviado']);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            // 🔥 Decodifica token con tu helper
            $decoded = validateToken($token);

            // 🔥 Añadimos los datos del usuario (role, id, email) a la request
            // Esto permite hacer:  $request->user  en los controladores
            $request->user = $decoded->data;

        } catch (\Throwable $e) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON(['message' => 'Token inválido', 'error' => $e->getMessage()]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}
