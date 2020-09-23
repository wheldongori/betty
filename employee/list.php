<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location:/auth/login.php");
}
 //include config files
 include_once '../config/config.php';
 require_once(WEB_ROOT.'config/database.php');
 require_once(WEB_ROOT.'objects/employee.php');

$database = Database::getInstance();
$db = $database->getConnection();

$employee = new Employee($db);

$records = $employee->read();

include_once(WEB_ROOT.'templates/header.php');

?>
<div class="container">
<div class="card-header">
          <p class="lead"> <strong>EMPLOYEES RECORDS</strong></p>   <a href="create.php" class="btn btn-primary  ">  
          <i class="fa fa-plus-circle fw-fa"></i> New</a></div><br/>
<table style = " font-family: arial, sans-serif;border-collapse: collapse; width = 70%;">
                       
                       <tr>
               
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>EMPLOYEE ID</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>SURNAME</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>OTHER NAMES</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>GENDER</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>DATE OF BIRTH</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>ACTIONS</strong></th>
                           

                             
                                                   </tr>
                                                   <?php
                                                    while($row = $records->fetch(PDO::FETCH_ASSOC)){
                                                        extract($row);
                                                   ?>
                                                  
                                                   <tr>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$empid;?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$surname;?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$otherNames;?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$gender;?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$DoB;?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;">
                       <a title="Edit" href="edit.php?req=<?=$empid;?>"  class="btn btn-success btn-sm  "> 
                        <span class="fa fa-edit fw-fa"></span></a>
                        <a title="view" href="view.php?req=<?=$empid;?>"  class="btn btn-primary btn-sm  "> 
                        <span class="fa fa-eye fw-fa"></span></a>
				  		
				  				</td>
                       </tr>
                                                    <?php }?>
                       </tr>
                       </table>

                       <?php
                       include_once(WEB_ROOT.'templates/footer.php');