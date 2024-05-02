<?php

namespace app\controllers;

use app\models\TipoProdutos;

class TipoProdutoController extends Controller
{
    public function index($request): void
    {
      if (empty($request->id)) {
         $this->getAll();
      } else {
         $this->getById($request->id);
      }
    }

    public function getById(int $id): void
    {
        $query = TipoProdutos::select($id);
        if (!empty($query)) {
            $this->json($query, 200);
        } else {
            $this->json($query, 404);
        }
    }

    public function getAll(): void
    {
        $query = TipoProdutos::selectAll();
        if (!empty($query)) {
            $this->json($query, 200);
        } else {
            $this->json($query, 404);
        }
    }

    public function store($request): void
    {
        $query = TipoProdutos::like($request->tipo_produto);
        if (!$query) {
            $data = TipoProdutos::insert($request);
            $this->json($data, 201);
        }
        $this->json($query, 409);
    }

    public function update($request): void
    {
        $query = TipoProdutos::update($request);
        if ($query) {
           $this->json($query, 200);
        } else {
           $this->json($query, 422);
        }
    }

    public function delete($request): void
    {
        $query = TipoProdutos::delete($request);
        if ($query) {
           $this->json($query, 200);
        } else {
            $this->json($query, 422);
        }
    }
}