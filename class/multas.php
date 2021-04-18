<?php
    class Multas{

        // Connection
        private $conn;

        // Table
        private $db_table = "permisos_multas";

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getMultas(){
            $sqlQuery = "SELECT  patente, vehiculo, valor_permiso, interes_reajuste, multas, subtotal  FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createMulta(){

            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        patente = :patente,
                        vehiculo = :vehiculo,
                        valor_permiso = :valor_permiso,
                        interes_reajuste = :interes_reajuste,
                        multas = :multas,
                        subtotal = :subtotal";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->patente=htmlspecialchars(strip_tags($this->patente));
            $this->vehiculo=htmlspecialchars(strip_tags($this->vehiculo));
            $this->valor_permiso=htmlspecialchars(strip_tags($this->valor_permiso));
            $this->interes_reajuste=htmlspecialchars(strip_tags($this->interes_reajuste));
            $this->multas=htmlspecialchars(strip_tags($this->multas));
            $this->subtotal=htmlspecialchars(strip_tags($this->subtotal));

            // bind data
            $stmt->bindParam(":patente", $this->patente);
            $stmt->bindParam(":vehiculo", $this->vehiculo);
            $stmt->bindParam(":valor_permiso", $this->valor_permiso);
            $stmt->bindParam(":interes_reajuste", $this->interes_reajuste);
            $stmt->bindParam(":multas", $this->multas);
            $stmt->bindParam(":subtotal", $this->subtotal);

            if($stmt->execute()){
               return true;
            }
            return false;
        }


        // GET DATOS PATENTE
        public function getSingleMulta(){
            $sqlQuery = "SELECT
                        patente,
                        vehiculo,
                        valor_permiso,
                        interes_reajuste,
                        multas,
                        subtotal
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
            $this->vehiculo = $dataRow['vehiculo'];
            $this->valor_permiso = $dataRow['valor_permiso'];
            $this->interes_reajuste = $dataRow['interes_reajuste'];
            $this->multas = $dataRow['multas'];
            $this->subtotal = $dataRow['subtotal'];
        }        

        // UPDATE
        public function updateMulta(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        interes_reajuste = :interes_reajuste,
                        multas = :multas,
                        subtotal = :multas + :interes_reajuste + valor_permiso
                    WHERE 
                        patente = :patente";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->patente=htmlspecialchars(strip_tags($this->patente));
            $this->valor_permiso=htmlspecialchars(strip_tags($this->valor_permiso));
            $this->interes_reajuste=htmlspecialchars(strip_tags($this->interes_reajuste));
            $this->multas=htmlspecialchars(strip_tags($this->multas));
        
            // bind data
            $stmt->bindParam(":patente", $this->patente);
            $stmt->bindParam(":valor_permiso", $this->valor_permiso);
            $stmt->bindParam(":interes_reajuste", $this->interes_reajuste);
            $stmt->bindParam(":multas", $this->multas);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }


    }
?>

