<?php

use \Slim\Slim;

$app = Slim::getInstance();


$app->get('/faq/list', function () use ($app) {
    $faqs = Faq::all()->toArray();
    send_response(array("status" => 1, "faqs" => $faqs));
});


$app->get('/faq/delete', function () use ($app) {
    $faq_id = (int) $app->request()->get('faq_id');
    if (!$faq_id) {
        send_response(array("status" => 0, "errors" => array("FAQ ID not recieved")));
    }

    $faq = Faq::where('id', '=', $faq_id)->first();
    $deleted = $faq->delete();

    if (!$deleted) {
        send_response(array("status" => 0, "errors" => array("An error occured")));
    } else {
        send_response(array("status" => 1, "success" => "FAQ has been deleted"));
    }
});

$app->post('/faq/add', function () use ($app) {
    $faqValidator = new App\Services\Validators\FaqValidator($app->request()->params());

    if ($faqValidator->passes()) {
        $data = $faqValidator->getData();

        $faq = new Faq;
        $faq->fill($data);
        $saved = $faq->save();

        if (!$saved) {
            $error = "An error occured";
        }


        if (!isset($error)) {
            send_response(array("status" => 1, "message" => "FAQ added successfully"));
        } else {
            send_response(array("status" => 0, "errors" => array($error)));
        }
    } else {
        $errors = $faqValidator->getValidator()->messages()->all();
        send_response(array("status" => 0, "errors" => $errors));
    }
});

?>
