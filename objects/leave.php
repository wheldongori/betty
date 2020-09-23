<?php
class Leave{
    private $conn;
    private $table = 'off';
    private $table2 = 'employee';
    private $table4 = 'empHist';
    private $table5 = 'role';
    private $table6 = 'leaveType';
    private $table7 = 'leaveStatus';

    public $leaveId;
    public $startDate;
    public $end_Date;
    public $No_Of_Days;
    public $reason;
    public $datePosted;
    public $empid;
    public $adminRemark;
    public $leaveTid;
    public $leaveStatusId;
    public $ave_leave;

    public function __construct($db){
        $this->conn = $db;
        $this->conn->beginTransaction();
    }

    public function create(){
        try{
        $sql = "INSERT INTO
                ". $this->table ."
              SET startDate=:startDate, end_Date=:end_Date, No_Of_Days=:No_Of_Days, reason=:reason,
                  datePosted=:datePosted, empid=:empid, leaveTid=:leaveTid, 
                  leaveStatusId=:leaveStatusId, available_leave=:available_leave";

        $stmt = $this->conn->prepare($sql);

        $this->startDate = htmlspecialchars(strip_tags($this->startDate));
        $this->end_Date = htmlspecialchars(strip_tags($this->end_Date));
        $this->No_Of_Days = htmlspecialchars(strip_tags($this->No_Of_Days));
        $this->reason = htmlspecialchars(strip_tags($this->reason));
        $this->datePosted = htmlspecialchars(strip_tags($this->datePosted));
        $this->empid = htmlspecialchars(strip_tags($this->empid));
        // $this->adminRemark = htmlspecialchars(strip_tags($this->adminRemark));
        $this->leaveTid = htmlspecialchars(strip_tags($this->leaveTid));
        // $this->leaveStatusId = htmlspecialchars(strip_tags($this->leaveStatusId));
        $this->ave_leave = htmlspecialchars(strip_tags($this->ave_leave));

        // print_r($this->datePosted);exit;



        $stmt->bindParam(':startDate',$this->startDate);
        $stmt->bindParam(':end_Date',$this->end_Date);
        $stmt->bindParam(':No_Of_Days',$this->No_Of_Days);
        $stmt->bindParam(':reason',$this->reason);
        $stmt->bindParam(':datePosted',$this->datePosted);
        $stmt->bindParam(':empid',$this->empid,PDO::PARAM_INT);
        // $stmt->bindParam(':adminRemark',$this->adminRemark);
        $stmt->bindParam(':leaveTid',$this->leaveTid,PDO::PARAM_INT);
        $stmt->bindParam(':leaveStatusId',$this->leaveStatusId,PDO::PARAM_INT);
        $stmt->bindParam(':available_leave',$this->ave_leave,PDO::PARAM_INT);

        // print_r($stmt);
        // $stmt->debugDumpParams();

        $stmt->execute();

        $this->conn->commit();
        
        }catch(Exception $e){
            $this->conn->rollBack();
        }
    }

    public function read(){
        
        $sql = "SELECT surname,otherNames,gender,role,ave_leave FROM
                ". $this->table4 ."
              INNER JOIN ". $this->table2 ." ON ". $this->table4. ".empid = ". $this->table2 . ".empid 
              INNER JOIN ". $this->table5 ." ON ". $this->table4 .".id =  ". $this->table5 .".id 
              WHERE ". $this->table2 . ".empid = :empid";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':empid',$this->empid,PDO::PARAM_INT);

        // if($stmt->execute()){
            // $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // }else{
        //     print_r($stmt->errorInfo());
        // }
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        

        return $row;


    }

    public function readTypes(){

        $sql = "SELECT * FROM
                ". $this->table6 ."
               ORDER BY leaveTid";

        $stmt = $this->conn->prepare($sql);
        
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
        }

        return $stmt;
    }

    public function readLastLeave(){
                $sql = "SELECT * FROM 
                        ". $this->table ."
                        INNER JOIN ". $this->table2 ." ON ". $this->table .".empid = ". $this->table2 .".empid
                        INNER JOIN ".$this->table4 ." ON .". $this->table4.".empid = ".$this->table.".empid
                        INNER JOIN ". $this->table5." ON ".$this->table5. ".id = ". $this->table4 .".id
                        WHERE ".$this->table. " .empid=:empid  ORDER BY leaveId DESC LIMIT 0,1";
        
                $stmt = $this->conn->prepare($sql);
        
                $stmt->bindParam(':empid',$this->empid,PDO::PARAM_INT);

                // print_r($stmt);
        
                if($stmt->execute()){
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                }else{
                    print_r($stmt->errorInfo());
                }
                // $stmt->execute();
                // $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
        
                return $row;       
    }

    public function listLeaves(){
        $sql = "SELECT * FROM 
                ". $this->table ."
                INNER JOIN ". $this->table2 ." ON ".$this->table2 .".empid = ". $this->table. ".empid
                INNER JOIN ". $this->table7 ." ON ". $this->table .".leaveStatusId = ". $this->table7 .".leaveStatusId 
                WHERE ". $this->table .".empid=:empid ORDER BY leaveId DESC";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(":empid",$this->empid,PDO::PARAM_INT);
// print_r($sql);echo"<br/>";
        $stmt->execute();

        $result = $stmt->fetchAll();

        // $this->conn->commit();

        return $result;

        
    }

    public function readPendingLeaves(){
        $sql = "SELECT * FROM 
                ". $this->table ."
                INNER JOIN ". $this->table2 ." ON ".$this->table2 .".empid = ". $this->table. ".empid
                INNER JOIN ". $this->table7 ." ON ". $this->table .".leaveStatusId = ". $this->table7 .".leaveStatusId 
                WHERE ". $this->table .".leaveStatusId=:leaveStatusId ORDER BY leaveId DESC";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(":leaveStatusId",$this->leaveStatusId,PDO::PARAM_INT); 
        // print_r($sql);echo "<br/>";
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
        }

        $result = $stmt->fetchAll();

        // $this->conn->commit();

        return $result;
    }



    public function readLeave(){
        $sql = "SELECT * FROM 
                ". $this->table ."
                INNER JOIN ". $this->table2 ." ON ". $this->table .".empid = ". $this->table2 .".empid
                INNER JOIN ".$this->table4 ." ON .". $this->table4.".empid = ".$this->table.".empid
                INNER JOIN ". $this->table5." ON ".$this->table5. ".id = ". $this->table4 .".id
                WHERE ".$this->table. " .leaveId=:leaveId ";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(":leaveId",$this->leaveId,PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function readStatus(){
        $sql = "SELECT * FROM
                ". $this->table7 ."
                  ORDER BY leaveStatusId ASC";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute();

        return $stmt;
    }

    public function update(){
        try{
        $sql = "UPDATE 
                ".$this->table ."
               SET adminRemark=:adminRemark,leaveStatusId=:leaveStatusId,available_leave=:ave_leave WHERE leaveId=:leaveId";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(":adminRemark",$this->adminRemark);
        $stmt->bindParam(":leaveStatusId",$this->leaveStatusId,PDO::PARAM_INT);
        $stmt->bindParam(":leaveId",$this->leaveId,PDO::PARAM_INT);
        $stmt->bindParam(":ave_leave",$this->ave_leave,PDO::PARAM_INT);

        // print_r($this->ave_leave);exit;

        $stmt->execute();

        $this->conn->commit();

    }catch(Exception $e){

        $this->conn->rollBack();
    }


    }


}
