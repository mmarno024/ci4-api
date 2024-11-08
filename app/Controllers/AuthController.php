<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Libraries\JWTAuth;

class AuthController extends ResourceController
{
    protected $jwt;

    public function __construct()
    {
        $this->jwt = new JWTAuth();
    }

    public function login()
    {
        $userModel = new UserModel();
        $jwt = new JWTAuth();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Invalid credentials');
        }

        $payload = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        $token = $jwt->encode($payload);

        return $this->respond([
            'message' => 'Login successful',
            'token' => $token
        ]);
    }

    public function logout()
    {
        $token = $this->request->getHeaderLine('Authorization');

        $token = str_replace('Bearer ', '', $token);

        $this->jwt->invalidateToken($token);

        return $this->respond([
            'message' => 'Logout successful, token has been invalidated'
        ]);
    }
    // public function logout()
    // {
    //     $session = session();
    //     $session->destroy();
    //     return $this->respond([
    //         'message' => 'Logout successful, token has been invalidated'
    //     ]);
    // }
}
