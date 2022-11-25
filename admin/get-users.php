<?php
session_start();
if(isset($_SESSION['adminid'])) {
    include_once 'database/dbconfig.php';
    $output = "";
    $mysqli = $db_conn->query("SELECT * FROM users ORDER BY id DESC");
    if($mysqli->num_rows > 0) {
    	while($row = $mysqli->fetch_assoc()) {
    		
			$output .= '
			<li class="nav-item active">
                <a href="messages?userid='.$row['userid'].'" class="nav-link text-primary">'.$row['fname'].' '.$row['lname'].' <span class="float-right text-info text-sm"><i class="fas fa-star"></i></span></a>
            </li>
            ';
    	}
    }
    else {
        $output .= '
        <li class="nav-item active">
            <a class="nav-link">No records</a>
        </li>
        ';
    }
}
echo $output;
?>