<?php

namespace MilkoKosturkov\VC\UI\Common;

use MilkoKosturkov\VC\Common\UseCaseExecutionInfo;

class Router {

    /**
     * @var array
     */
    private $routes;

    public static function fromFile($file) {
        return new static(require $file);
    }

    /**
     * Router constructor.
     *
     * @param array $routes
     */
    public function __construct(array $routes) {
        $this->routes = $routes;
    }

    /**
     * @param \stdClass $request
     *
     * @return UseCaseExecutionInfo
     * @throws \MilkoKosturkov\VC\UI\Common\RouteNotFoundException
     */
    public function matchRequest(\stdClass $request) {
        foreach ($this->routes as $route) {
            if ($this->isMatch($request, $route['match'])) {
                return UseCaseExecutionInfo::fromArray($route['useCase']);
            }
        }
        throw new RouteNotFoundException('Could not find route for request');
    }

    private function isMatch(\stdClass $request, array $criteria) {
        $isMatch = true;
        while ($isMatch && list ($field, $expected) = each($criteria)) {
            $isMatch = $isMatch && !is_null($request->$field) && ($request->$field == $expected || $expected == '.*');
        }
        return $isMatch;
    }

}
