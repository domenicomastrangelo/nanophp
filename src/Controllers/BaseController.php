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

    public function getView()
    {
        $config = $this->di->make('config');
        $viewFilePath = realpath($config::VIEWS_PATH) . '/' . $this->view . ".php";
        $_SESSION['viewData'] = $this->viewData;

        ob_start();
        include $viewFilePath;
        $viewFileContent = ob_get_clean();

        return $viewFileContent;
    }

    public function setView(string $name)
    {
        $this->view = $name;
    }

    public function setViewData(array $data)
    {
        $this->viewData = $data;
    }
}
