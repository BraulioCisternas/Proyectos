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
    
    $data = json_decode(file_get_contents("php://input"));
    
   // $item->id = $data->id;
    
    // multa values
    $item->patente = $data->patente;
    $item->valor_permiso = $data->valor_permiso;
    $item->interes_reajuste = $data->interes_reajuste;
    $item->multas = $data->multas;
    
    if($item->updateMulta()){
        echo json_encode("Patente actualizada");
        location.replace("index.html");
    } else{
        echo json_encode("Error al actualizar patente");
    }
?>