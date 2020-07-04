<?php

namespace NanoPHP;

class Config {

    const VIEWS_PATH = __DIR__ . '/../NanoPHP/Views';

    const DB_NAME = 'database';
    const DB_USER = 'user';
    const DB_PASS = 'password';
    const DB_HOST = 'mariadb';

    public static function getDBOptions(): array
    {
        return [
            'DB_NAME'   => static::DB_NAME,
            'DB_USER'   => static::DB_USER,
            'DB_PASS'   => static::DB_PASS,
            'DB_HOST'   => static::DB_HOST,
        ];
    }
}