<?php
session_start();
if(isset($_SESSION['adminid'])) {
    include_once '../database/dbconfig.php';
	$outgoing_id = $_POST['adminid'];
    $incoming_id = $_POST['incoming_id'];
    $output = "";
    $mysqli = $db_conn->query("SELECT * FROM conversations LEFT JOIN users ON users.userid = conversations.outgoing_msg_id 
    	WHERE (outgoing_msg_id = '$outgoing_id' AND incoming_msg_id = '$incoming_id' ) 
    	OR (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '$outgoing_id') ORDER BY msg_id");
    if($mysqli->num_rows > 0) {
    	while($row = $mysqli->fetch_assoc()) {
    		if($row['outgoing_msg_id'] === $outgoing_id) {
    			$output .= '
    			<!-- Message. Default to the left -->
                <div class="direct-chat-msg pt-4">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">Admin</span>
                      <span class="direct-chat-timestamp float-right">'. $row['msg_time'].'</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <div class="direct-chat-text">
                      '. $row['msg'] .'
                    </div>
                    <!-- /.direct-chat-text -->
                </div>';
            } else {
                $output .= '
                <!-- Message to the right -->
                <div class="direct-chat-msg right pt-4">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">'. $row['name'].'</span>
                      <span class="direct-chat-timestamp float-left">'. $row['msg_time'].'</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <div class="direct-chat-text">
                      '. $row['msg'] .'
                    </div>
                    <!-- /.direct-chat-text -->
                </div>';
            }
    	}
    }
    else {
        $output .= '<div class="card-text text-center px-4 text-primary" style="font-size: 12px;">No new messages!</div>';
    }
}
echo $output;
?>