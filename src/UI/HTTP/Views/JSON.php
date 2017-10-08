<?php

namespace MilkoKosturkov\VC\UI\HTTP\Views;


use MilkoKosturkov\VC\UI\HTTP\Response;

class JSON extends BaseView {

    public function render(Response $response) {
        $response->setHeader('Content-Type', 'application/json');
        $response->setBody(\json_encode($this->data, JSON_PARTIAL_OUTPUT_ON_ERROR));
    }

}