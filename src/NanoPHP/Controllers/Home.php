<?php

namespace NanoPHP\Controllers;

class Home extends BaseController {

    public function Homepage()
    {
        echo $this->getView();
    }
}