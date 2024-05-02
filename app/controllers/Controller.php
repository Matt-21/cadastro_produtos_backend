<?php

namespace app\controllers;

class Controller
{
  public function json (array $json, int $response_code): void
  {
    http_response_code($response_code);
    echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  }
}
