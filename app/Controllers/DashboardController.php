<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class DashboardController extends ResourceController
{
    public function index()
    {
        $user = $this->request->user;

        if ($user->role !== 'user') {
            return $this->failForbidden('You do not have permission to access the dashboard.');
        }

        $data = [
            [
                'category' => 'Auth',
                'route' => 'POST /auth/login',
                'description' => 'Login dan dapatkan token JWT untuk autentikasi.',
                'access' => 'Semua'
            ],
            [
                'category' => 'Dashboard',
                'route' => 'GET /dashboard',
                'description' => 'Menampilkan halaman informasi umum (hanya untuk role user).',
                'access' => 'User'
            ],
            [
                'category' => 'Products',
                'route' => 'GET /products',
                'description' => 'Mendapatkan daftar produk (hanya untuk role admin).',
                'access' => 'Admin'
            ],
            [
                'category' => 'Products',
                'route' => 'POST /products',
                'description' => 'Menambahkan produk baru (hanya untuk role admin).',
                'access' => 'Admin'
            ],
            [
                'category' => 'Products',
                'route' => 'GET /products/{id}',
                'description' => 'Mendapatkan daftar produk berdasarkan ID (hanya untuk role admin).',
                'access' => 'Admin'
            ],
            [
                'category' => 'Products',
                'route' => 'PUT /products/{id}',
                'description' => 'Mengupdate data produk berdasarkan ID (hanya untuk role admin).',
                'access' => 'Admin'
            ],
            [
                'category' => 'Products',
                'route' => 'DELETE /products/{id}',
                'description' => 'Menghapus produk berdasarkan ID (hanya untuk role admin).',
                'access' => 'Admin'
            ]
        ];

        return $this->respond([
            'message' => 'Welcome to the Dashboard!',
            'Security' => [
                'JWT Authentication (JSON Web Token)' => 'Authorization',
                'Role Access Control User' => 'Endpoint Filtering',
                'Validation' => 'Validasi input pada setiap form',
                'HTTP Header' => 'meminimalisir serangan dari protocol HTTP',
                'ORM' => 'meminimalisir serangan Query'
            ],
            'description' => 'API ini menyediakan layanan CRUD untuk produk dan manajemen pengguna dengan peran khusus.',
            'access_roles' => [
                'admin' => 'Hanya dapat mengakses endpoint untuk mengelola produk (CRUD).',
                'user' => 'Hanya dapat mengakses halaman dashboard.',
            ],
            'Usage' => [
                'Authorization' => 'Gunakan header "Authorization: Bearer <token>" untuk autentikasi di semua endpoint.',
                'Note' => 'Hanya admin yang bisa mengakses endpoint produk.'
            ],
            'dataTable_serverSide' => $data,
            'draw' => intval($this->request->getVar('draw')),
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
        ]);
    }
}
