<?php

namespace MilkoKosturkov\VC\UI\CLI;

use MilkoKosturkov\VC\UI\Common\BaseApp;

class App extends BaseApp {

    public function run(array $argv) {
        try {
            $command = new Command($argv);
            list ($data, $viewClass) = $this->execute($command, __DIR__ . '/routes.php');
            if (!empty ($viewClass)) {
                $view = new $viewClass();
                $view->setData($data);
                $view->render();
            }
            $status = 0;
        } catch (\Exception $e) {
            $status = 1;
        }
        return $status;
    }

}
