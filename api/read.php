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

    $item = new Pagos($db);

    $item->patente = isset($_GET['patente']) ? $_GET['patente'] : die();
  
    $item->getSinglePermiso();

    if($item->patente != null){
        // create array
        $emp_arr = array(
            //"id" => $item->id,
            "patente" => $item->patente,
            "fecha_pago" => $item->fecha_pago,
            "monto" => $item->monto
            );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Datos no enconrtados");
    }