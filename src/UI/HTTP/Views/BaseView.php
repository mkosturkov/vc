<?php

namespace MilkoKosturkov\VC\UI\HTTP\Views;

use MilkoKosturkov\VC\UI\HTTP\Response;

abstract class BaseView {

    protected $data;

    public function setData($data) {
        $this->data = $data;
    }

    abstract function render(Response $response);

}