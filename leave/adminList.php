<?php
session_start();

if(!isset($_SESSION['id']) && $_SESSION['role'] == 'supervisor' || $_SESSION['role'] == 'director'){
    header("Location:/auth/login.php");
}
 //include config files
 include_once '../config/config.php';
 require_once(WEB_ROOT.'config/database.php');
 require_once(WEB_ROOT.'objects/leave.php');

$database = Database::getInstance();
$db = $database->getConnection();

$leave = new Leave($db);

$leave->empid = $_SESSION['id'];

$leaves = $leave->listLeaves();

include_once(WEB_ROOT.'templates/header.php');

?>
<div class="container">
<div class="card-header">
<?php if(empty($leaves)):?>
    <p><strong> NO LEAVES ARE AVAILABLE FOR THIS USER</strong></p>
    <a href="create.php" class="btn btn-primary  ">  
          <i class="fa fa-plus-circle fw-fa"></i> New</a></div><br/>
<?php else:?>
    <p><strong> MY LEAVE LISTINGS</strong></p>
    <a href="create.php" class="btn btn-primary  ">  
          <i class="fa fa-plus-circle fw-fa"></i> New</a>
          <a href="list.php" class="btn btn-success pull-right ">  
          <i class="fa fa-backward fw-fa"></i> Back</a>
          </div><br/>
    <?php endif;?>
<table style = " font-family: arial, sans-serif;border-collapse: collapse; width = 70%;">
                       
                       <tr>
                        
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>SURNAME</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>OTHER NAMES</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>REASON</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>START DATE</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>END DATE</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>NUMBER OF DAYS</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>STATUS</strong></th>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>REMARK</strong></th>
                           <?php if($_SESSION['role'] == 'supervisor' || $_SESSION['role'] == 'director'):?>
                           <th style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><strong>ACTIONS</strong></th>
                           <?php endif;?>

                             
                                                   </tr>
                                                   <?php
                                                   
                                                   
                                                    foreach($leaves as $leave => $value){
                                                        extract($leaves);
                                                        // print_r($value);
                                                   ?>
                                                  
                                                   <tr>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$value['surname'];?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$value['otherNames'];?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$value['reason'];?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$value['startDate'];?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$value['end_Date'];?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$value['No_Of_Days'];?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?=$value['leaveStatus'];?></td>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;"><?php if(empty($value['adminRemark'])){
                           echo "LEAVE NOT YET PROCESSED";
                       }else{echo $value['adminRemark'];}?></td>
                       <?php if($_SESSION['role'] == 'supervisor' || $_SESSION['role'] == 'director'):?>
                       <td style = " border: 1px solid #dddddd;text-align: left;padding: 8px;">
                       <a title="Edit" href="edit.php?req=<?=$value['leaveId'];?>"  class="btn btn-success btn-sm  "> 
                        <span class="fa fa-edit fw-fa"></span></a>
                        <a title="view" href="view.php?req=<?=$value['leaveId'];?>"  class="btn btn-primary btn-sm  "> 
                        <span class="fa fa-eye fw-fa"></span></a></td>
                        <?php endif;?>
                        </tr>
                   


				  		
				  				
                       
                                                    <?php } ?>
                       </tr>
                       </table>
                    
                       

                       <?php
                       include_once(WEB_ROOT.'templates/footer.php');