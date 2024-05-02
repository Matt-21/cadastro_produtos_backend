<?php

namespace app\controllers;

use app\config\Storage;
use app\models\Produtos;
use app\models\TipoProdutos;

class ProdutosController extends Controller
{
   public function index (): void
   {
       $query = Produtos::selectAll();
       if ($query) {
         $this->json($query, 200);
       }
   }

   public function store ($request): void
   {
       $query = Produtos::like($request->nome);
       if (!$query) {
           $this->calcular_valores($request, $request->id_tipo_produto);
           $request->image = Storage::Disk($request->files);
           $data = Produtos::insert($request);
           $this->json($data, 201);
       } else {
           $this->json($query, 409);
       }
   }

    public function update ($request): void
    {;
        $query = Produtos::update($request);
        if ($query) {
            $this->json($query, 200);
        } else {
            $this->json($query, 422);
        }
    }

   public function calcular_valores($request, $id_tipo_produto) {
       $tipo_produto = TipoProdutos::select($id_tipo_produto);
       $request->valor_imposto = (float) $tipo_produto['valor_imposto'] * (float) $request->valor / 100;
       $request->valor_total = $request->valor_imposto + (float) $request->valor;
       return $request;
   }
}