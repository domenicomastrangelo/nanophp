<?php

namespace NanoPHP\Controllers;

class BaseController
{
    protected $view     = '';
    protected $viewData = [];
    protected $config   = [];
    
    public function __construct(array $config = [])
    {
        $this->view   = (new \ReflectionClass($this))->getShortName();
        $this->config = $config;
    }

    public function getView()
    {
        $viewFilePath = realpath($this->config['VIEWS_PATH']) . '/' . $this->view . ".php";
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
