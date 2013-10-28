<?php
use \Slim\Slim;
$app = Slim::getInstance();

$app->get('/bloodgroups/all', function () use ($app) {
             $blood_groups = array(
                 'Not Sure',
                 'A-',
                 'A+',
                 'AB-',
                 'B-',
                 'B+',
                 'O-',
                 'O+'
             );
             send_response($blood_groups);
        });
?>
