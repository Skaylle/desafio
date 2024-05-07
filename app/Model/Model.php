<?php

namespace App\Model;

use App\DB;
use PDO;
use PDOException;

class Model
{
    /**
     * @var string $table
     */
    protected string $table;

    /**
     * @var array
     */
    protected array $fillable;

    protected PDO $pdo;

    public function __construct(PDO $pdo = null)
    {
        $this->pdo = $pdo ?? DB::connect();
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} order by id desc");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} where id = {$id}");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $data = array_intersect_key($data, array_flip($this->fillable));

        $data = array_merge($data, ["created_at" => date('Y-m-d H:i:s')]);
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        try {
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $stmt = $this->pdo->prepare($sql);

            foreach ($data as $chive => $valor) {
                $stmt->bindValue(":$chive", $valor);
            }

            $stmt->execute();

            return $this->find($this->pdo->lastInsertId());
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    public function update(int $id, array $data)
    {
        $data = array_intersect_key($data, array_flip($this->fillable));

        $data = array_merge($data, ["updated_at" => date('Y-m-d H:i:s')]);
        try {
            $column_values = '';
            foreach ($data as $column => $value) {
                $column_values .= "$column = :$column, ";
            }
            $column_values = rtrim($column_values, ', ');

            $sql = "UPDATE {$this->table} SET $column_values WHERE id = {$id}";
            $stmt = $this->pdo->prepare($sql);

            foreach ($data as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }

            $stmt->execute();
            return $this->find($id);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    public function destroy(int $id): bool
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    public function count(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count']) {
            return $result['count'];
        } else {
            return 0;
        }
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function rollback()
    {
        $this->pdo->rollback();
    }
}