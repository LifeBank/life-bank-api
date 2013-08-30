<?php

use \Slim\Slim;

$app = Slim::getInstance();


$app->get('/user/get', function () use ($app) {
            $user_id = (int) $app->request->get('id');
            if (!$user_id) {
                send_response(array("status" => 0, "errors" => array("User ID not recieved")));
            }

            try {
                $user = Sentry::getUserProvider()->findById($user_id);
                send_response(array("status" => 1, "user" => get_user_attributes($user)));
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                send_response(array("status" => 0, "errors" => array('User not found')));
            }
        });



$app->post('/user/login', function () use ($app) {
            $error_occured = false;
            $loginValidator = new App\Services\Validators\LoginValidator($app->request->params());

            if ($loginValidator->passes()) {

                $data = $loginValidator->getData();

                try {

                    $user = Sentry::getUserProvider()->findByCredentials(array(
                        'email' => $data['email'],
                        'password' => $data['password']
                            ));
                } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    $error_occured = true;
                    send_response(array("status" => 0, "errors" => array('Invalid login credentials')));
                }

                if (!$error_occured)
                    send_response(array("status" => 1, "user" => get_user_attributes($user)));
            } else {
                $errors = $loginValidator->getValidator()->messages()->all();
                send_response(array("status" => 0, "errors" => $errors));
            }
        });


$app->post('/user/registration', function () use ($app) {
            $error_occured = false;
            $signupValidator = new App\Services\Validators\SignupValidator($app->request->params());

            if ($signupValidator->passes()) {

                $data = $signupValidator->getData();

                try {

                    $user = Sentry::register(array(
                                'email' => $data['email'],
                                'password' => $data['password'],
                                'first_name' => $data['first_name'],
                                'last_name' => $data['last_name'],
                                'phone_number' => $data['phone_number'],
                                'location' => $data['location'],
                                'blood_group' => $data['blood_group'],
                                'image_path' => $data['image_path'],
                                'status' => 1,
                                'permissions' => array(
                                    'test' => 1,
                                    'other' => -1,
                                    'admin' => 1
                                )
                            ));
                } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
                    $error_occured = true;
                    send_response(array("status" => 0, "errors" => array('User with email already exists')));
                }

                if (!$error_occured)
                    send_response(array("status" => 1, "message" => "User registered successfully"));
            } else {
                $errors = $signupValidator->getValidator()->messages()->all();
                send_response(array("status" => 0, "errors" => $errors));
            }
        });



$app->post('/user/update', function () use ($app) {
            $user_id = (int) $app->request->post('id');
            if (!$user_id) {
                send_response(array("status" => 0, "errors" => array("User ID not recieved")));
            }

            $updateValidator = new App\Services\Validators\UpdateValidator($app->request->params());

            if ($updateValidator->passes()) {

                $data = $updateValidator->getData();

                try {

                    $user = Sentry::getUserProvider()->findById($user_id);

                    $user->first_name = $data['first_name'];
                    $user->last_name = $data['last_name'];
                    $user->phone_number = $data['phone_number'];
                    $user->location = $data['location'];
                    $user->blood_group = $data['blood_group'];
                    
                    $user->save();
                } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    send_response(array("status" => 0, "errors" => array('User with email already exists')));
                }

                send_response(array("status" => 1, "message" => "User registered successfully"));
            } else {
                $errors = $updateValidator->getValidator()->messages()->all();
                send_response(array("status" => 0, "errors" => $errors));
            }
        });

function get_user_attributes($user) {
    $attributes = array();
    $attributes['id'] = $user->id;
    $attributes['email'] = $user->email;
    $attributes['phone_number'] = $user->phone_number;
    $attributes['location'] = Location::where('short_name', '=', "ikoyi")->get();
    $attributes['blood_group'] = $user->blood_group;
    $attributes['image_path'] = $user->image_path;
    $attributes['status'] = $user->status;
    $attributes['first_name'] = $user->first_name;
    $attributes['last_name'] = $user->last_name;
    $attributes['created_at'] = $user->created_at;
    $attributes['updated_at'] = $user->updated_at;




    return $attributes;
}

