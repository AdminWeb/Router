<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14/07/18
 * Time: 12:26
 */
require 'vendor/autoload.php';

use AW\Router;
use AW\Request as Request;

$router = new Router(new Request($_SERVER, $_POST, $_GET));

class Teste{
    public function home(Request $request)
    {
        echo "eu {$request->show} com {$request->marombada}";
    }
}

$router->get('/', function () {
    echo 'start';
});
$router->get('/data', function () {
    echo 'get data';
});
$router->post('/data', function (Request $request) {
    echo 'post data';
});
$router->get('/datas/:var', function (Request $request) {
    echo 'datas ' . $request->var;
});
$router->get('/date/:show', function (Request $request) {
    echo 'date ' . $request->show;
});
$router->get('/data/:show/denovo', function (Request $request) {
    echo 'show: ' . $request->show;
});
$router->get('/data/:show/denovo/:marombada', 'Teste@home');

$router->run();