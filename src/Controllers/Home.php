<?php

namespace NanoPHP\Controllers;

use NanoPHP\Models\User;

class Home extends BaseController
{
    public function homepage()
    {
        return $this->getView();
    }
}
