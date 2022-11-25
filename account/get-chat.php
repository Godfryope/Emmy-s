<?php 
session_start();
if(isset($_SESSION['userid'])) {
    include_once '../database/dbconfig.php';
	$outgoing_id = $_POST['userid'];
    $incoming_id = $_POST['incoming_id'];
    $output = "";
    $mysqli = $db_conn->query("SELECT * FROM conversations LEFT JOIN admin ON admin.adminid = conversations.outgoing_msg_id 
    	WHERE (outgoing_msg_id = '$outgoing_id' AND incoming_msg_id = '$incoming_id' ) 
    	OR (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '$outgoing_id') ORDER BY msg_id");
    if($mysqli->num_rows > 0) {
    	while($row = $mysqli->fetch_assoc()) {
    		if($row['outgoing_msg_id'] === $outgoing_id) {
    			$output .= '
    			<div class="direct-chat-msg pt-4">
                    <div class="direct-chat-info clearfix">
                    	<span class="direct-chat-name text-dark text-capitalize" style="float: left"> '. $row['name'].' </span>
                    	<span class="direct-chat-timestamp" style="float: right"> '. $row['msg_time'].' </span>
                    </div>
                    <div class="direct-chat-text bg-light border-0" style="font-size: 12px;"> '. $row['msg'] .' </div>
                </div>';
            } else {
                $output .= '
                <div class="direct-chat-msg right pt-4">
                    <div class="direct-chat-info clearfix">
                    	<span class="direct-chat-name text-dark text-capitalize" style="float: right">'.$row['name'].'</span>
                    	<span class="direct-chat-timestamp" style="float: left"> '.$row['msg_time'].' </span>
                    </div>
                    <div class="direct-chat-text bg-orch border-0" style="font-size: 12px;">'. $row['msg'] .'</div>
                </div>';
            }
    	}
    }
    else {
        $output .= '<div class="card-text text-center px-4 text-primary" style="font-size: 12px;">Chat with us, we&#39;re online!</div>';
    }
}
echo $output;
?>