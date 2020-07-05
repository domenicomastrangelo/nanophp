<?php

namespace NanoPHP\Models;

use NanoPHP\Library\Database\Mysql;

class BaseModel
{
    protected ?\PDO $dbInstance = null;
    protected string $tableName  = '';
    protected ?\NanoPHP\DependencyInjector $di = null;

    public function __construct(array $dbOptions)
    {
        $this->di = new \NanoPHP\DependencyInjector();
        $this->dbInstance = Mysql::getInstance($dbOptions);
    }
}
