<?php

use \Slim\Slim;

//use \Validators\SignupValidator as App\Services\Validators\SignupValidator::;

$app = Slim::getInstance();

$app->post('/user/registration', function () use ($app) {
            $validator = new App\Services\Validators\SignupValidator($app->request->params());

            if ($validator->passes()) {
                echo "failed";
            } else {
                echo "success";
            }
        });
?>
