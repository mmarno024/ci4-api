<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\JWTAuth;
use CodeIgniter\Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $jwt = new JWTAuth();

        $token = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            if ($jwt->isTokenBlacklisted($token)) {
                return Services::response()
                    ->setJSON(['message' => 'Token has been invalidated'])
                    ->setStatusCode(401);
            }

            $decoded = $jwt->decode($token);

            $request->user = $decoded;

            return $request;
        } catch (\Exception $e) {
            return Services::response()
                ->setJSON(['message' => 'Invalid or expired token'])
                ->setStatusCode(401);
        }

        // $header = $request->getHeaderLine('Authorization');
        // if (empty($header)) {
        //     return service('response')->setJSON(['error' => 'Token is not found'])->setStatusCode(401);
        // }

        // try {
        //     $token = explode(' ', $header)[1];
        //     $decoded = $jwt->decode($token);
        //     $request->user = $decoded;
        //     return $request;
        // } catch (\Exception $e) {
        //     return service('response')->setJSON(['error' => 'Token is invalid'])->setStatusCode(401);
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
