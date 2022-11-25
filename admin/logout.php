<?php 
session_start();
include('../database/dbconfig.php');
$adminid = $_SESSION['adminid'];

unset($_SESSION['adminid']);
session_destroy();
header('Location:login');
exit(); 

?>