<?php

namespace app\models;

use app\database\Database;
use Exception;
use PDO;
use PDOStatement;

class Pedidos
{
    private static $table = 'pedidos';

    public static function select(int $id): bool|object
    {
        $connPdo = Database::getConnection();

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id_pedidos = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        throw new Exception("Nenhum pedido encontrado!");
    }

    public static function selectAll(): bool|array
    {
        $connPdo = Database::getConnection();

        $sql = 'SELECT p2.id_pedidos, p.nome, p2.qtd_vendida, p2.valor_total, p.caminho
                FROM produtos p 
                INNER JOIN pedidos p2 ON p.id_produto=p2.id_produto;';
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
            ' (id_produto, qtd_vendida, valor_total)
             VALUES (:id, :qtd, :vt)';

        $stmt = self::bindValues($connPdo, $sql, $data);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            Database::close();
            return ['mensagem' => 'Pedido cadastrado com sucesso!'];
        }
        return ['mensagem' => "Falha ao inserir Pedido!"];

    }

    public static function update($data): array
    {
        $connPdo = Database::getConnection();

        $sql = 'UPDATE ' . self::$table .
            ' SET 
              qtd_vendida = :qtd,
              valor_total = :vt
          WHERE id_pedidos = :id';

        $stmt = self::bindValues($connPdo, $sql, $data);

        if ($stmt->execute()) {
            Database::close();
            return ['mensagem' => 'Pedido atualizado com sucesso!'];
        }
        return ['mensagem' => 'Falha ao atualizar o pedido!'];

    }

    public static function delete($data): array
    {
        $connPdo = Database::getConnection();

        $sql = 'DELETE FROM ' . self::$table . ' WHERE id_pedidos = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $data->id);

        if ($stmt->execute()) {
            return ['mensagem' => 'Pedido deletado com sucesso!'];
        }
        return ['mensagem' => 'Falha ao deletar o pedido!'];
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
        $stmt->bindValue(':id', $data->id_produto);
        $stmt->bindValue(':qtd', $data->qtd_vendida);
        $stmt->bindValue(':vt', $data->valor_total);
        return $stmt;
    }
}