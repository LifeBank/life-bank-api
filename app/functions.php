<?php
use \Slim\Slim;

function send_response($response) {    
    $app = Slim::getInstance();

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($response);
}

?>
