<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['surname']) && isset($_SESSION['otherNames']) 
&& isset($_SESSION['role']) && isset($_SESSION['status'])){

    unset($_SESSION['id']);
    unset($_SESSION['surname']);
    unset($_SESSION['otherNames']);
    unset($_SESSION['role']);
    unset($_SESSION['status']);

    session_destroy();

    header("Location:login.php");
}