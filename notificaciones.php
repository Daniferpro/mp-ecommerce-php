<?php

require __DIR__ .  '/vendor/autoload.php';


MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398');


// $datos = [
//     'type' => $_REQUEST['type'],
//     'topic' => $_REQUEST['topic'],
//     'id' => $_REQUEST['id'],
//     "id"=> $_REQUEST['id'],
//     "live_mode": true,
//     "type": "payment",
//     "date_created": "2015-03-25T10:04:58.396-04:00",
//     "application_id": 123123123,
//     "user_id": 44444,
//     "version": 1,
//     "api_version": "v1",
//     "action": "payment.created",
//     "data": {
//         "id": "999999999"
//     }
// ];

if($_REQUEST['topic']=="payment" || $_REQUEST['topic'=="merchant_order"]){
    file_put_contents('webhook.log', $_POST["payment"] . PHP_EOL,FILE_APPEND);
}

switch ($type) {
    case "payment":
        $payment = MercadoPago\Payment::find_by_id($id);
        if (!empty($payment)) {
            header("HTTP/1.1 200 OK");

        } else {
            header("HTTP/1.1 400 NOT_OK");
        }
        break;
    case "plan":
        $plan = MercadoPago\Plan::find_by_id($id);
        if (!empty($plan)) {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 NOT_OK");
        }
        break;
    case "subscription":
        $plan = MercadoPago\Subscription::find_by_id($id);
        if (!empty($plan)) {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 NOT_OK");
        }
        break;
    case "invoice":
        $plan = MercadoPago\Invoice::find_by_id($id);
        if (!empty($plan)) {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 NOT_OK");
        }
        break;
    default:
        header("HTTP/1.1 200 OK");
        break;

}

?>