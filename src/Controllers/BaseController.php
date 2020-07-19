<?php

namespace NanoPHP\Controllers;

class BaseController
{
    protected $view     = '';
    protected $viewData = [];
    protected $config   = [];
    protected $di = null;
    
    public function __construct(\NanoPHP\DependencyInjector $di)
    {
        $this->di   = $di;
        $this->view = (new \ReflectionClass($this))->getShortName();
    }

    public function setView(string $name)
    {
        $this->view = $name;
    }

    public function getView(): string
    {
        return $this->view . ".php";
    }

    public function disableView()
    {
        $this->view = null;
    }
}
