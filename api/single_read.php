<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/multas.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Multas($db);

    $item->patente = isset($_GET['patente']) ? $_GET['patente'] : die();
  
    $item->getSingleMulta();

    if($item->patente != null){
        // create array
        $emp_arr = array(
            //"id" => $item->id,
            "patente" => $item->patente,
            "vehiculo" => $item->vehiculo,
            "valor_permiso" => $item->valor_permiso,
            "interes_reajuste" => $item->interes_reajuste,
            "multas" => $item->multas,
            "subtotal" => $item->subtotal
            );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Datos no enconrtados");
    }
?>