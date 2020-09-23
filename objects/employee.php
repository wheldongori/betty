<?php
    class Employee{
        private $conn;
        private $table = 'employee';
    

        public $empid;
        public $surname;
        public $otherNames;
        public $password;
        public $gender;
        public $DoB;

        public function __construct($db){
            $this->conn = $db;
            $this->conn->beginTransaction();
        }

        public function create(){
            try{    
                    //write query
        $sql = "INSERT INTO
        " . $this->table . "
    SET
        surname=:surname, otherNames=:otherNames, password=:password, gender=:gender, DoB=:DoB";
            
            $stmt = $this->conn->prepare($sql);

            // sanitize
            $this->surname=htmlspecialchars(strip_tags($this->surname));
            $this->otherNames=htmlspecialchars(strip_tags($this->otherNames));
            $this->password=htmlspecialchars(strip_tags($this->password));
            //encrypt password
            $this->password = password_hash($this->password,PASSWORD_BCRYPT);
            $this->gender=htmlspecialchars(strip_tags($this->gender));
            $this->DoB=htmlspecialchars(strip_tags($this->DoB));

            // print_r($stmt);exit;

            //bind values
            $stmt->bindParam(":surname", $this->surname);
            $stmt->bindParam(":otherNames", $this->otherNames);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":gender", $this->gender);
            $stmt->bindParam(":DoB", $this->DoB);

            // print_r($this->DoB);exit;
            // $stmt->debugDumpParams();exit;
            
           $stmt->execute();
                
            //     return true;
                
            // }else{
                // echo 'not done <br/>';
                // print_r($stmt->errorInfo());
            //     return false;
            // }

            $this->conn->commit();
            // print_r($stmt);
            }catch(Exception $e){

                $this->conn->rollBack();
                
            }
            //execute query
            // if($stmt->execute()){
                
            //     return true;
            // }else{
            //     echo 'not done <br/>';
            //     print_r($stmt->errorInfo());
            //     return false;
            // }
        }

        public function read(){
            $sql = "SELECT * FROM 
                    ". $this->table ."
                    ORDER BY empid";
                    // print_r($sql);
            
            $stmt = $this->conn->prepare( $sql );
           
            $stmt->execute();

            return $stmt;
        }

        public function readOne(){
            $sql = "SELECT * FROM 
                    ". $this->table . "
                    WHERE empid=:empid LIMIT 0,1";
            
            $stmt = $this->conn->prepare($sql);

            // $arrId = str_split($this->empid);
            $stmt->bindParam(":empid",$this->empid,PDO::PARAM_INT);

            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
            }else{

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->empid = $row['empid'];
            $this->surname = $row['surname'];
            $this->otherNames = $row['otherNames'];
            $this->password = $row['password'];
            $this->gender = $row['gender'];
            $this->DoB = $row['DoB'];
            }
        }

        public function edit(){
            try{
            $sql = "UPDATE 
                    ". $this->table . "
                SET 
                    surname=:surname, otherNames=:otherNames, password=:password, gender=:gender, DoB=:DoB WHERE empid=:id";

                    $stmt = $this->conn->prepare($sql);

                    // print_r($stmt);

                    // sanitize
                    $this->surname=htmlspecialchars(strip_tags($this->surname));
                    $this->otherNames=htmlspecialchars(strip_tags($this->otherNames));
                    $this->password=htmlspecialchars(strip_tags($this->password));
                    //encrypt password
                    $this->password = password_hash($this->password,PASSWORD_BCRYPT);
                    $this->gender=htmlspecialchars(strip_tags($this->gender));
                    $this->DoB=htmlspecialchars(strip_tags($this->DoB));
                    $this->empid=htmlspecialchars(strip_tags($this->empid));

                      //bind values
                    $stmt->bindParam(":id",$this->empid);  
                    $stmt->bindParam(":surname", $this->surname);
                    $stmt->bindParam(":otherNames", $this->otherNames);
                    $stmt->bindParam(":password", $this->password);
                    $stmt->bindParam(":gender", $this->gender);
                    $stmt->bindParam(":DoB", $this->DoB);
            // print_r($this->empid);

                    // if($stmt->execute()){
                    //     return true;
                    // }else{
                    //     print_r($stmt->errorInfo());
                    //     return false;
                    $stmt->execute();
                    // }
                    $this->conn->commit();
                    }catch(Exception $e){
                        $this->conn->rollBack();
                    }

        }

       

        public function readLast(){
            $sql = "SELECT MAX(empid) FROM 
                    ". $this->table ."
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;

        }


    }