<?php
namespace App;

// use App\Utility;

include('Utility.php');

$route = $_POST['controller'];
$action = $_POST['action'];

$utility = new Utility();
$response = $utility->invokeFunction($route, $action);
