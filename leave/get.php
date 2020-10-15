<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location:/auth/login.php");
}

// echo $_SESSION['role'];
 //include config files
include_once '../config/config.php';
require_once(WEB_ROOT.'config/database.php');
require_once(WEB_ROOT.'objects/leave.php');

$database = Database::getInstance();
$db = $database->getConnection();

$leave = new Leave($db);

$leave->empid = $_SESSION['id'];

$leaves = $leave->readLeaves();

$data= [];
    foreach($leaves as $leave){
        extract($leave);
        $data[] = $leave;
    }
    
    echo json_encode($data);

