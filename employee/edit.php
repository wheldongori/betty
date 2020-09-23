<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location:/auth/login.php");
}

include_once '../config/config.php';
//include config files
require_once(WEB_ROOT.'config/database.php');
require_once(WEB_ROOT.'objects/employee.php');
require_once(WEB_ROOT.'objects/empHist.php');

//get db instance
$database = Database::getInstance();
$db = $database->getConnection();

$employee = new Employee($db);
$emp = new EmpHist($db);

$role = $emp->readRoles();
$companies = $emp->readCompanies();
$department = $emp->readDepartments();
$status = $emp->readStatus();

$id = (isset($_GET['req']) && $_GET['req'] != '') ? $_GET['req'] : '';

$employee->empid = $id;

$emp->empid = $id;

$emp->readHist();

$employee->readOne();

// $date = new DateTime($employee->DoB);

// const HTML_DATETIME_LOCAL = 'Y-m-d\TH:i:sP';

// $php_timestamp = strtotime($employee->DoB);

// $employee->DoB = date(HTML_DATETIME_LOCAL,$php_timestamp);

include_once(WEB_ROOT.'templates/header.php');

$errors = [];

// $row = $record->fetch(PDO::FETCH_ASSOC);

// extract($row);

// print_r($empid);exit;

if($_POST){
    $employee->surname = $_POST['surname'];
    $employee->otherNames = $_POST['otherNames'];
    $employee->password = $_POST['pwd'];
    $employee->gender = $_POST['gender'];
    // $employee->DoB = $_POST['date'];
    $date = date_create($_POST['dob']);
    // $date = $date->format('Y-m-d H:i:s');
    $employee->DoB = $date;
    $employee->empid = $_POST['id'];

    // $surlen = strlen($employee->surname);
    // $namelen = strlen($employee->otherNames);
    // $passlen = strlen($employee->password);
    // $genlen = strlen($employee->gender);
    // // $len = strlen($employee->surname);

    // // print_r($employee);exit;
    // if($surlen < 3){
    //   array_push($errors,'surname should have three or more characters');
    // }elseif($namelen < 3){
    //   array_push($errors,'other names should have three or more characters');
    // }elseif($passlen < 6){
    //   array_push($errors,'password should have six or more characters');
    // }else{
    // if(!empty($employee->surname) && !empty($employee->otherNames) && !empty($employee->password)
    //  && !empty($employee->gender) && !empty($employee->DoB)){
         $employee->edit();

         $emp->empid = $_POST['id'];
         $emp->status_Id = $_POST['status'];
         $emp->compId = $_POST['company'];
         $emp->deptId = $_POST['dept'];
         $emp->id = $_POST['role'];

         $emp->createHist();
         header("Location:list.php");
    //  }else{
    //      echo "error";
    //  }
    // }

}

//edit employee form
?>
<div class="container">


  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="employee_edit" method="post">
  <div class="row">
        <div class="col-md-4 col-md-offset-4">
        <h1 class="text-center">Employee Edit form</h1>
  <input type="hidden" name = "id" value="<?=$employee->empid;?>"/>
    <div class="form-group">
    
      <label for="surname">Surname:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter surname" name="surname" value = "<?=$employee->surname;?>" required/>
    </div>
    <div class="form-group">
 
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required/>
    </div>
    <div class="form-group">
    
      <label for="pwd">other names:</label>
      <input type="text" class="form-control"  placeholder="Enter other names" name="otherNames" 
      value = "<?=$employee->otherNames;?>" required/>
    </div>
    <div class="form-group">
    <label>Date of Birth:</label>
        <!-- <div class='input-group date' id='datetimepicker1'> -->
          <input type="Date" value = "<?=$employee->DoB;?>" name = "dob"  class="form-control" required/>
          <!-- <span class="input-group-addon"> -->
            <!-- <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div> -->
      </div>
  <div class="form-group">
		<label>Status:</label>
		<select name="status" class="form-contol">
            <?php while($row = $status->fetch(PDO::FETCH_ASSOC)){?>
           <?php if($row['status_id'] == $emp->status_Id){?>
              <option selected = 'selected' value="<?php echo $row['status_Id']; ?>"><?php echo $row['status']; ?>
			</option>
           <?php }else{?>
            <option value="<?php echo $row['status_Id']; ?>"><?php echo $row['status']; ?>
			</option>
              <?php }?>
            <?php }?>
		</select>
	<!-- </div>   -->
  <!-- <div class="form-group"> -->
		<label>role:</label>
		<select name="role" class="form-contol">
            <?php while($row2 = $role->fetch(PDO::FETCH_ASSOC)){?>
           <?php if($row2['id'] == $emp->id){?>
              <option selected = 'selected' value="<?php echo $row2['id']; ?>"><?php echo $row2['role']; ?>
			</option>
           <?php }else{?>
            <option value="<?php echo $row2['id']; ?>"><?php echo $row2['role']; ?>
			</option>
              <?php }?>
            <?php }?>
		</select>
	<!-- </div>  -->
  <!-- <div class="form-group"> -->
		<label>Company:</label>
		<select name="company" class="form-contol">
            <?php while($row3 = $companies->fetch(PDO::FETCH_ASSOC)){?>
           <?php if($row3['compId'] == $emp->compId){?>
              <option selected = 'selected' value="<?php echo $row3['compId']; ?>"><?php echo $row3['company']; ?>
			</option>
           <?php }else{?>
            <option value="<?php echo $row3['compId']; ?>"><?php echo $row3['company']; ?>
			</option>
              <?php }?>
            <?php }?>
		</select>
	<!-- </div>  -->
  <!-- <div class="form-group"> -->
		<label>Department:</label>
		<select name="dept" class="form-contol">
            <?php while($row4 = $department->fetch(PDO::FETCH_ASSOC)){?>
           <?php if($row4['deptId'] == $emp->deptId){?>
              <option selected = 'selected' value="<?php echo $row4['deptId']; ?>"><?php echo $row4['department']; ?>
			</option>
           <?php }else{?>
            <option value="<?php echo $row4['deptId']; ?>"><?php echo $row4['department']; ?>
			</option>
              <?php }?>
            <?php }?>
		</select>
	</div> 
    <div class="form-group">
      <div class="radio">
          <label><input type="radio" name="gender" <?php if($employee->gender=="male") {echo "checked";}?> value = "male">Male</label>
          <label><input type="radio" name="gender" <?php if($employee->gender=="female") {echo "checked";}?> value = "female">Female</label>
      </div>
    </div>
   
    <button type="submit" class="btn btn-block btn-success">Submit</button> <a href="list.php" class="btn btn-block btn-primary pull-right  ">  
          Back</a>
          </div>
         </div> 
  </form>
</div>

<?php

include_once(WEB_ROOT.'templates/footer.php');



