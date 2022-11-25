<?php 
session_start();
if(isset($_SESSION['adminid'])) {
    include_once '../database/dbconfig.php';
    $output = "";
    $mysqli = $db_conn->query("SELECT DISTINCT userid FROM conversations WHERE source = 'user' ORDER BY msg_id DESC");
    if($mysqli->num_rows > 0) {
        while($row = $mysqli->fetch_assoc()) {
            $userid = $row['userid'];
            $sqlio = $db_conn->query("SELECT DISTINCT name FROM conversations WHERE userid = '$userid' ORDER BY msg_id DESC");
            $data = $sqlio->fetch_assoc();
            
            $output .= '
            <li class="nav-item active">
                <a id="'.$row['userid'].'" href="live-chat?user_chat_id='.$row['userid'].'" class="nav-link text-primary">'.$data['name'].' <span class="float-right text-success text-sm"><i class="fas fa-star"></i></span></a>
            </li>
            ';
        }
    }
    else {
        $output .= '
        <li class="nav-item active">
            <a class="nav-link">No chats</a>
        </li>
        ';
    }
}
echo $output;
?>