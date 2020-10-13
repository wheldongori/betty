<?php

include_once '../config/config.php';
//include config files
require_once(WEB_ROOT.'config/database.php');
require_once(WEB_ROOT.'objects/login.php');


$database = Database::getInstance();
$db = $database->getConnection();

$login = new Login($db);



if($_POST){
    $login->empid = $_POST['id'];
    $login->password = $_POST['pwd'];
    $user = $login->login();
    // print_r($user);exit;
    if(!empty($user)){
        $checkPasswordMatch = password_verify($login->password,$user['password']);

        if($checkPasswordMatch){
            session_start();
            $_SESSION['id'] = $user['empid'];
            $_SESSION['surname'] = $user['surname'];
            $_SESSION['otherNames'] = $user['otherNames'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['status'] = $user['status'];

            header("Location:/leave/list.php");

        }else{
            echo '<script>alert("Invalid credentials")</script>';
        }
    }else{
        echo '<script>alert("Invalid credentials")</script>';
    }
    
     

}

include_once(WEB_ROOT.'templates/header.php');

?>
<div class="container">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="login" method="post">
  <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <h1 class="text-center">Login form</h1>
      <div class="form-group">
      <label>Employee Id:</label>
          <input type='text' name="id" placeholder="Enter your staff id" class="form-control" required/>
      </div>

      <div class="form-group">
      <label>Password:</label>
          <input type='password' name="pwd" placeholder="Enter your password" class="form-control" required/>
      </div>
         
   
    <button type="submit" class="btn btn-success btn-block">Login</button>  
          </div>
         </div> 
  </form>
</div>

<?php

include_once(WEB_ROOT.'templates/footer.php');


