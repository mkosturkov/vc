<?php

namespace MilkoKosturkov\VC\UI\HTTP;

use MilkoKosturkov\VC\UI\Common\BaseApp;
use MilkoKosturkov\VC\UI\Common\RouteNotFoundException;
use MilkoKosturkov\VC\UI\HTTP\Views\BaseView;
use MilkoKosturkov\VC\UI\HTTP\Views\JSON;

class App extends BaseApp {

    public function run() {
        $response = new Response();
        try {
            $request = Request::fromGlobals();
            list ($data, $viewClass) = $this->execute($request, __DIR__ . '/routes.php');
            if (empty ($viewClass)) {
                $viewClass = JSON::class;
            }
            /** @var BaseView $view */
            $view = new $viewClass();
            $view->setData($data);
            $view->render($response);
        } catch (RouteNotFoundException $e) {
            $response->setStatus(404);
        } catch (\Exception $e) {
            $response->setStatus(500);
            $response->setBody($e->getMessage());
        }
        $response->send();
    }

}
