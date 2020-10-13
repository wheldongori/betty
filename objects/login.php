<?php
class Login{
    private $conn;
    private $table = 'employee';
    private $table2 = 'empHist';
    private $table3 = 'role';
    private $table4 = 'status';

    public $empid;
    public $password;

    public function __construct($db){
        $this->conn = $db;
    }

    public function login(){
        $sql = "SELECT * FROM 
                ". $this->table ."
                INNER JOIN ".$this->table2." ON " .$this->table. ".empid = ". $this->table2.".empid
                INNER JOIN ".$this->table3 ." ON ". $this->table3.".id = ".$this->table2.".id
                INNER JOIN ".$this->table4 ." ON ".$this->table4.".status_Id = ".$this->table2.".status_Id
                WHERE ".$this->table.".empid=:empid ORDER BY eid DESC LIMIT 0,1";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(":empid",$this->empid,PDO::PARAM_INT);

        // print_r($stmt);

        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }else{
            print_r($stmt->errorInfo());  
        }

        

        return $row;
    }
}