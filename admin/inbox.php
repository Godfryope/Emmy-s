<?php
session_start();

$response = array( 
    'status' => 0, 
    'message' => 'No message sent' 
);

if(isset($_POST['inbox_msg'])) {
	include_once '../database/dbconfig.php';
    $userid = $_POST['userid'];
    $subject = addslashes($_POST['subject']);
    $message = addslashes($_POST['message']);

    if(!empty($message)){
        $sql = $db_conn->query("SELECT * FROM inbox WHERE userid = '$userid'");
        if ($sql->num_rows < 1) {
            $mysqli = $db_conn->query("INSERT INTO inbox (userid,subject,message) 
            VALUES ('".$userid."', '".$subject."', '".$message."')");
            if ($mysqli) {
                $response['status'] = 1;
                $response['message'] = 'Sent';
            } 
        } else {
           $mysqli = $db_conn->query("UPDATE inbox SET subject ='$subject' AND message ='$message' WHERE userid = '$userid'");
            $response['status'] = 1;
                $response['message'] = 'Sent';
        }
    }
}

// Return response 
echo json_encode($response);
?>