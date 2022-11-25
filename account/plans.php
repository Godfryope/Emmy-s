<?php
session_start();
include('../database/dbconfig.php');
if (!isset($_SESSION['username'])) {
  header('Location:../login');
  exit();
} else {
  if((time() - $_SESSION['last_login_timestamp']) > 900) {
    header("location:logout");
  } else {  
        $_SESSION['last_login_timestamp'] = time();
  }
}

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$mysqli = $db_conn->query("SELECT * FROM users WHERE username = '$username'");
$data = $mysqli->fetch_assoc();


$stmt = $db_conn->query("SELECT * FROM admin WHERE adminid = 'admin' ");
if ($stmt){
  $stmt_row = $stmt->fetch_assoc();
  $adminid = $stmt_row['adminid'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Plan - Bitcoptions</title>
  <link rel="shortcut icon" href="../img/favicon.png" />
  <link rel="icon" href="../img/favicon.png" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/custom-css.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <style>.referral{cursor: copy;}.icon svg {width: 100%;height: 100%;}</style>
  <style>.btn-check{position:absolute;clip:rect(0,0,0,0);pointer-events:none;}.btn-check:checked + .btn-secondary{color: #fff;background-color:#0000;border-color:#ffdd6196;}</style>
</head>
<body id="results" class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="modal fade" id="planModal" tabindex="-1" role="dialog" data-backdrop="static" tabindex="-1" role="dialog"
  aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header px-sm-4 px-2">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-0 px-sm-2">

          <?php
          $a = $db_conn->query("SELECT * FROM coins WHERE coin = 'btc'");
          $btc = $a->fetch_assoc();
          $b = $db_conn->query("SELECT * FROM coins WHERE coin = 'eth'");
          $eth = $b->fetch_assoc();
          $c = $db_conn->query("SELECT * FROM coins WHERE coin = 'bnb'");
          $bnb = $c->fetch_assoc();
          $d = $db_conn->query("SELECT * FROM coins WHERE coin = 'ada'");
          $ada = $d->fetch_assoc();
          $e = $db_conn->query("SELECT * FROM coins WHERE coin = 'xpr'");
          $xpr = $e->fetch_assoc();
          $f = $db_conn->query("SELECT * FROM coins WHERE coin = 'doge'");
          $doge = $f->fetch_assoc();
          $g = $db_conn->query("SELECT * FROM coins WHERE coin = 'usdt'");
          $usdt = $g->fetch_assoc();
          ?>

          <div id="btc-wallet" style="min-height: 350px; display:none;">
            <div class="card rounded-0 shadow-none p-0">
              <div class="card-body px-0 py-0" style="font-size: 12px;">
                <div class="px-4">
                   <div class="rounded-lg border border-secondary pt-4 pb-2">
                    <div class="p-2 bg-white mx-auto" style="max-width: 150px;">
                      <img src="img/<?php echo $btc['barcode'] ?>" alt="Bitcoin Barcode" class="card-img-top">
                    </div>
                    <div class="w-100 py-2 px-2">
                      <p class="card-text text-muted my-0 text-center">Wallet Address</p>
                      <p id="btcWalletId" class="card-text text-center text-white pb-0 mb-0"><?php echo $btc['walletid'] ?></p>
                    </div>
                    <div class="card-text text-center font-weight-bold py-0 my-0">No memo required</div>
                  </div>
                </div>
                <div class="px-2 pt-4">
                  <p class="card-text text-muted text-center" style="font-size: 12px;">* Send only <span class="font-weight-bold">Bitcoin (BTC)</span> to this address.<br>Sending coins or tokesn other than BTC to this address may result in permanent loss.</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Coins will be deposited after <span class="text-warning">1</span> network confirmations</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Until <span class="text-warning">2</span> confirmations are made, an equivalent amount of your assets will be temporarily unavailable for withdrawal.</p>
                </div>

                <div class="d-flex justify-content-center mt-4">
                  <span class="copy text-center mx-2" onclick="copyBtc(btcWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div type="button" class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyBtc(btcWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div type="button" class="card-text text-primary">Share</div>
                  </span>
                </div>
                
              </div>
            </div>
          </div>

          <div id="eth-wallet" style="min-height: 350px; display:none;">
            <div class="card rounded-0 shadow-none p-0">
              <div class="card-body px-0 py-0" style="font-size: 12px;">
                <div class="px-4">
                   <div class="rounded-lg border border-secondary pt-4 pb-2">
                    <div class="p-2 bg-white mx-auto" style="max-width: 150px;">
                      <img src="img/<?php echo $eth['barcode'] ?>" alt="Ethereum Barcode" class="card-img-top">
                    </div>
                    <div class="w-100 py-2 px-2">
                      <p class="card-text text-muted my-0 text-center">Wallet Address</p>
                      <p id="ethWalletId" class="card-text text-center text-white pb-0 mb-0"><?php echo $eth['walletid'] ?></p>
                    </div>
                    <div class="card-text text-center font-weight-bold py-0 my-0">No memo required</div>
                  </div>
                </div>
                <div class="px-2 pt-4">
                  <p class="card-text text-muted text-center" style="font-size: 12px;">* Send only <span class="font-weight-bold">Ethereum (ETH)</span> to this address.<br>Sending coins or tokesn other than ETH to this address may result in permanent loss.</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Coins will be deposited after <span class="text-warning">1</span> network confirmations</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Until <span class="text-warning">2</span> confirmations are made, an equivalent amount of your assets will be temporarily unavailable for withdrawal.</p>
                </div>

                <div class="d-flex justify-content-center mt-4">
                  <span class="copy text-center mx-2" onclick="copyETH(ethWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div type="button" class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyEth(ethWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div type="button" class="card-text text-primary">Share</div>
                  </span>
                </div>
                
              </div>
            </div>
          </div>

          <div id="bnb-wallet" style="min-height: 350px; display:none;">
            <div class="card rounded-0 shadow-none p-0">
              <div class="card-body px-0 py-0" style="font-size: 12px;">
                <div class="px-4">
                   <div class="rounded-lg border border-secondary pt-4 pb-2">
                    <div class="p-2 bg-white mx-auto" style="max-width: 150px;">
                      <img src="img/<?php echo $bnb['barcode'] ?>" alt="Binance Barcode" class="card-img-top">
                    </div>
                    <div class="w-100 py-2 px-2">
                      <p class="card-text text-muted my-0 text-center">Wallet Address</p>
                      <p id="bnbWalletId" class="card-text text-center text-white pb-0 mb-0"><?php echo $bnb['walletid'] ?></p>
                    </div>
                    <div class="card-text text-center font-weight-bold py-0 my-0">No memo required</div>
                  </div>
                </div>
                <div class="px-2 pt-4">
                  <p class="card-text text-muted text-center" style="font-size: 12px;">* Send only <span class="font-weight-bold">BNB (BNB)</span> to this address.<br>Sending coins or tokesn other than BNB to this address may result in permanent loss.</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Coins will be deposited after <span class="text-warning">1</span> network confirmations</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Until <span class="text-warning">2</span> confirmations are made, an equivalent amount of your assets will be temporarily unavailable for withdrawal.</p>
                </div>

                <div class="d-flex justify-content-center mt-4">
                  <span class="copy text-center mx-2" onclick="copyBnb(bnbWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div type="button" class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyBnb(bnbWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div type="button" class="card-text text-primary">Share</div>
                  </span>
                </div>
                
              </div>
            </div>
          </div>

          <div id="ada-wallet" style="min-height: 350px; display:none;">
            <div class="card rounded-0 shadow-none p-0">
              <div class="card-body px-0 py-0" style="font-size: 12px;">
                <div class="px-4">
                   <div class="rounded-lg border border-secondary pt-4 pb-2">
                    <div class="p-2 bg-white mx-auto" style="max-width: 150px;">
                      <img src="img/<?php echo $ada['barcode'] ?>" alt="Cardano Barcode" class="card-img-top">
                    </div>
                    <div class="w-100 py-2 px-2">
                      <p class="card-text text-muted my-0 text-center">Wallet Address</p>
                      <p id="adaWalletId" class="card-text text-center text-white pb-0 mb-0"><?php echo $ada['walletid'] ?></p>
                    </div>
                    <div class="card-text text-center font-weight-bold py-0 my-0">No memo required</div>
                  </div>
                </div>
                <div class="px-2 pt-4">
                  <p class="card-text text-muted text-center" style="font-size: 12px;">* Send only <span class="font-weight-bold">Cardano (ADA)</span> to this address.<br>Sending coins or tokesn other than ADA to this address may result in permanent loss.</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Coins will be deposited after <span class="text-warning">1</span> network confirmations</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Until <span class="text-warning">2</span> confirmations are made, an equivalent amount of your assets will be temporarily unavailable for withdrawal.</p>
                </div>

                <div class="d-flex justify-content-center mt-4">
                  <span class="copy text-center mx-2" onclick="copyAda(adaWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div type="button" class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyAda(adaWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div type="button" class="card-text text-primary">Share</div>
                  </span>
                </div>
                
              </div>
            </div>
          </div>

          <div id="xpr-wallet" style="min-height: 350px; display:none;">
            <div class="card rounded-0 shadow-none p-0">
              <div class="card-body px-0 py-0" style="font-size: 12px;">
                <div class="px-4">
                   <div class="rounded-lg border border-secondary pt-4 pb-2">
                    <div class="p-2 bg-white mx-auto" style="max-width: 150px;">
                      <img src="img/<?php echo $xpr['barcode'] ?>" alt="Proton Barcode" class="card-img-top">
                    </div>
                    <div class="w-100 py-2 px-2">
                      <p class="card-text text-muted my-0 text-center">Wallet Address</p>
                      <p id="xprWalletId" class="card-text text-center text-white pb-0 mb-0"><?php echo $xpr['walletid'] ?></p>
                    </div>
                    <div class="card-text text-center font-weight-bold py-0 my-0">No memo required</div>
                  </div>
                </div>
                <div class="px-2 pt-4">
                  <p class="card-text text-muted text-center" style="font-size: 12px;">* Send only <span class="font-weight-bold">Proton (XPR)</span> to this address.<br>Sending coins or tokesn other than XPR to this address may result in permanent loss.</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Coins will be deposited after <span class="text-warning">1</span> network confirmations</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Until <span class="text-warning">2</span> confirmations are made, an equivalent amount of your assets will be temporarily unavailable for withdrawal.</p>
                </div>

                <div class="d-flex justify-content-center mt-4">
                  <span class="copy text-center mx-2" onclick="copyXpr(xprWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div type="button" class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyXPR(xprWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div type="button" class="card-text text-primary">Share</div>
                  </span>
                </div>
                
              </div>
            </div>
          </div>

          <div id="doge-wallet" style="min-height: 350px; display:none;">
            <div class="card rounded-0 shadow-none p-0">
              <div class="card-body px-0 py-0" style="font-size: 12px;">
                <div class="px-4">
                   <div class="rounded-lg border border-secondary pt-4 pb-2">
                    <div class="p-2 bg-white mx-auto" style="max-width: 150px;">
                      <img src="img/<?php echo $doge['barcode'] ?>" alt="Dogecoin Barcode" class="card-img-top">
                    </div>
                    <div class="w-100 py-2 px-2">
                      <p class="card-text text-muted my-0 text-center">Wallet Address</p>
                      <p id="dogeWalletId" class="card-text text-center text-white pb-0 mb-0"><?php echo $doge['walletid'] ?></p>
                    </div>
                    <div class="card-text text-center font-weight-bold py-0 my-0">No memo required</div>
                  </div>
                </div>
                <div class="px-2 pt-4">
                  <p class="card-text text-muted text-center" style="font-size: 12px;">* Send only <span class="font-weight-bold">Dogecoin (DOGE)</span> to this address.<br>Sending coins or tokesn other than DOGE to this address may result in permanent loss.</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Coins will be deposited after <span class="text-warning">1</span> network confirmations</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Until <span class="text-warning">2</span> confirmations are made, an equivalent amount of your assets will be temporarily unavailable for withdrawal.</p>
                </div>

                <div class="d-flex justify-content-center mt-4">
                  <span class="copy text-center mx-2" onclick="copyDoge(dogeWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div type="button" class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyDoge(dogeWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div type="button" class="card-text text-primary">Share</div>
                  </span>
                </div>
                
              </div>
            </div>
          </div>

          <div id="usdt-wallet" style="min-height: 350px; display:none;">
            <div class="card rounded-0 shadow-none p-0">
              <div class="card-body px-0 py-0" style="font-size: 12px;">
                <div class="px-4">
                   <div class="rounded-lg border border-secondary pt-4 pb-2">
                    <div class="p-2 bg-white mx-auto" style="max-width: 150px;">
                      <img src="img/<?php echo $usdt['barcode'] ?>" alt="Tether Barcode" class="card-img-top">
                    </div>
                    <div class="w-100 py-2 px-2">
                      <p class="card-text text-muted my-0 text-center">Wallet Address</p>
                      <p id="usdtWalletId" class="card-text text-center text-white pb-0 mb-0"><?php echo $usdt['walletid'] ?></p>
                    </div>
                    <div class="card-text text-center font-weight-bold py-0 my-0">No memo required</div>
                  </div>
                </div>
                <div class="px-2 pt-4">
                  <p class="card-text text-muted text-center" style="font-size: 12px;">* Send only <span class="font-weight-bold">Tether (USDT)</span> to this address.<br>Sending coins or tokesn other than USDT to this address may result in permanent loss.</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Coins will be deposited after <span class="text-warning">1</span> network confirmations</p>
                  <p class="card-text text-muted text-center" style="font-size: 12px;">*Until <span class="text-warning">2</span> confirmations are made, an equivalent amount of your assets will be temporarily unavailable for withdrawal.</p>
                </div>

                <div class="d-flex justify-content-center mt-4">
                  <span class="copy text-center mx-2" onclick="copyUsdt(usdtWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div type="button" class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyUsdt(usdtWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div type="button" class="card-text text-primary">Share</div>
                  </span>
                </div>
                
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <div class="spinner-grow text-info" role="status"></div>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item mt-1">
          <a class="btn btn-primary btn-sm" href="support" role="button">Support</a>
        </li>
      </ul>
     
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        
        <!-- Live Chat Messages Dropdown Menu -->
        <li class="nav-item">
          
          <a class="text-capitalize btn btn-primary btn-sm" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i> <?php echo $data['lastname']; ?>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
            <li class="nav-item">
              <a href="dashboard" class="nav-link ">
                <i class="fas fa-house-user nav-icon"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="bitcoin-mining-hardware" class="nav-link">
                <i class="fas fa-shopping-cart nav-icon"></i>
                <p>Buy Mining Hardware</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="deposit" class="nav-link">
                <i class="fas fa-stream nav-icon"></i>
                <p>Deposit</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="transfer" class="nav-link">
                <i class="fas fa-exchange-alt nav-icon"></i>
                <p>Transfer</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="withdraw" class="nav-link">
                <i class="fas fa-gem nav-icon"></i>
                <p>Withdraw</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="earn" class="nav-link">
                <i class="fas fa-coins nav-icon"></i>
                <p>Earn</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="plans" class="nav-link active">
                <i class="fas fa-expand-arrows-alt nav-icon"></i>
                <p>Plans</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="markets" class="nav-link">
                <i class="fas fa-chart-line nav-icon"></i>
                <p>Markets</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="history" class="nav-link">
                <i class="fas fa-history nav-icon"></i>
                <p>History</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="wallet" class="nav-link">
                <i class="fas fa-wallet nav-icon"></i>
                <p>Wallet</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="profile" class="nav-link">
                <i class="fas fa-cog nav-icon"></i>
                <p>Profile</p>
              </a>
            </li>

            <li class="nav-item mt-2">
              <a href="logout" class="nav-link text-warning">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Sign out</p>
              </a>
            </li>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <div class="content-header py-2"></div>
      <!-- /.content-header -->
      
      <!-- Main content -->
      <section class="content">
        <div class="container">

          <?php
            $status = $data['status'];
            if ($status == "pending") {
              echo '
                <div class="row justify-content-center">
                  <div class="col-12 col-lg-10 col-md-11 px-sm-2 px-0">
                    <div class="card rounded-0 bg-secondary">
                      <div class="card-body text-center py-2 px-3 text-white">
                        We have sent a message to the e-mail address <strong>'.$data['email'].'</strong>. To confirm your user account, please click the link in the e-mail! If you did not find an e-mail message, then be sure to check the "Spam" folder.
                      </div>
                    </div>
                  </div>
                </div>';
            }
            else {
              echo '
              ';
            }
          ?>

          <div class="row justify-content-center">
            <?php
              $sus = $db_conn->query("SELECT * FROM account WHERE username = '$username'");
              $sus_data = $sus->fetch_assoc();
              $sus_status = $sus_data['status'];
  
              if ($sus_status == "suspended") {
                echo '
                  <div class="col-12 col-lg-10 col-md-11 px-sm-2 px-0">
                    <div class="card rounded-0">
                        
                        <div class="card-body">
                            <div class="card-title font-weight-normal text-warning pb-2">
                                Sorry! Your Account Has Been Blocked.
                            </div>
                            <div class="card-text" style="font-size:14px;">
                                You&#39;ve been temporarily blocked from making any new transactions. We restrict certain content and actions to protect our community. <a href="mailto:info@bitcoptions.com">Tell us</a> if you think we made a mistake, or send us a mail at <a href="mailto:info@bitcoptions.com">info@bitcoptions.com</a>
                            </div>
                            
                        </div>
                      
                      
                    </div>
                  </div>
                  <!-- end section title -->
                ';
              }
            ?>
          </div>

          <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-md-11 px-sm-2 px-0">
              <div class="card rounded-0">
                <div class="card-body">
                  <div class="row px-sm-0 text-muted text-sm">Equity Value (BTC)</div>
                  <div class="row px-sm-0">
                    <?php
                    $x = $db_conn->query("SELECT * FROM account WHERE username='$username'");
                    $xy = $x->fetch_assoc();
                    $accbalance = $xy['totalbalance'];

                    $a = $db_conn->query("SELECT * FROM coins WHERE coin = 'btc'");
                    $btc = $a->fetch_assoc();
                    $btc_rate = $btc['value'];

                    $b = $db_conn->query("SELECT * FROM coins WHERE coin = 'eth'");
                    $eth = $b->fetch_assoc();
                    $eth_rate = $eth['value'];

                    $c = $db_conn->query("SELECT * FROM coins WHERE coin = 'bnb'");
                    $bnb = $c->fetch_assoc();
                    $bnb_rate = $bnb['value'];

                    $d = $db_conn->query("SELECT * FROM coins WHERE coin = 'ada'");
                    $ada = $d->fetch_assoc();
                    $ada_rate = $ada['value'];

                    $e = $db_conn->query("SELECT * FROM coins WHERE coin = 'xpr'");
                    $xpr = $e->fetch_assoc();
                    $xpr_rate = $xpr['value'];

                    $f = $db_conn->query("SELECT * FROM coins WHERE coin = 'doge'");
                    $doge = $f->fetch_assoc();
                    $doge_rate = $doge['value'];

                    $g = $db_conn->query("SELECT * FROM coins WHERE coin = 'usdt'");
                    $usdt = $g->fetch_assoc();
                    $usdt_rate = $usdt['value'];

                    $bal_btc_value = $accbalance / $btc_rate;
                    $bal_eth_value = $accbalance / $eth_rate;
                    $bal_bnb_value = $accbalance / $bnb_rate;
                    $bal_ada_value = $accbalance / $ada_rate;
                    $bal_xpr_value = $accbalance / $xpr_rate;
                    $bal_doge_value = $accbalance / $doge_rate;
                    $bal_usdt_value = $accbalance / $usdt_rate;
                    ?>
                    <span class="h4" style="letter-spacing: 0px;"><?php echo number_format($bal_btc_value, 8, '.', ''); ?></span>
                    <span class="pl-1 card-text text-muted text-sm">&#x2248; $<?php echo number_format($accbalance, 2); ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Main row -->
          <div class="row justify-content-center">
            <div class="col-12 col-xl-10 px-sm-2 px-0">
              <div class="card rounded-0">
                <div class="card-body text-right px-3 pb-0">
                  <div class="row">

                    <div class="col-sm-6 col-lg-3 px-1">
                      <div id="planSilver" class="card">
                        <div class="card-header text-center bg-secondary">Available</div>
                        <div class="card-body px-0">
                          <form id="silverPlan">
                            <div id="planSilverChoose">
                              <div class="h3 text-center" style="font-weight: bolder;">Silver</div>
                              <div class="text-sm text-muted text-center pb-2">Starter</div>
                              <div class="text-center h3" style="color: #ffdd61;font-size: 48px;">
                                $<span class="font-weight-normal">5, 000</span>
                              </div>
                              <div class="w-100 py-2 px-2">
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Hashrate</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">64 TH/S</span></div>
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Power</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">3100w</span></div>
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Profit</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">0.000361 BTC</span></div>
                              </div>
                              <div class="text-center px-4">
                                <button type="button" id="planSilverChooseBtn" class="btn btn-block btn-sm mt-2" style="background-color: #ffdd61;">Select Plan</button>
                              </div>
                            </div>
                          
                            <div id="planSilverPay" style="display: none;">
                              <div class="px-1">
                                <div class="">
                                  <div class="text-muted px-1 w-100 text-left">Select a coin</div>
                                </div>
                              </div>
                              <input type="hidden" name="username" value="<?php echo $username; ?>">
                              <input type="hidden" name="plan" value="silver">
                              <input type="hidden" name="amount" value="5000">
                              <div class="row px-2">
                                <div class="col-12">
                                  <input type="radio" class="btn-check mx-auto" name="method" id="option1" value="btc" autocomplete="off" checked>
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option1" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/bitcoin.png" alt="Bitcoin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>BTC</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Bitcoin</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_btc_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($btc_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option2" value="eth" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option2" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/ethereum.png" alt="Ethereum" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>ETH</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Ethereum</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_eth_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($eth_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option3" value="bnb" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option3" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/binance_coin.png" alt="Binance coin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>BNB</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Binance</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_bnb_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($bnb_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option4" value="ada" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option4" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/cardano.png" alt="Cardano" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>ADA</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Cardano</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_ada_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($ada_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>



                                  <input type="radio" class="btn-check mx-auto" name="method" id="option5" value="xpr" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option5" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/proton.png" alt="Proton" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>XPR</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Proton</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_xpr_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($xpr_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>



                                  <input type="radio" class="btn-check mx-auto" name="method" id="option6" value="doge" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option6" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/dogecoin.png" alt="Dogecoin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>DOGE</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Dogecoin</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_doge_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($doge_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option7" value="usdt" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option7" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/tether.png" alt="Tether" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>USDT</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Tether</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_usdt_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($usdt_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                </div>  
                              </div>
                              <div class="text-center px-2">
                                <button type="submit" id="planSilverBtn" class="btn btn-block btn-sm mt-2" style="background-color: #ffdd61;">Pay <i class="fas fa-angle-double-right"></i></button>
                              </div>
                              <div class="text-center px-2">
                                <button type="button" id="planSilverCancel" class="btn btn-block btn-sm btn-secondary mt-2">Cancel</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-sm-6 col-lg-3 px-1">
                      <div id="planGold" class="card">
                        <div class="card-header text-center bg-secondary">Available</div>
                        <div class="card-body px-0">
                          <form id="goldPlan">
                            <div id="planGoldChoose">
                              <div class="h3 text-center" style="font-weight: bolder;">Gold</div>
                              <div class="text-sm text-muted text-center pb-2">Intermediate</div>
                              <div class="text-center h3" style="color: #ffdd61;font-size: 48px;">
                                $<span class="font-weight-normal">10, 000</span>
                              </div>
                              <div class="w-100 py-2 px-2">
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Hashrate</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">64 TH/S</span></div>
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Power</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">3100w</span></div>
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Profit</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">0.000461 BTC</span></div>
                              </div>
                              <div class="text-center px-4">
                                <button type="button" id="planGoldChooseBtn" class="btn btn-block btn-sm mt-2" style="background-color: #ffdd61;">Select Plan</button>
                              </div>
                            </div>
                          
                            <div id="planGoldPay" style="display: none;">
                              <div class="px-1">
                                <div class="">
                                  <div class="text-muted px-1 w-100 text-left">Select a coin</div>
                                </div>
                              </div>
                              <input type="hidden" name="username" value="<?php echo $username; ?>">
                              <input type="hidden" name="plan" value="gold">
                              <input type="hidden" name="amount" value="5000">
                              <div class="row px-2">
                                <div class="col-12">
                                  <input type="radio" class="btn-check mx-auto" name="method" id="option11" value="btc" autocomplete="off" checked>
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option11" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/bitcoin.png" alt="Bitcoin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>BTC</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Bitcoin</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_btc_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($btc_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option21" value="eth" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option21" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/ethereum.png" alt="Ethereum" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>ETH</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Ethereum</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_eth_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($eth_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option31" value="bnb" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option31" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/binance_coin.png" alt="Binance coin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>BNB</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Binance</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_bnb_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($bnb_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option41" value="ada" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option41" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/cardano.png" alt="Cardano" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>ADA</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Cardano</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_ada_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($ada_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option51" value="xpr" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option51" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/proton.png" alt="Proton" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>XPR</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Proton</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_xpr_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($xpr_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option61" value="doge" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option61" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/dogecoin.png" alt="Dogecoin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>DOGE</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Dogecoin</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_doge_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($doge_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option71" value="usdt" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option71" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/tether.png" alt="Tether" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>USDT</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Tether</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_usdt_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($usdt_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                </div>  
                              </div>
                              <div class="text-center px-2">
                                <button type="submit" id="planGoldBtn" class="btn btn-block btn-sm mt-2" style="background-color: #ffdd61;">Pay <i class="fas fa-angle-double-right"></i></button>
                              </div>
                              <div class="text-center px-2">
                                <button type="button" id="planGoldCancel" class="btn btn-block btn-sm btn-secondary mt-2">Cancel</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-sm-6 col-lg-3 px-1">
                      <div id="planPlatinum" class="card">
                        <div class="card-header text-center bg-secondary">Available</div>
                        <div class="card-body px-0">
                          <form id="platinumPlan">
                            <div id="planPlatinumChoose">
                              <div class="h3 text-center" style="font-weight: bolder;">Platinum</div>
                              <div class="text-sm text-muted text-center pb-2">Professional</div>
                              <div class="text-center h3" style="color: #ffdd61;font-size: 48px;">
                                $<span class="font-weight-normal">20, 000</span>
                              </div>
                              <div class="w-100 py-2 px-2">
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Hashrate</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">64 TH/S</span></div>
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Power</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">3100w</span></div>
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Profit</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">0.000561 BTC</span></div>
                              </div>
                              <div class="text-center px-4">
                                <button type="button" id="planPlatinumChooseBtn" class="btn btn-block btn-sm mt-2" style="background-color: #ffdd61;">Select Plan</button>
                              </div>
                            </div>
                          
                            <div id="planPlatinumPay" style="display: none;">
                              <div class="px-1">
                                <div class="">
                                  <div class="text-muted px-1 w-100 text-left">Select a coin</div>
                                </div>
                              </div>
                              <input type="hidden" name="username" value="<?php echo $username; ?>">
                              <input type="hidden" name="plan" value="platinum">
                              <input type="hidden" name="amount" value="5000">
                              <div class="row px-2">
                                <div class="col-12">
                                  <input type="radio" class="btn-check mx-auto" name="method" id="option12" value="btc" autocomplete="off" checked>
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option12" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/bitcoin.png" alt="Bitcoin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>BTC</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Bitcoin</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_btc_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($btc_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option22" value="eth" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option22" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/ethereum.png" alt="Ethereum" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>ETH</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Ethereum</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_eth_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($eth_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option32" value="bnb" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option32" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/binance_coin.png" alt="Binance coin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>BNB</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Binance</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_bnb_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($bnb_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option42" value="ada" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option42" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/cardano.png" alt="Cardano" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>ADA</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Cardano</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_ada_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($ada_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option52" value="xpr" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option52" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/proton.png" alt="Proton" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>XPR</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Proton</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_xpr_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($xpr_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option62" value="doge" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option62" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/dogecoin.png" alt="Dogecoin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>DOGE</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Dogecoin</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_doge_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($doge_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option72" value="usdt" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option72" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/tether.png" alt="Tether" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>USDT</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Tether</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_usdt_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($usdt_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                </div>  
                              </div>
                              <div class="text-center px-2">
                                <button type="submit" id="planPlatinumBtn" class="btn btn-block btn-sm mt-2" style="background-color: #ffdd61;">Pay <i class="fas fa-angle-double-right"></i></button>
                              </div>
                              <div class="text-center px-2">
                                <button type="button" id="planPlatinumCancel" class="btn btn-block btn-sm btn-secondary mt-2">Cancel</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-sm-6 col-lg-3 px-1">
                      <div id="planDiamond" class="card">
                        <div class="card-header text-center bg-secondary">Available</div>
                        <div class="card-body px-0">
                          <form id="diamondPlan">
                            <div id="planDiamondChoose">
                              <div class="h3 text-center" style="font-weight: bolder;">Diamond</div>
                              <div class="text-sm text-muted text-center pb-2">Executive</div>
                              <div class="text-center h3" style="color: #ffdd61; font-size: 48px;">
                                $<span class="font-weight-normal">50, 000</span>
                              </div>
                              <div class="w-100 py-2 px-2">
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Hashrate</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">64 TH/S</span></div>
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Power</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">3100w</span></div>
                                <div class="bg-secondary rounded my-2 text-dark text-left pt-1" style="font-size:13px; height:30px;"><span class="pl-2 my-auto">Profit</span><span class="float-right bg-primary rounded text-center h-100 pt-1" style="width:80px;margin-top:-2px;">0.000661 BTC</span></div>
                              </div>
                              <div class="text-center px-4">
                                <button type="button" id="planDiamondChooseBtn" class="btn btn-block btn-sm mt-2" style="background-color: #ffdd61;">Select Plan</button>
                              </div>
                            </div>
                          
                            <div id="planDiamondPay" style="display: none;">
                              <div class="px-1">
                                <div class="">
                                  <div class="text-muted px-1 w-100 text-left">Select a coin</div>
                                </div>
                              </div>
                              <input type="hidden" name="username" value="<?php echo $username; ?>">
                              <input type="hidden" name="plan" value="diamond">
                              <input type="hidden" name="amount" value="5000">
                              <div class="row px-2">
                                <div class="col-12">
                                  <input type="radio" class="btn-check mx-auto" name="method" id="option13" value="btc" autocomplete="off" checked>
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option13" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/bitcoin.png" alt="Bitcoin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>BTC</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Bitcoin</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_btc_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($btc_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option23" value="eth" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option23" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/ethereum.png" alt="Ethereum" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>ETH</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Ethereum</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_eth_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($eth_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option33" value="bnb" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option33" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/binance_coin.png" alt="Binance coin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>BNB</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Binance</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_bnb_value, 7, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($bnb_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option43" value="ada" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option43" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/cardano.png" alt="Cardano" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>ADA</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Cardano</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_ada_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($ada_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option53" value="xpr" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option53" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/proton.png" alt="Proton" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>XPR</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Proton</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_xpr_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($xpr_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option63" value="doge" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option63" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/dogecoin.png" alt="Dogecoin" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>DOGE</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Dogecoin</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_doge_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($doge_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                  <input type="radio" class="btn-check mx-auto" name="method" id="option73" value="usdt" autocomplete="off">
                                  <label class="btn btn-secondary w-100 text-left text-white my-1 rounded py-0" for="option73" style="font-size:12px;font-weight:normal;">
                                    <span class="row px-0 py-0">
                                      <div class="col-6">
                                        <span><img src="img/tether.png" alt="Tether" class=" rounded-circle" style="height:20px;width:20px;"><span class="pl-2 h6"></span>USDT</span>
                                        <span>
                                        <div class="text-muted" style="padding-left:27px;font-size:12px;">Tether</div>
                                        </span>
                                      </div>
                                      <div class="col-6 text-right">
                                        <div class="h6 mb-0"><?php echo number_format($bal_usdt_value, 4, '.', ''); ?></div>
                                        <div class="text-muted" style="font-size:12px;">&#x2248; $<?php echo number_format($usdt_rate, 2, '.', ''); ?></div>
                                      </div>
                                    </span>
                                  </label>

                                </div>  
                              </div>
                              <div class="text-center px-2">
                                <button type="submit" id="planDiamondBtn" class="btn btn-block btn-sm mt-2" style="background-color: #ffdd61;">Pay <i class="fas fa-angle-double-right"></i></button>
                              </div>
                              <div class="text-center px-2">
                                <button type="button" id="planDiamondCancel" class="btn btn-block btn-sm btn-secondary mt-2">Cancel</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
            </div>
          </div>
              
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!--Footer-->
    <footer class="main-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn">
      <!--Copyright-->
      <div class="footer-copyright">All Rights Reserved &copy; 2018-<?php echo date("Y"); ?></div>
      <!--/.Copyright-->

    </footer>
    <!--/.Footer-->
    
  </div>
  <!-- ./wrapper -->

  <!-- Button trigger modal -->
  <div class="chat-div" id="livechatdiv">
    <button type="button" class="chat-btn bg-lemon-green text-white" id="livechatbtn">
      <i class="fas fa-comment-dots comment"></i>
    </button>
  </div>
  <div class="card chat-modal rounded" id="livechatmodal">
    <div class="box direct-chat direct-chat-warning">
      <div class="d-flex flex-row p-3 adiv text-white box-header">
        <span class="pb-3 box-title"><i class="fas fa-comment"></i> Live chat</span>
        <div class="box-tools">
          <button id="close-livechat-app" type="button" class="btn btn-box-tool text-white"><i class="fa fa-times"></i></button>
        </div>
      </div>

      <div class="box-body">
          <div id="direct-chat-messages" class="direct-chat-messages">
              
              
          </div>
      </div>
      <div class="box-footer">
        <form class="live-chat-form" id="live-chat-form">
            <div class="input-group">
              <input type="hidden" name="send_msg">
              <input type="hidden" class="name" name="name" value="<?php echo $data['firstname'].' '.$data['lastname']; ?>">
              <input class="userid" type="hidden" name="userid" value="<?php echo $userid; ?>">
              <input class="incoming_id" type="hidden" name="incoming_id" value="<?php echo $adminid; ?>">
              <textarea class="form-control input-field bg-light" id="compose-textarea" name="message" placeholder="Type message here..." rows="2"autocomplete="off"></textarea>
            </div>
            <div class="input-group d-flex justify-content-end py-2">
              <button type="submit" id="new-message-btn" class="btn btn-success rounded-0 border-0"><i class="fab fa-telegram-plane"></i></button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../plugins/jszip/jszip.min.js"></script>
  <script src="../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- Toastr -->
  <script src="../plugins/toastr/toastr.min.js"></script>
  <!-- Summernote -->
  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>
  
  <!-- Page specific script -->
  <script>
    $(function () {
        //Add text editor
        $('#compose-textarea').summernote({
          toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic']],
          ['fontsize', ['fontsize']],
          ['picture', ['picture']],
        ],
        placeholder: 'Enter ...',
        disableGrammar: false
        })
        $('.note-editor').css({'width': '100%', 'height': '100%', 'background-color': '#fff', 'color': '#343a40'})
    });

    $(document).on('click', '#close-livechat-app', function() {
      $('#livechatmodal').hide();
      $('#livechatdiv').show();
    });

    $(document).on('click','#livechatbtn', function() {
      $('#livechatdiv').hide();
      $('#livechatmodal').show();
    });

    $(document).on('submit','#live-chat-form', function(e) {
      e.preventDefault();
      $.ajax({
        url: 'conversations.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        success: function(response) {
          if(response.status == '1') {
            $('#live-chat-form')[0].reset();
            get_msgs();
            scrollToBottom();
          }
        }
      });
    });

    setInterval(function(){
      get_msgs();
    }, 200);

    function get_msgs() {
      var name = $('.name').val();
      var userid = $('.userid').val();
      var incoming_id = $('.incoming_id').val();
      $.ajax({
        url: 'get-chat.php',
        type: 'POST',
        data: {userid:userid, incoming_id:incoming_id},
         success: function(data) {
                $('#direct-chat-messages').html(data);
        }
      });
    }

    scrollToBottom();

    function scrollToBottom(){
        $('#direct-chat-messages').stop().animate({
          scrollTop: $('#direct-chat-messages')[0].scrollHeight
        }, 800);
    }
    function copyReferralCode(containerid) {
      var copyText = document.createRange();
      copyText.selectNode(containerid); //changed here
      window.getSelection().removeAllRanges(); 
      window.getSelection().addRange(copyText); 
      document.execCommand("copy");
      window.getSelection().removeAllRanges();
    }

    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip({
        placement : 'top'
      });
      $('[data-toggle="tooltip"]').click(function(){
        $(this).tooltip('hide').attr('data-original-title', 'Copied').tooltip('show');
      });
      $('[data-toggle="tooltip"]').mouseleave(function() {
        $(this).tooltip('hide').attr('data-original-title', 'Copy');
      });
    });

    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });

    $('.noclick').click(false);

    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip({
        placement : 'top'
      });
      $('[data-toggle="tooltip"]').click(function(){
        $(this).tooltip('hide').attr('data-original-title', 'Copied').tooltip('show');
      });
      $('[data-toggle="tooltip"]').mouseleave(function() {
        $(this).tooltip('hide').attr('data-original-title', 'Copy to clipboard');
      });
      $('[data-bs-toggle="tooltip"]').tooltip('Close');
    });

    $('.refresh-modal').click(function() {
      $('#planSilverBtn, #planGoldBtn, #planPlatinumBtn, #planDiamondBtn').html('Pay <i class="fas fa-angle-double-right pl-2"></i>');
      $('#btc-wallet').hide();
      $('#silverPlan, #goldPlan, #platinumPlan, #diamondPlan')[0].reset();
    });

    $(document).on('click', '#planSilverChooseBtn', function() {
      $('#planSilverChoose').hide();
      $('#planSilverPay').show();
      $('#planGoldPay, #planPlatinumPay, #planDiamondPay').hide();
      $('#planGoldChoose, #planPlatinumChoose, #planDiamondChoose').show();
    });
    $(document).on('click', '#planGoldChooseBtn', function() {
      $('#planGoldChoose').hide();
      $('#planGoldPay').show();
      $('#planSilverPay, #planPlatinumPay, #planDiamondPay').hide();
      $('#planSilverChoose, #planPlatinumChoose, #planDiamondChoose').show();
    });
    $(document).on('click', '#planPlatinumChooseBtn', function() {
      $('#planPlatinumChoose').hide();
      $('#planPlatinumPay').show();
      $('#planSilverPay, #planGoldPay, #planDiamondPay').hide();
      $('#planSilverChoose, #planGoldChoose, #planDiamondChoose').show();
    });
    $(document).on('click', '#planDiamondChooseBtn', function() {
      $('#planDiamondChoose').hide();
      $('#planDiamondPay').show();
      $('#planSilverPay, #planGoldPay, #planPlatinumPay').hide();
      $('#planSilverChoose, #planGoldChoose, #planPlatinumChoose').show();
    });

    $(document).on('click', '#planSilverCancel', function(e) {
      e.preventDefault();
      $('#planSilverPay').hide();
      $('#planSilverChoose').show();
    });
    $(document).on('click', '#planGoldCancel', function(e) {
      e.preventDefault();
      $('#planGoldPay').hide();
      $('#planGoldChoose').show();
    });
    $(document).on('click', '#planPlatinumCancel', function(e) {
      e.preventDefault();
      $('#planPlatinumPay').hide();
      $('#planPlatinumChoose').show();
    });
    $(document).on('click', '#planDiamondCancel', function(e) {
      e.preventDefault();
      $('#planDiamondPay').hide();
      $('#planDiamondChoose').show();
    });

    $(document).on('submit', '#silverPlan', function(e) {
      e.preventDefault();
      var data = $(this).serialize();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#planSilverBtn').html('Processing <i class="fas fa-spinner fa-spin"></i>');
          $('#planSilverPay').css("opacity",".5");
        },
        success: function(response) {
          if(response.status == '1') {
            $('#planSilverPay').css("opacity","");
            $('#planSilverBtn').html('Buy');
            $('#planModal').modal('show');
            $('#btc-wallet').show();
          }
          else if(response.status == '2') {
            $('#planSilverPay').css("opacity","");
            $('#planSilverBtn').html('Buy');
            $('#planModal').modal('show');
            $('#eth-wallet').show();
          }
          else if(response.status == '3') {
            $('#planSilverPay').css("opacity","");
            $('#planSilverBtn').html('Buy');
            $('#planModal').modal('show');
            $('#bnb-wallet').show();
          }
          else if(response.status == '4') {
            $('#planSilverPay').css("opacity","");
            $('#planSilverBtn').html('Buy');
            $('#planModal').modal('show');
            $('#ada-wallet').show();
          }
          else if(response.status == '5') {
            $('#planSilverPay').css("opacity","");
            $('#planSilverBtn').html('Buy');
            $('#planModal').modal('show');
            $('#xpr-wallet').show();
          }
          else if(response.status == '6') {
            $('#planSilverPay').css("opacity","");
            $('#planSilverBtn').html('Buy');
            $('#planModal').modal('show');
            $('#doge-wallet').show();
          }
          else if(response.status == '7') {
            $('#planSilverPay').css("opacity","");
            $('#planSilverBtn').html('Buy');
            $('#planModal').modal('show');
            $('#usdt-wallet').show();
          }
        }
      });
    });

    $(document).on('submit', '#goldPlan', function(e) {
      e.preventDefault();
      var data = $(this).serialize();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#planGoldBtn').html('Processing <i class="fas fa-spinner fa-spin"></i>');
          $('#planGoldPay').css("opacity",".5");
        },
        success: function(response) {
          if(response.status == '1') {
            $('#planGoldPay').css("opacity","");
            $('#planGoldBtn').html('Buy');
            $('#planModal').modal('show');
            $('#btc-wallet').show();
          }
          else if(response.status == '2') {
            $('#planGoldPay').css("opacity","");
            $('#planGoldBtn').html('Buy');
            $('#planModal').modal('show');
            $('#eth-wallet').show();
          }
          else if(response.status == '3') {
            $('#planGoldPay').css("opacity","");
            $('#planGoldBtn').html('Buy');
            $('#planModal').modal('show');
            $('#bnb-wallet').show();
          }
          else if(response.status == '4') {
            $('#planGoldPay').css("opacity","");
            $('#planGoldBtn').html('Buy');
            $('#planModal').modal('show');
            $('#ada-wallet').show();
          }
          else if(response.status == '5') {
            $('#planGoldPay').css("opacity","");
            $('#planGoldBtn').html('Buy');
            $('#planModal').modal('show');
            $('#xpr-wallet').show();
          }
          else if(response.status == '6') {
            $('#planGoldPay').css("opacity","");
            $('#planGoldBtn').html('Buy');
            $('#planModal').modal('show');
            $('#doge-wallet').show();
          }
          else if(response.status == '7') {
            $('#planGoldPay').css("opacity","");
            $('#planGoldBtn').html('Buy');
            $('#planModal').modal('show');
            $('#usdt-wallet').show();
          }
        }
      });
    });

    $(document).on('submit', '#platinumPlan', function(e) {
      e.preventDefault();
      var data = $(this).serialize();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#planPlatinumBtn').html('Processing <i class="fas fa-spinner fa-spin"></i>');
          $('#planPlatinumPay').css("opacity",".5");
        },
        success: function(response) {
          if(response.status == '1') {
            $('#planPlatinumPay').css("opacity","");
            $('#planPlatinumBtn').html('Buy');
            $('#planModal').modal('show');
            $('#btc-wallet').show();
          }
          else if(response.status == '2') {
            $('#planPlatinumPay').css("opacity","");
            $('#planPlatinumBtn').html('Buy');
            $('#planModal').modal('show');
            $('#eth-wallet').show();
          }
          else if(response.status == '3') {
            $('#planPlatinumPay').css("opacity","");
            $('#planPlatinumBtn').html('Buy');
            $('#planModal').modal('show');
            $('#bnb-wallet').show();
          }
          else if(response.status == '4') {
            $('#planPlatinumPay').css("opacity","");
            $('#planPlatinumBtn').html('Buy');
            $('#planModal').modal('show');
            $('#ada-wallet').show();
          }
          else if(response.status == '5') {
            $('#planPlatinumPay').css("opacity","");
            $('#planPlatinumBtn').html('Buy');
            $('#planModal').modal('show');
            $('#xpr-wallet').show();
          }
          else if(response.status == '6') {
            $('#planPlatinumPay').css("opacity","");
            $('#planPlatinumBtn').html('Buy');
            $('#planModal').modal('show');
            $('#doge-wallet').show();
          }
          else if(response.status == '7') {
            $('#planPlatinumPay').css("opacity","");
            $('#planPlatinumBtn').html('Buy');
            $('#planModal').modal('show');
            $('#usdt-wallet').show();
          }
        }
      });
    });

    $(document).on('submit', '#diamondPlan', function(e) {
      e.preventDefault();
      var data = $(this).serialize();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#planDiamondBtn').html('Processing <i class="fas fa-spinner fa-spin"></i>');
          $('#planDiamondPay').css("opacity",".5");
        },
        success: function(response) {
          if(response.status == '1') {
            $('#planDiamondPay').css("opacity","");
            $('#planDiamondBtn').html('Buy');
            $('#planModal').modal('show');
            $('#btc-wallet').show();
          }
          else if(response.status == '2') {
            $('#planDiamondPay').css("opacity","");
            $('#planDiamondBtn').html('Buy');
            $('#planModal').modal('show');
            $('#eth-wallet').show();
          }
          else if(response.status == '3') {
            $('#planDiamondPay').css("opacity","");
            $('#planDiamondBtn').html('Buy');
            $('#planModal').modal('show');
            $('#bnb-wallet').show();
          }
          else if(response.status == '4') {
            $('#planDiamondPay').css("opacity","");
            $('#planDiamondBtn').html('Buy');
            $('#planModal').modal('show');
            $('#ada-wallet').show();
          }
          else if(response.status == '5') {
            $('#planDiamondPay').css("opacity","");
            $('#planDiamondBtn').html('Buy');
            $('#planModal').modal('show');
            $('#xpr-wallet').show();
          }
          else if(response.status == '6') {
            $('#planDiamondPay').css("opacity","");
            $('#planDiamondBtn').html('Buy');
            $('#planModal').modal('show');
            $('#doge-wallet').show();
          }
          else if(response.status == '7') {
            $('#planDiamondPay').css("opacity","");
            $('#planDiamondBtn').html('Buy');
            $('#planModal').modal('show');
            $('#usdt-wallet').show();
          }
        }
      });
    });
  </script>
</body>
</html>