<?php

namespace MilkoKosturkov\VC\UI\Common;

use MilkoKosturkov\VC\Common\UseCaseExecutor;
use MilkoKosturkov\VC\Common\UseCaseFactory;
use MilkoKosturkov\VC\Configuration;

abstract class BaseApp {

    protected function execute(\stdClass $input, $routesFile) {
        $router = Router::fromFile($routesFile);
        $useCaseInfo = $router->matchRequest($input);
        $config = new Configuration();
        $useCaseFactory = new UseCaseFactory($config);
        $executor = new UseCaseExecutor($useCaseFactory);
        $data = $executor->execute($input, $useCaseInfo);
        $viewClass = $useCaseInfo->getViewClass();
        return [$data, $viewClass];
    }

}
