<?php

namespace App\Models;

use App\Helpers\DB;

abstract class Model
{
    protected string $table;

    protected DB $connection;

    /**
     * Base model constructor.
     */
    public function __construct()
    {
        $this->connection = new DB(get_class($this));
        $this->connection->table($this->table);
    }

    /**
     * Find model by ID in database.
     *
     * @param $id
     * @return object|array
     */
    public function find($id): object|array
    {
        $result = $this->connection->where('id', '=', $id)->get();

        if (!empty($result)) return $result[0];

        return $result;
    }

    /**
     * Start a new empty query.
     *
     * @return DB
     */
    public function newQuery(): DB
    {
        return $this->connection;
    }

    /**
     * Return all models from database.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->connection->get();
    }

    /**
     * Delete model from database..
     *
     * @return void
     */
    public function delete(): void
    {
        $this->connection->where('id', '=', $this->id)->delete();
    }

    /**
     * Update model in database.
     *
     * @param array $data
     * @return void
     */
    public function update(array $data): void
    {
        $this->connection->where('id', '=', $this->id)->update($data);
    }

    /**
     * Create new model in database.
     *
     * @param array $data
     * @return object|array
     */
    public function create(array $data): object|array
    {
        $id = $this->connection->insert($data);

        return $this->find($id);
    }

    /**
     * Delete model with specific where clause.
     *
     * @param string $column
     * @param string $comparator
     * @param $value
     * @return void
     */
    public function deleteWhere(string $column, string $comparator, $value)
    {
        $this->connection->where($column, $comparator, $value)->delete();
    }
}