<?php

namespace MilkoKosturkov\VC\UI\Common;

use MilkoKosturkov\VC\Common\DotNotionAccessorProxy;
use MilkoKosturkov\VC\Common\UseCaseExecutionInfo;
use MilkoKosturkov\VC\Exceptions\UndefinedKeyException;

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
     * @param DotNotionAccessorProxy $request
     *
     * @return UseCaseExecutionInfo
     * @throws \MilkoKosturkov\VC\UI\Common\RouteNotFoundException
     */
    public function matchRequest(DotNotionAccessorProxy $request) {
        foreach ($this->routes as $route) {
            if ($this->isMatch($request, $route['match'])) {
                return UseCaseExecutionInfo::fromArray($route['useCase']);
            }
        }
        throw new RouteNotFoundException('Could not find route for request');
    }

    private function isMatch(DotNotionAccessorProxy $request, array $criteria) {
        $isMatch = true;
        foreach ($criteria as $field => $expected) {
            try {
                $isMatch = $isMatch && ($request->$field == $expected || $expected == '.*');
            } catch (UndefinedKeyException $e) {
                return false;
            }
        }
        return $isMatch;
    }

}
