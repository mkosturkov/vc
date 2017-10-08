<?php

namespace MilkoKosturkov\VC\Common;

use MilkoKosturkov\VC\Configuration;

class UseCaseFactory {

    /**
     * @var Configuration
     */
    private $config;

    /**
     * UseCaseFactory constructor.
     *
     * @param Configuration $config
     */
    public function __construct(Configuration $config) {
        $this->config = $config;
    }

    /**
     * @return Configuration
     */
    public function getConfig() {
        return $this->config;
    }


    /**
     * @param  string $className
     * @return mixed
     */
    public function makeUseCase($className) {
        $factoryName = $className . 'Factory';
        if (class_exists($factoryName)) {
            return (new $factoryName())->make($this);
        }
        return new $className($this->config);
    }

}
