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
require_once(WEB_ROOT.'objects/company.php');

$database = Database::getInstance();
$db = $database->getConnection();

$comp = new Company($db);

$comp->compId = $id;

$record = $comp->readOne();

include_once(WEB_ROOT.'templates/header.php');

?>
<div class="container">

<h2> COMPANY DETAILS:</h2>
                        
                        <table style = " font-family: arial, sans-serif;border-collapse: collapse; width = 70%;">     
					</tr>
                        <tr>
					    <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>Company Id:</strong></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$comp->compId;?></td>
					   </tr>
                       <tr>
					    <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>Company:</strong></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$comp->company;?></td>
					   </tr>
                    </tr>
              
                    </table>
                    <br/>

                     
   <a href="list.php" class="btn btn-primary   ">  
          Back</a>   <a href="edit.php?req=<?=$comp->compId;?>" class="btn btn-success pull-right  ">  
          edit</a>
          <?php
          include_once(WEB_ROOT.'templates/footer.php');