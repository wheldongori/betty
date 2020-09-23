<?php
class Department{
    private $conn;
    private $table = 'dept';

    public $deptId;
    public $department;

    public function __construct($db){
        $this->conn = $db;
        $this->conn->beginTransaction();
    }

    public function create(){
        try{
        $sql = "INSERT INTO
                ". $this->table ."
              SET department=:department";
              
        $stmt = $this->conn->prepare($sql);
        
        //sanitize
        $this->department = htmlspecialchars(strip_tags($this->department));

        $stmt->bindParam(':department',$this->department);

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
               ORDER BY deptId";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();

        return $stmt;

    }

    public function readOne(){

        $sql = "SELECT * FROM
                ". $this->table ."
               WHERE deptId=:deptId LIMIT 0,1"; 
        
        $stmt = $this->conn->prepare($sql); 
        
        $stmt->bindParam(":deptId",$this->deptId,PDO::PARAM_INT);
        // $arrId = str_split($this->deptId);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->deptId = $row['deptId'];
        $this->department = $row['department'];
    }

    public function update(){
        try{
        $sql = "UPDATE 
                ". $this->table ."
            SET 
                department=:department WHERE deptId=:deptId";

        $stmt = $this->conn->prepare($sql);  

        //sanitize
        $this->department = htmlspecialchars(strip_tags($this->department));
        $this->deptId = htmlspecialchars(strip_tags($this->deptId));

        //bind values
        $stmt->bindParam(":deptId",$this->deptId);
        $stmt->bindParam(":department",$this->department);

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