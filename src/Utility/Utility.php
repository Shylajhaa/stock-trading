<?php

namespace App\Utility;

use App\Controller\StocksController;

/**
 *
 */
class Utility
{
    public function getClass($routeName)
    {
        $classObj = null;
        switch ($routeName) {
            case 'stocks':
                $classObj = new StocksController();
                break;
            
            default:
                break;
        }

        return $classObj;
    }

    public function invokeFunction($route, $action)
    {
        $controllerClass = $this->getClass($route);
        $controllerClass->{$action}();
    }
}
