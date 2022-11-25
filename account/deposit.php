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
  <title>Deposit - Bitcoptions</title>
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
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/custom-css.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <style>.btn-dark:hover{background-color: #454d55 !important}</style>
</head>
<body id="results" class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <!-- Modal -->
  <div class="modal fade" id="depositModal" tabindex="-1" role="dialog" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header border-0 px-sm-4 px-2">
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
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyBtc(btcWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div class="card-text text-primary">Share</div>
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
                      <img src="img/<?php echo $eth['barcode'] ?>" alt="Bitcoin Barcode" class="card-img-top">
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
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyEth(ethWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div class="card-text text-primary">Share</div>
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
                      <img src="img/<?php echo $bnb['barcode'] ?>" alt="Bitcoin Barcode" class="card-img-top">
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
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyBnb(bnbWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
                    <div class="card-text text-primary">Share</div>
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
                      <img src="img/<?php echo $ada['barcode'] ?>" alt="Bitcoin Barcode" class="card-img-top">
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
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyAda(adaWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
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
                      <img src="img/<?php echo $xpr['barcode'] ?>" alt="Bitcoin Barcode" class="card-img-top">
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
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyXpr(xprWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
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
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyDoge(dogeWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
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
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="far fa-copy"></i></button>
                    <div class="card-text text-primary">Copy</div>
                  </span>
                  <span class="copy text-center mx-2">
                    <button type="button" data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-times"></i></button>
                    <div data-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Close" class="refresh-modal card-text text-primary">Close</div>
                  </span>
                  <span class="copy text-center mx-2" onclick="copyUsdt(usdtWalletId)" data-toggle="tooltip" data-original-title="Copy to clipboard">
                    <button type="button" class="btn btn-primary p-0 rounded-circle border-0 align-items-center" style="height: 40px; width: 40px; font-size: 15px;"><i class="fas fa-share-alt"></i></button>
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

  <div class="modal fade" id="hashModal" tabindex="-1" role="dialog" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header border-0 px-sm-4 px-2">
          <h4>Upload Transaction Hash</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body px-sm-4 px-2">
          <form id="uploadHashForm">
            <input type="hidden" name="username" id="username" value="<?php echo $data['username'] ?>">

            <div id="checkTransactionId">
              <div class="form-group">
                <label for="exampleInput1" style="font-weight: normal;">Transaction Reference Number (TRN) <span class="text-danger">*</span></label>
                <input type="text" name="transid" id="transid" class="form-control bg-light" required/>
                <ul class="text-muted" style="font-size: 14px; list-style: none; padding-left: 0;">
                  <li><span class="text-warning">*</span> A transaction reference number (TRN) is a unique number given to every transaction made on Bitcoptions.</li>
                  <li><span class="text-warning">*</span> An email containing the TRN was sent to your email for every transaction made on Bitcoptions</li>
                  <li><span class="text-warning">*</span> It commonly appears at the first column of the transaction row in the history table.</li>
                </ul>

              </div>

              <div class="form-group d-flex justify-content-end">
                <button type="button" id="checkTransactionIdBtn" class="btn btn-default">Continue</button>
              </div>
            </div>


            <div id="uploadTransactionHash" style="display: none;">
              
            </div>
          </form>
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
              <a href="dashboard" class="nav-link">
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
              <a href="deposit" class="nav-link active">
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
              <a href="plans" class="nav-link">
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

          <?php
          $t = "deposit";
          $s = "pending";
          $xy = $db_conn->query("SELECT * FROM transactions WHERE username = '$username' AND type = '$t' AND status = '$s'");
          $z = $xy->num_rows;
          if ($z > 0) {
            echo '
            <div class="row justify-content-center">
              <div class="col-12 col-lg-10 col-md-11 px-sm-2 px-0">
                <div class="card rounded-0 bg-transparent border-0 shadow-none">
                  <div class="card-body px-0 py-2">
                    <span class="text-warning float-left">Pending</span>
                    <a id="getHashModal" class="btn btn-primary btn-sm float-right">Confirm Transaction <span class="badge badge-danger">'.$z.'</span></a>
                  </div>
                </div>
              </div>
            </div>
            ';
          } else {
            echo '';
          }
          ?>
          


          <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-md-11 px-sm-2 px-0">
              <div class="card rounded-0">
                <div class="card-body">
                  <div class="row px-sm-1 text-muted text-sm">Equity Value (BTC)</div>
                  <div class="row px-sm-1">
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
                    <span class="h5" style="letter-spacing: 0px;"><?php echo number_format($bal_btc_value, 8, '.', ''); ?></span>
                    <span class="pl-1 card-text text-muted text-sm">&#x2248; $<?php echo number_format($accbalance, 2); ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-12 col-sm-6 px-sm-2 px-0 pb-3">
              <div class="card rounded-0 h-100">
                
                <div class="card-body px-1">
                  <div id="choose-deposit-method" class="row">
                    <div class="col-12 px-4">
                      <div class="row px-0 border border-secondary border-top-0 border-right-0 border-left-0">
                        <div class="text-muted w-100">Coin List</div>
                      </div>
                    </div>

                    <div class="col-12 px-1">
                      <button type="button" id="btc-deposit" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/bitcoin.png" height="25" alt="Bitcoin" class="my-auto" >
                            <span class="ml-1 h5 align-middle">BTC<span class="text-muted" style="font-size:12px;"> Bitcoin</span></span>
                      </button>

                      <button type="button" id="eth-deposit" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/ethereum.png" height="25" alt="Ethereum" class="my-auto" >
                            <span class="ml-1 h5 align-middle">ETH<span class="text-muted" style="font-size:12px;"> Ethereum</span></span>
                      </button>

                      <button type="button" id="bnb-deposit" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/binance_coin.png" height="25" alt="Binance" class="my-auto" >
                            <span class="ml-1 h5 align-middle">BNB<span class="text-muted" style="font-size:12px;"> Binance</span></span>
                      </button>

                      <button type="button" id="ada-deposit" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/cardano.png" height="25" alt="Cardano" class="my-auto" >
                            <span class="ml-1 h5 align-middle">ADA<span class="text-muted" style="font-size:12px;"> Cardano</span></span>
                      </button>


                      <button type="button" id="xpr-deposit" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/proton.png" height="25" alt="Proton" class="my-auto" >
                            <span class="ml-1 h5 align-middle">XPR<span class="text-muted" style="font-size:12px;"> Proton</span></span>
                      </button>


                      <button type="button" id="doge-deposit" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/dogecoin.png" height="25" alt="Dogecoin" class="my-auto" >
                            <span class="ml-1 h5 align-middle">DOGE<span class="text-muted" style="font-size:12px;"> Dogecoin</span></span>
                      </button>


                      <button type="button" id="usdt-deposit" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/tether.png" height="25" alt="Tether" class="my-auto" >
                            <span class="ml-1 h5 align-middle">USDT<span class="text-muted" style="font-size:12px;"> Tether</span></span>
                      </button>

                    </div>
                      
                  </div>
                  <div id="process-deposit-request" class="px-2">
                    
                    <form id="depositBTCForm" style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-deposit text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a href="history" class="btn border-0 cancel-deposit text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2 pb-4">Deposit BTC</div>
                      
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="btc">
                      <input type="hidden" name="deposit" value="deposit">
                      <input type="hidden" name="network" value="BTC">
                      
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group pb-4">
                        <input id="deposit-btc-amount" class="form-control text-muted border-0 rounded-0 usd-btc-value bg-secondary text-white" type="text" name="amount" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="$1,000,000.00" required style="font-size:16px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text deposit-usd border-0 px-1 border-0 rounded-0 bg-secondary text-white" id="basic-addon2">USD</span>
                      </div>
                                                
                      <div class="row border-top border-secondary py-2">
                        <div class="col">
                          <div class="float-left">
                            
                            <div class="py-0 text-sm"><span class="btc-value h5">0.00</span> BTC</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="depositBTCBtn" class="btn btn-outline-light btn-sm mt-2">Pay <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="depositETHForm"  style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-deposit text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a href="history" class="btn border-0 cancel-deposit text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2 pb-4">Deposit ETH</div>
                      
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="eth">
                      <input type="hidden" name="deposit" value="deposit">
                      <input type="hidden" name="network" value="ETH">
                      
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group pb-4">
                        <input id="deposit-eth-amount" class="form-control text-muted border-0 rounded-0 usd-eth-value bg-secondary text-white" type="text" name="amount" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="$1,000,000.00" required style="font-size:16px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text deposit-usd border-0 px-1 border-0 rounded-0 bg-secondary text-white" id="basic-addon2">USD</span>
                      </div>
                                                
                      <div class="row border-top border-secondary py-2">
                        <div class="col">
                          <div class="float-left">
                            
                            <div class="py-0 text-sm"><span class="eth-value h5">0.00</span> ETH</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="depositETHBtn" class="btn btn-outline-light btn-sm mt-2">Pay <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="depositBNBForm"  style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-deposit text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a href="history" class="btn border-0 cancel-deposit text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2 pb-4">Deposit BNB</div>
                      
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="bnb">
                      <input type="hidden" name="deposit" value="deposit">
                      <input type="hidden" name="network" value="BNB">
                      
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group pb-4">
                        <input id="deposit-bnb-amount" class="form-control text-muted border-0 rounded-0 usd-bnb-value bg-secondary text-white" type="text" name="amount" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="$1,000,000.00" required style="font-size:16px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text deposit-usd border-0 px-1 border-0 rounded-0 bg-secondary text-white" id="basic-addon2">USD</span>
                      </div>
                                                
                      <div class="row border-top border-secondary py-2">
                        <div class="col">
                          <div class="float-left">
                            
                            <div class="py-0 text-sm"><span class="bnb-value h5">0.00</span> BNB</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="depositBNBBtn" class="btn btn-outline-light btn-sm mt-2">Pay <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="depositADAForm"  style="height:302px;display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-deposit text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a href="history" class="btn border-0 cancel-deposit text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2 pb-4">Deposit ADA</div>
                      
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="ada">
                      <input type="hidden" name="deposit" value="deposit">
                      <input type="hidden" name="network" value="BEP2">
                      
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group pb-4">
                        <input id="deposit-ada-amount" class="form-control text-muted border-0 rounded-0 usd-ada-value bg-secondary text-white" type="text" name="amount" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="$1,000,000.00" required style="font-size:16px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text deposit-usd border-0 px-1 border-0 rounded-0 bg-secondary text-white" id="basic-addon2">USD</span>
                      </div>
                                                
                      <div class="row border-top border-secondary py-2">
                        <div class="col">
                          <div class="float-left">
                            
                            <div class="py-0 text-sm"><span class="ada-value h5">0.00</span> ADA</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="depositADABtn" class="btn btn-outline-light btn-sm mt-2">Pay <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="depositXPRForm"  style="height:302px;display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-deposit text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a href="history" class="btn border-0 cancel-deposit text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2 pb-4">Deposit XPR</div>
                      
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="xpr">
                      <input type="hidden" name="deposit" value="deposit">
                      <input type="hidden" name="network" value="BEP2">
                      
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group pb-4">
                        <input id="deposit-xpr-amount" class="form-control text-muted border-0 rounded-0 usd-xpr-value bg-secondary text-white" type="text" name="amount" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="$1,000,000.00" required style="font-size:16px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text deposit-usd border-0 px-1 border-0 rounded-0 bg-secondary text-white" id="basic-addon2">USD</span>
                      </div>
                                                
                      <div class="row border-top border-secondary py-2">
                        <div class="col">
                          <div class="float-left">
                            
                            <div class="py-0 text-sm"><span class="xpr-value h5">0.00</span> XPR</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="depositXPRBtn" class="btn btn-outline-light btn-sm mt-2">Pay <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="depositDOGEForm"  style="height:302px;display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-deposit text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a href="history" class="btn border-0 cancel-deposit text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2 pb-4">Deposit DOGE</div>
                      
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="doge">
                      <input type="hidden" name="deposit" value="deposit">
                      <input type="hidden" name="network" value="BEP2">
                      
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group pb-4">
                        <input id="deposit-doge-amount" class="form-control text-muted border-0 rounded-0 usd-doge-value bg-secondary text-white" type="text" name="amount" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="$1,000,000.00" required style="font-size:16px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text deposit-usd border-0 px-1 border-0 rounded-0 bg-secondary text-white" id="basic-addon2">USD</span>
                      </div>
                                                
                      <div class="row border-top border-secondary py-2">
                        <div class="col">
                          <div class="float-left">
                            
                            <div class="py-0 text-sm"><span class="doge-value h5">0.00</span> DOGE</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="depositDOGEBtn" class="btn btn-outline-light btn-sm mt-2">Pay <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="depositUSDTForm"  style="height:302px;display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-deposit text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a href="history" class="btn border-0 cancel-deposit text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2 pb-4">Deposit USDT</div>
                      
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="usdt">
                      <input type="hidden" name="deposit" value="deposit">
                      <input type="hidden" name="network" value="BEP2">
                      
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group pb-4">
                        <input id="deposit-usdt-amount" class="form-control text-muted border-0 rounded-0 usd-usdt-value bg-secondary text-white" type="text" name="amount" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="$1,000,000.00" required style="font-size:16px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text deposit-usd border-0 px-1 border-0 rounded-0 bg-secondary text-white" id="basic-addon2">USD</span>
                      </div>
                                                
                      <div class="row border-top border-secondary py-2">
                        <div class="col">
                          <div class="float-left">
                            
                            <div class="py-0 text-sm"><span class="usdt-value h5">0.00</span> USDT</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="depositUSDTBtn" class="btn btn-outline-light btn-sm mt-2">Pay <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                  </div>

                </div>
                <div id="loading" class="overlay dark" style="display: none;"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-5 col-lg-4 px-sm-2 px-0">
              <div class="card rounded-0">
                <div class="card-body p-0">
                  <script>!function(){var e=document.getElementsByTagName("script"),t=e[e.length-1],n=document.createElement("script");function r(){var e=crCryptocoinPriceWidget.init({base:"USD,BTC,ETH,BNB",items:"BTC,ETH,BNB,ADA,LTC,TRX,BUSD,USDT",backgroundColor:"#454d55",streaming:"1",rounded:"0",boxShadow:"1",border:"1"});t.parentNode.insertBefore(e,t)}n.src="https://co-in.io/widget/pricelist.js?items=BTC%2CETH%2CBNB%2CADA%2CLTC%2CTRX%2CBUSD%2CUSDT",n.async=!0,n.readyState?n.onreadystatechange=function(){"loaded"!=n.readyState&&"complete"!=n.readyState||(n.onreadystatechange=null,r())}:n.onload=function(){r()},t.parentNode.insertBefore(n,null)}();</script>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center pb-2">
              
            <div class="col-12 col-lg-10 col-md-11 px-sm-2 px-0">

              <div class="card rounded-0">
                <div class="card-body">
                  <?php 
                  $sql = $db_conn->query("SELECT * FROM transactions WHERE username = '$username' AND type ='deposit' ORDER BY id DESC");
                  if($sql->num_rows > 0) {
                    echo '
                    <table id="example1" class="table table table-hover table-dark" style="font-size: 14px;">
                      <thead>
                        <tr class="bg-secondary">
                          <th>TRN</th>
                          <th>Date</th>
                          <th>Coin</th>
                          <th>Value</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      ';
                      while($row = $sql->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="text-muted font-weight-bold">'.$row['transid'].'</td>';
                            echo '<td>'.date("m-d-Y", strtotime($row['regdate'])).'</td>';
                            echo '<td class="text-info text-uppercase" >'.$row['method'].'</td>';
                            echo '<td class="text-warning" >$'.number_format($row['amount'], 2).'</td>';
                            echo '<td class="text-danger text-capitalize">'.$row['status'].'</td>
                            ';
                            echo '</tr>';
                           
                          }
                      echo '
                      </tbody>
                    </table>
                    ';
                  } else {
                    echo '
                    <table id="example1" class="table table table-hover table-dark" style="font-size: 14px;">
                      <thead>
                        <tr class="bg-secondary">
                          <th>#</th>
                          <th>Date</th>
                          <th>Coin</th>
                          <th>Value</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                    ';
                  }
                  ?>
                    
                </div>
              </div>
              
            </div>
          </div>
        </div><!-- /.container-fluid -->
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
              <textarea class="form-control input-field bg-light" name="message" placeholder="Type message here..." rows="2"autocomplete="off"></textarea>
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

    $('#checkTransactionIdBtn').click(function () {
      $('#checkTransactionId').hide();
      $('#uploadTransactionHash').show();
      get_hash();
    });

    function get_hash() {
      var transid = $('#transid').val();
      var username = $('#username').val();
      $.ajax({
        url: 'get-hash.php',
        type: 'POST',
        data: {transid:transid, username:username},
        success: function(data) {
          $('#uploadTransactionHash').html(data);
        }
      });
    }

    $(document).on('submit', '#uploadHashForm', function(e) {
      e.preventDefault();      
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#uploadHashForm').css("opacity",".5");
          $('#loadEx').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#uploadHashForm')[0].reset();
            $('#uploadHashForm').css("opacity","");
            $('#loadEx').hide();
            $('#uploadTransactionHash').html(''+response.message+'');
          }
        }
      });
    });

    $(document).on('click', '#getHashModal', function() {
      $('#hashModal').modal('show');
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
    function copyBtc(containerid) {
      var copyText = document.createRange();
      copyText.selectNode(containerid); //changed here
      window.getSelection().removeAllRanges(); 
      window.getSelection().addRange(copyText); 
      document.execCommand("copy");
      window.getSelection().removeAllRanges();
    }

    function copyEth(containerid) {
      var copyText = document.createRange();
      copyText.selectNode(containerid); //changed here
      window.getSelection().removeAllRanges(); 
      window.getSelection().addRange(copyText); 
      document.execCommand("copy");
      window.getSelection().removeAllRanges();
    }

    function copyBnb(containerid) {
      var copyText = document.createRange();
      copyText.selectNode(containerid); //changed here
      window.getSelection().removeAllRanges(); 
      window.getSelection().addRange(copyText); 
      document.execCommand("copy");
      window.getSelection().removeAllRanges();
    }

    function copyAda(containerid) {
      var copyText = document.createRange();
      copyText.selectNode(containerid); //changed here
      window.getSelection().removeAllRanges(); 
      window.getSelection().addRange(copyText); 
      document.execCommand("copy");
      window.getSelection().removeAllRanges();
    }

    function copyXpr(containerid) {
      var copyText = document.createRange();
      copyText.selectNode(containerid); //changed here
      window.getSelection().removeAllRanges(); 
      window.getSelection().addRange(copyText); 
      document.execCommand("copy");
      window.getSelection().removeAllRanges();
    }

    function copyDoge(containerid) {
      var copyText = document.createRange();
      copyText.selectNode(containerid); //changed here
      window.getSelection().removeAllRanges(); 
      window.getSelection().addRange(copyText); 
      document.execCommand("copy");
      window.getSelection().removeAllRanges();
    }

    function copyUsdt(containerid) {
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
        $(this).tooltip('hide').attr('data-original-title', 'Copy to clipboard');
      });
      $('[data-bs-toggle="tooltip"]').tooltip('Close');
    });

    $('.refresh-modal').click(function() {
      $('#depositBTCBtn, #depositETHBtn, #depositBNBBtn, #depositADABtn, #depositXPRBtn, #depositDOGEBtn #depositUSDTBtn').html('Pay <i class="fas fa-angle-double-right pl-2"></i>');
      $('#btc-wallet').hide();
      $('#eth-wallet').hide();
      $('#bnb-wallet').hide();
      $('#ada-wallet').hide();
      $('#xpr-wallet').hide();
      $('#doge-wallet').hide();
      $('#usdt-wallet').hide();
      $('#choose-deposit-method').show();
      $('.usd-btc-value, .usd-eth-value, .usd-bnb-value, .usd-ada-value, .usd-xpr-value, .usd-doge-value .usd-usdt-value').html('0.00');
      $('#depositBTCForm, #depositETHForm, #depositBNBForm, #depositADAForm, #depositXPRForm, #depositDOGEForm, #depositUSDTForm')[0].reset();
    });

    $(document).on('click', '#btc-deposit', function(event) {
      event.preventDefault();
      $('#choose-deposit-method').hide();
      $('#depositBTCForm').show();
    });
    $(document).on('click', '#eth-deposit', function(event) {
      event.preventDefault();
      $('#choose-deposit-method').hide();
      $('#depositETHForm').show();
    });
    $(document).on('click', '#bnb-deposit', function(event) {
      event.preventDefault();
      $('#choose-deposit-method').hide();
      $('#depositBNBForm').show();
    });
    $(document).on('click', '#ada-deposit', function(event) {
      event.preventDefault();
      $('#choose-deposit-method').hide();
      $('#depositADAForm').show();
    });
    $(document).on('click', '#xpr-deposit', function(event) {
      event.preventDefault();
      $('#choose-deposit-method').hide();
      $('#depositXPRForm').show();
    });
    $(document).on('click', '#doge-deposit', function(event) {
      event.preventDefault();
      $('#choose-deposit-method').hide();
      $('#depositDOGEForm').show();
    });
    $(document).on('click', '#usdt-deposit', function(event) {
      event.preventDefault();
      $('#choose-deposit-method').hide();
      $('#depositUSDTForm').show();
    });
    $(document).on('click', '.cancel-deposit', function() {
      $('#depositBTCForm, #depositETHForm, #depositBNBForm, depositADAForm, depositXPRForm, depositDOGEForm, depositUSDTForm')[0].reset();
      $('#choose-deposit-method').show();
      $('#depositBTCForm').hide();
      $('#depositETHForm').hide();
      $('#depositBNBForm').hide();
      $('#depositADAForm').hide();
      $('#depositXPRForm').hide();
      $('#depositDOGEForm').hide();
      $('#depositUSDTForm').hide();
      $('#usd-btc-value, #usd-eth-value, #usd-bnb-value, #usd-ada-value, #usd-xpr-value, #usd-usdt-value').html('0.00');
    });

    $(document).on('submit', '#depositBTCForm', function(e) {
      e.preventDefault();
      var temp = $(this).serialize();
      var data = temp.replace(/\$|,/g, '');
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#depositBTCForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#choose-deposit-method').show();
            $('#depositBTCForm').hide();
            $('#depositBTCForm')[0].reset();
            $('#loading').html('<i class="fa-4x fas fa-check-circle text-success"></i>');
            $('#depositModal').modal('show');
            $('#btc-wallet').show();
            $('#loading').hide();
          }
        }
      });
    });

    $(document).on('submit', '#depositETHForm', function(e) {
      e.preventDefault();
      var temp = $(this).serialize();
      var data = temp.replace(/\$|,/g, '');
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#depositETHForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '2') {
            $('#choose-deposit-method').show();
            $('#depositETHForm').hide();
            $('#depositETHForm')[0].reset();
            $('#loading').html('<i class="fa-4x fas fa-check-circle text-success"></i>');
            $('#depositModal').modal('show');
            $('#eth-wallet').show();
            $('#loading').hide();
          }
        }
      });
    });

    $(document).on('submit', '#depositBNBForm', function(e) {
      e.preventDefault();
      var temp = $(this).serialize();
      var data = temp.replace(/\$|,/g, '');
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#depositBNBForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '3') {
            $('#choose-deposit-method').show();
            $('#depositBNBForm').hide();
            $('#depositBNBForm')[0].reset();
            $('#loading').html('<i class="fa-4x fas fa-check-circle text-success"></i>');
            $('#depositModal').modal('show');
            $('#bnb-wallet').show();
            $('#loading').hide();
          }
        }
      });
    });

    $(document).on('submit', '#depositADAForm', function(e) {
      e.preventDefault();
      var temp = $(this).serialize();
      var data = temp.replace(/\$|,/g, '');
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#depositADAForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '4') {
            $('#choose-deposit-method').show();
            $('#depositADAForm').hide();
            $('#depositADAForm')[0].reset();
            $('#loading').html('<i class="fa-4x fas fa-check-circle text-success"></i>');
            $('#depositModal').modal('show');
            $('#ada-wallet').show();
            $('#loading').hide();
          }
        }
      });
    });

    $(document).on('submit', '#depositXPRForm', function(e) {
      e.preventDefault();
      var temp = $(this).serialize();
      var data = temp.replace(/\$|,/g, '');
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#depositXPRForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '5') {
            $('#choose-deposit-method').show();
            $('#depositXPRForm').hide();
            $('#depositXPRForm')[0].reset();
            $('#loading').html('<i class="fa-4x fas fa-check-circle text-success"></i>');
            $('#depositModal').modal('show');
            $('#xpr-wallet').show();
            $('#loading').hide();
          }
        }
      });
    });

    $(document).on('submit', '#depositDOGEForm', function(e) {
      e.preventDefault();
      var temp = $(this).serialize();
      var data = temp.replace(/\$|,/g, '');
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#depositDOGEForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '6') {
            $('#choose-deposit-method').show();
            $('#depositDForm').hide();
            $('#depositDOGEForm')[0].reset();
            $('#loading').html('<i class="fa-4x fas fa-check-circle text-success"></i>');
            $('#depositModal').modal('show');
            $('#doge-wallet').show();
            $('#loading').hide();
          }
        }
      });
    });

    $(document).on('submit', '#depositUSDTForm', function(e) {
      e.preventDefault();
      var temp = $(this).serialize();
      var data = temp.replace(/\$|,/g, '');
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#depositUSDTForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '7') {
            $('#choose-deposit-method').show();
            $('#depositDForm').hide();
            $('#depositUSDTForm')[0].reset();
            $('#loading').html('<i class="fa-4x fas fa-check-circle text-success"></i>');
            $('#depositModal').modal('show');
            $('#usdt-wallet').show();
            $('#loading').hide();
          }
        }
      });
    });

    $(function () {
      $("#example1").DataTable({
        "paging": true,
        "responsive": true, 
        "lengthChange": true, 
        "autoWidth": true, 
        "searching": false, 
        "ordering": true,
        "order": [[ 2, "desc" ]],
        "info": true,
        buttons: ['pdf', 'print']

      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "order": [[ 2, "desc" ]],
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });

    $(document).ready(function() {
      $('.buttons-pdf').removeClass('btn-secondary').addClass('btn-default btn-sm rounded text-info mr-2');
      $('.buttons-print').removeClass('btn-secondary').addClass('btn-default btn-sm rounded text-info');
      $('.buttons-pdf').html('Download <i class="fas fa-download"></i>');
      $('.buttons-print').html('Print <i class="fas fa-print"></i>');
      $('#example1_wrapper .col-md-6').removeClass('col-md-6 ').addClass('pb-2');
    });

    $('#deposit-btc-amount, #deposit-eth-amount, #deposit-bnb-amount, #deposit-ada-amount, #deposit-xpr-amount, #deposit-doge-amount, #deposit-usdt-amount').keyup(function() {
      get_btc();
      get_eth();
      get_bnb();
      get_ada();
      get_xpr();
      get_doge();
      get_usdt();
    });

    function get_btc() {
      var temp = $('.usd-btc-value').val();
      var usd = temp.replace(/\$|,/g, '');
      var btc = $('.btc-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, btc:btc},
          success: function (data) {
            $('.btc-value').html(data);
            $('#usd-btc-value').html(usd);
            formatValue();
          }
        });
      }
      else {
        $('#check-num-value').html('Enter a valid amount');
        setTimeout(function() {
          $('#check-num-value').html('');
        }, 2000);
      }     
    }

    function get_eth() {
      var temp = $('.usd-eth-value').val();
      var usd = temp.replace(/\$|,/g, '');
      var eth = $('.eth-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, eth:eth},
          success: function (data) {
            $('.eth-value').html(data);
            $('#usd-eth-value').html(usd);
            formatValue();
          }
        });
      }
      else {
        $('#check-num-value').html('Enter a valid amount');
        setTimeout(function() {
          $('#check-num-value').html('');
        }, 2000);
      }     
    }

    function get_bnb() {
      var temp = $('.usd-bnb-value').val();
      var usd = temp.replace(/\$|,/g, '');
      var bnb = $('.bnb-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, bnb:bnb},
          success: function (data) {
            $('.bnb-value').html(data);
            $('#usd-bnb-value').html(usd);
            formatValue();
          }
        });
      }
      else {
        $('#check-num-value').html('Enter a valid amount');
        setTimeout(function() {
          $('#check-num-value').html('');
        }, 2000);
      }     
    }

    function get_ada() {
      var temp = $('.usd-ada-value').val();
      var usd = temp.replace(/\$|,/g, '');
      var ada = $('.ada-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, ada:ada},
          success: function (data) {
            $('.ada-value').html(data);
            $('#usd-ada-value').html(usd);
            formatValue();
          }
        });
      }
      else {
        $('#check-num-value').html('Enter a valid amount');
        setTimeout(function() {
          $('#check-num-value').html('');
        }, 2000);
      }     
    }

    function get_xpr() {
      var temp = $('.usd-xpr-value').val();
      var usd = temp.replace(/\$|,/g, '');
      var xpr = $('.xpr-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, xpr:xpr},
          success: function (data) {
            $('.xpr-value').html(data);
            $('#usd-xpr-value').html(usd);
            formatValue();
          }
        });
      }
      else {
        $('#check-num-value').html('Enter a valid amount');
        setTimeout(function() {
          $('#check-num-value').html('');
        }, 2000);
      }     
    }

    function get_doge() {
      var temp = $('.usd-doge-value').val();
      var usd = temp.replace(/\$|,/g, '');
      var doge = $('.doge-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, doge:doge},
          success: function (data) {
            $('.doge-value').html(data);
            $('#usd-doge-value').html(usd);
            formatValue();
          }
        });
      }
      else {
        $('#check-num-value').html('Enter a valid amount');
        setTimeout(function() {
          $('#check-num-value').html('');
        }, 2000);
      }     
    }

    function get_usdt() {
      var temp = $('.usd-usdt-value').val();
      var usd = temp.replace(/\$|,/g, '');
      var usdt = $('.usdt-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, usdt:usdt},
          success: function (data) {
            $('.usdt-value').html(data);
            $('#usd-usdt-value').html(usd);
            formatValue();
          }
        });
      }
      else {
        $('#check-num-value').html('Enter a valid amount');
        setTimeout(function() {
          $('#check-num-value').html('');
        }, 2000);
      }     
    }

    $("input[data-type='currency']").on({
        keyup: function() {
          formatCurrency($(this));
        },
        blur: function() { 
          formatCurrency($(this), "blur");
        }
    });


    function formatNumber(n) {
      // format number 1000000 to 1,234,567
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
      // appends $ to value, validates decimal side
      // and puts cursor back in right position.
      
      // get input value
      var input_val = input.val();
      
      // don't validate empty input
      if (input_val === "") { return; }
      
      // original length
      var original_len = input_val.length;

      // initial caret position 
      var caret_pos = input.prop("selectionStart");
        
      // check for decimal
      if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);
        
        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
          right_side += "00";
        }
        
        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = "$" + left_side + "." + right_side;

      } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = "$" + input_val;
        
        // final formatting
        if (blur === "blur") {
          input_val += ".00";
        }
      }
      
      // send updated string to input
      input.val(input_val);

      // put caret back in the right position
      var updated_len = input_val.length;
      caret_pos = updated_len - original_len + caret_pos;
      input[0].setSelectionRange(caret_pos, caret_pos);
    }

    function formatValue() {
      let x = document.querySelectorAll('.usd-btc-value, .usd-eth-value, .usd-bnb-value, .usd-ada-value, .usd-xpr-value, .usd-doge-value, .usd-usdt-value');
      for (let i = 0, len = x.length; i < len; i++) {
          let num = Number(x[i].innerHTML)
                    .toLocaleString('en');
          x[i].innerHTML = num;
          x[i].classList.add("currSign");
      }
    }
  </script>
</body>
</html>