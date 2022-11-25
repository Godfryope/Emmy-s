<?php
session_start();
include('../database/dbconfig.php');

$uploadDir = '../account/img/';
$uploadFolder = '../account/uploads/';
$response = array( 
    'status' => 0, 
    'message' => 'Request failed, please try again.' 
);

if(isset($_POST['login'])) {
    $adminid = $db_conn->real_escape_string($_POST['adminid']);
    $password = $db_conn->real_escape_string($_POST['password']);

    $mysqli = $db_conn->query("SELECT * FROM admin WHERE adminid = '$adminid' AND password = '$password'" );
    if($mysqli->num_rows > 0) {
        $_SESSION['adminid'] = $adminid;
        $response['status'] = 1; 
        $response['message'] = 'Success';
    } else {
        $response['status'] = 0; 
        $response['message'] = 'Incorrect login details!';
    }
}

if (isset($_POST['edit_user'])) {
    $userid = $_POST['userid'];
    $newtotalbalance = $_POST['totalbalance'];
    $newactivedeposit = $_POST['activedeposit'];
    $newlastdeposit = $_POST['lastdeposit'];
    $newtotaldeposit = $_POST['totaldeposit'];
    $newlastwithdrawal = $_POST['lastwithdrawal'];
    $newtotalwithdrawal = $_POST['totalwithdrawal'];
    $newearn = $_POST['newearn'];
    $newbonus = $_POST['newbonus'];
    $btc = $_POST['btc'];
    $eth = $_POST['eth'];
    $bnb = $_POST['bnb'];
    $ada = $_POST['ada'];
    $xpr = $_POST['xpr'];
    $doge = $_POST['doge'];
    $usdt = $_POST['usdt'];

    $mysqli = $db_conn->query("UPDATE account SET 
        totalbalance = '$newtotalbalance',
        activedeposit = '$newactivedeposit',
        lastdeposit = '$newlastdeposit',
        totaldeposit = '$newtotaldeposit',
        totalbalance = '$newtotalbalance',
        lastwithdrawal = '$newlastwithdrawal',
        totalwithdrawal = '$newtotalwithdrawal',
        earn = '$newearn',
        bonus = '$newbonus',
        btc = '$btc',
        eth = '$eth',
        bnb = '$bnb',
        ada = '$ada',
        xpr = '$xpr',
        doge = '$doge',
        usdt = '$usdt'
        WHERE id = $userid");
    if ($mysqli) {
        $response['status'] = 1;
        $response['message'] = 'Account updated';
    }
}

if (isset($_POST['profit'])) {
    $transid = substr(str_shuffle("012345678901234567890"), 0, 5);
    $username = $_POST['username'];
    $wallet = $_POST['wallet'];
    $newearn = $_POST['profit'];
    $type = "profit";
    $method = "BTC";
    $status = "completed";
    
    $mysqli = $db_conn->query("SELECT * FROM account WHERE username = '$username'");
    if ($mysqli) {
        $row = $mysqli->fetch_assoc();

        $totalbalance = $row['totalbalance'];
        $activedeposit = $row['activedeposit'];
        $lastdeposit = $row['lastdeposit'];
        $totaldeposit = $row['totaldeposit'];
        $lastwithdrawal = $row['lastwithdrawal'];
        $totalwithdrawal = $row['totalwithdrawal'];
        $totalearn = $row['earn'];

        $newbalance = $totalbalance + $newearn;
        $earn = $totalearn + $newearn;

        $sqli = $db_conn->query("UPDATE account SET 
            totalbalance = '$newbalance',

            earn = '$earn'

            WHERE username = '$username'");

        

        if ($sqli) {
            if ($wallet == "btc") {
            $coin = $row['btc'];
            $btc = $coin + $newearn;
            $db_conn->query("UPDATE account SET btc = '$btc' WHERE username = '$username'");
            }
            elseif ($wallet == "eth") {
                $coin = $row['eth'];
                $eth = $coin + $newearn;
                $db_conn->query("UPDATE account SET eth = '$eth' WHERE username = '$username'");
            }
            elseif ($wallet == "bnb") {
                $coin = $row['bnb'];
                $bnb = $coin + $newearn;
                $db_conn->query("UPDATE account SET bnb = '$bnb' WHERE username = '$username'");
            }
            elseif ($wallet == "ada") {
                $coin = $row['ada'];
                $ada = $coin + $newearn;
                $db_conn->query("UPDATE account SET ada = '$ada' WHERE username = '$username'");
            }
            elseif ($wallet == "xpr") {
                $coin = $row['xpr'];
                $xpr = $coin + $newearn;
                $db_conn->query("UPDATE account SET xpr = '$xpr' WHERE username = '$username'");
            }
            elseif ($wallet == "doge") {
                $coin = $row['doge'];
                $doge = $coin + $newearn;
                $db_conn->query("UPDATE account SET doge = '$doge' WHERE username = '$username'");
            }
            elseif ($wallet == "usdt") {
                $coin = $row['usdt'];
                $usdt = $coin + $newearn;
                $db_conn->query("UPDATE account SET usdt = '$usdt' WHERE username = '$username'");
            }

            $sql = $db_conn->query("INSERT INTO transactions (transid,username,regdate,method,type,amount,status) VALUES ('$transid', '$username', NOW(), '$method', '$type', '$newearn','$status')");
            if ($sql) {
                $sqlio = $db_conn->query("SELECT * FROM users WHERE username = '$username'");
                $data = $sqlio->fetch_assoc();
                $response['status'] = 1; 
                $response['message'] = '
                    <div class="row">
                        <div class="col-sm-6">
                          <div class="text-muted pb-2 text-capitalize">Name: <span class="text-dark h5">'.$data['firstname'].' '.$data['lastname'].'</span></div>
                        </div>
                        <div class="col-sm-6">
                          <div class="text-muted pb-2">Username: <span class="text-dark h5">'.$username.'</span></div>
                        </div>
                        <div class="col-12 table-responsive">
                          <table class="table table-bordered text-center table-sm" style="font-size: 14px;">
                            <thead>
                              <th>Plan</th>
                              <th>Balance</th>
                              <th>Active</th>
                              <th>Profit</th>
                              <th>Bonus</th>
                            </thead>
                            <tbody>
                              <td class="text-warning">'.$row['plan'].'</td>
                              <td class="text-secondary">$'.number_format($newbalance).'</td>
                              <td class="text-secondary">$'.number_format($row['activedeposit']).'</td>
                              <td class="text-secondary">$'.number_format($earn).'</td>
                              <td class="text-secondary">$'.number_format($row['bonus']).'</td>
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="card w-100">
                        <div class="card-body">
                          <p class="text-success">Updated</p>
                          <button type="button" id="closeModalBtn" class="btn btn-default btn-block">Close</button>
                        </div>
                        
                    </div>
                ';
            }
        }
    }
}


if (isset($_POST['bonus'])) {
    $transid = substr(str_shuffle("012345678901234567890"), 0, 5);
    $username = $_POST['username'];
    $wallet = $_POST['wallet'];
    $newbonus = $_POST['bonus'];
    $type = "bonus";
    $method = "BTC";
    $status = "completed";
    
    $mysqli = $db_conn->query("SELECT * FROM account WHERE username = '$username'");
    if ($mysqli) {
        $row = $mysqli->fetch_assoc();

        $totalbalance = $row['totalbalance'];
        $activedeposit = $row['activedeposit'];
        $lastdeposit = $row['lastdeposit'];
        $totaldeposit = $row['totaldeposit'];
        $lastwithdrawal = $row['lastwithdrawal'];
        $totalwithdrawal = $row['totalwithdrawal'];
        $totalbonus = $row['bonus'];

        $newbalance = $totalbalance + $newbonus;
        $bonus = $totalbonus + $newbonus;

        $sqli = $db_conn->query("UPDATE account SET 
            totalbalance = '$newbalance',

            bonus = '$bonus'

            WHERE username = '$username'");

        

        if ($sqli) {
            if ($wallet == "btc") {
            $coin = $row['btc'];
            $btc = $coin + $newbonus;
            $db_conn->query("UPDATE account SET btc = '$btc' WHERE username = '$username'");
            }
            elseif ($wallet == "eth") {
                $coin = $row['eth'];
                $eth = $coin + $newbonus;
                $db_conn->query("UPDATE account SET eth = '$eth' WHERE username = '$username'");
            }
            elseif ($wallet == "bnb") {
                $coin = $row['bnb'];
                $bnb = $coin + $newbonus;
                $db_conn->query("UPDATE account SET bnb = '$bnb' WHERE username = '$username'");
            }
            elseif ($wallet == "ada") {
                $coin = $row['ada'];
                $ada = $coin + $newbonus;
                $db_conn->query("UPDATE account SET ada = '$ada' WHERE username = '$username'");
            }
            elseif ($wallet == "xpr") {
                $coin = $row['xpr'];
                $xpr = $coin + $newbonus;
                $db_conn->query("UPDATE account SET xpr = '$xpr' WHERE username = '$username'");
            }
            elseif ($wallet == "doge") {
                $coin = $row['doge'];
                $doge = $coin + $newbonus;
                $db_conn->query("UPDATE account SET doge = '$doge' WHERE username = '$username'");
            }
            elseif ($wallet == "usdt") {
                $coin = $row['usdt'];
                $usdt = $coin + $newbonus;
                $db_conn->query("UPDATE account SET usdt = '$usdt' WHERE username = '$username'");
            }

            $sql = $db_conn->query("INSERT INTO transactions (transid,username,regdate,method,type,amount,status) VALUES ('$transid', '$username', NOW(), '$method', '$type', '$newbonus','$status')");
            if ($sql) {
                $sqlio = $db_conn->query("SELECT * FROM users WHERE username = '$username'");
                $data = $sqlio->fetch_assoc();
                $response['status'] = 1; 
                $response['message'] = '
                    <div class="row">
                        <div class="col-sm-6">
                          <div class="text-muted pb-2 text-capitalize">Name: <span class="text-dark h5">'.$data['firstname'].' '.$data['lastname'].'</span></div>
                        </div>
                        <div class="col-sm-6">
                          <div class="text-muted pb-2">Username: <span class="text-dark h5">'.$username.'</span></div>
                        </div>
                        <div class="col-12 table-responsive">
                          <table class="table table-bordered text-center table-sm" style="font-size: 14px;">
                            <thead>
                              <th>Plan</th>
                              <th>Balance</th>
                              <th>Active</th>
                              <th>Profit</th>
                              <th>Bonus</th>
                            </thead>
                            <tbody>
                              <td class="text-warning">'.$row['plan'].'</td>
                              <td class="text-secondary">$'.number_format($newbalance).'</td>
                              <td class="text-secondary">$'.number_format($row['activedeposit']).'</td>
                              <td class="text-secondary">$'.number_format($row['earn']).'</td>
                              <td class="text-secondary">$'.number_format($bonus).'</td>
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="card w-100">
                        <div class="card-body">
                          <p class="text-success">Updated</p>
                          <button type="button" id="closeModalBtn" class="btn btn-default btn-block">Close</button>
                        </div>
                        
                    </div>
                ';
            }
        }
    }
}


if (isset($_POST['coin'])) {
    $coin = $_POST['coin'];
    $value = $_POST['value'];
    $barcode = date('d-m-Y-H-i-s').'-'.$_FILES["barcode"]["name"];
    $walletid = $_POST['walletid'];

    $mysqliStatus = 1;
    
    // Upload file 
    $uploadedPhoto = '';


    // Photo path config 
    $photoName = basename(rand().time().$_FILES["barcode"]["name"]); 
    $targetFilePath = $uploadDir . $photoName; 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
     
    // Allow certain file formats 
    $allowTypes = array('jpg', 'png', 'jpeg'); 
    if(in_array($fileType, $allowTypes)){ 
        // Upload file to the server 
        if(move_uploaded_file($_FILES["barcode"]["tmp_name"], $targetFilePath)){ 
            $uploadedPhoto = $photoName; 
        }else{ 
            $mysqliStatus = 0; 
            $response['message'] = 'Request failed, please try again.'; 
        } 
    }else{ 
        $mysqliStatus = 0; 
        $response['message'] = 'Sorry, only JPG, JPEG, & PNG files are allowed to upload.'; 
    }

    if($mysqliStatus == 1){
         // Insert form data in the database
        $mysqli = $db_conn->query("UPDATE coins SET value = '$value', barcode = '$uploadedPhoto', walletid = '$walletid' WHERE coin = '$coin'");
        if ($mysqli) {
            $response['status'] = 1; 
            $response['message'] = 'Coin has been updated successfully';
        }
    }
}

if (isset($_POST['coin-value'])) {
    $coin = $_POST['coin-value'];
    $value = $_POST['value'];

     // Insert form data in the database
    $mysqli = $db_conn->query("UPDATE coins SET value = '$value' WHERE coin = '$coin'");
    
    $response['status'] = 1; 
    $response['message'] = 'Coin has been updated successfully';
}

if(isset($_POST['verify'])) {
    $username = $_POST['username'];

    $mysqli = $db_conn->query("UPDATE users SET verification = 'verfied' WHERE username = '$username'" );
    if($mysqli) {
        $response['status'] = 1; 
        $response['message'] = 'Success';
    }
}


if (isset($_POST['getmsg'])) {
  $id = $_POST['id'];
  $mysql = $db_conn->query("SELECT * FROM help WHERE id = '$id'");
  $data = $mysql->fetch_assoc();

  $date = date_create($data['msg_time']);

  $response['status'] = 1; 
  $response['message'] = '
    <div class="mailbox-read-info">
        <h5>'.$data['subject'].'</h5>
        <h6>From: '.$data['email'].'
          <span class="mailbox-read-time float-right">'.date_format($date,"F d, Y h:i:s").'</span></h6>
        </div>
        <!-- /.mailbox-read-info -->
        <div class="mailbox-controls with-border text-center">
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
            <i class="far fa-trash-alt"></i>
          </button>
          <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
            <i class="fas fa-reply"></i>
          </button>
          <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
            <i class="fas fa-share"></i>
          </button>
        </div>
        <!-- /.btn-group -->
        <button type="button" class="btn btn-default btn-sm" title="Print">
          <i class="fas fa-print"></i>
        </button>
        </div>
        <!-- /.mailbox-controls -->
        <div class="mailbox-read-message">
        <p>'.$data['message'].'</p>
    </div>
    <!-- /.mailbox-read-message -->
  ';
}


if (isset($_POST['getchat'])) {
  $userid = $_POST['userid'];
  $mysql = $db_conn->query("SELECT * FROM help WHERE id = '$id'");
  $data = $mysql->fetch_assoc();

  $date = date_create($data['msg_time']);

  $response['status'] = 1; 
  $response['message'] = '
    <div class="mailbox-read-info">
        <h5>'.$data['subject'].'</h5>
        <h6>From: '.$data['email'].'
          <span class="mailbox-read-time float-right">'.date_format($date,"F d, Y h:i:s").'</span></h6>
        </div>
        <!-- /.mailbox-read-info -->
        <div class="mailbox-controls with-border text-center">
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
            <i class="far fa-trash-alt"></i>
          </button>
          <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
            <i class="fas fa-reply"></i>
          </button>
          <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
            <i class="fas fa-share"></i>
          </button>
        </div>
        <!-- /.btn-group -->
        <button type="button" class="btn btn-default btn-sm" title="Print">
          <i class="fas fa-print"></i>
        </button>
        </div>
        <!-- /.mailbox-controls -->
        <div class="mailbox-read-message">
        <p>'.$data['message'].'</p>
    </div>
    <!-- /.mailbox-read-message -->
  ';
}


if (isset($_POST['delete_user'])) {
    $username = $_POST['username'];
    $mysqli = $db_conn->query("DELETE FROM users WHERE username='$username'");
    if ($mysqli) {
        $sql = $db_conn->query("DELETE FROM transactions WHERE username = '$username'");

        if ($sql) {
            $sqli = $db_conn->query("DELETE FROM account WHERE username = '$username'");
            if ($sqli) {
                $response['status'] = 1; 
                $response['message'] = 'Deleted';
            }
        }
    }
}


if (isset($_POST['view_user'])) {
    $username = $_POST['username'];
    $mysqli = $db_conn->query("SELECT * FROM users WHERE username = '$username'");
      $data = $mysqli->fetch_assoc();

      $verification = $data['verification'];

           $status = '';
           $verify = '';

      $output = '
        <div class="card rounded-0 border-0 shadow-none">
            <div class="card-body">
              <div class="row">
                <div class="col-md-5">
                  <!-- Profile Image -->
                  <div id="userProfile" class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      
                      <h3 class="profile-username text-center text-capitalize">'.$data['firstname'].' '.$data['lastname'].'</h3>';
                      if ($verification == 'verified') {
                        $status = '<p class="text-capitalize text-center text-success">'.$verification.'</p>';
                        $verify = '';
                      }
                      elseif ($verification == 'pending') {
                        $status = '<p class="text-capitalize text-center text-warning">'.$verification.'</p>';
                        $verify = '<button id="verifyBtn" data-user="'.$username.'" data-verify="'.$username.'" type="button" class="btn btn-primary btn-block"><b>Verify</b></button>';
                      }
                      elseif ($verification == 'unverified') {
                        $status = '<p class="text-capitalize text-center text-danger">'.$verification.'</p>';
                        $verify = '<button id="verifyBtn" data-user="'.$username.'" data-verify="'.$username.'" type="button" class="btn btn-primary btn-block"><b>Verify</b></button>';
                      }

                $output .= $status;

                      $output .= '<ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          <b>First Name</b> <a class="float-right text-capitalize">'.$data['firstname'].'</a>
                        </li>
                        <li class="list-group-item">
                          <b>Last Name</b> <a class="float-right text-capitalize">'.$data['lastname'].'</a>
                        </li>
                        <li class="list-group-item">
                          <b>Middle Name</b> <a class="float-right text-capitalize">'.$data['middlename'].'</a>
                        </li>
                        <li class="list-group-item">
                          <b>Date of Birth</b> <a class="float-right text-capitalize">'.$data['dob'].'</a>
                        </li>
                        <li class="list-group-item">
                          <b>Country</b> <a class="float-right text-capitalize">'.$data['country'].'</a>
                        </li>
                        <li class="list-group-item">
                          <b>Nationality</b> <a class="float-right text-capitalize">'.$data['nationality'].'</a>
                        </li>
                        <li class="list-group-item">
                          <b>Plan</b> <a class="float-right text-capitalize">'.$data['plan'].'</a>
                        </li>
                      </ul>';
                      $output .= $verify;
                    $output .='</div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-7">
                  <div class="card">
                    <div class="card-body">
                      <img src="../account/uploads/'.$data['passport'].'" alt="" class="img-thumbnail p-0 border-0">
                    </div><!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
            </div>
        </div>
      ';

      $response['status'] = 1; 
      $response['message'] = $output;
}


if(isset($_POST['user_status'])) {
    $status = $_POST['user_status'];
    $username = $_POST['username'];
    if($status == 'suspended') {
        $sql = $db_conn->query("UPDATE account SET status = 'active' WHERE username = '$username'");
        $response['status'] = 1; 
        $response['message'] = 'User account has been activated';

    } elseif ($status == 'active') {
        $sql = $db_conn->query("UPDATE account SET status = 'suspended' WHERE username = '$username'");
        $response['status'] = 1; 
        $response['message'] = 'User account has been deactivated';
    }
}

if (isset($_POST['approve_deposit'])) {
    $transid = $_POST['transid'];
    $username = $_POST['username'];
    $status = $_POST['status'];
    $amount = $_POST['amount'];
    $plan = $_POST['plan'];
    $method = $_POST['method'];

    $mysqli = $db_conn->query("SELECT * FROM account WHERE username = '$username'");
    if ($mysqli) {
        $row = $mysqli->fetch_assoc();
        
        $totalbalance = $row['totalbalance'];
        $activedeposit = $row['activedeposit'];
        $lastdeposit = $row['lastdeposit'];
        $totaldeposit = $row['totaldeposit'];
        $lastwithdrawal = $row['lastwithdrawal'];
        $totalwithdrawal = $row['totalwithdrawal'];

        $newactivedeposit = $activedeposit + $amount;
        $newbalance = $totalbalance + $amount;

        $sqli = $db_conn->query("UPDATE account SET 
            plan = '$plan',
            totalbalance = '$newbalance',
            activedeposit = '$newactivedeposit',
            lastdeposit = '$amount',
            totaldeposit = '$newbalance',
            lastwithdrawal = '$lastwithdrawal'
            
            WHERE username ='$username'");
        if ($sqli) {
            if ($method == 'btc') {
                $btc = $row['btc'];
                $newbtc = $btc + $amount;
                $run = $db_conn->query("UPDATE account SET btc = '$newbtc' WHERE username = '$username'");
            }
            if ($method == 'eth') {
                $eth = $row['eth'];
                $neweth = $eth + $amount;
                $run = $db_conn->query("UPDATE account SET eth = '$neweth' WHERE username = '$username'");
            }
            if ($method == 'bnb') {
                $bnb = $row['bnb'];
                $newbnb = $bnb + $amount;
                $run = $db_conn->query("UPDATE account SET bnb = '$newbnb' WHERE username = '$username'");
            }
            if ($method == 'ada') {
                $ada = $row['ada'];
                $newada = $ada + $amount;
                $run = $db_conn->query("UPDATE account SET ada = '$newada' WHERE username = '$username'");
            }
            if ($method == 'xpr') {
                $xpr = $row['xpr'];
                $newxpr = $xpr + $amount;
                $run = $db_conn->query("UPDATE account SET xpr = '$newxpr' WHERE username = '$username'");
            }
            if ($method == 'doge') {
                $doge = $row['doge'];
                $newdoge = $doge + $amount;
                $run = $db_conn->query("UPDATE account SET doge = '$newdoge' WHERE username = '$username'");
            }
            if ($method == 'usdt') {
                $usdt = $row['usdt'];
                $newusdt = $usdt + $amount;
                $run = $db_conn->query("UPDATE account SET usdt = '$newusdt' WHERE username = '$username'");
            }

            $sql = $db_conn->query("UPDATE transactions SET status = '$status' WHERE transid ='$transid'");

            if ($sql) {
                $response['status'] = 1; 
                $response['message'] = "TRANSACTION APPROVED";
            }
        }
    }
}


if (isset($_POST['disapprove_deposit'])) {
    $transid = $_POST['transid'];
    $username = $_POST['username'];
    $status = $_POST['status'];
    $amount = $_POST['amount'];
    $plan = $_POST['plan'];

    $mysqli = $db_conn->query("SELECT * FROM account WHERE username='$username'");
    if ($mysqli) {
        $row = $mysqli->fetch_assoc();
        
        $totalbalance = $row['totalbalance'];
        $activedeposit = $row['activedeposit'];
        $lastdeposit = $row['lastdeposit'];
        $totaldeposit = $row['totaldeposit'];
        $lastwithdrawal = $row['lastwithdrawal'];
        $totalwithdrawal = $row['totalwithdrawal'];

        $sqli = $db_conn->query("UPDATE account SET 
            lastdeposit = '$amount'
            WHERE username ='$username'");
        if ($sqli) {
            $sql = $db_conn->query("UPDATE transactions SET status = '$status' WHERE transid ='$transid'");

            if ($sql) {
                $response['status'] = 1; 
                $response['message'] = "TRANSACTION DISAPPROVED";
            }
        }
    }
}


if (isset($_POST['approve_withdraw'])) {
    $transid = $_POST['transid'];
    $username = $_POST['username'];
    $status = $_POST['status'];
    $amount = $_POST['amount'];
    $method = $_POST['method'];

    $mysqli = $db_conn->query("SELECT * FROM account WHERE username='$username'");
    if ($mysqli) {
        $row = $mysqli->fetch_assoc();
        
        $balance = $row['totalbalance'];
        $activedeposit = $row['activedeposit'];
        $lastdeposit = $row['lastdeposit'];
        $totaldeposit = $row['totaldeposit'];
        $lastwithdrawal = $row['lastwithdrawal'];
        $totalwithdrawal = $row['totalwithdrawal'];

        $newactivedeposit = $activedeposit - $amount;
        $newbalance = $balance - $amount;
        $newtotalwithdrawal = $amount + $totalwithdrawal;

        $sqli = $db_conn->query("UPDATE account SET 
            totalbalance = '$newbalance',
            activedeposit = '$newactivedeposit',
            lastdeposit = '$lastdeposit',
            totaldeposit = '$totaldeposit',
            lastwithdrawal = '$amount',
            totalwithdrawal = '$newtotalwithdrawal'

            WHERE username = '$username'");
        if ($sqli) {
            if ($method == 'btc') {
                $btc = $row['btc'];
                $newbtc = $btc - $amount;
                $run = $db_conn->query("UPDATE account SET btc = '$newbtc' WHERE username = '$username'");
            }
            if ($method == 'eth') {
                $eth = $row['eth'];
                $neweth = $eth - $amount;
                $run = $db_conn->query("UPDATE account SET eth = '$neweth' WHERE username = '$username'");
            }
            if ($method == 'bnb') {
                $bnb = $row['bnb'];
                $newbnb = $bnb - $amount;
                $run = $db_conn->query("UPDATE account SET bnb = '$newbnb' WHERE username = '$username'");
            }
            if ($method == 'ada') {
                $ada = $row['ada'];
                $newada = $ada - $amount;
                $run = $db_conn->query("UPDATE account SET ada = '$newada' WHERE username = '$username'");
            }
            if ($method == 'xpr') {
                $xpr = $row['xpr'];
                $newxpr = $xpr - $amount;
                $run = $db_conn->query("UPDATE account SET xpr = '$newxpr' WHERE username = '$username'");
            }
            if ($method == 'doge') {
                $doge = $row['doge'];
                $newdoge = $doge - $amount;
                $run = $db_conn->query("UPDATE account SET doge = '$newdoge' WHERE username = '$username'");
            }
            if ($method == 'usdt') {
                $usdt = $row['usdt'];
                $newusdt = $usdt - $amount;
                $run = $db_conn->query("UPDATE account SET usdt = '$newusdt' WHERE username = '$username'");
            }

            $sql = $db_conn->query("UPDATE transactions SET status = '$status' WHERE transid ='$transid'");
    
            if ($sql) {
                $response['status'] = 1; 
                $response['message'] = "TRANSACTION APPROVED";
            }
        }
    }
        
}


if (isset($_POST['disapprove_withdraw'])) {
    $transid = $_POST['transid'];
    $username = $_POST['username'];
    $status = $_POST['status'];
    $amount = $_POST['amount'];

    $mysqli = $db_conn->query("SELECT * FROM account WHERE username='$username'");
    if ($mysqli) {
        $row = $mysqli->fetch_assoc();
        
        $balance = $row['totalbalance'];
        $activedeposit = $row['activedeposit'];
        $lastdeposit = $row['lastdeposit'];
        $totaldeposit = $row['totaldeposit'];
        $lastwithdrawal = $row['lastwithdrawal'];
        $totalwithdrawal = $row['totalwithdrawal'];

        $sqli = $db_conn->query("UPDATE account SET 
            lastwithdrawal = '$amount'
            WHERE username = '$username'");
        if ($sqli) {
            $sql = $db_conn->query("UPDATE transactions SET status = '$status' WHERE transid ='$transid'");
            
            if ($sql) {
                $response['status'] = 1; 
                $response['message'] = "TRANSACTION DISAPPROVED";
            }
        }
    }
}


if (isset($_POST['approve_transfer'])) {
    $transid = $_POST['transid'];
    $username = $_POST['username'];
    $status = $_POST['status'];
    $amount = $_POST['amount'];
    $method = $_POST['method'];

    $mysqli = $db_conn->query("SELECT * FROM account WHERE username='$username'");
    if ($mysqli) {
        $row = $mysqli->fetch_assoc();
        
        $balance = $row['totalbalance'];
        $activedeposit = $row['activedeposit'];
        $lastdeposit = $row['lastdeposit'];
        $totaldeposit = $row['totaldeposit'];
        $lastwithdrawal = $row['lastwithdrawal'];
        $totalwithdrawal = $row['totalwithdrawal'];

        $newactivedeposit = $activedeposit - $amount;
        $newbalance = $balance - $amount;
        $newtotalwithdrawal = $amount + $totalwithdrawal;

        $sqli = $db_conn->query("UPDATE account SET 
            totalbalance = '$newbalance',
            activedeposit = '$newactivedeposit',
            lastdeposit = '$lastdeposit',
            totaldeposit = '$totaldeposit',
            lastwithdrawal = '$amount',
            totalwithdrawal = '$newtotalwithdrawal'

            WHERE username = '$username'");
        if ($sqli) {
            if ($method == 'btc') {
                $btc = $row['btc'];
                $newbtc = $btc - $amount;
                $run = $db_conn->query("UPDATE account SET btc = '$newbtc' WHERE username = '$username'");
            }
            if ($method == 'eth') {
                $eth = $row['eth'];
                $neweth = $eth - $amount;
                $run = $db_conn->query("UPDATE account SET eth = '$neweth' WHERE username = '$username'");
            }
            if ($method == 'bnb') {
                $bnb = $row['bnb'];
                $newbnb = $bnb - $amount;
                $run = $db_conn->query("UPDATE account SET bnb = '$newbnb' WHERE username = '$username'");
            }
            if ($method == 'ada') {
                $ada = $row['ada'];
                $newada = $ada - $amount;
                $run = $db_conn->query("UPDATE account SET ada = '$newada' WHERE username = '$username'");
            }
            if ($method == 'xpr') {
                $xpr = $row['xpr'];
                $newxpr = $xpr - $amount;
                $run = $db_conn->query("UPDATE account SET xpr = '$newxpr' WHERE username = '$username'");
            }
            if ($method == 'doge') {
                $doge = $row['doge'];
                $newdoge = $doge - $amount;
                $run = $db_conn->query("UPDATE account SET doge = '$newdoge' WHERE username = '$username'");
            }
            if ($method == 'usdt') {
                $usdt = $row['usdt'];
                $newusdt = $usdt - $amount;
                $run = $db_conn->query("UPDATE account SET usdt = '$newusdt' WHERE username = '$username'");
            }

            $sql = $db_conn->query("UPDATE transactions SET status = '$status' WHERE transid ='$transid'");
            
            if ($sql) {
                $response['status'] = 1; 
                $response['message'] = "TRANSACTION APPROVED";
            }
        }
    }
        
}


if (isset($_POST['disapprove_transfer'])) {
    $transid = $_POST['transid'];
    $username = $_POST['username'];
    $status = $_POST['status'];
    $amount = $_POST['amount'];

    $mysqli = $db_conn->query("SELECT * FROM account WHERE username='$username'");
    if ($mysqli) {
        $row = $mysqli->fetch_assoc();
        
        $balance = $row['totalbalance'];
        $activedeposit = $row['activedeposit'];
        $lastdeposit = $row['lastdeposit'];
        $totaldeposit = $row['totaldeposit'];
        $lastwithdrawal = $row['lastwithdrawal'];
        $totalwithdrawal = $row['totalwithdrawal'];

        $sqli = $db_conn->query("UPDATE account SET 
            lastwithdrawal = '$amount'
            WHERE username = '$username'");
        if ($sqli) {
            $sql = $db_conn->query("UPDATE transactions SET status = '$status' WHERE transid ='$transid'");
    
            if ($sql) {
                $response['status'] = 1; 
                $response['message'] = "TRANSACTION DISAPPROVED";
            }
        }
    }
        
}


if (isset($_POST['delete_transaction'])) {
    $trackid = $_POST['trackid'];
    $username = $_POST['username'];
    $mysqli = $db_conn->query("DELETE FROM transactions WHERE username='$username' AND trackid = '$trackid'");
    if ($mysqli) {
        $response['status'] = 1; 
        $response['message'] = "Transaction Deleted";
    }
}

if (isset($_POST['approve_purchase'])) {
    $trackid = $_POST['trackid'];
    $status = $_POST['status'];
    $mysqli = $db_conn->query("UPDATE hardware SET status = '$status' WHERE trackid  = '$trackid'");
    if ($mysqli) {
        $response['status'] = 1; 
        $response['message'] = "Purchase approved";
    }
}


if (isset($_POST['disapprove_purchase'])) {
    $trackid = $_POST['trackid'];
    $status = $_POST['status'];
    $mysqli = $db_conn->query("UPDATE hardware SET status = '$status' WHERE trackid  = '$trackid'");
    if ($mysqli) {
        $response['status'] = 1; 
        $response['message'] = "Purchase disapproved";
    }
}


if (isset($_POST['delete_purchase'])) {
    $trackid = $_POST['trackid'];
    $mysqli = $db_conn->query("DELETE FROM hardwared WHERE trackid = '$trackid'");
    if ($mysqli) {
        $response['status'] = 1; 
        $response['message'] = "Transaction Deleted";
    }
}
// Return response 
echo json_encode($response);
?>