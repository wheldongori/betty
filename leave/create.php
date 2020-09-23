<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location:/auth/login.php");
}

include_once '../config/config.php';
//include config files
require_once(WEB_ROOT.'config/database.php');
require_once(WEB_ROOT.'objects/leave.php');


$database = Database::getInstance();
$db = $database->getConnection();

$leave = new Leave($db);

$leave->empid = $_SESSION['id'];

$emp = empty($leave->readLastLeave()) ? $leave->read() : $leave->readLastLeave();

// redirect to leave list if the last applied leave is not yet processed.
if(empty($emp['adminRemark']) && $emp['leaveStatusId'] == 1 && $emp['empid'] == $_SESSION['id']){
  echo " <script>
    alert('Your last leave application has not yet been processed! Please wait before you apply for another leave.Thank you.');
window.location.href = 'list.php'</script>";
// header("Location:list.php");
}

$type = $leave->readTypes();

// print_r($emp);

// print_r($emp);exit;

include_once(WEB_ROOT.'templates/header.php');



$errors = [];

if($_POST){
  $leave->startDate = $_POST['start'];
  $start = date_create($leave->startDate);
  // $leave->startDate = $leave->startDate->format('Y-m-d H:i:s');
  $leave->end_Date = $_POST['end'];
  $end= date_create($leave->end_Date);
  // $leave->end_Date = $leave->end_Date->format('Y-m-d H:i:s');
  $leave->No_Of_Days = date_diff($start,$end);
  $leave->No_Of_Days = $leave->No_Of_Days->days + 2;
  $leave->ave_leave = $_POST['ave_leave'] - $leave->No_Of_Days;
  $leave->reason = $_POST['reason'];
  $leave->datePosted = date('y-m-d');
  $leave->empid = $_SESSION['id'];
  $leave->leaveTid = $_POST['type'];
  $leave->leaveStatusId = 1;

  // print_r($leave->No_Of_Days);exit;

  if(!empty($leave->startDate) && !empty($leave->end_Date) && !empty($leave->No_Of_Days) && !empty($leave->ave_leave)
  && !empty($leave->reason) && !empty($leave->datePosted) && !empty($leave->empid) && !empty($leave->leaveTid)
   && !empty($leave->leaveTid)){
     $leave->create();
     header("Location:list.php");
    
   }else{
     echo "error";
   }

}


//create employee form
?>
<div class="container">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="leave_create" method="post">
  <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <h1 class="text-center">Leave form</h1>
    <div class="form-group">
      <label for="department">Surname:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter department name" 
       value = "<?=$emp['surname'];?>" readonly/>
      <br/>
      </div>

      <div class="form-group">
      <label for="department">Other Names:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter department name" 
      value = "<?=$emp['otherNames'];?>" readonly/>
      <br/>
      </div>

      <div class="form-group">
      <label for="department">Employee Position:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter department name"  
      value = "<?=$emp['role'];?>" readonly/>
      <br/>
      </div>

     
      <div class="form-group">
      <label for="department">Available leave Days:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter department name" name="ave_leave" 
      value = "<?php if($emp['available_leave'] != 0){
        echo $emp['available_leave'];
      }else{
        echo $emp['ave_leave'];
      }?>" readonly/>
      <br/>
      </div>

      <div class="form-group">
      <label>Date start:</label>
        <!-- <div class='input-group date' id='datetimepicker1'> -->
          <input type='Date' name="start" placeholder="Choose start date" class="form-control" required/>
          <!-- <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div> -->
      </div>

      <div class="form-group">
      <label>Date end:</label>
        <!-- <div class='input-group date' id='datetimepicker2'> -->
          <input type='Date' name="end" placeholder="Choose end date" class="form-control" required/>
          <!-- <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div> -->
      </div>

      <div class="form-group">
      <label for="department">Reason:</label>
      <textarea type="text" class="form-control" rows="4" cols="50" id="email" placeholder="Enter reason here" name="reason" 
      ></textarea>
      <br/>
      </div>

      <div class="form-group">
        <label>Leave Type:</label>
        <select name="type" class="form-contol">
                <?php while($row = $type->fetch(PDO::FETCH_ASSOC)){?>
              
                    <option value="<?php echo $row['leaveTid']; ?>"><?php echo $row['leaveType']; ?>
          </option>
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



