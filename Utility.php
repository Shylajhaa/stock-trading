<?php

namespace App;

use App\Controller\StocksController;

require('/Applications/MAMP/htdocs/stock-trading/Controllers/StocksController.php');

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
