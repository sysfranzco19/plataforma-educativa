<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function createToken($data)
{
    $key = getenv('JWT_SECRET');
    $payload = [
        'iss' => 'plataforma-educativa',
        'aud' => 'usuarios',
        'iat' => time(),
        'exp' => time() + 86400, // 1 día
        'data' => $data
    ];

    return JWT::encode($payload, $key, 'HS256');
}

function validateToken($token)
{
    $key = getenv('JWT_SECRET');
    return JWT::decode($token, new Key($key, 'HS256'));
}
