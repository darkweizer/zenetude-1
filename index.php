<?php
/**
 * Created by PhpStorm (tu veux une médaille ?).
 * User: sknz
 * Date: 05/12/14
 * Time: 03:39
 */

require 'vendor/autoload.php';

$app = new \Slim\Slim(array(
    'debug' => true
));

$app->get('/', function () {
    echo 'SWAG YOLO';
});

$app->get('/:name', function ($name) {
    echo $name;
});

$app->run();

