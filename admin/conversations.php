<?php
$response = array( 
    'status' => 0, 
    'message' => 'No message sent' 
);

if(isset($_POST['send_msg'])) {
	include_once '../database/dbconfig.php';
    $adminid = $_POST['adminid'];
    $name = $_POST['name'];
    $msg_time = date("h:i:sa");
	$outgoing_id = $_POST['adminid'];
    $incoming_id = $db_conn->real_escape_string($_POST['incoming_id']);
    $message = $db_conn->real_escape_string($_POST['message']);
    $source = "admin";
    if(!empty($message)){
    	$mysqli = $db_conn->query("INSERT INTO conversations (userid,msg_time,name,incoming_msg_id,outgoing_msg_id,msg,source) 
    		VALUES ('".$adminid."', '".$msg_time."', '".$name."', '".$incoming_id."', '".$outgoing_id."', '".$message."', '".$source."')");
    	if ($mysqli) {
    		$response['status'] = 1;
    		$response['message'] = 'Sent';
    	}
    }
}

// Return response 
echo json_encode($response);
?>