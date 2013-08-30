<?php

use \Slim\Slim;

function send_response($response) {
    $app = Slim::getInstance();

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    if (is_array($response))
        $response = json_encode($response);
    $res->body($response);
    $app->stop();
}

?>
