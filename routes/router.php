<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');

function load(string $controller, string $action)
{
    try {
        // se controller existe
        $controllerNamespace = "app\\controllers\\{$controller}";

        if (!class_exists($controllerNamespace)) {
            throw new Exception("O controller {$controller} não existe");
        }

        $controllerInstance = new $controllerNamespace();

        if (!method_exists($controllerInstance, $action)) {
            throw new Exception(
                "O método {$action} não existe no controller {$controller}"
            );
        }

        if (empty($_REQUEST)) {
            $json_string = file_get_contents("php://input");

            if (empty($json_string)) {
                $uri = parse_url($_SERVER["REQUEST_URI"])["path"];
                $id = explode("/", $uri);
                foreach ($id as $value) {
                    if (is_numeric($value)) {
                        $id = $value;
                    } else {
                        $id = [];
                    }
                }
                $controllerInstance->$action(empty($uri) ? NULL : (object)['id' => $id]);
            } else {
                $object = json_decode($json_string);
                $controllerInstance->$action($object);
            }
        } else {
            if (!empty($_FILES)) {
                $_REQUEST['files'] = $_FILES;
            }
            $controllerInstance->$action((object)$_REQUEST);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$router = [
    "GET" => [
        "/tipoProduto" => fn() => load("TipoProdutoController", "index"),
        "/produtos" => fn() => load("ProdutosController", "index"),
        "/pedidos" => fn() => load("PedidosController", "index"),
    ],
    "POST" => [
        "/contact" => fn() => load("ContactController", "store"),
        "/tipoProduto" => fn() => load("TipoProdutoController", "store"),
        "/produtos" => fn() => load("ProdutosController", "store"),
        "/pedidos" => fn() => load("PedidosController", "store"),
    ],
    "PUT" => [
        "/tipoProduto" => fn() => load("TipoProdutoController", "update"),
        "/produtos" => fn() => load("ProdutosController", "update"),
    ],
    "DELETE" => [
        "/" => fn() => load("TipoProdutoController", "delete"),
        "/pedidos" => fn() => load("PedidosController", "delete"),
    ]
];
