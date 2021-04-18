<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/pagos.php';

    $database = new Database();
    $db = $database->getConnection();

    $itempago = new Pagos($db);

    $datapago = json_decode(file_get_contents("php://input"));
    //$datapago = json_decode(file_get_contents(FormData()));

    //$datapago = json_decode($datos)

    $itempago->patente = $datapago->patente;
    //$itempago->fecha_pago = $datapago->fecha_pago;
    $itempago->valor_permiso = $datapago->valor_permiso;
    $itempago->interes_reajuste = $datapago->interes_reajuste;
    $itempago->multas = $datapago->multas;
   

            if($itempago->creaPago()){
                json_encode("Pago realizado");
            } else{
                json_encode("Pago  no realizado");
            }
        
   
?>