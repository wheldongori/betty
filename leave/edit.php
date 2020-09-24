<?php
session_start();

if(!isset($_SESSION['id']) || 
$_SESSION['role'] != 'supervisor' || $_SESSION['role'] != 'supervisor' ){
    header("Location:/auth/login.php");
}

$id = (isset($_GET['req']) && $_GET['req'] != '') ? $_GET['req'] : '';

include_once '../config/config.php';
//include config files
require_once(WEB_ROOT.'config/database.php');
require_once(WEB_ROOT.'objects/leave.php');

$database = Database::getInstance();
$db = $database->getConnection();

$leave = new Leave($db);

$leave->leaveId = $id;

$status = $leave->readStatus();


$oneLeave = $leave->readLeave();

$type = $leave->readTypes();

// $row = $record->fetch(PDO::FETCH_ASSOC);
// print_r($row);exit;
// extract($row);

include_once(WEB_ROOT.'templates/header.php');

$errors = [];

// print_r($empid);exit;

if($_POST){
  
  $total_leave_days = $_POST['ave_leave'];
  $requested_leave_days = $_POST['request'];
  $available_leave_days = $_POST['remainder'];
  $leave->adminRemark = $_POST['remark'];
  $leave->leaveStatusId = $_POST['status'];
  

  if($requested_leave_days > $total_leave_days && $leave->leaveStatusId ==2 ){
    echo '<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Failed!</strong> Leave days requested are more than total days!
  </div>';
  }else{
    $leave->leaveId = $_POST['id'];
    if(!empty($leave->adminRemark) && !empty($leave->leaveStatusId) && !empty($leave->leaveId)){
      if($leave->leaveStatusId == 1){
        echo '<div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Failed!</strong> Please approve or disapprove the leave!
      </div>';exit();
      }elseif($leave->leaveStatusId == 3){
        $leave->ave_leave = 0;
      }else{
        $leave->ave_leave = $available_leave_days;
      }
      $leave->update();
      header("Location:list.php");
    }
  }

  

}

//create employee form
?>
<div class="container">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="leave_edit" method="post">
  <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <h1 class="text-center">LEAVE APPROVAL FORM</h1>
          <input type="hidden" name = "id" value="<?=$oneLeave['leaveId'];?>"/>
    <div class="form-group">
      <label for="department">Surname:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter department name" 
       value = "<?=$oneLeave['surname'];?>" readonly/>
      <br/>
      </div>

      <div class="form-group">
      <label for="department">Other Names:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter department name" 
      value = "<?=$oneLeave['otherNames'];?>" readonly/>
      <br/>
      </div>

      <div class="form-group">
      <label for="department">Employee Position:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter department name"  
      value = "<?=$oneLeave['role'];?>" readonly/>
      <br/>
      </div>

      <div class="form-group">
      <label for="department">Total leave Days:</label>
      <input type="text" class="form-control" id="total" placeholder="Enter department name" name="ave_leave" 
      value = "<?=$oneLeave['ave_leave'];?>" readonly/>
      <br/>
      <label for="department">Number of leave Days requested:</label>
      <input type="text" class="form-control" id="request" placeholder="Enter department name" name="request" 
      value = "<?=$oneLeave['No_Of_Days'];?>" readonly/>
      </div>

     
      <div class="form-group">
      <label for="department">Remaining leave Days after request:</label>
      <input type="text" class="form-control" id="remaining" placeholder="Enter department name" name="remainder" 
      value = "<?=$oneLeave['available_leave'];?>" readonly/>
      <br/>
      </div>

      <div class="form-group">
      <label>Start Date:</label>
        <!-- <div class='input-group date' id='datetimepicker1'> -->
          <input type='Date' name="start" id="start_date" value = "<?=$oneLeave['startDate'];?>" placeholder="Choose start date" class="form-control" readonly/>
          <!-- <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div> -->
      </div>

      <div class="form-group">
      <label>End Date:</label>
        <!-- <div class='input-group date' id='datetimepicker2'> -->
          <input type='Date' name="end" id="end_Date" value = "<?=$oneLeave['end_Date'];?>" placeholder="Choose end date" class="form-control" readonly/>
          <!-- <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div> -->
      </div>

      <div class="form-group">
      <label for="department">Reason:</label>
      <input type="text" class="form-control" value="<?=$oneLeave['reason'];?>" id="email" placeholder="Enter reason" name="reason" readonly/>
      <br/>
      </div>

      <div class="form-group">
      <label for="department">Admin Remarks:</label>
      <textarea type="text" class="form-control" rows="4" cols="50" id="email" placeholder="Enter remark here" name="remark" 
      ></textarea>
      <br/>
      </div>

      <div class="form-group">
        <label>Leave Type:</label>
        <select name="type" class="form-contol" >
                <?php while($row = $type->fetch(PDO::FETCH_ASSOC)){?>
                  <?php if($oneLeave['leaveTid'] == $row['leaveTid']){?>
                    <option selected = 'selected' value="<?php echo $row['leaveTid']; ?>"><?php echo $row['leaveType']; ?>
          </option>
                  <?php }else{?>
                    <option  value="<?php echo $row['leaveTid']; ?>"><?php echo $row['leaveType']; ?>
          </option>
                  <?php }?>
                <?php }?>
        </select>
	  </div>

    <div class="form-group">
        <label>Leave Status:</label>
        <select name="status" id = "status" class="form-contol">
                <?php while($row2 = $status->fetch(PDO::FETCH_ASSOC)){?>
              <?php if($oneLeave['leaveStatusId'] == $row2['leaveStatusId']):?>
                    <option selected = 'selected' value="<?php echo $row2['leaveStatusId']; ?>"><?php echo $row2['leaveStatus']; ?>
          </option>
              <?php else:?>
                <option  value="<?php echo $row2['leaveStatusId']; ?>"><?php echo $row2['leaveStatus']; ?>
          </option>
              <?php endif;?>
                <?php }?>
        </select>
	  </div>

         
   
    <button type="submit" class="btn btn-success btn-block">Submit</button>  <a href="list.php" class="btn btn-primary btn-block pull-right  ">  
          Back</a> 
          </div>
         </div> 
  </form>
</div>



<?php

include_once(WEB_ROOT.'templates/footer.php');



