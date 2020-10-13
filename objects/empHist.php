<?php
class EmpHist{
    private $conn;
    private $table2 = 'status';
    private $table3 = 'role';
    private $table4 = 'company';
    private $table5 = 'dept';
    private $table6 = 'empHist';

    public $eid;
    public $compId;
    public $status_Id;
    public $deptId;
    public $id;
    public $empid;

    public function __construct($db){
        $this->conn = $db;
    }
    public function readStatus(){
        $sql = "SELECT * FROM
                ". $this->table2 ."
                ORDER BY status_Id";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();

        return $stmt;
    }

    public function readRoles(){
        $sql = "SELECT * FROM 
                ". $this->table3 ."
                  ORDER BY id";
        // print_r($sql);

        $stmt = $this->conn->prepare( $sql );
    
        $stmt->execute();

        return $stmt;
    }
    public function readCompanies(){
        $sql = "SELECT * FROM 
                ". $this->table4 ."
                  ORDER BY compId";
        // print_r($sql);

        $stmt = $this->conn->prepare( $sql );

        // print_r($stmt);exit;
    
        $stmt->execute();

        return $stmt;
    }

    public function readDepartments(){
        $sql = "SELECT * FROM 
                ". $this->table5 ."
                  ORDER BY deptId";
        // print_r($sql);

        $stmt = $this->conn->prepare( $sql );
    
        $stmt->execute();

        return $stmt;
    }

    public function createHist(){
        
        $sql = "CALL addHist(?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(1,$this->empid);
        $stmt->bindParam(2,$this->compId);
        $stmt->bindParam(3,$this->deptId);
        $stmt->bindParam(4,$this->status_Id);
        $stmt->bindParam(5,$this->id);

        $stmt->execute();

       
    }

    public function readHist(){
        $sql = "SELECT * FROM 
                ". $this->table6 ."
              WHERE empid=:empid ORDER BY eid DESC LIMIT 0,1";
        
        $stmt = $this->conn->prepare($sql);
        
        //sanitize
        $this->empid = htmlspecialchars(strip_tags($this->empid));

        //bind
        $stmt->bindParam(":empid",$this->empid,PDO::PARAM_INT);
        
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->empid = $row['empid'];
        $this->eid = $row['eid'];
        $this->compId = $row['compId'];
        $this->id = $row['id'];
        $this->deptId = $row['deptId'];
        $this->status_Id = $row['status_Id'];


    }

}