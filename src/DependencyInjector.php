<?php

namespace NanoPHP;

class DependencyInjector
{
    protected $pairsKeyClass = [];

    public function register(string $key, string $class): self
    {
        $this->pairsKeyClass[$key] = $class;
        return $this;
    }

    public function make(string $key)
    {
        return new $this->pairsKeyClass[$key]();
    }
}
