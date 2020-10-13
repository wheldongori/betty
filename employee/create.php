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
require_once(WEB_ROOT.'objects/empHist.php');


$database = Database::getInstance();
$db = $database->getConnection();

$employee = new Employee($db);
$emp = new EmpHist($db);


$role = $emp->readRoles();
$companies = $emp->readCompanies();
$department = $emp->readDepartments();

include_once(WEB_ROOT.'templates/header.php');

$errors = [];

if($_POST){
    $employee->surname = $_POST['surname'];
    $employee->otherNames = $_POST['otherNames'];
    $employee->password = $_POST['pwd'];
    $employee->gender = $_POST['gender'];
    $date = $_POST['dob'];
    // $date = $date->format('Y-m-d H:i:s');
    $employee->DoB = $date;

    $surlen = strlen($employee->surname);
    $namelen = strlen($employee->otherNames);
    $passlen = strlen($employee->password);
    $genlen = strlen($employee->gender);
    // $len = strlen($employee->surname);

    // print_r($employee);exit;
    if($surlen < 3){
      array_push($errors,'surname should have three or more characters');
    }elseif($namelen < 3){
      array_push($errors,'other names should have three or more characters');
    }elseif($passlen < 6){
      array_push($errors,'password should have six or more characters');
    }else{
    if(!empty($employee->surname) && !empty($employee->otherNames) && !empty($employee->password)
     && !empty($employee->gender) && !empty($employee->DoB)){
         $employee->create();
         
         $last = $employee->readLast();
        //  print_r($last['MAX(empid)']);exit;
         $emp->empid = $last['MAX(empid)'];
         $emp->status_Id = 1;
         $emp->compId = $_POST['company'];
         $emp->deptId = $_POST['department'];
        //  $employee->id = $_POST['id'];
         $emp->id = $_POST['role'];

         $emp->createHist();
         header("Location:list.php");
     }else{
         echo "error";
     }
    }

}

//create employee form
?>
<div class="container">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name = "employee_add" method="post">
  <div class="row">
        <div class="col-md-4 col-md-offset-4">
        <h1 class="text-center">Employee Form</h1>
    <div class="form-group">
    <?php if(in_array('surname should have three or more characters',$errors)){
      echo '<div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Failed!</strong> surname should have three or more characters!
    </div>';
    unset($errors);
    }?>
      <label for="surname">Surname:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter surname" name="surname" required/>
    </div>
    <div class="form-group">
    <?php if(in_array('password should have six or more characters',$errors)){
      echo '<div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Failed!</strong> password should have six or more characters!
    </div>';
    unset($errors);
    }?>
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required/>
    </div>
    <div class="form-group">
    <?php if(in_array('other names should have three or more characters',$errors)){
      echo '<div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Failed!</strong> other names should have three or more characters!
    </div>';
    unset($errors);
    }?>
      <label for="pwd">other names:</label>
      <input type="text" class="form-control"  placeholder="Enter other names" name="otherNames" required/>
    </div>
    <div class="form-group">
    <label>Date of Birth:</label>
        <!-- <div class='input-group date' id='datetimepicker1'> -->
          <input type='Date' name="dob" class="form-control" required/>
          <!-- <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div> -->
      </div>
  <div class="form-group">
		<label>Role:</label>
		<select name="role" class="form-contol">
            <?php while($row = $role->fetch(PDO::FETCH_ASSOC)){?>
           
                <option value="<?php echo $row['id']; ?>"><?php echo $row['role']; ?>
			</option>
            <?php }?>
		</select>
	<!-- </div> -->
  <!-- <div class="form-group"> -->
		<label>Company:</label>
		<select name="company" class="form-contol">
            <?php while($row2 = $companies->fetch(PDO::FETCH_ASSOC)){?>
           
                <option value="<?php echo $row2['compId']; ?>"><?php echo $row2['company']; ?>
			</option>
            <?php }?>
		</select>
	<!-- </div> -->
  <!-- <div class="form-group"> -->
		<label>Department:</label>
		<select name="department" class="form-contol">
            <?php while($row3 = $department->fetch(PDO::FETCH_ASSOC)){?>
           
                <option value="<?php echo $row3['deptId']; ?>"><?php echo $row3['department']; ?>
			</option>
            <?php }?>
		</select>
	</div>
    <div class="form-group">
      <div class="radio">
          <label><input type="radio" name="gender" value = "male">Male</label>
          <label><input type="radio" name="gender" value = "female">Female</label>
      </div>
    </div>
   
    <button type="submit" class="btn btn-block btn-success">Submit</button>  <a href="list.php" class="btn btn-block btn-primary pull-right  ">  
          Back</a> 
          </div>
         </div> 
  </form>
</div>

<?php

include_once(WEB_ROOT.'templates/footer.php');



