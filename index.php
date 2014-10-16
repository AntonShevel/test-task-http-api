<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 10/15/14
 * Time: 12:33 AM
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

function autoLoader($class) {
    list($dir, $file) = explode('\\', $class);
    $path = $dir.DIRECTORY_SEPARATOR.$file.'.php';
    include_once $path;
}
function exceptionHandler($exception) {
    header('HTTP/1.0 400 Bad Request', true, 400);
    echo json_encode(array('error'=>$exception->getMessage()));
}

set_include_path('src');
spl_autoload_register('autoLoader');
set_exception_handler('exceptionHandler');

use \Router\Route;
use \Router\RouteCollection;
use \Router\Router;


$routeCollection = new RouteCollection();
$routeCollection->attach(new Route('/api/', array(
    'method' => 'GET',
    'action' => array('Model\Data', 'getData')
)));
$routeCollection->attach(new Route('/api/', array(
    'method' => 'PUT',
    'action' => array('Model\Data', 'saveData')
)));

$router = new Router($routeCollection);
$router->setBasePath('/http-api-test-task');

$db = new Database\Database('resource/database.db');
//$db->exec('CREATE TABLE string_data (id INTEGER PRIMARY KEY, value TEXT, time INTEGER)');
//$db->exec('CREATE TABLE binary_data (id INTEGER PRIMARY KEY, value BLOB, time INTEGER)');
$router->setParameters(array($db));

$router->checkCurrentRequest();