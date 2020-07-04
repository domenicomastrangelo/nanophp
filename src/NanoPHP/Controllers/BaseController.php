<?php

namespace NanoPHP\Controllers;

class BaseController {

    protected $view     = '';
    protected $viewData = [];
    
    public function __construct()
    {
        $this->view = (new \ReflectionClass($this))->getShortName();
    }

    public function getView()
    {
        $viewFilePath = realpath(\NanoPHP\Config::VIEWS_PATH) . '/' . $this->view . ".php";
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