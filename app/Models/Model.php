<?php

namespace App\Models;

use PDO;

use Database\DBConnection;

abstract class Model
{

    protected $db;
    protected $table;
    protected $id;

    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }


    public function all(): array
    {
        return $this->query("SELECT * FROM {$this->table}");

    }

    public function findById(int $id): ?array
    {
        $result = $this->query("SELECT * FROM {$this->table} WHERE {$this->id} = ?", [$id], true);
        if (!empty($result)) {
            return $result;
        } else {

            return null;
        }
    }

    public function query(string $sql, array $param = null, bool $single = null)
    {
        $method = is_null($param) ? 'query' : 'prepare';
        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = $this->db->getPDO()->$method($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 

        if ($method === 'query') {
            return $stmt->$fetch();
        } else {
            $stmt->execute($param);
            return $stmt->$fetch();
        }
    }
}