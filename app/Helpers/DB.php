<?php

namespace App\Helpers;

use PDO;
use PDOStatement;

class DB
{
    protected PDO $connection;

    private string $table;

    public array $where = [];

    private array $joins = [];

    private string $model;

    private string $query;

    private string $action;

    private array $columns = [];

    private array $insert = [];

    private array $bindings = [
        'WHERE' => [],
        'SET' => [],
    ];

    private PDOStatement $statement;

    /**
     * DB helper constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;

        $this->connection = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};port={$_ENV['DB_PORT']}", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Set the table to use.
     *
     * @param string $table
     * @return void
     */
    public function table(string $table): void
    {
        $this->table = $table;
    }

    /**
     * Add a where statement.
     *
     * @param string $column
     * @param string $comparator
     * @param $value
     * @return $this
     */
    public function where(string $column, string $comparator, $value): self
    {
        $this->where[] = [
            'column' => $column,
            'comparator' => $comparator,
            'value' => $value,
        ];

        $this->bindings['WHERE'] = array_merge($this->bindings['WHERE'], [$column => $value]);

        return $this;
    }

    /**
     * Start a select query.
     *
     * @param array|string $columns
     * @return $this
     */
    public function select(array|string $columns = ['*']): self
    {
        $this->action = 'SELECT';

        if (!is_array($columns)) {
            $columns = explode(',', $columns);
        }

        $this->columns = $columns;

        return $this;
    }

    /**
     * Execute a select query.
     *
     * @param array|string $columns
     * @return array
     */
    public function get(array|string $columns = ['*']): array
    {
        $this->select($columns);

        $this->executeStatement();

        return $this->statement->fetchAll(PDO::FETCH_CLASS, $this->model);
    }

    /**
     * Get all records.
     *
     * @return array|object
     */
    public function all(): array|object
    {
        $this->select();

        $this->executeStatement();

        return $this->statement->fetchAll(PDO::FETCH_CLASS, $this->model);
    }

    /**
     * Start an update query.
     *
     * @param array $data
     * @return void
     */
    public function update(array $data): void
    {
        if(empty($this->where)) {
            die('You probably do not want to do this.');
        }

        $this->action = "UPDATE";

        foreach ($data as $column => $value) {
            $this->bindings['SET'] = array_merge($this->bindings['SET'], [$column => $value]);
        }

        $this->executeStatement();
    }

    /**
     * Start an insert query.
     *
     * @param array $data
     * @return int
     */
    public function insert(array $data): int
    {
        $this->action = 'INSERT';

        $this->insert['columns'] = array_keys($data);
        $this->insert['values'] = array_values($data);

        foreach ($this->insert['values'] as &$value) {
            $value = "'$value'";
        }

        $this->executeStatement();

        return $this->connection->lastInsertId();
    }

    /**
     * Start a delete statement.
     *
     * @return void
     */
    public function delete(): void
    {
        if(empty($this->where)) {
            die('You probably do not want to do this.');
        }

        $this->action = 'DELETE';

        $this->executeStatement();
    }

    /**
     * Add a left join.
     *
     * @param string $table
     * @param string $source
     * @param string $target
     * @return $this
     */
    public function leftJoin(string $table, string $source, string $target)
    {
        $this->joins[] = [
            'type' => 'LEFT',
            'table' => $table,
            'source' => $source,
            'target' => $target,
        ];

        return $this;
    }

    /**
     * Execute the built SQL query.
     *
     * @return void
     */
    private function executeStatement(): void
    {
        $columns = implode(', ', $this->columns);

        switch ($this->action) {
            case 'SELECT':
                $this->query = "SELECT $columns FROM $this->table";
                $this->addJoins();
                $this->addWheres();
                break;
            case 'UPDATE':
                $this->query = "UPDATE $this->table SET";
                $this->addUpdates();;
                $this->addWheres();
                break;
            case 'DELETE':
                $this->query = "DELETE FROM $this->table";
                $this->addWheres();
                break;
            case 'INSERT':
                $columns = implode(', ', $this->insert['columns']);
                $values = implode(', ', $this->insert['values']);

                $this->query = "INSERT INTO $this->table ($columns) VALUES ($values)";
                break;
        }

        $this->statement = $this->connection->prepare($this->query);

        $this->processBindings();

        $this->statement->execute();
    }

    /**
     * Execute a raw SQL query.
     *
     * @param string $query
     * @return bool|array
     */
    public function rawQuery(string $query = ''): bool|array
    {
        $this->query = $query;

        $this->statement = $this->connection->prepare($this->query);

        $this->statement->execute();

        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Add the set joins to the query.
     *
     * @return void
     */
    private function addJoins(): void
    {
        foreach ($this->joins as $key => $join) {
            $this->query .= " {$join['type']} JOIN {$join['table']} ON {$this->table}.{$join['source']} = {$join['table']}.{$join['target']}";
        }
    }

    /**
     * Add the set wheres to the query.
     *
     * @return void
     */
    private function addWheres(): void
    {
        if(empty($this->where)) return;

        $iterator = 1;
        foreach ($this->where as $key => $value) {
            if ($iterator === 1) {
                $this->query .= " WHERE {$value['column']} {$value['comparator']} :WHERE{$value['column']}";
            } else {
                $this->query .= " AND {$value['column']} {$value['comparator']} :WHERE{$value['column']}";
            }

            $iterator++;
        }

        $this->where = [];
    }

    /**
     * Add the set updates to the query.
     *
     * @return void
     */
    private function addUpdates(): void
    {
        $length = count($this->bindings['SET']);

        $iterator = 1;
        foreach ($this->bindings['SET'] as $column => $value) {
            $this->query .= " {$column}=:SET{$column}";

            if($iterator != $length) $this->query .= ",";

            $iterator++;
        }
    }

    /**
     * Process all bindings.
     *
     * @return void
     */
    private function processBindings(): void
    {
        foreach ($this->bindings as $type => $binding) {
            foreach ($binding as $column => $value) {
                $this->statement->bindValue($type . $column, $value);
            }
            $this->bindings[$type] = [];
        }
    }
}