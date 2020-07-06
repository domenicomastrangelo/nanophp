<?php

namespace NanoPHP\Library\Http;

use GuzzleHttp\Psr7\Request as GuzzleRequest;

class Request extends GuzzleRequest
{
    public function __construct()
    {
        parent::__construct(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            apache_request_headers(),
            file_get_contents('php://input'),
            substr($_SERVER['SERVER_PROTOCOL'], strrpos($_SERVER['SERVER_PROTOCOL'], '/') + 1)
        );
    }
}
