<?php

namespace MilkoKosturkov\VC\UI\Common;

use MilkoKosturkov\VC\UI\HTTP\Request;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {

    private $routes = [
        [
            'match' => [
                'method' => 'GET',
                'get.action' => 'search'
            ],
            'useCase' => [
                'className' => 'U1',
                'parametersMapping' => [
                    'p1' => '1p'
                ]
            ]
        ],
        [
            'match' => [
                'get.action' => 'search',
                'method' => 'POST',
                'post.page' => 1
            ],
            'useCase' => [
                'className' => 'U2',
                'parametersMapping' => [
                    'p2' => '2p'
                ]
            ]
        ],
        [
            'match' => [
                'get.anything' => '.*'
            ],
            'useCase' => [
                'className' => 'U3'
            ]
        ]
    ];

    /**
     * @var Router
     */
    private $router;

    public function setUp() {
        $this->router = new Router($this->routes);
    }

    public function testMatch() {
        $request = new Request(['REQUEST_METHOD' => 'GET'], ['action' => 'search'], []);
        $match = $this->router->matchRequest($request);
        $this->assertEquals($this->routes[0]['useCase']['className'], $match->getClassName());
        $this->assertEquals($this->routes[0]['useCase']['parametersMapping'], $match->getParametersMapping());

        $request = new Request(['REQUEST_METHOD' => 'POST'], ['action' => 'search'], ['page' => 1]);
        $match = $this->router->matchRequest($request);
        $this->assertEquals($this->routes[1]['useCase']['className'], $match->getClassName());
        $this->assertEquals($this->routes[1]['useCase']['parametersMapping'], $match->getParametersMapping());
    }

    public function testMatchExistingParameterIgnoreValue() {
        $request = new Request(['REQUEST_METHOD' => 'GET'], ['anything' => 'var1'], []);
        $match = $this->router->matchRequest($request);
        $this->assertEquals($this->routes[2]['useCase']['className'], $match->getClassName());

        $request = new Request(['REQUEST_METHOD' => 'GET'], ['anything' => 'param2'], []);
        $match = $this->router->matchRequest($request);
        $this->assertEquals($this->routes[2]['useCase']['className'], $match->getClassName());
    }

    public function testExceptionOnNoRoute() {
        $this->expectException(RouteNotFoundException::class);
        $request = new Request(['REQUEST_METHOD' => 'POST'], ['action' => 'search'], []);
        $this->router->matchRequest($request);
    }


}
