<?php

use \Slim\Slim;

$app = Slim::getInstance();

$app->get('/location/all', function () use ($app) {
    $locations = Location::with('parent', 'state', 'hospitals')->get()->toArray();
    send_response($locations);
});

$app->get('/state/all', function () use ($app) {
    $states = State::all();
    $result = array();


    foreach ($states as $state) {
        $row = array();
        $row['id'] = $state->id;
        $row['state'] = $state->state;

        $result[] = $row;
    }
    send_response(array("status" => 1, "states" => $result));
});

$app->get('/location/list', function () use ($app) {
    $state_id = (int) $app->request()->get('state_id');
    if (!$state_id) {
        send_response(array("status" => 0, "errors" => array("State ID not recieved")));
    }

    $locations = array();
    $result = Location::where('state_id', '=', $state_id)->get();
    foreach ($result as $row) {
        $locations[] = get_location_attr($row);
    }
    send_response(array("status" => 1, "state" => get_state($state_id), "locations" => $locations));
});

$app->get('/location/get', function () use ($app) {
    $location_id = (int) $app->request()->get('location_id');
    if (!$location_id) {
        send_response(array("status" => 0, "errors" => array("Location ID not recieved")));
    }

    $location = get_location($location_id);

    if (is_null($location)) {
        send_response(array("status" => 0, "errors" => array("Location not found")));
    } else {
        send_response(array("status" => 1, "location" => $location));
    }
});

$app->get('/location/get_hospitals', function () use ($app) {
    $location_id = (int) $app->request()->get('location_id');
    if (!$location_id) {
        send_response(array("status" => 0, "errors" => array("Location ID not recieved")));
    }

    $hospitals = Location::find($location_id)->hospitals->toArray();
    

    if (is_null($hospitals)) {
        send_response(array("status" => 1, "hospitals" => array()));
    } else {
        send_response(array("status" => 1, "hospitals" => $hospitals));
    }
});

$app->get('/location/get_by_short_name', function () use ($app) {
    $short_name = $app->request()->get('short_name');
    if (!$short_name) {
        send_response(array("status" => 0, "errors" => array("Short name not recieved")));
    }

    $location = get_location_by_short_name($short_name);

    if (is_null($location)) {
        send_response(array("status" => 0, "errors" => array("Location not found")));
    } else {
        send_response(array("status" => 1, "location" => $location));
    }
});

$app->get('/location/get_by_name', function () use ($app) {
    $location = $app->request()->get('location');
    if (!$location) {
        send_response(array("status" => 0, "errors" => array("Location not recieved")));
    }

    $location = get_location_by_name($location);

    if (is_null($location)) {
        send_response(array("status" => 0, "errors" => array("Location not found")));
    } else {
        send_response(array("status" => 1, "location" => $location));
    }
});

$app->post('/location/add', function () use ($app) {
    $locationValidator = new App\Services\Validators\LocationValidator($app->request()->params());

    if ($locationValidator->passes()) {
        $data = $locationValidator->getData();
        $location1 = get_location_by_name($data['location']);
        $location2 = get_location_by_short_name($data['short_name']);

        if (!is_null($location1) || !is_null($location2)) {
            $error = "Location exists already";
        } else {
            $location = new Location;
            $location->fill($data);
            $saved = $location->save();

            if (!$saved) {
                $error = "An error occured";
            }
        }


        if (!isset($error)) {
            send_response(array("status" => 1, "message" => "Location added successfully"));
        } else {
            send_response(array("status" => 0, "errors" => array($error)));
        }
    } else {
        $errors = $locationValidator->getValidator()->messages()->all();
        send_response(array("status" => 0, "errors" => $errors));
    }
});

function get_location($location_id) {
    return get_location_attr(Location::where('id', '=', $location_id)->first());
}

function get_location_by_short_name($short_name) {
    return get_location_attr(Location::where('short_name', '=', $short_name)->first());
}

function get_location_by_name($location) {
    return get_location_attr(Location::where('location', $location)->first());
}

function get_state($state_id) {
    return get_state_attr(State::where('id', '=', $state_id)->first());
}

function get_state_attr($row) {
    if (is_null($row)) {
        return $row;
    }

    $state = array();
    $state['id'] = $row->id;
    $state['state'] = $row['state'];

    return $state;
}

function get_location_attr($row) {
    if (is_null($row)) {
        return $row;
    }

    $location = array();
    $location['id'] = $row->id;
    $location['short_name'] = $row->short_name;
    $location['location'] = $row->location;
    $location['state_id'] = $row->state_id;

    if ($row->parent_id) {
        $location['parent'] = get_location($row->parent_id);
    }

    return $location;
}

?>
