<?php
   Class Pagos{

     // Connection
     private $conn;

     // Table
     private $db_table = "pagos_permisos";

     public function __construct($db){
        $this->conn = $db;
    }

 
    // CREA PAGO DE PERMISO
    public function CreaPago(){

        $sqlQuery = "INSERT INTO
                    ". $this->db_table ."
                SET
                    patente = :patente,
                    fecha_pago = curdate(),
                    monto = :interes_reajuste + :valor_permiso + :multas";
    
        $stmt = $this->conn->prepare($sqlQuery);

   // sanitize
   $this->patente=htmlspecialchars(strip_tags($this->patente));
   //$this->fecha_pago=htmlspecialchars(strip_tags($this->fecha_pago));
   $this->valor_permiso=htmlspecialchars(strip_tags($this->valor_permiso));
   $this->interes_reajuste=htmlspecialchars(strip_tags($this->interes_reajuste));
   $this->multas=htmlspecialchars(strip_tags($this->multas));

   // bind data
   $stmt->bindParam(":patente", $this->patente);
   //$stmt->bindParam(":fecha_pago", $this->fecha_pago);
   $stmt->bindParam(":valor_permiso", $this->valor_permiso);
   $stmt->bindParam(":interes_reajuste", $this->interes_reajuste);
   $stmt->bindParam(":multas", $this->multas);
 
   if($stmt->execute()){
      return true;
   }
   return false;
   }    

   // GET SINGLE
   public function getSinglePermiso(){
      $sqlQuery = "SELECT
                  patente,
                  fecha_pago,
                  monto
                FROM
                  ". $this->db_table ."
              WHERE 
                 patente = ?
              LIMIT 0,1";

      $stmt = $this->conn->prepare($sqlQuery);

      $stmt->bindParam(1, $this->patente);

      $stmt->execute();

      $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $this->patente = $dataRow['patente'];
      $this->fecha_pago = $dataRow['fecha_pago'];
      $this->monto = $dataRow['monto'];
  }        
}
?>