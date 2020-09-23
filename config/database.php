<?php
    class Database{
        private $dsn = 'mysql:dbname=leave;host=127.0.0.1';
        private $user = 'deno';
        private $password = 'Deno@1234';

        public $conn;

        public static $instance;

        

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO($this->dsn, $this->user, $this->password);
            }catch(PDOException $e){
                echo "Connection error:".$e->getMessage();
            }

            return $this->conn;
        }

        public static function getInstance(){
            if(!isset(self::$instance)){
                self::$instance = new Database();
            }
            return self::$instance;
        }

    }