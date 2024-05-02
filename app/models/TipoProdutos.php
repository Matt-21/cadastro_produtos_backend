<?php

namespace app\models;

use app\database\Database;
use Exception;

class TipoProdutos
{
    private static $table = 'tipoprodutos';

    public static function select(int $id): bool|array
    {
        $connPdo = Database::getConnection();

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id_tipo_produto = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return ['mensagem' => 'Nenhum tipo de produto encontrado!'];
    }

    public static function like(string $id): bool|array
    {
        $connPdo = Database::getConnection();

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE tipo_produto LIKE :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', "%" . $id . "%");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['mensagem' => 'Tipo de produto já cadastrado!'];
        }
        return false;
    }

    public static function selectAll(): bool|array
    {
        $connPdo = Database::getConnection();

        $sql = 'SELECT * FROM ' . self::$table;
        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return ['mensagem' => 'Nenhum tipo de produto encontrado!'];

    }

    public static function insert($data): array
    {
        $connPdo = Database::getConnection();

        $sql = 'INSERT INTO ' . self::$table . ' (tipo_produto, valor_imposto) VALUES (:tp, :vi)';

        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':tp', $data->tipo_produto);
        $stmt->bindValue(':vi', $data->valor_imposto);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            Database::close();
            return ['mensagem' => 'Tipo de produto cadastrado com sucesso!'];
        }
        return ['mensagem' => "Falha ao inserir Tipo de Produto!"];

    }

    public static function update($data): array
    {
        $connPdo = Database::getConnection();

        $sql = 'UPDATE ' . self::$table . ' SET tipo_produto = :tp, valor_imposto = :vi WHERE id_tipo_produto = :id';

        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':tp', $data->tipo_produto);
        $stmt->bindValue(':vi', $data->valor_imposto);
        $stmt->bindValue(':id', $data->id_tipo_produto);

        if ($stmt->execute()) {
            Database::close();
            return ['mensagem' => 'Tipo de produto atualizado com sucesso!'];
        }
        return ['mensagem' => 'Falha ao atualizar o tipo de produto!'];

    }

    public static function delete($data): array
    {
        $connPdo = Database::getConnection();

        $sql = 'DELETE FROM ' . self::$table . ' WHERE id_tipo_produto = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $data->id);

        if ($stmt->execute()) {
            return ['mensagem' => 'Tipo de produto deletado com sucesso!'];
        }
        return ['mensagem' => 'Falha ao deletar o tipo de produto!'];
    }
}