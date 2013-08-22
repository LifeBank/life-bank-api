<?php
use \Slim\Slim;
$app = Slim::getInstance();

$app->get('/locations/all', function () use ($app) {
             $locations = Location::all();
             send_response($locations);
        });
?>
