<?php

namespace MilkoKosturkov\VC\UI\HTTP\Views;

use MilkoKosturkov\VC\UI\HTTP\Response;

abstract class TemplateView extends BaseView {

    abstract protected function getTemplate();

    public function render(Response $response) {
        ob_start();
        // TODO: Fix the rendering here
        require __DIR__ . '/templates/' . $this->getTemplate() . '.php';
        $response->setBody(ob_get_clean());
    }

}
