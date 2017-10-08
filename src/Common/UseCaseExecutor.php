<?php

namespace MilkoKosturkov\VC\Common;

class UseCaseExecutor {

    /**
     * @var UseCaseFactory
     */
    private $factory;

    /**
     * UseCaseExecutor constructor.
     *
     * @param UseCaseFactory $factory
     */
    public function __construct(UseCaseFactory $factory) {
        $this->factory = $factory;
    }

    public function execute($input, UseCaseExecutionInfo $execInfo) {
        $useCaseClass = $execInfo->getClassName();
        $useCaseParamsClass = $useCaseClass . 'Params';
        $useCase = $this->factory->makeUseCase($useCaseClass);
        $params = !class_exists($useCaseParamsClass)
                  ? null
                  : $this->buildParams($useCaseParamsClass, $input, $execInfo->getParametersMapping());
        return $useCase->execute($params);
    }

    private function buildParams($paramsClass, $input, $mappings) {
        $params = [];
        $params['userId'] = $input->userId;
        foreach ($mappings as $paramKey => $inputKey) {
            $params[$paramKey] = $input->$inputKey;
        }
        return call_user_func([$paramsClass, 'fromArray'], $params);
    }

}
