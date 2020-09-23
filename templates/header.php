<?php include_once '../config/config.php';?>
<!Doctype html>
    <head>
    	<title>Leavesys</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> -->
<link rel = "stylesheet" href="styles.css"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<style>
input.invalid, textarea.invalid, select.invalid
{
    background-color: #ffdddd;
}
</style>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css"> -->
    </head>
    <body>
    	<nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="mainbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        	<a class="navbar-brand" href="<?=SRV_ROOT.'templates/dashboard.php';?>">Leave System</a>
        </div>
        <div id="navbar">
          <div class="collapse navbar-collapse" id="mainNavBar">
          <ul class="nav navbar-nav navbar-right">
          
            <?php if(!isset($_SESSION['id'])){?>
              <li><a href="<?=SRV_ROOT.'auth/login.php';?>">login</a></li>
            <?php }else{?>
            <li><a href="<?=SRV_ROOT.'leave/list.php';?>">Welcome <?=$_SESSION['surname'].' '.$_SESSION['otherNames'];?></a></li>
            <?php if($_SESSION['role'] == 'director' || $_SESSION['role'] == 'supervisor'):?>
            <li><a href="<?=SRV_ROOT.'employee/list.php';?>">Employee</a></li>
          	<li><a href="<?=SRV_ROOT.'department/list.php';?>">Department</a></li>
            <li><a href="<?=SRV_ROOT.'company/list.php';?>">Company</a></li>
            <?php endif;?>
            <li><a href="<?=SRV_ROOT.'leave/list.php';?>">Leave</a></li>
            <li><a href="<?=SRV_ROOT.'auth/logout.php';?>">Logout</a></li>
            <?php }?>
            <!-- <li><a href="#">Categories</a></li> -->
          </ul>   
      </div>
  </div>
 </div> 
</nav>

   <div class="container">