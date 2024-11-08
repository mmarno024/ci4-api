<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;

class ProductsController extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';

    public function index()
    {
        $user = $this->request->user;
        if ($user->role !== 'admin') {
            return $this->failForbidden('You do not have permission to access this menu.');
        }

        $products = $this->model->findAll();
        return $this->respond($products);
    }

    public function create()
    {
        $user = $this->request->user;
        if ($user->role !== 'admin') {
            return $this->failForbidden('You do not have permission to access this menu.');
        }

        $rules = [
            'product_name' => 'required|min_length[3]',
            'description'  => 'required',
            'price'        => 'required|decimal',
            'stock'        => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        try {
            $data = $this->request->getJSON(true);

            $model = new ProductModel();
            $model->insert($data);

            return $this->respondCreated(['message' => 'Product created successfully']);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError('Failed');
        }
    }

    public function show($id = null)
    {
        $user = $this->request->user;
        if ($user->role !== 'admin') {
            return $this->failForbidden('You do not have permission to access this menu.');
        }

        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $product
        ]);
    }

    public function update($id = null)
    {
        $user = $this->request->user;
        if ($user->role !== 'admin') {
            return $this->failForbidden('You do not have permission to access this menu.');
        }

        $product = $this->model->find($id);
        if (!$product) {
            return $this->failNotFound('Product not found');
        }
        $rules = [
            'product_name' => 'required|min_length[3]',
            'description'  => 'required',
            'price'        => 'required|decimal',
            'stock'        => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        try {
            $data = $this->request->getJSON(true);

            if ($this->model->update($id, $data)) {
                return $this->respond([
                    'status' => true,
                    'message' => 'Product updated successfully'
                ]);
            }

            return $this->fail('Failed to update product');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError('An error occurred while updating the product');
        }
    }

    public function delete($id = null)
    {
        $user = $this->request->user;
        if ($user->role !== 'admin') {
            return $this->failForbidden('You do not have permission to access this menu.');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Delete product ' . $id . ' successfully']);
        }
        return $this->failNotFound('Product not found');
    }
}
