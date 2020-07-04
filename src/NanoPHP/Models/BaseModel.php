<?php

namespace NanoPHP\Models;

use NanoPHP\Config;

class BaseModel {

    protected $dbInstance     = null;
    protected $tableName      = '';
    protected $query          = '';
    protected $preparedValues = [];

    public function __construct()
    {
        $this->dbInstance = \NanoPHP\Library\Database\Mysql::getInstance(Config::getDBOptions());
    }

    public function select(string $columns): ?self
    {
        $columns = explode(", ", $columns);

        try {
            foreach($columns as $column) {
                $this->checkColumnExists($column);
            }
            $columns = implode(", ", $columns);
            $this->query = "select $columns from $this->tableName ";

            return $this;
        } catch(\Exception $e) {
            if(Config::DEBUG_MODE) {
                echo $e;
            } else {
                echo "500 - Internal Server Error";
            }
        }

        return null;
    }

    public function where(string $columnName, string $operator, string $value): self
    {
        switch($operator) {
            case '=':
                $this->query .= $this->whereEquals($columnName, $value);
            break;
        }
        return $this;
    }

    public function whereEquals(string $columnName, string $value): string
    {
        try {
            $this->checkColumnExists($columnName);

            $randomValueName = bin2hex(random_bytes(8));
            $this->preparedValues[] = [$randomValueName, $value];

            return "where $columnName = :$randomValueName";
        } catch(\Exception $e) {
            if(Config::DEBUG_MODE) {
                echo $e;
            } else {
                echo "500 - Internal Server Error";
            }
        }

        return '';
    }

    public function get(): array
    {
        $stmt = $this->dbInstance->prepare($this->query);
        foreach($this->preparedValues as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFirst()
    {
        $stmt = $this->dbInstance->prepare($this->query);
        foreach($this->preparedValues as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function checkTableExists(string $tableName)
    {
        $tableExists = in_array($tableName, array_values($this->getAllDBTables()));
        print_r(array_values($this->getAllDBTables()));
        if(!$tableExists) {
            throw new \Exception("Table '$tableName' does not exist in '" . \NanoPHP\Config::DB_NAME . "'");
        }
    }

    private function checkColumnExists(string $columnName)
    {
        $tableExists  = $this->checkTableExists($this->tableName);
        $columnExists = in_array($columnName, $this->getAllTableColumns($this->tableName));
        if(!$tableExists || !$columnExists) {
            throw new \Exception("Column '$columnName' does not exist in '" . \NanoPHP\Config::DB_NAME . "'");
        }
    }

    private function getAllTableColumns(string $tableName)
    {
        $sql = "show columns from $tableName";
        $stmt = $this->dbInstance->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function getAllDBTables(): array
    {
        $sql = "show tables";
        $result = $this->dbInstance->query($sql);
        return $result->fetchAll(\PDO::FETCH_COLUMN);
    }
}