<?php
session_start();
include('database/dbconfig.php');

$response = array( 
    'status' => 0, 
    'message' => 'Request failed, please try again.' 
);

if (isset($_POST['register'])) {
    $userid = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890123456789"), 0, 7);
    $walletid = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 22);
    $username = $db_conn->real_escape_string($_POST['username']);
    $fname = $db_conn->real_escape_string($_POST['fname']);
    $lname = $db_conn->real_escape_string($_POST['lname']);
    $email = $db_conn->real_escape_string($_POST['email']);
    $country = $db_conn->real_escape_string($_POST['country']);
    $password = $db_conn->real_escape_string($_POST['password']);
    $plan = "custom";
    $referral = $db_conn->real_escape_string($_POST['referral']);
    $status = "pending";
    $account = "active";
    $totalbalance = "0.00";
    $activedeposit = "0.00";
    $lastdeposit = "0.00";
    $totaldeposit = "0.00";
    $lastwithdrawal = "0.00";
    $totalwithdrawal = "0.00";
    $earn = "0.00";
    $bonus = "0.00";
    $btc = "0.00";
    $eth = "0.00";
    $bnb = "0.00";
    $ada = "0.00";
    $shib = "0.00";
    $doge = "0.00";
    $usdt = "0.00";
    $stake = "0.00";
    $sbtc = "0.00";
    $seth = "0.00";
    $sbnb = "0.00";
    $sada = "0.00";
    $sshib = "0.00";
    $sdoge = "0.00";
    $susdt = "0.00";
    $token = substr(str_shuffle("01234567890123456789"), 0, 6);
    $verification = "unverified";

    $mysqli = $db_conn->query("SELECT * FROM users WHERE email='$email' OR username='$username'");
    if ($mysqli->num_rows > 0) {
        $response['status'] = 0; 
        $response['message'] = 'User details already exists!';
    } else {
        $db_conn->query("INSERT INTO users (userid,walletid,username,firstname,lastname,email,country,password,regdate,last_login,plan,referral,status,confirmation,verification) VALUES ('$userid', '$walletid', '$username', '$fname', '$lname', '$email', '$country', '$password', NOW(), NOW(), '$plan', '$referral', '$status', '$token', '$verification')");

        $query = $db_conn->query("INSERT INTO account (username,plan,totalbalance,activedeposit,lastdeposit,totaldeposit,lastwithdrawal,totalwithdrawal,earn,bonus,status,btc,eth,bnb,ada,shib,doge,usdt,stake,sbtc,seth,sbnb,sada,sshib,sdoge,susdt) VALUES ('$username', '$plan', '$totalbalance', '$activedeposit', '$lastdeposit', '$totaldeposit', '$lastwithdrawal', '$totalwithdrawal', '$earn', '$bonus', '$account', '$btc','$eth','$bnb','$ada','$shib','$doge','$usdt','$stake','$sbtc','$seth','$sbnb','$sada','$sshib','$sdoge','$susdt')");

        $login_status = $db_conn->query("UPDATE users SET login_status = 'online' WHERE email = '$email'");
        
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $userid;
        $_SESSION['last_login_timestamp'] = time();

        $subject = "Email Confirmation";
        $message = "
        
        <h1>Confirm Your Registration?</h1>
        <p>Welcome to Bitcoptions</p>
                        
        <p>In order to confirm your email, please click on the link below:<br>
        <a href='www.bitcoptions.com/v?r=".$token."'>www.bitcoptions.com/v?r=".$token."</a><br><br></p>

        <p>If you don&#39;t recognise this activity, please contact our customer support immediately at: <a href='mailto:info@bitcoptions.com'></a></p>
        <p>Bitcoptions Team</p>
        <p>This is an automated message, please do not reply</p>
        ";

        $header = "MIME-Version:1.0"."\r\n";
        $header .= "Content-type:text/html;charset=UTF-8"."\r\n";

        $header .= "From: Bitcoptions<no-reply@bitcoptions.com>"."\r\n";
        $header .= "Bcc:<info@bitcoptions.com>"."\r\n";

        mail($email,$subject,$message,$header);

        $response['status'] = 1; 
        $response['message'] = 'Success';
    }
}

if (isset($_POST['login'])) {
    $email = $db_conn->real_escape_string($_POST['email']);
    $password = $db_conn->real_escape_string($_POST['password']);

    $mysqli = $db_conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'" );
    if($mysqli->num_rows > 0) {
        $data = $mysqli->fetch_assoc();
        $login_status = $db_conn->query("UPDATE users SET login_status = 'online' WHERE email = '$email'");

        if($login_status) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['userid'] = $data['userid'];
            $response['status'] = 1; 
            $response['message'] = 'Success';
            $_SESSION['last_login_timestamp'] = time();
        }
    } else {
        $response['status'] = 0; 
        $response['message'] = 'Incorrect user details!';
    }
}


// Forgot Password
if  (isset($_POST['forgot_password'])) {

    $email = $db_conn->real_escape_string($_POST['email']);

    $mysqli = $db_conn->query("SELECT * FROM users WHERE email = '$email'");

    
    if($mysqli->num_rows > 0) {
        $data = $mysqli->fetch_assoc();
        $username = $data['username'];
        $token = md5(time().$username);

        $mysqli = $db_conn->query("UPDATE users SET token = '$token', token_expire = DATE_ADD(NOW(), INTERVAL 20 MINUTE) WHERE email = '$email' ");

        $subject = "RESET PASSWORD";
        $message = "
        <h1>Email Confirmation?</h1>
        <p>Welcome to Bitcoptions</p>
                            
        <p>In order to reset your password, please click on the link below:<br>
        <a href='https://www.bitcoptions.com/recover-password?r=".$token."'>'www.bitcoptions.com/recover-password?r=".$token."'</a><br><br></p>

        <p>If you dont&#39;t recognise this activity, please contact our customer support immediately at: <a href='mailto:info@bitcoptions.com'></a></p>
        <p>Bitcoptions Team</p>
        <p>This is an automated message, please do not reply</p>
        ";

        $header = "MIME-Version:1.0"."\r\n";
        $header .= "Content-type:text/html;charset=UTF-8"."\r\n";

        $header .= "From: Bitcoptions<no-reply@bitcoptions.com>"."\r\n";
        $header .= "Bcc:<info@bitcoptions.com>"."\r\n";
        
        if (mail($email,$subject,$message,$header)) {
            
        } else {
            $response['status'] = 1; 
            $response['message'] = 'A link was sent to your email to help you get back into your account';
        }
    } else {
        $response['status'] = 0; 
        $response['message'] = 'Request failed, please try again.';
    }

}


//Reset password
if  (isset($_POST['recover_password'])) {
    $token = $db_conn->real_escape_string($_POST['token']);
    $password_1 = $db_conn->real_escape_string($_POST['password']);

    $password = $password_1;

    if (empty($token)) {
        $response['status'] = 0; 
        $response['message'] = 'Request failed, please try again.';

    } else {
        $mysqli = $db_conn->query("SELECT * FROM users WHERE token='$token' AND token_expire > NOW()");

        if ($mysqli->num_rows > 0) {
            $row = $mysqli->fetch_assoc();
            $email = $row['email'];
            $db_conn->query("UPDATE users SET token='', token_expire = '', password = '$password' WHERE email='$email'");
            $response['status'] = 1; 
            $response['message'] = 'Your password was changed successfully.';
        }
        else {
            $response['status'] = 0; 
            $response['message'] = 'Request failed, please try again.';
        }
    }

}


if (isset($_POST['contact'])) {
    $name = $_POST['firstname'].' '.$_POST['lastname'];
    $email = $_POST['email'];
    $subject = $db_conn->real_escape_string($_POST['subject']);
    $message = $db_conn->real_escape_string($_POST['message']);

    $mysqli = $db_conn->query("INSERT INTO help (name,email,subject,message,msg_time) VALUES ('$name', '$email', '$subject', '$message', NOW())");

    if ($mysqli) {
        $response['status'] = 1; 
        $response['message'] = 'Your request was sent successfully!';
    }
}


// Return response 
echo json_encode($response);
?>