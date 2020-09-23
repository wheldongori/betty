<?php
session_start();

if(!isset($_SESSION['id']) || 
$_SESSION['role'] != 'supervisor' || $_SESSION['role'] != 'supervisor' ){
    header("Location:/auth/login.php");
}

include_once '../config/config.php';
//include config files
require_once(WEB_ROOT.'config/database.php');
require_once(WEB_ROOT.'objects/department.php');

$database = Database::getInstance();
$db = $database->getConnection();

$department = new Department($db);

include_once(WEB_ROOT.'templates/header.php');



$errors = [];

if($_POST){
    $department->department = $_POST['department'];

    $complen = strlen($department->department);
    // $len = strlen($employee->surname);

    // print_r($employee->DoB);exit;
    // print_r($department->department);exit;
    if($complen < 3){
      array_push($errors,'department should have three or more characters');
    }else{
    if(!empty($department->department)){
         $department->create();
         header("Location:list.php");
     }else{
         echo "error";
     }
    }

}

//create employee form
?>
<div class="container">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <h1 class="text-center">Department form</h1>
    <div class="form-group">
    <?php if(in_array('department should have three or more characters',$errors)){
      echo '<div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Failed!</strong> department should have three or more characters!
    </div>';
    unset($errors);
    }?>
      <label for="department">Department:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter department name" name="department" required/>
      <br/>
   
   
    <button type="submit" class="btn btn-block btn-success">Submit</button>  <a href="list.php" class="btn btn-block btn-primary pull-right  ">  
          Back</a> 
          </div>
         </div> 
  </form>
</div>

<?php

include_once(WEB_ROOT.'templates/footer.php');



