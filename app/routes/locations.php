<?php
use \Slim\Slim;
$app = Slim::getInstance();

$app->get('/locations/all', function () use ($app) {
             $locations = Location::where('parent_id', '=', 0)->get();
             send_response($locations);
        });
?>
