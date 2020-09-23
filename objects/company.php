<?php
class Company{
    private $conn;
    private $table = 'company';

    public $compId;
    public $company;

    public function __construct($db){
        $this->conn = $db;
        $this->conn->beginTransaction();
    }

    public function create(){
        try{
        $sql = "INSERT INTO
                ". $this->table ."
              SET company=:company";
              
        $stmt = $this->conn->prepare($sql);
        
        //sanitize
        $this->company = htmlspecialchars(strip_tags($this->company));

        $stmt->bindParam(':company',$this->company);

        // print_r($this->company);exit;

        //execute query
        // if($stmt->execute()){
        //     return true;
        // }else{
        //     print_r($stmt->errorInfo());
        //     return false;
        // }
        $stmt->execute();

        $this->conn->commit();
        }catch(Exception $e){
            $this->conn->rollBack();
        }
    }

    public function read(){
        $sql = "SELECT * FROM
                ". $this->table ."
               ORDER BY compId";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();

        return $stmt;

    }

    public function readOne(){

        $sql = "SELECT * FROM
                ". $this->table ."
               WHERE compId=:compId LIMIT 0,1"; 
        
        $stmt = $this->conn->prepare($sql); 
        
        $stmt->bindParam(":compId",$this->compId,PDO::PARAM_INT);
        // $arrId = str_split($this->compId);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->compId = $row['compId'];
        $this->company = $row['company'];
    }

    public function update(){
        try{
        $sql = "UPDATE 
                ". $this->table ."
            SET 
                company=:company WHERE compId=:compId";

        $stmt = $this->conn->prepare($sql);  

        //sanitize
        $this->company = htmlspecialchars(strip_tags($this->company));
        $this->compId = htmlspecialchars(strip_tags($this->compId));

        //bind values
        $stmt->bindParam(":compId",$this->compId);
        $stmt->bindParam(":company",$this->company);

        // if($stmt->execute()){
        //     return true;
        // }else{
        //     print_r($stmt->errorInfo());
        //     return false;

        // }
        $stmt->execute();

        $this->conn->commit();
        }catch(Exception $e){
            $this->conn->rollBack();
        }


        
        
    }




}