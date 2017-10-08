<?php

namespace MilkoKosturkov\VC\UI\CLI;

use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase {

    public function testCommandParsing() {
        $args = [
            ['test.php'],
            ['some/sort/of/path/test.php'],
            ['test']
        ];
        foreach ($args as $a) {
            $command = new Command($a);
            $this->assertEquals('test', $command->command);
        }
    }

    public function testPassingArguments() {
        $called = ['short' => '', 'long' => ''];
        $command = new Command([''], function ($short, array $long = null) use (&$called) {
            $called['short'] = $short;
            $called['long'] = $long;
        });
        $command->{'-a'};

        $this->assertEquals('a', $called['short']);
        $this->assertNull($called['long']);

        $command->{'--long-one'};
        $this->assertTrue($called['short'] === '');
        $this->assertEquals(['long-one'], $called['long']);
    }

    public function testReturnValuesPostproduction() {
        foreach (['-a', '-a:', '-a::', '--a', '--a:', '--a::'] as $key) {
            $command = new Command([''], function ($short, array $long = null) {
                return [];
            });
            $this->assertNull($command->$key);

            $command = new Command([''], function ($s, $l = null) {
                return ['a' => false];
            });
            $this->assertTrue($command->$key);

            $command = new Command([''], function ($s, $l = null) {
                return ['a' => 'aha'];
            });
            $this->assertEquals('aha', $command->{$key});
        }

        $command = new Command(['']);
        $this->assertNull($command->b);
    }


}
