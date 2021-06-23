<?php

require __DIR__ .  '/vendor/autoload.php';


MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398');

$dato = json_decode($_REQUEST['payment']);
$datos = [
    'topic'     => $_REQUEST['topic'],
    'id'        => $_REQUEST['id'],
    "live_mode" => $_REQUEST['live_mode'],
    "type"      => $_REQUEST['type'],
    "date_created"  => $_REQUEST['date_created'],
    "application_id"=> $_REQUEST['application_id'],
    "user_id"       => $_REQUEST['user_id'],
    "version"       => $_REQUEST['version'],
    "api_version"   => $_REQUEST['api_version'],
    "action"        => $_REQUEST['action'],
    "data"          => $_REQUEST['data'],
];

if($_REQUEST['topic']=="payment" || $_REQUEST['topic'=="merchant_order"]){
    file_put_contents('webhook.log', json_encode($dato) . PHP_EOL,FILE_APPEND);
}

$payment = fopen("pagos.txt", "a");
$json = file_get_contents('php://input');
fwrite($payment, "================" . PHP_EOL);
fwrite($payment, $json);
fwrite($payment, "================ POST" . PHP_EOL);
fwrite($payment, $_POST);
fwrite($payment, "================ GET" . PHP_EOL);
fwrite($payment, $_GET);
fwrite($payment, "================ REQUEST" . PHP_EOL);
fwrite($payment, $_REQUEST);
fclose($payment);

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