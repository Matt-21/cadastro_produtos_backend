<?php
require "../vendor/autoload.php";
require "../routes/router.php";

try {
    $uri = parse_url($_SERVER["REQUEST_URI"])["path"];
    $request = $_SERVER["REQUEST_METHOD"];
    $query_string = explode("/", $uri);
    $id = 0;

    foreach ($query_string as $value) {
        if (is_numeric($value)) {
            $id = (int) $value;
        }
    }

    if (is_numeric($query_string[1])) {
         $value = (int) $query_string[1];
    } else {
        $value = $query_string[1];
    }

    if (!isset($router[$request])) {
        throw new Exception("A rota não existe");
    }

    if ($id != 0) {
        if (is_string($value)) {
            $path = '/'.$value;
        } else {
            $path = '/';
        }

        if (!array_key_exists($path, $router[$request])) {
            throw new Exception("A rota não existe");
        }

        $controller = $router[$request][$path];
    } else {

        if (!array_key_exists($uri, $router[$request])) {
            throw new Exception("A rota não existe");
        }

        $controller = $router[$request][$uri];
    }
    $controller();
} catch (Exception $e) {
    echo $e->getMessage();
}
