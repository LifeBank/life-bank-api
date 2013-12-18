<?php

use \Slim\Slim;

$app = Slim::getInstance();

$app->get('/hospital/list', function () use ($app) {
    $hospitals = Hospital::all()->toArray();
    send_response(array("status" => 1, "hospitals" => $hospitals));
});

$app->get('/hospital/get', function () use ($app) {
    $hospital_id = (int) $app->request()->get('hospital_id');
    if (!$hospital_id) {
        send_response(array("status" => 0, "errors" => array("Hospital ID not recieved")));
    }

    $hospital = get_hospital($hospital_id);

    if (is_null($hospital)) {
        send_response(array("status" => 0, "errors" => array("Hospital not found")));
    } else {
        send_response(array("status" => 1, "hospital" => $hospital));
    }
});

$app->post('/hospital/add_location', function () use ($app) {
    $hospital_id = (int) $app->request()->post('hospital_id');
    $location_id = (int) $app->request()->post('location_id');

    if (!$hospital_id || !$location_id) {
        send_response(array("status" => 0, "errors" => array("Location ID and Hospital ID expected")));
    }

    $hLocation = new HospitalLocation();
    $hLocation->hospital_id = $hospital_id;
    $hLocation->location_id = $location_id;
    $saved = $hLocation->save();

    if ($saved) {
        send_response(array("status" => 1, "message" => "Hospital Location Saved"));
    } else {
        send_response(array("status" => 0, "errors" => array("An error occured")));
    }
});

$app->post('/hospital/broadcast', function () use ($app) {
    $hospital_id = (int) $app->request()->post('hospital_id');
    $message = $app->request()->post('message');
    $blood_groups = (array) $app->request()->post('blood_groups');

    if (!$hospital_id || !$message) {
        send_response(array("status" => 0, "errors" => array("Message and Hospital ID expected")));
    }

    if (empty($blood_groups)) {
        send_response(array("status" => 0, "errors" => array("Blood group expected")));
    }


    $blood_groups = "('" . implode("','", $blood_groups) . "')";
    $users = UserHospital::select('users.email')->join('users', 'users.id', '=', 'user_hospital.user_id')->whereRaw("hospital_id = $hospital_id AND blood_group IN {$blood_groups}")->get();
    //var_dump($users);

    $emails = array();
    foreach ($users as $user) {
        $emails[] = $user->email;
    }

    $hospital = get_hospital($hospital_id);
    $to = implode(",", $emails);
    $subject = "{$hospital->hospital_name} needs blood";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= 'From: <donate@lifebankapp.com>' . "\r\n";

    mail($to, $subject, $message, $headers);
    
    send_response(array("status" => 1, "message" => $users->toArray(), $blood_groups, $hospital_id));
});

$app->post('/hospital/delete_location', function () use ($app) {
    $hospital_id = (int) $app->request()->post('hospital_id');
    $location_id = (int) $app->request()->post('location_id');

    if (!$hospital_id || !$location_id) {
        send_response(array("status" => 0, "errors" => array("Location ID and Hospital ID expected")));
    }

    $deleted = false;
    $hLocation = HospitalLocation::whereRaw('location_id = ? AND hospital_id = ?', array($location_id, $hospital_id))->first();

    if (!is_null($hLocation)) {
        $deleted = $hLocation->delete();
    }

    if ($deleted) {
        send_response(array("status" => 1, "message" => "Hospital Location Deleted"));
    } else {
        send_response(array("status" => 0, "errors" => array("An error occured")));
    }
});

$app->get('/hospital/get_locations', function () use ($app) {
    $hospital_id = (int) $app->request()->get('hospital_id');
    if (!$hospital_id) {
        send_response(array("status" => 0, "errors" => array("Hospital ID not recieved")));
    }

    $locations = Hospital::find($hospital_id)->locations->toArray();



    if (is_null($locations)) {
        send_response(array("status" => 1, "locations" => array()));
    } else {
        $hospital = get_hospital($hospital_id);
        $all_locations = Location::all()->toArray();
        send_response(array("status" => 1, "locations" => $locations, "hospital" => $hospital, "all_locations" => $all_locations));
    }
});


$app->get('/hospital/get_by_name', function () use ($app) {
    $hospital_name = $app->request()->get('hospital_name');
    if (!$hospital_name) {
        send_response(array("status" => 0, "errors" => array("Hospital name not recieved")));
    }

    $hospital = get_hospital_by_name($hospital_name);

    if (is_null($hospital)) {
        send_response(array("status" => 0, "errors" => array("Hospital not found")));
    } else {
        send_response(array("status" => 1, "hospital" => $hospital));
    }
});

$app->get('/hospital/delete', function () use ($app) {
    $hospital_id = (int) $app->request()->get('hospital_id');
    if (!$hospital_id) {
        send_response(array("status" => 0, "errors" => array("Hospital ID not recieved")));
    }

    $hospital = Hospital::where('id', '=', $hospital_id)->first();
    $deleted = $hospital->delete();

    if (!$deleted) {
        send_response(array("status" => 0, "errors" => array("An error occured")));
    } else {
        send_response(array("status" => 1, "success" => "Hospital has been deleted"));
    }
});

$app->post('/hospital/add', function () use ($app) {
    $hospitalValidator = new App\Services\Validators\HospitalValidator($app->request()->params());

    if ($hospitalValidator->passes()) {
        $data = $hospitalValidator->getData();

        if (!is_null(get_hospital_by_name($data['hospital_name']))) {
            $error = "Hospital exists already";
        } else {
            $hospital = new Hospital;
            $hospital->fill($data);
            $saved = $hospital->save();

            if (!$saved) {
                $error = "An error occured";
            }
        }


        if (!isset($error)) {
            send_response(array("status" => 1, "message" => "Hospital added successfully"));
        } else {
            send_response(array("status" => 0, "errors" => array($error)));
        }
    } else {
        $errors = $hospitalValidator->getValidator()->messages()->all();
        send_response(array("status" => 0, "errors" => $errors));
    }
});

function get_hospital($hospital_id) {
    return get_hospital_attr(Hospital::where('id', '=', $hospital_id)->first());
}

function get_hospital_by_name($hospital_name) {
    return get_location_attr(Hospital::where('hospital_name', $hospital_name)->first());
}

function get_hospital_attr($row) {
    if (is_null($row)) {
        return $row;
    }
    return $row->toArray();
}

?>
