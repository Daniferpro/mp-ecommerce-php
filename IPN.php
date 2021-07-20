<?php

header("HTTP/1.1 200 OK");
    # Sistema de notificaciones de Mercaedo Pago mendiante IPN
    # Aquí obtenemos variables mendiannnte esa notificación
    # procesamos los datos enviamamos para poder ver el estado de la compra
    # según el estado de la compra, resolvemos la habilitación o no de las suscripciones

    // topic -> Identifica de qué se trata. Puede ser payment, chargebacks o merchant_order .
    // id    ->	Es un identificador único del recurso notificado.

    include 'vendor/autoload.php';
    include 'includes.php';
    $servername = 'localhost';
    $database="radminzh_gymapp";
    $username="radminzh_gymup";
    $password="6CF*oTWp";
    $con = mysqli_connect($servername, $username, $password, $database);
    
    
    $qry = " SELECT * FROM `pagos_config_ml` WHERE `idGym` = '$_GET[idgym]' ";
    $resul = mysqli_query($con, $qry);

    if($resul){
        $mp = mysqli_fetch_assoc($resul);
        $accessToken = $mp['PrivateKey'];
    }

    $qry = " SELECT * FROM `pagos_config_ml` WHERE `idGym` = $_GET[idgym] ";
    $resul = mysqli_query($con, $qry);
    if($resul){
        $mp = mysqli_fetch_assoc($resul);
        $ACCESS_TOKEN = $mp['PrivateKey'];
    }

    //Lo primerito, creamos una variable iniciando curl, pasándole la url
    $curl = curl_init(); //iniciamos la funcion curl
    
    curl_setopt_array($curl, array(
    //ahora vamos a definir las opciones de conexion de curl
          CURLOPT_URL => "https://api.mercadopago.com/v1/payments/".$_GET['id'],//aqui iria el id de tu pago
          CURLOPT_CUSTOMREQUEST => "GET", // el metodo a usar, si mercadopago dice que es post, se cambia GET por POST.
          CURLOPT_RETURNTRANSFER => true, //esto es importante para que no imprima en pantalla y guarde el resultado en una variable
          CURLOPT_ENCODING => "",
          CURLOPT_TIMEOUT => 0, 
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$ACCESS_TOKEN
          ),
        ));
        
        
        
        $response = curl_exec($curl); //ejecutar CURL
        $json_data = json_decode($response, true); //a la respuesta obtenida de CURL la guardamos en una variable con formato json.
        
        //ahora las imprimimos en pantalla
        echo "<pre>";
        print_r($json_data); 
        echo "</pre>";
        //ahora por ejemplo, queremos obtener el status de pago, hacemos esto:
        $status=$json_data["status"];  
        $external_reference = $json_data["external_reference"];
        file_put_contents('datos.json', json_encode($json_data) . PHP_EOL,FILE_APPEND);

        updatePayment($external_reference, $status, $con, "ExternalReference");
?>