<?php

namespace App\Helpers;

use PDO;
use PDOStatement;

class DB
{
    protected PDO $connection;

    private string $table;

    private array $where = [];

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

    public function __construct($model)
    {
        $this->model = $model;

        $this->connection = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};port={$_ENV['DB_PORT']}", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function table(string $table): void
    {
        $this->table = $table;
    }

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

    public function select(array|string $columns = ['*']): self
    {
        $this->action = 'SELECT';

        if (!is_array($columns)) {
            $columns = explode(',', $columns);
        }

        $this->columns = $columns;

        return $this;
    }

    public function get(): array
    {
        $this->select();

        $this->executeStatement();

        return $this->statement->fetchAll(PDO::FETCH_CLASS, $this->model);
    }

    public function all(): array|object
    {
        $this->select();

        $this->executeStatement();

        return $this->statement->fetchAll(PDO::FETCH_CLASS, $this->model);
    }

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

    public function insert(array $data): void
    {
        $this->action = 'INSERT';

        $this->insert['columns'] = array_keys($data);
        $this->insert['values'] = array_values($data);

        foreach ($this->insert['values'] as &$value) {
            $value = "'$value'";
        }

        $this->executeStatement();
    }

    public function delete(): void
    {
        if(empty($this->where)) {
            die('You probably do not want to do this.');
        }

        $this->action = 'DELETE';

        $this->executeStatement();
    }

    private function executeStatement(): void
    {
        $columns = implode(', ', $this->columns);

        switch ($this->action) {
            case 'SELECT':
                $this->query = "SELECT $columns FROM $this->table";
                $this->addWheres();
                break;
            case 'UPDATE':
                $this->query = "UPDATE $this->table";

                foreach ($this->bindings['SET'] as $column => $value) {
                    $this->query .= " SET {$column}=:SET{$column}";
                }

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
                dump($this->query);
                break;
        }

        $this->statement = $this->connection->prepare($this->query);

        $this->processBindings();

        $this->statement->execute();
    }

    private function addWheres(): void
    {
        if(empty($this->where)) return;

        $iterator = 1;
        foreach ($this->where as $key => $value) {
            if ($iterator === 1) {
                $this->query .= " WHERE {$value['column']}{$value['comparator']}:WHERE{$value['column']}";
            } else {
                $this->query .= " AND {$value['column']}{$value['comparator']}:WHERE{$value['column']}";
            }

            $iterator++;
        }

        $this->where = [];
    }
    
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