<?php

namespace App\Utility;

use App\Controller\StocksController;

/**
 *
 */
class Utility
{
    const DS = DIRECTORY_SEPARATOR;
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

    public function uploadFile($fileName)
    {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . DS . 'stock-trading' . DS . 'src' . DS . 'Files' . DS . 'Uploaded';
        $targetFile = $targetDir . DS . 'stock_data_csv_' . date('Y-m-d-H-i-s');
        if (!move_uploaded_file($fileName, $targetFile)) {
            return false;
        }

        return $targetFile;
    }

    public function isDateInRange($from, $to, $givenDate)
    {
        $fromDate = strtotime($from);
        $toDate = strtotime($to);
        $stockDate = strtotime($givenDate);

        if ($stockDate >= $fromDate && $stockDate <= $toDate) {
            return true;
        }

        return false;
    }
}
