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
require_once(WEB_ROOT.'objects/company.php');

$database = Database::getInstance();
$db = $database->getConnection();

$company = new Company($db);

include_once(WEB_ROOT.'templates/header.php');



$errors = [];

if($_POST){
    $company->company = $_POST['company'];

    $complen = strlen($company->company);
    // $len = strlen($employee->surname);

    // print_r($employee->DoB);exit;
    // print_r($company->company);exit;
    if($complen < 3){
      array_push($errors,'company should have three or more characters');
    }else{
    if(!empty($company->company)){
         $company->create();
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
          <h1 class="text-center">Company form</h1>
    <div class="form-group">
    <?php if(in_array('company should have three or more characters',$errors)){
      echo '<div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Failed!</strong> company should have three or more characters!
    </div>';
    unset($errors);
    }?>
      <label for="company">Company:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter company name" name="company" required/>
      <br/>
   
   
    <button type="submit" class="btn btn-block btn-success">Submit</button>  <a href="list.php" class="btn btn-block btn-primary pull-right  ">  
          Back</a> 
          </div>
         </div> 
  </form>
</div>

<?php

include_once(WEB_ROOT.'templates/footer.php');



