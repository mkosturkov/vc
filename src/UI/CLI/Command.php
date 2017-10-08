<?php

namespace MilkoKosturkov\VC\UI\CLI;

class Command {

    private $command;

    private $parserCallback = 'getopt';

    public function __construct(array $argv, callable $parserCallback = null) {
        $this->command = preg_replace('/\.php$/', '', basename($argv[0]));
        if (!is_null($parserCallback)) {
            $this->parserCallback = $parserCallback;
        }
    }

    public function __get($name) {
        if ($name == 'command') {
            return $this->command;
        }

        if ($name[0] === '-' && $name[1] === '-') {
            $optQuery = substr($name, 2);
            $r = call_user_func($this->parserCallback, '', [$optQuery]);
        } else if ($name[0] === '-') {
            $optQuery = substr($name, 1);
            $r = call_user_func($this->parserCallback, $optQuery);
        } else {
            return null;
        }
        $returnKey = str_replace(':', '', $optQuery);
        if (isset ($r[$returnKey])) {
            return $r[$returnKey] === false ? true : $r[$returnKey];
        }
        return null;
    }

}
