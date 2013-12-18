<?php

use \Slim\Slim;

$app = Slim::getInstance();


$app->get('/user/get', function () use ($app) {
    $user_id = (int) $app->request()->get('id');
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

$app->get('/user/get_with_username', function () use ($app) {
    $username = $app->request()->get('username');
    if (!$username) {
        send_response(array("status" => 0, "errors" => array("Username not recieved")));
    }

    try {
        $userProvider = Sentry::getUserProvider();
        $model = $userProvider->createModel();
        $user = $model->newQuery()->where("username", '=', $username)->first();

        if ($user) {
            send_response(array("status" => 1, "user" => get_user_attributes($user)));
        } else {
            send_response(array("status" => 0, "errors" => array('User not found')));
        }
    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
        send_response(array("status" => 0, "errors" => array('User not found')));
    }
});

$app->get('/user/list', function () use ($app) {
    try {

        $users = array();
        $result = Sentry::getUserProvider()->findAll();

        foreach ($result as $row) {
            $users[] = get_user_attributes($row);
        }

        if ($users) {
            send_response(array("status" => 1, "users" => $users));
        } else {
            send_response(array("status" => 0, "errors" => array('User not found')));
        }
    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
        send_response(array("status" => 0, "errors" => array('User not found')));
    }
});


$app->get('/user/random', function () use ($app) {
    $count = (int) $app->request()->get('count');
    $count = ($count) ? $count : 5;

    try {

        $users = array();
        $userProvider = Sentry::getUserProvider();
        $model = $userProvider->createModel();
        $result = $model->newQuery()->where("id", '>', 0)->take($count)->get();

        foreach ($result as $row) {
            $users[] = get_user_attributes($row);
        }

        if ($users) {
            send_response(array("status" => 1, "users" => $users));
        } else {
            send_response(array("status" => 0, "errors" => array('User not found')));
        }
    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
        send_response(array("status" => 0, "errors" => array('User not found')));
    }
});

$app->get('/user/count', function () use ($app) {
    $userProvider = Sentry::getUserProvider();
    $model = $userProvider->createModel();
    $count = $model->newQuery()->where('id', '>', 0)->count();


    send_response(array("status" => 1, "count" => $count));
});



$app->post('/user/login', function () use ($app) {
    $error_occured = false;
    $loginValidator = new App\Services\Validators\LoginValidator($app->request()->params());

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
    $signupValidator = new App\Services\Validators\SignupValidator($app->request()->params());

    if ($signupValidator->passes()) {

        $data = $signupValidator->getData();

        try {

            $user = Sentry::register(array(
                        'email' => $data['email'],
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'phone_number' => $data['phone_number'],
                        'username' => $data['username'],
                        'location_id' => $data['location_id'],
                        'blood_group' => $data['blood_group'],
                        'image_path' => $data['image_path'],
                        'password' => 'nill',
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


        if (!$error_occured) {
            if ($user) {

                $userProvider = Sentry::getUserProvider();
                $model = $userProvider->createModel();
                $user = $model->newQuery()->where("username", '=', $data['username'])->first();

                $user_hospitals = (array) $data['user_hospitals'];

                add_user_hospitals($user_hospitals, $user);
                send_response(array("status" => 1, "message" => "User registered successfully"));
            } else {
                send_response(array("status" => 0, "errors" => array('An error occured')));
            }
        }
    } else {
        $errors = $signupValidator->getValidator()->messages()->all();
        $errors[] = $data['location_id'];
        send_response(array("status" => 0, "errors" => $errors));
    }
});



$app->post('/user/update', function () use ($app) {
    $user_id = (int) $app->request()->post('id');
    if (!$user_id) {
        send_response(array("status" => 0, "errors" => array("User ID not recieved")));
    }

    $updateValidator = new App\Services\Validators\UpdateValidator($app->request()->params());

    if ($updateValidator->passes()) {

        $data = $updateValidator->getData();

        try {

            $user = Sentry::getUserProvider()->findById($user_id);

            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->phone_number = $data['phone_number'];
            $user->location_id = $data['location_id'];
            $user->blood_group = $data['blood_group'];

            $saved = $user->save();
            
            UserHospital::where("user_id", $user_id)->delete();            
            add_user_hospitals((array) $data['user_hospitals'], $user);
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            send_response(array("status" => 0, "errors" => array('Unsuccessful operation')));
        }

        send_response(array("status" => 1, "message" => "User details updated {$saved}"));
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

    require_once 'locations.php';
    $attributes['location'] = get_location($user->location_id);

    $attributes['blood_group'] = $user->blood_group;
    //str_replace($attributes, $replace, $subject);
    $attributes['image_path'] = str_replace("_normal", "_bigger", $user->image_path);
    $attributes['status'] = $user->status;
    $attributes['first_name'] = $user->first_name;
    $attributes['last_name'] = $user->last_name;
    $attributes['created_at'] = $user->created_at;
    $attributes['updated_at'] = $user->updated_at;
    $attributes['username'] = $user->username;
    $attributes['hospitals'] = UserHospital::whereRaw('user_id = ?', array($user->id))->get()->toArray();




    return $attributes;
}

function add_user_hospitals($user_hospitals, $user) {
    if ($user_hospitals) {
        foreach ($user_hospitals as $hospital) {
            $uHospital = new UserHospital();
            $uHospital->hospital_id = $hospital;
            $uHospital->user_id = $user->id;
            $uHospital->save();
        }
    }
}
