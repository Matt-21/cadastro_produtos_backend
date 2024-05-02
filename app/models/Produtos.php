<?php

namespace app\models;

use app\database\Database;
use PDO;
use PDOStatement;

class Produtos
{
    private static $table = 'produtos';

    public static function select(int $id): bool|object
    {
        $connPdo = Database::getConnection();

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id_produto = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public static function like(string $nome): bool|array
    {
        $connPdo = Database::getConnection();

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE nome LIKE :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', "%" . $nome . "%");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['mensagem' => 'Produto já cadastrado!'];
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public static function insert($data): array
    {
        $connPdo = Database::getConnection();

        $sql = 'INSERT INTO ' . self::$table .
            ' (id_tipo_produto, nome, valor, qtd_estoque, valor_imposto, caminho, valor_total)
             VALUES (:itp, :n, :v, :qtd, :vi, :cm, :vt)';

        $stmt = self::bindValues($connPdo, $sql, $data);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            Database::close();
            return ['mensagem' => 'Produto cadastrado com sucesso!'];
        }
        return ['mensagem' => "Falha ao inserir Produto!"];

    }


    public static function update ($data): array
    {
        $connPdo = Database::getConnection();

        $sql = 'UPDATE ' . self::$table .
            ' SET qtd_estoque = :qtd
          WHERE id_produto = :id';

        $stmt = $connPdo->prepare($sql);

        $stmt->bindValue(':qtd', $data->qtd_estoque);
        $stmt->bindValue(':id', $data->id_produto);

        if ($stmt->execute()) {
            Database::close();
            return ['mensagem' => 'Produto atualizado com sucesso!'];
        }
        return ['mensagem' => 'Falha ao atualizar o produto!'];

    }

    public static function delete($data): array
    {
        $connPdo = Database::getConnection();

        $sql = 'DELETE FROM ' . self::$table . ' WHERE id_tipo_produto = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $data->id);

        if ($stmt->execute()) {
            return ['mensagem' => 'Produto deletado com sucesso!'];
        }
        return ['mensagem' => 'Falha ao deletar o produto!'];
    }

    /**
     * @param PDO|null $connPdo
     * @param string $sql
     * @param $data
     * @return false|PDOStatement
     */
    public static function bindValues(?PDO $connPdo, string $sql, $data): PDOStatement|false
    {
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':itp', $data->id_tipo_produto);
        $stmt->bindValue(':n', $data->nome);
        $stmt->bindValue(':v', $data->valor);
        $stmt->bindValue(':qtd', $data->qtd_estoque);
        $stmt->bindValue(':vi', $data->valor_imposto);
        $stmt->bindValue(':cm', $data->image);
        $stmt->bindValue(':vt', $data->valor_total);
        return $stmt;
    }
}