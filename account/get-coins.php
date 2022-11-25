<?php
session_start();
include('../database/dbconfig.php');

if (isset($_POST['btc'])) {
	$usd = $_POST['usd'];
	$mysqli = $db_conn->query("SELECT value FROM coins WHERE coin = 'btc'");
	$row = $mysqli->fetch_assoc();
	$value = $row['value'];
	$btc = $usd / $value;
	echo $btc;
}

if (isset($_POST['eth'])) {
	$usd = $_POST['usd'];
	$mysqli = $db_conn->query("SELECT value FROM coins WHERE coin = 'eth'");
	$row = $mysqli->fetch_assoc();
	$value = $row['value'];
	$eth = $usd / $value;
	echo $eth;
}

if (isset($_POST['bnb'])) {
	$usd = $_POST['usd'];
	$mysqli = $db_conn->query("SELECT value FROM coins WHERE coin = 'bnb'");
	$row = $mysqli->fetch_assoc();
	$value = $row['value'];
	$bnb = $usd / $value;
	echo $bnb;
}

if (isset($_POST['ada'])) {
	$usd = $_POST['usd'];
	$mysqli = $db_conn->query("SELECT value FROM coins WHERE coin = 'ada'");
	$row = $mysqli->fetch_assoc();
	$value = $row['value'];
	$ada = $usd / $value;
	echo $ada;
}

if (isset($_POST['xpr'])) {
	$usd = $_POST['usd'];
	$mysqli = $db_conn->query("SELECT value FROM coins WHERE coin = 'xpr'");
	$row = $mysqli->fetch_assoc();
	$value = $row['value'];
	$xpr = $usd / $value;
	echo $xpr;
}

if (isset($_POST['doge'])) {
	$usd = $_POST['usd'];
	$mysqli = $db_conn->query("SELECT value FROM coins WHERE coin = 'doge'");
	$row = $mysqli->fetch_assoc();
	$value = $row['value'];
	$doge = $usd / $value;
	echo $doge;
}

if (isset($_POST['usdt'])) {
	$usd = $_POST['usd'];
	$mysqli = $db_conn->query("SELECT value FROM coins WHERE coin = 'usdt'");
	$row = $mysqli->fetch_assoc();
	$value = $row['value'];
	$usdt = $usd / $value;
	echo $usdt;
}

?>