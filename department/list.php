<?php
session_start();

if(!isset($_SESSION['id']) || 
$_SESSION['role'] != 'supervisor' || $_SESSION['role'] != 'supervisor' ){
    header("Location:/auth/login.php");
}
 //include config files
 include_once '../config/config.php';
 require_once(WEB_ROOT.'config/database.php');
 require_once(WEB_ROOT.'objects/department.php');

$database = Database::getInstance();
$db = $database->getConnection();

$department = new Department($db);

$records = $department->read();

include_once(WEB_ROOT.'templates/header.php');

?>
<div class="container">
<div class="card-header">
          <p class="lead"> <strong>DEPARTMENTS</strong></p>   <a href="create.php" class="btn btn-primary  ">  
          <i class="fa fa-plus-circle fw-fa"></i> New</a></div><br/>
<table style = " font-family: arial, sans-serif;border-collapse: collapse; width = 70%;">
                       
                       <tr>
               
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>DEPARTMENT ID</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>DEPARTMENT</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>ACTIONS</strong></th>
                           

                             
                                                   </tr>
                                                   <?php
                                                    while($row = $records->fetch(PDO::FETCH_ASSOC)){
                                                        extract($row);
                                                   ?>
                                                  
                                                   <tr>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$deptId;?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$department;?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;">
                       <a title="Edit" href="edit.php?req=<?=$deptId;?>"  class="btn btn-success btn-sm  "> 
                        <span class="fa fa-edit fw-fa"></span></a>
                        <a title="view" href="view.php?req=<?=$deptId;?>"  class="btn btn-primary btn-sm  "> 
                        <span class="fa fa-eye fw-fa"></span></a>
				  		
				  				</td>
                       </tr>
                                                    <?php }?>
                       </tr>
                       </table>

                       <?php
                       include_once(WEB_ROOT.'templates/footer.php');