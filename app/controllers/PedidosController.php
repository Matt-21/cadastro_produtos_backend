<?php

namespace app\controllers;

use app\models\Pedidos;
use app\models\Produtos;

class PedidosController extends Controller
{
    public function index(): void
    {
        $data = Pedidos::selectAll();
        if ($data) {
            $this->json($data, 200);
        }
    }

    public function store($request): void
    {
        $data = Pedidos::insert($request);
        if ($data) {
            $this->calcularEstoque($request);
            $this->json($data, 201);
        } else {
            $this->json($data, 409);
        }
    }

    public function delete($request): void
    {
        $query = Pedidos::delete($request);
        if ($query) {
            $this->json($query, 200);
        } else {
            $this->json($query, 422);
        }
    }

    public function calcularEstoque ($request): void
    {
        $query = Produtos::select($request->id_produto);
        if ($query) {
            $dado['qtd_estoque'] = $query->qtd_estoque - $request->qtd_vendida;
            $dado['id_produto'] = $request->id_produto;
           var_dump(Produtos::update((object)$dado)); die;
        }
    }
}