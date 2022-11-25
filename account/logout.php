<?php 
session_start();
include('../database/dbconfig.php');
$userid = $_SESSION['userid'];
$mysqli = $db_conn->query("UPDATE users SET login_status = 'offline' WHERE userid = '$userid'");
if ($mysqli) {
    $sqli = $db_conn->query("DELETE FROM conversations WHERE incoming_msg_id ='$userid' OR outgoing_msg_id = '$userid'");
    if ($sqli) {
        unset($_SESSION['username']);
		session_destroy();
		header('Location:../login');
		exit(); 
    } 
} 
?>