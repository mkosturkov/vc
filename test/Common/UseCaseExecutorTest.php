<?php

namespace MilkoKosturkov\VC\Common;

use PHPUnit\Framework\TestCase;

class UseCaseExecutorTestUseCaseParams {
    use ValidatedArrayFactoryTrait;

    public $a = false;
    public $b = false;
}

class UseCaseExecutorTestUseCase {
    public function execute(UseCaseExecutorTestUseCaseParams $p = null) {
        return $p->a ? $p->a / $p->b : $p->userId;
    }
}

class UseCaseExecutorTestUseCaseNoParams {
    public function execute() {
        return 'inexisting';
    }
}

class UseCaseExecutorTest extends TestCase {

    /**
     * @var UseCaseFactory
     */
    private $factory;

    /**
     * @var UseCaseExecutor
     */
    private $executor;

    public function setUp() {
        $this->factory = $this->getMockBuilder(UseCaseFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->factory->method('makeUseCase')
            ->willReturnCallback(function ($className) {
                return new $className();
            });
        $this->executor = new UseCaseExecutor($this->factory);
    }

    public function testExecutionWithParams() {
        $info = UseCaseExecutionInfo::fromArray([
            'className' => UseCaseExecutorTestUseCase::class,
            'parametersMapping' => ['a' => 'sa', 'b' => 'sb']
       ]);
        $input = (object)['sa' => 10, 'sb' => 2, 'userId' => 5];
        $result = $this->executor->execute($input, $info);
        $this->assertEquals(5, $result);
    }

    public function testExecutionWithNoParams() {
        $info = UseCaseExecutionInfo::fromArray(['className' => UseCaseExecutorTestUseCase::class]);
        $input = (object)['sa' => 10, 'sb' => 2, 'userId' => 100];
        $result = $this->executor->execute($input, $info);
        $this->assertEquals(100, $result);
    }

    public function testExecutingUseCaseWithNoParamsClass() {
        $info = UseCaseExecutionInfo::fromArray([
            'className' => UseCaseExecutorTestUseCaseNoParams::class,
            'parametersMapping' => ['a' => 'sa', 'b' => 'sb']
        ]);
        $result = $this->executor->execute(new \stdClass(), $info);
        $this->assertEquals('inexisting', $result);
    }

}
