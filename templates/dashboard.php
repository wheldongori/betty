<?php
require_once 'header.php';

session_start();

if(!isset($_SESSION['id'])){
    header("Location:/leave/list.php");
  }elseif($_SESSION['role'] != 'supervisor'){
    header("Location:/leave/list.php");
  }elseif($_SESSION['role'] == 'employee'){
    header("Location:/leave/list.php");
  }elseif($_SESSION['role'] == 'manager'){
    header("Location:/leave/list.php");
  }

?>
<p class = "lead">SUPERVISOR ACTIONS</p>

<div class="wrapper">
 
  <div><a href="<?=SRV_ROOT.'employee/list.php';?>">EMPLOYEE DETAILS</a></div>
  <div><a href="<?=SRV_ROOT.'department/list.php';?>">DEPARTMENT DETAILS</a></div>
  <div><a href="<?=SRV_ROOT.'company/list.php';?>">COMPANY DETAILS</a></div>
  <div><a href="<?=SRV_ROOT.'leave/list.php';?>">LEAVE DETAILS</a></div>
  
  

</div>

<?php require_once 'footer.php';?>