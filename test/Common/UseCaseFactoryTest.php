<?php

namespace MilkoKosturkov\VC\Common;

use MilkoKosturkov\VC\Configuration\Configuration;
use PHPUnit\Framework\TestCase;

class UseCaseFactoryTestMockUseCase {
    public function __construct(Configuration $c) {}
}

class UseCaseFactoryTest extends TestCase {

    /**
     * @var UseCaseFactory
     */
    private $factory;

    public function setUp() {
        parent::setUp();
        $this->factory = new UseCaseFactory(new Configuration());
    }

    public function testMakeUseCase() {
        $useCase = $this->factory->makeUseCase(UseCaseFactoryTestMockUseCase::class);
        $this->assertInstanceOf(UseCaseFactoryTestMockUseCase::class, $useCase);
    }
}
