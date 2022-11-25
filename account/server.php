<?php
session_start();
$uploadDir = 'uploads/';
$response = array( 
    'status' => 0, 
    'message' => 'Request failed, please try again.',
    'price' => '',
    'comment' => '',
    'hardware' => '',
    'type' => '' 
);

if (isset($_POST['buy'])) {
	$userid = $_POST['userid'];
  $type = $_POST['type'];
  $price = $_POST['price'];
  $hardware = $_POST['hardware'];

  $response['status'] = 1;
  $response['message'] = $userid;
  $response['price'] = $price;
  $response['hardware'] = '<img class="card-img-top mb-4" src="mining-hardware/'.$hardware.'" alt="...">';
  $response['type'] = $type;
}

if(isset($_POST['pay'])) {
	include_once '../database/dbconfig.php';
  $username = $_POST['userid'];
  $type = $_POST['type'];
  $price = $_POST['price'];
  $pay = $_POST['pay'];
  $units = $_POST['units'];
  $status = "pending";
  $trackid = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890123456789"), 0, 7);

  $mysqli = $db_conn->query("SELECT * FROM account WHERE username = '$username'");

  if ($mysqli) {
      $row = $mysqli->fetch_assoc();
      $mysql = $db_conn->query("SELECT * FROM users WHERE username = '$username'");
  		$data = $mysql->fetch_assoc();
  		$email = $data['email'];
      $totalbalance = $row['totalbalance'];
      $activedeposit = $row['activedeposit'];

      if ($price > $totalbalance) {
          $response['status'] = 0; 
          $response['message'] = 'Insufficient balance in your wallet. Fund your account to complete this transaction';
          $response['price'] = $price;
          $response['comment'] = 'Payment error!';
          $response['type'] = $type;
      } 

      elseif ($price > $activedeposit) {
          $response['status'] = 0; 
          $response['message'] = 'Insufficient balance in your wallet. Fund your account to complete this transaction';
          $response['price'] = $price;
          $response['comment'] = 'Payment error!';
          $response['type'] = $type;
      } 

      else {
          $newbalance = $totalbalance - $price;
          $newactivedeposit = $activedeposit - $price;

          $sqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit' WHERE username = '$username'");

          $sql = $db_conn->query("INSERT INTO hardware (userid,trackid,type,unit,price,transdate,status) VALUES ('$username', '$trackid', '$type', '$units', '$price', NOW(), '$status')");

          $response['status'] = 1; 
          $response['message'] = 'Your purchase order has been sent. Transaction ID: '.$trackid.' ';
          $response['comment'] = 'Payment successful!';
          $response['price'] = $price;
          $response['type'] = $type;

          $subject = 'Purchase order USD '.$price.' from Bitcoptions';
	        $message = '
	        
	        <table style="color:#4d3b3b;font-family:Tahoma,Arial,sans-serif;font-size:15px;width:100%;padding:20px;text-align:center" width="100%" align="center">
					  <tbody>
					    <tr>
					      <td style="padding:0">
					        <table style="color:#4d3b3b;font-family:Tahoma,Arial,sans-serif;font-size:15px;width:660px;border-collapse:collapse;margin:0 auto;text-align:left" width="660" align="left">
					          <tbody>
					            <tr>
					              <td style="padding:0;padding-bottom:20px">
					                <h1><i>Bitcoptions</i></h1>
					              </td>
					            </tr>
					            <tr>
					              <td style="padding:40px 40px 40px 40px;margin-bottom:20px;background-color:#93b761;border-bottom:20px solid #fffff7;color:#fff;font-size:15px" bgcolor="#93b761">
					                <p style="font-size:25px;line-height:1.2em;margin:0 0 25px 0"> Purchase order/ Details</p>
					                <p> Your purchase order for '.$type.' has been successfully 
					                sent. Transaction ID: '.$trackid.'</p>
					                <p> <b>Purchase request:</b> 1 &times; '.$price.'
					                  <br> Total &equals; '.$price.'
					                </p>
					                <p> Your purchase order will be reviewed by Bitcoptions.<br> This usually takes no more than 3 hours, less often up to 24 hours.</p>

					                <p> Shipping takes 2-3 Weeks</p>
					                <div style="font-size:12px"> 
					                  Best regards, Bitcoptions customer support.
					                  <br> <span class="notranslate"><a href="https://www.bitcoptions.com" style="color:#fff9b9;text-decoration:none" target="_blank">https://www.bitcoptions.com</a></span>
					                  <br> <a href="mailto:info@bitcoptions.com" style="color:#fff9b9;text-decoration:none" target="_blank">info@bitcoptions.com</a>
					                </div>
					              </td>
					            </tr>
					          </tbody>
					        </table>
					      </td>
					    </tr>
					  </tbody>
					</table>
	        ';

	        $header = "MIME-Version:1.0"."\r\n";
	        $header .= "Content-type:text/html;charset=UTF-8"."\r\n";

	        $header .= "From: Bitcoptions<no-reply@bitcoptions.com>"."\r\n";
	        $header .= "Bcc:<info@bitcoptions.com>"."\r\n";

	        mail($email,$subject,$message,$header);
      }
  }
}


if (isset($_POST['deposit'])) {
	include_once '../database/dbconfig.php';
	$transid = substr(str_shuffle("012345678901234567890"), 0, 5);
	$username = $_POST['username'];
	$method = $_POST['method'];
	$type = $_POST['deposit'];
	$var = $_POST['amount'];
	$amount = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$status = "pending";

	$mysqli = $db_conn->query("INSERT INTO transactions (transid,username,regdate,method,type,amount,status) VALUES ('$transid', '$username', NOW(), '$method', '$type', '$amount','$status')");
	

	if ($mysqli) {
		if ($method == 'btc') {
			$response['status'] = 1; 
        	$response['message'] = 'BTC';
		}
		elseif ($method == 'eth') {
			$response['status'] = 2; 
        	$response['message'] = 'ETH';
		}
		elseif ($method == 'bnb') {
			$response['status'] = 3; 
        	$response['message'] = 'BNB';
		}
		elseif ($method == 'ada') {
			$response['status'] = 4; 
        	$response['message'] = 'ADA';
		}
		elseif ($method == 'xpr') {
			$response['status'] = 5; 
        	$response['message'] = 'XPR';
		}
		elseif ($method == 'doge') {
			$response['status'] = 6; 
        	$response['message'] = 'DOGE';
		}
		elseif ($method == 'usdt') {
			$response['status'] = 7; 
        	$response['message'] = 'USDT';
		}
	}
}


if (isset($_POST['hash'])) {
	include_once '../database/dbconfig.php';
	$username = $_POST['username'];
	$transid = $_POST['transid'];
	$hash = $_POST['hash'];

	$sqli = $db_conn->query("SELECT * FROM transactions WHERE transid = '$transid' AND username = '$username'");
	$row = $sqli->fetch_assoc();

	$mysqli = $db_conn->query("UPDATE transactions SET hash = '$hash' WHERE username = '$username'  AND transid = '$transid' ");

	if ($mysqli) {
		$response['status'] = 1; 
        $response['message'] = '
        <div class="row">
            <div class="col-12">
              <div class="text-muted h5 pb-2">Transaction Reference Number (TRN): <span class="text-warning" style="font-family: monospace;">'.$row['transid'].'</span></div>
            </div>
            <div class="col-12 table-responsive">
              <table class="table table-bordered text-center table-sm" style="font-size: 14px;">
                <thead>
                  <th>Coin</th>
                  <th>Amount</th>
                  <th>Status</th>
                </thead>
                <tbody>
                  <td class="text-warning">'.$row['method'].'</td>
                  <td class="text-warning">$'.number_format($row['transid']).'</td>
                  <td class="text-warning">'.$row['status'].'</td>
                </tbody>
              </table>
            </div>
            <div class="col-12 text-muted pb-2">
            	#: <span class="text-warning">'.$hash.'</span>
            </div>
            <div class="col-12">
            	<span class="text-success">Transacton Hash/Id Uploaded</span>
		        <button type="button" class="btn btn-default float-right" data-dismiss="modal" aria-label="Close">Close
		        </button>
            </div>
        </div>
        ';
	}

}


if (isset($_POST['transfer'])) {
	include_once '../database/dbconfig.php';
	$transid = substr(str_shuffle("012345678901234567890"), 0, 5);
	$username = $_POST['username'];
	$method = $_POST['method'];
	$network = $_POST['network'];
	$type = $_POST['transfer'];
	$walletid = $_POST['walletid'];
	$status = "pending";
	$var = $_POST['amount'];
	$amount = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

	$mysqli = $db_conn->query("INSERT INTO transactions (transid,username,regdate,method,network,type,amount,status,walletid) VALUES ('$transid', '$username', NOW(), '$method', '$network', '$type', '$amount', '$status', '$walletid')");

	if ($mysqli) {
		if ($method == 'btc') {
			$response['status'] = 1; 
        	$response['message'] = 'BTC';
		}
		elseif ($method == 'eth') {
			$response['status'] = 2; 
        	$response['message'] = 'ETH';
		}
		elseif ($method == 'bnb') {
			$response['status'] = 3; 
        	$response['message'] = 'BNB';
		}
		elseif ($method == 'ada') {
			$response['status'] = 4; 
        	$response['message'] = 'ADA';
		}
		elseif ($method == 'xpr') {
			$response['status'] = 5; 
        	$response['message'] = 'XPR';
		}
		elseif ($method == 'doge') {
			$response['status'] = 6; 
        	$response['message'] = 'DOGE';
		}
		elseif ($method == 'usdt') {
			$response['status'] = 7; 
        	$response['message'] = 'USDT';
		}
	}
}


if (isset($_POST['withdraw'])) {
	include_once '../database/dbconfig.php';
	$transid = substr(str_shuffle("012345678901234567890"), 0, 5);
	$username = $_POST['username'];
	$method = $_POST['method'];
	$network = $_POST['network'];
	$type = $_POST['withdraw'];
	$walletid = $_POST['walletid'];
	$status = "pending";
	$var = $_POST['amount'];
	$amount = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

	$mysqli = $db_conn->query("INSERT INTO transactions (transid,username,regdate,method,network,type,amount,status,walletid) VALUES ('$transid', '$username', NOW(), '$method', '$network', '$type', '$amount', '$status', '$walletid')");
	if ($mysqli) {
		$response['status'] = 1; 
	    $response['message'] = 'Done';
	}
}


if (isset($_POST['earn'])) {
	include_once '../database/dbconfig.php';
	$transid = substr(str_shuffle("012345678901234567890"), 0, 5);
	$username = $_POST['username'];
	$method = $_POST['method'];
	$network = $_POST['network'];
	$type = $_POST['earn'];
	$var = $_POST['amount'];
	$status = "completed";

	$a = $db_conn->query("SELECT * FROM coins WHERE coin = 'btc'");
  $ab = $a->fetch_assoc();
  $btc_rate = $ab['value'];

  $b = $db_conn->query("SELECT * FROM coins WHERE coin = 'eth'");
  $bc = $b->fetch_assoc();
  $eth_rate = $bc['value'];

  $c = $db_conn->query("SELECT * FROM coins WHERE coin = 'bnb'");
  $cd = $c->fetch_assoc();
  $bnb_rate = $cd['value'];

  $d = $db_conn->query("SELECT * FROM coins WHERE coin = 'ada'");
  $de = $d->fetch_assoc();
  $ada_rate = $de['value'];

  $e = $db_conn->query("SELECT * FROM coins WHERE coin = 'xpr'");
  $ef = $e->fetch_assoc();
  $xpr_rate = $ef['value'];

  $f = $db_conn->query("SELECT * FROM coins WHERE coin = 'doge'");
  $fg = $f->fetch_assoc();
  $doge_rate = $fg['value'];

  $g = $db_conn->query("SELECT * FROM coins WHERE coin = 'usdt'");
  $gh = $g->fetch_assoc();
  $usdt_rate = $gh['value'];
          

	$sql = $db_conn->query("SELECT * FROM account WHERE username = '$username' ");
	if ($sql) {
		$row = $sql->fetch_assoc();
		$totalbalance = $row['totalbalance'];
		$activedeposit = $row['activedeposit'];
		$btc_balance = $row['btc'];
		$eth_balance = $row['eth'];
		$bnb_balance = $row['bnb'];
		$ada_balance = $row['ada'];
		$xpr_balance = $row['xpr'];
		$doge_balance = $row['doge'];
		$usdt_balance = $row['usdt'];
		$pool = $row['stake'];
		$sbtc_balance = $row['sbtc'];
		$seth_balance = $row['seth'];
		$sbnb_balance = $row['sbnb'];
		$sada_balance = $row['sada'];
		$sxpr_balance = $row['sxpr'];
		$sdoge_balance = $row['sdoge'];
		$susdt_balance = $row['susdt'];

		if ($method == 'btc') {
			$amount = $var * $btc_rate;
			if ($amount > $btc_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit - $amount;
				$newbalance = $totalbalance - $amount;
				$stake = $pool + $amount;
				$btc = $btc_balance - $amount;
				$sbtc = $sbtc_balance + $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  btc = '$btc', sbtc = '$sbtc' WHERE username = '$username'");
				$response['status'] = 1; 
			    $response['message'] = 'BTC';
			}
		}
		elseif ($method == 'eth') {
			$amount = $var * $eth_rate;
			if ($amount > $eth_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit - $amount;
				$newbalance = $totalbalance - $amount;
				$stake = $pool + $amount;
				$eth = $eth_balance - $amount;
				$seth = $seth_balance + $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  eth = '$eth', seth = '$seth' WHERE username = '$username'");
				$response['status'] = 2; 
			    $response['message'] = 'ETH';
			}
		}
		elseif ($method == 'bnb') {
			$amount = $var * $bnb_rate;
			if ($amount > $bnb_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit - $amount;
				$newbalance = $totalbalance - $amount;
				$stake = $pool + $amount;
				$bnb = $bnb_balance - $amount;
				$sbnb = $sbnb_balance + $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  bnb = '$bnb', sbnb = '$sbnb' WHERE username = '$username'");
				$response['status'] = 3; 
			    $response['message'] = 'BNB';
			}
		}
		elseif ($method == 'ada') {
			$amount = $var * $ada_rate;
			if ($amount > $ada_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit - $amount;
				$newbalance = $totalbalance - $amount;
				$stake = $pool + $amount;
				$ada = $ada_balance - $amount;
				$sada = $sada_balance + $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  ada = '$ada', sada = '$sada' WHERE username = '$username'");
				$response['status'] = 4; 
			    $response['message'] = 'ADA';
			}
		}
		elseif ($method == 'xpr') {
			$amount = $var * $xpr_rate;
			if ($amount > $xpr_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit - $amount;
				$newbalance = $totalbalance - $amount;
				$stake = $pool + $amount;
				$xpr = $xpr_balance - $amount;
				$sxpr = $sxpr_balance + $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  xpr = '$xpr', sxpr = '$sxpr' WHERE username = '$username'");
				$response['status'] = 4; 
			    $response['message'] = 'XPR';
			}
		}
		elseif ($method == 'doge') {
			$amount = $var * $doge_rate;
			if ($amount > $doge_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit - $amount;
				$newbalance = $totalbalance - $amount;
				$stake = $pool + $amount;
				$doge = $doge_balance - $amount;
				$sdoge = $sdoge_balance + $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  doge = '$doge', sdoge = '$sdoge' WHERE username = '$username'");
				$response['status'] = 4; 
			    $response['message'] = 'DOGE';
			}
		}
		elseif ($method == 'usdt') {
			$amount = $var * $usdt_rate;
			if ($amount > $usdt_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit - $amount;
				$newbalance = $totalbalance - $amount;
				$stake = $pool + $amount;
				$usdt = $usdt_balance - $amount;
				$susdt = $susdt_balance + $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  usdt = '$usdt', susdt = '$susdt' WHERE username = '$username'");
				$response['status'] = 4; 
			    $response['message'] = 'USDT';
			}
		}
	}
}


if (isset($_POST['redeem'])) {
	include_once '../database/dbconfig.php';
	$transid = substr(str_shuffle("012345678901234567890"), 0, 5);
	$username = $_POST['username'];
	$method = $_POST['method'];
	$network = $_POST['network'];
	$type = $_POST['redeem'];
	$var = $_POST['amount'];
	$status = "completed";

	$a = $db_conn->query("SELECT * FROM coins WHERE coin = 'btc'");
    $ab = $a->fetch_assoc();
    $btc_rate = $ab['value'];

    $b = $db_conn->query("SELECT * FROM coins WHERE coin = 'eth'");
    $bc = $b->fetch_assoc();
    $eth_rate = $bc['value'];

    $c = $db_conn->query("SELECT * FROM coins WHERE coin = 'bnb'");
    $cd = $c->fetch_assoc();
    $bnb_rate = $cd['value'];

    $d = $db_conn->query("SELECT * FROM coins WHERE coin = 'ada'");
    $de = $d->fetch_assoc();
    $ada_rate = $de['value'];

    $e = $db_conn->query("SELECT * FROM coins WHERE coin = 'xpr'");
    $ef = $e->fetch_assoc();
    $xpr_rate = $ef['value'];

    $f = $db_conn->query("SELECT * FROM coins WHERE coin = 'doge'");
    $fg = $f->fetch_assoc();
    $doge_rate = $fg['value'];

    $g = $db_conn->query("SELECT * FROM coins WHERE coin = 'usdt'");
    $gh = $g->fetch_assoc();
    $usdt_rate = $gh['value'];

	$sql = $db_conn->query("SELECT * FROM account WHERE username = '$username' ");
	if ($sql) {
		$row = $sql->fetch_assoc();
		$totalbalance = $row['totalbalance'];
		$activedeposit = $row['activedeposit'];
		$btc_balance = $row['btc'];
		$eth_balance = $row['eth'];
		$bnb_balance = $row['bnb'];
		$ada_balance = $row['ada'];
		$xpr_balance = $row['xpr'];
		$doge_balance = $row['doge'];
		$usdt_balance = $row['usdt'];
		$pool = $row['stake'];
		$sbtc_balance = $row['sbtc'];
		$seth_balance = $row['seth'];
		$sbnb_balance = $row['sbnb'];
		$sada_balance = $row['sada'];
		$sxpr_balance = $row['sxpr'];
		$sdoge_balance = $row['sdoge'];
		$susdt_balance = $row['susdt'];

		if ($method == 'btc') {
			$amount = $var * $btc_rate;
			if ($amount > $sbtc_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit + $amount;
				$newbalance = $totalbalance + $amount;
				$stake = $pool - $amount;
				$btc = $btc_balance + $amount;
				$sbtc = $sbtc_balance - $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  btc = '$btc', sbtc = '$sbtc' WHERE username = '$username'");
				$response['status'] = 1; 
			    $response['message'] = 'BTC';
			}
		}
		elseif ($method == 'eth') {
			$amount = $var * $eth_rate;
			if ($amount > $seth_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit + $amount;
				$newbalance = $totalbalance + $amount;
				$stake = $pool - $amount;
				$eth = $eth_balance + $amount;
				$seth = $seth_balance - $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  eth = '$eth', seth = '$seth' WHERE username = '$username'");
				$response['status'] = 1; 
			    $response['message'] = 'ETH';
			}
		}
		elseif ($method == 'bnb') {
			$amount = $var * $bnb_rate;
			if ($amount > $sbnb_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit + $amount;
				$newbalance = $totalbalance + $amount;
				$stake = $pool - $amount;
				$bnb = $bnb_balance + $amount;
				$sbnb = $sbnb_balance - $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  bnb = '$bnb', sbnb = '$sbnb' WHERE username = '$username'");
				$response['status'] = 1; 
			    $response['message'] = 'BNB';
			}
		}
		elseif ($method == 'ada') {
			$amount = $var * $ada_rate;
			if ($amount > $sada_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit + $amount;
				$newbalance = $totalbalance + $amount;
				$stake = $pool - $amount;
				$ada = $ada_balance + $amount;
				$sada = $sada_balance - $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  ada = '$ada', sada = '$sada' WHERE username = '$username'");
				$response['status'] = 1; 
			    $response['message'] = 'ADA';
			}
		}
		elseif ($method == 'xpr') {
			$amount = $var * $xpr_rate;
			if ($amount > $sxpr_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit + $amount;
				$newbalance = $totalbalance + $amount;
				$stake = $pool - $amount;
				$xpr = $xpr_balance + $amount;
				$sxpr = $sxpr_balance - $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  xpr = '$xpr', sxpr = '$sxpr' WHERE username = '$username'");
				$response['status'] = 1; 
			    $response['message'] = 'XPR';
			}
		}
		elseif ($method == 'doge') {
			$amount = $var * $doge_rate;
			if ($amount > $sdoge_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit + $amount;
				$newbalance = $totalbalance + $amount;
				$stake = $pool - $amount;
				$doge = $doge_balance + $amount;
				$sdoge = $sdoge_balance - $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  doge = '$doge', sdoge = '$sdoge' WHERE username = '$username'");
				$response['status'] = 1; 
			    $response['message'] = 'DOGE';
			}
		}
		elseif ($method == 'usdt') {
			$amount = $var * $usdt_rate;
			if ($amount > $susdt_balance) {
				$response['status'] = 0;
				$response['message'] = 'There is not enough asset in your balance';
			} else {
				$newactivedeposit = $activedeposit + $amount;
				$newbalance = $totalbalance + $amount;
				$stake = $pool - $amount;
				$usdt = $usdt_balance + $amount;
				$susdt = $susdt_balance - $amount;

				$mysqli = $db_conn->query("UPDATE account SET totalbalance = '$newbalance', activedeposit = '$newactivedeposit', stake = '$stake',  usdt = '$usdt', susdt = '$susdt' WHERE username = '$username'");
				$response['status'] = 1; 
			    $response['message'] = 'USDT';
			}
		}
	}
}


if (isset($_POST['plan'])) {
	include_once '../database/dbconfig.php';
	$transid = substr(str_shuffle("012345678901234567890"), 0, 5);
	$username = $_POST['username'];
	$method = $_POST['method'];
	$plan = $_POST['plan'];
	$type = "deposit";
	$var = $_POST['amount'];
	$amount = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$status = "pending";
	if ($method == 'btc') {
		$network = 'BTC';
	}
	elseif ($method == 'eth') {
		$network = 'Eth';
	}
	elseif ($method == 'bnb') {
		$network = 'BNB';
	}
	elseif ($method == 'ada') {
		$network = 'BEP20';
	}
	elseif ($method == 'xpr') {
		$network = 'XPR';
	}
	elseif ($method == 'doge') {
		$network = 'DOGE';
	}
	elseif ($method == 'usdt') {
		$network = 'USDT';
	}

	$mysqli = $db_conn->query("INSERT INTO transactions (transid,username,regdate,method,network,type,amount,plan,status) VALUES ('$transid', '$username', NOW(), '$method', '$network', '$type', '$amount', '$plan','$status')");
	

	if ($mysqli) {
		if ($method == 'btc') {
			$response['status'] = 1; 
        	$response['message'] = 'BTC';
		}
		elseif ($method == 'eth') {
			$response['status'] = 2; 
        	$response['message'] = 'ETH';
		}
		elseif ($method == 'bnb') {
			$response['status'] = 3; 
        	$response['message'] = 'BNB';
		}
		elseif ($method == 'ada') {
			$response['status'] = 4; 
        	$response['message'] = 'ADA';
		}
		elseif ($method == 'xpr') {
			$response['status'] = 4; 
        	$response['message'] = 'XPR';
		}
		elseif ($method == 'doge') {
			$response['status'] = 4; 
        	$response['message'] = 'DOGE';
		}
		elseif ($method == 'usdt') {
			$response['status'] = 4; 
        	$response['message'] = 'USDT';
		}
	}
}


if (isset($_POST['contact'])) {
	include_once '../database/dbconfig.php';
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject = $db_conn->real_escape_string($_POST['subject']);
	$message = $db_conn->real_escape_string($_POST['message']);

	$mysqli = $db_conn->query("INSERT INTO help (name,email,subject,message,msg_time) VALUES ('$name', '$email', '$subject', '$message', NOW())");

	if ($mysqli) {
		$response['status'] = 1; 
        $response['message'] = 'Your request was sent successfully!';
	}
}


if 	(isset($_POST['change_password'])) {
	include_once '../database/dbconfig.php';
	$username = $_POST['username'];
	$password_0 = $db_conn->real_escape_string($_POST['password_0']);
	$password_1 = $db_conn->real_escape_string($_POST['password_1']);

	$mysqli = $db_conn->query("SELECT * FROM users WHERE username='$username'");

	$data = $mysqli->fetch_assoc();

	$password = $data['password'];
	if ($password_0 !== $password) {
		$response['status'] = 0; 
        $response['message'] = 'Your old password is incorrect';
	} else {
		$db_conn->query("UPDATE users SET password = '$password_1' WHERE username ='$username'");
		$response['status'] = 1; 
        $response['message'] = 'Password has been changed';
	}
}


if (isset($_POST['verify'])) {
	$username = $_POST['username'];
	$country = $_POST['country'];
    $nationality = $_POST['nationality'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$middlename = $_POST['middlename'];
	$dob = $_POST['dob'];
	$address = $_POST['address'];
	$dob = $_POST['dob'];
	$zip = $_POST['zip'];
	$city = $_POST['city'];
	$issuer = $_POST['issuer'];
	$verification = "pending";
	
	$mysqliStatus = 1;
	
    // Upload file 
    $uploadedPhoto = '';
    
    // Photo path config 
    $photoName = basename(rand().time().$_FILES["passport"]["name"]); 
    $targetFilePath = $uploadDir . $photoName; 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
     
    // Allow certain file formats 
    $allowTypes = array('jpg', 'png', 'jpeg');
    if(in_array($fileType, $allowTypes)){ 
        // Upload file to the server 
        if(move_uploaded_file($_FILES["passport"]["tmp_name"], $targetFilePath)){ 
            $uploadedPhoto = $photoName; 
        }else{ 
            $mysqliStatus = 0; 
            $response['message'] = 'Sorry, there was an error uploading your Picture.'; 
        } 
    }else{ 
        $mysqliStatus = 0; 
        $response['message'] = 'Sorry, only JPG, JPEG, & PNG files are allowed to upload.'; 
    }

    if($mysqliStatus == 1){ 
        // Include the database config file 
        include_once '../database/dbconfig.php'; 
         
        // Insert form data in the database 
        $mysqli = $db_conn->query("UPDATE users SET username = '$username', country = '$country', nationality = '$nationality', firstname = '$firstname', lastname = '$lastname', middlename = '$middlename', dob = '$dob', address = '$address', zip = '$zip', city = '$city', issuer = '$issuer', passport = '$uploadedPhoto', verification = '$verification'  WHERE username ='$username'"); 
         
        if($mysqli){ 
            $response['status'] = 1; 
            $response['message'] = 'Request submitted successfully!';
        } 
    }
}


if (isset($_POST['update'])) {
	$username = $_POST['username'];
	$country = $_POST['country'];
    $nationality = $_POST['nationality'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$dob = $_POST['dob'];
	$address = $_POST['address'];
	$dob = $_POST['dob'];
	$zip = $_POST['zip'];
	$city = $_POST['city'];
	$issuer = $_POST['issuer'];
		
    // Include the database config file 
    include_once '../database/dbconfig.php'; 
     
    // Insert form data in the database 
    $mysqli = $db_conn->query("UPDATE users SET username = '$username', country = '$country', nationality = '$nationality', firstname = '$firstname', lastname = '$lastname', dob = '$dob', address = '$address', zip = '$zip', city = '$city', issuer = '$issuer' WHERE username ='$username'"); 
     
    if($mysqli){ 
        $response['status'] = 1; 
        $response['message'] = 'Request submitted successfully!';
    } 
    
}

// Return response 
echo json_encode($response);
?>