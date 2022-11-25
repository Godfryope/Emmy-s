<?php
session_start();
include('database/dbconfig.php');
if (!isset($_GET['r'])) {
  header('Location:login');
  exit();
} else {
  $r = $_GET['r'];
  $status = "confirmed";
  $mysqli = $db_conn->query("UPDATE users SET status = '$status' WHERE confirmation = '$r' ");
  if ($mysqli) {
    $sql = $db_conn->query("SELECT * FROM users WHERE confirmation = '$r'");
    $row = $sql->fetch_assoc();

    $_SESSION['username'] = $row['username'];
    $_SESSION['userid'] = $row['userid'];
    $_SESSION['last_login_timestamp'] = time();

    header('Location:account/dashboard');
  }
}
?>
