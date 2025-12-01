<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');

        // CORS headers requeridos por navegadores modernos y Google AI Studio
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader(
            'Access-Control-Allow-Headers',
            'Origin, X-Requested-With, Content-Type, Accept, Authorization, X-HTTP-Method-Override'
        );
        $response->setHeader(
            'Access-Control-Allow-Methods',
            'GET, POST, PUT, DELETE, PATCH, OPTIONS'
        );

        // Opciones preflight
        if ($request->getMethod() === 'options') {
            return $response->setStatusCode(200);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Asegurar que SIEMPRE salgan estos headers en la respuesta final
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader(
            'Access-Control-Allow-Headers',
            'Origin, X-Requested-With, Content-Type, Accept, Authorization, X-HTTP-Method-Override'
        );
        $response->setHeader(
            'Access-Control-Allow-Methods',
            'GET, POST, PUT, DELETE, PATCH, OPTIONS'
        );

        return $response;
    }
}

