<?php
session_start();

if(!isset($_SESSION['id'])){
       header("Location:/auth/login.php");
   }elseif($_SESSION['role'] != 'supervisor'){
       header("Location:/auth/login.php");
   }elseif($_SESSION['role'] == 'employee'){
       header("Location:/auth/login.php");
   }elseif($_SESSION['role'] == 'manager'){
       header("Location:/auth/login.php");
   }
   
include_once '../config/config.php';
//include config files
require_once(WEB_ROOT.'config/database.php');
require_once(WEB_ROOT.'objects/employee.php');

$database = Database::getInstance();
$db = $database->getConnection();

$employee = new Employee($db);

$id = (isset($_GET['req']) && $_GET['req'] != '') ? $_GET['req'] : '';

$employee->empid = $id;

$employee->readOne();



include_once(WEB_ROOT.'templates/header.php');




?>
<div class="container">

<h2> EMPLOYEE DETAILS:</h2>
                        
                        <table style = " font-family: arial, sans-serif;border-collapse: collapse; width = 70%;">     
					</tr>
                        <tr>
					    <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>Surname:</strong></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$employee->surname;?></td>
					   </tr>
                       <tr>
					    <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>Other Names:</strong></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$employee->otherNames;?></td>
					   </tr>
                       <tr>
					    <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>Date of Birth:</strong></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$employee->DoB;?></td>
					   </tr>
                       <tr>
					    <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>Gender:</strong></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$employee->gender;?></td>
					   </tr>
                    </tr>
              
                    </table>
                    <br/>

                     
   <a href="list.php" class="btn btn-primary   ">  
          Back</a>   <a href="edit.php?req=<?=$employee->empid;?>" class="btn btn-success pull-right  ">  
          edit</a>
          <?php
          include_once(WEB_ROOT.'templates/footer.php');