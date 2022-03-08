<?php

namespace App\Models;

use App\Helpers\DB;

abstract class Model
{
    protected string $table;

    protected DB $connection;

    public function __construct()
    {
        $this->connection = new DB(get_class($this));
        $this->connection->table($this->table);
    }

    public function find($id): object|array
    {
        $result = $this->connection->where('id', '=', $id)->get();

        if (!empty($result)) return $result[0];

        return $result;
    }

    public function all(): array
    {
        return $this->connection->get();
    }

    public function delete(): void
    {
        $this->connection->where('id', '=', $this->id)->delete();
    }

    public function update(array $data): void
    {
        $this->connection->where('id', '=', $this->id)->update($data);
    }

    public function create(array $data): void
    {
        $this->connection->insert($data);
    }
}