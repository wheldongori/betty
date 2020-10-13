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

$id = (isset($_GET['req']) && $_GET['req'] != '') ? $_GET['req'] : '';

include_once '../config/config.php';
//include config files
require_once(WEB_ROOT.'config/database.php');
require_once(WEB_ROOT.'objects/department.php');

$database = Database::getInstance();
$db = $database->getConnection();

$dept = new Department($db);

$dept->deptId = $id;

$record = $dept->readOne();

include_once(WEB_ROOT.'templates/header.php');

?>
<div class="container">

<h2> DEPARTMENT DETAILS:</h2>
                        
                        <table style = " font-family: arial, sans-serif;border-collapse: collapse; width = 70%;">     
					</tr>
                        <tr>
					    <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>Department Id:</strong></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$dept->deptId;?></td>
					   </tr>
                       <tr>
					    <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>Department:</strong></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$dept->department;?></td>
					   </tr>
                    </tr>
              
                    </table>
                    <br/>

                     
   <a href="list.php" class="btn btn-primary   ">  
          Back</a>   <a href="edit.php?req=<?=$dept->deptId;?>" class="btn btn-success pull-right  ">  
          edit</a>
          <?php
          include_once(WEB_ROOT.'templates/footer.php');