<?php

namespace NanoPHP;

class Routes {

    public static function getRoutes(): array
    {
        return [
            '/'         => 'Home@Homepage',
            '/register' => 'Auth@Register',
        ];
    }
}