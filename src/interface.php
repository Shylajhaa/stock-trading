<?php

const DS = DIRECTORY_SEPARATOR;
require $_SERVER['DOCUMENT_ROOT'] . DS . "stock-trading" . DS . "vendor" . DS . "autoload.php";

use App\Utility\Utility;

$route = $_POST['controller'];
$action = $_POST['action'];

$utility = new Utility();
$response = $utility->invokeFunction($route, $action);
