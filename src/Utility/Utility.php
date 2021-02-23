<?php

namespace App\Utility;

use App\Controller\StocksController;

/**
 *
 */
class Utility
{
    const DS = DIRECTORY_SEPARATOR;

    /**
     * Fetches the class to invoke based on the route name
     * @param string $route routeName
     * @return object of class
     */
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

    /**
     * Invokes the given function in the given route
     * @param string $route routeName
     * @param string $action functionName
     * @return void
     */
    public function invokeFunction($route, $action)
    {
        $controllerClass = $this->getClass($route);
        $controllerClass->{$action}();
    }

    /**
     * Uploads the file to the server
     * @param string $fileName file name
     * @return string full path of uploaded file
     */
    public function uploadFile($fileName)
    {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . DS . 'stock-trading' . DS . 'src' . DS . 'Files' . DS . 'Uploaded';
        $targetFile = $targetDir . DS . 'stock_data_csv_' . date('Y-m-d-H-i-s');
        if (!move_uploaded_file($fileName, $targetFile)) {
            return false;
        }

        return $targetFile;
    }

    /**
     * Cheks if a given date is within the range or not
     * @param string $from from date
     * @param string $to to date
     * @param string $givenDate given date
     * @return boolean true/false
     */
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
