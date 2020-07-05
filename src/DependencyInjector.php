<?php

namespace NanoPHP;

class DependencyInjector
{
    protected $pairsKeyClass = [];

    public function register(string $key, string $class)
    {
        $this->pairsKeyClass[$key] = $class;
    }

    public function make(string $key)
    {
        return new $this->pairsKeyClass[$key]();
    }
}
