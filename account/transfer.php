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
  <title>Transfer - Bitcoptions</title>
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
              <a href="transfer" class="nav-link active">
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
                    $btcbalance = $xy['btc'];
                    $ethbalance = $xy['eth'];
                    $bnbbalance = $xy['bnb'];
                    $adabalance = $xy['ada'];
                    $xprbalance = $xy['xpr'];
                    $dogebalance = $xy['doge'];
                    $usdtbalance = $xy['usdt'];


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
                  <div id="choose-transfer-method" class="row">
                    <div class="col-12 px-4">
                      <div class="row px-0 border border-secondary border-top-0 border-right-0 border-left-0">
                        <div class="text-muted w-100">Coin List</div>
                      </div>
                    </div>

                    <div class="col-12 px-1">
                      <button type="button" id="btc-transfer" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/bitcoin.png" height="25" alt="Bitcoin" class="my-auto" >
                            <span class="ml-1 h5 align-middle">BTC<span class="text-muted" style="font-size:12px;"> Bitcoin</span></span>
                      </button>

                      <button type="button" id="eth-transfer" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/ethereum.png" height="25" alt="Ethereum" class="my-auto" >
                            <span class="ml-1 h5 align-middle">ETH<span class="text-muted" style="font-size:12px;"> Ethereum</span></span>
                      </button>

                      <button type="button" id="bnb-transfer" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/binance_coin.png" height="25" alt="Binance" class="my-auto" >
                            <span class="ml-1 h5 align-middle">BNB<span class="text-muted" style="font-size:12px;"> Binance</span></span>
                      </button>

                      <button type="button" id="ada-transfer" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/cardano.png" height="25" alt="Cardano" class="my-auto" >
                            <span class="ml-1 h5 align-middle">ADA<span class="text-muted" style="font-size:12px;"> Cardano</span></span>
                      </button>


                      <button type="button" id="xpr-transfer" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/proton.png" height="25" alt="Proton" class="my-auto" >
                            <span class="ml-1 h5 align-middle">XPR<span class="text-muted" style="font-size:12px;"> Proton</span></span>
                      </button>


                      <button type="button" id="doge-transfer" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/dogecoin.png" height="25" alt="Dogecoin" class="my-auto" >
                            <span class="ml-1 h5 align-middle">DOGE<span class="text-muted" style="font-size:12px;"> Dogecoin</span></span>
                      </button>


                      <button type="button" id="usdt-transfer" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <img src="img/tether.png" height="25" alt="Tether" class="my-auto" >
                            <span class="ml-1 h5 align-middle">USDT<span class="text-muted" style="font-size:12px;"> Tether</span></span>
                      </button>

                    </div>
                      
                  </div>
                  <div id="process-transfer-request" class="px-2">
                    
                    <form id="transferBTCForm" style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-transfer text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a class="btn border-0 cancel-transfer text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2 pb-4">Transfer BTC</div>
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="btc">
                      <input type="hidden" name="transfer" value="transfer">
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Address</label>
                      <div class="input-group mb-4">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="walletid" placeholder="Long press to paste" required style="font-size:12px;height:45px;" autocomplete="off" aria-describedby="basic-addon1">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon1"><i class="far fa-address-book text-muted"></i></span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Network <i class="fas fa-exclamation-circle text-muted"></i></label>
                      <div class="input-group mb-4">
                        <select class="form-select w-100 bg-light text-muted border-0" type="text" name="network" required style="font-size:12px;height:45px;" autocomplete="off">
                          <option value="BTC" selected>BTC</option>
                        </select>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0 usd-btc-value" type="text" id="transfer-btc-amount" name="amount" required pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">USD</span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0" style="font-size: 12px;">Available: <span class="pr-1"><?php echo number_format($btcbalance, 2); ?></span>BTC</label>
                      <div class="py-4">
                        <div class="card-text text-muted font-weight-bold pb-2" style="font-size: 14px;">Tips</div>
                        <p class="card-text text-muted" style="font-size: 12px;">* 24h remaining limit: <span class="text-dark">100/100.0BTC</span></p>
                        <p class="card-text text-muted" style="font-size: 12px;">* Do not transfer directly to a crowdfund or ICO. We will not credit your account with tokens from that sale. *Once you have submitted your transfer request, we will send a comfirmation email. Please click on the confirmation link in your email.</p>
                      </div>
                      <div class="row border-top border-grey py-2">
                        <div class="col">
                          <div class="float-left">
                            <div class="py-0 text-sm"><span class="btc-value h5"></span> BTC</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="transferBTCBtn" class="btn btn-default mt-2">Confirm Transfer <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="transferETHForm" style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-transfer text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a class="btn border-0 cancel-transfer text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2">Transfer ETH</div>
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="eth">
                      <input type="hidden" name="transfer" value="transfer">
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Address</label>
                      <div class="input-group mb-4">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="walletid" placeholder="Long press to paste" required style="font-size:12px;height:45px;" autocomplete="off" aria-describedby="basic-addon1">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon1"><i class="far fa-address-book text-muted"></i></span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Network <i class="fas fa-exclamation-circle text-muted"></i></label>
                      <div class="input-group mb-4">
                        <select class="form-select w-100 bg-light text-muted border-0" type="text" name="network" required style="font-size:12px;height:45px;" autocomplete="off">
                          <option value="" disabled selected hidden>Automatically match the network</option>
                          <option value="ETH" selected>ETH</option>
                        </select>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0 usd-eth-value" type="text" id="transfer-eth-amount" name="amount" required pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">USD</span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0" style="font-size: 12px;">Available: <span class="pr-1"><?php echo number_format($ethbalance, 2); ?></span>ETH</label>
                      <div class="py-4">
                        <div class="card-text text-muted font-weight-bold pb-2" style="font-size: 14px;">Tips</div>
                        <p class="card-text text-muted" style="font-size: 12px;">* 24h remaining limit: <span class="text-dark">100/100.0ETH</span></p>
                        <p class="card-text text-muted" style="font-size: 12px;">* Do not transfer directly to a crowdfund or ICO. We will not credit your account with tokens from that sale. *Once you have submitted your transfer request, we will send a comfirmation email. Please click on the confirmation link in your email.</p>
                      </div>
                      <div class="row border-top border-grey py-2">
                        <div class="col">
                          <div class="float-left">
                            <div class="py-0 text-sm"><span class="eth-value h5"></span> ETH</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="transferETHBtn" class="btn btn-default mt-2">Confirm Transfer <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="transferBNBForm" style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-transfer text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a class="btn border-0 cancel-transfer text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2">Transfer BNB</div>
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="bnb">
                      <input type="hidden" name="transfer" value="transfer">
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Address</label>
                      <div class="input-group mb-4">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="walletid" placeholder="Long press to paste" required style="font-size:12px;height:45px;" autocomplete="off" aria-describedby="basic-addon1">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon1"><i class="far fa-address-book text-muted"></i></span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Network <i class="fas fa-exclamation-circle text-muted"></i></label>
                      <div class="input-group mb-4">
                        <select class="form-select w-100 bg-light text-muted border-0" type="text" name="network" required style="font-size:12px;height:45px;" autocomplete="off">
                          <option value="" disabled selected hidden>Automatically match the network</option>
                          <option value="BEP2">BEP2</option>
                          <option value="BEP20 (BSC)">BEP20 (BSC)</option>
                          <option value="ERC20">ERC20</option>
                        </select>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0 usd-bnb-value" type="text" id="transfer-bnb-amount" name="amount" required pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">USD</span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0" style="font-size: 12px;">Available: <span class="pr-1"><?php echo number_format($bnbbalance, 2); ?></span>BNB</label>
                      <div class="py-4">
                        <div class="card-text text-muted font-weight-bold pb-2" style="font-size: 14px;">Tips</div>
                        <p class="card-text text-muted" style="font-size: 12px;">* 24h remaining limit: <span class="text-dark">100/100.0BNB</span></p>
                        <p class="card-text text-muted" style="font-size: 12px;">* Do not transfer directly to a crowdfund or ICO. We will not credit your account with tokens from that sale. *Once you have submitted your transfer request, we will send a comfirmation email. Please click on the confirmation link in your email.</p>
                      </div>
                      <div class="row border-top border-grey py-2">
                        <div class="col">
                          <div class="float-left">
                            <div class="py-0 text-sm"><span class="bnb-value h5"></span> BNB</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="transferBNBBtn" class="btn btn-default mt-2">Confirm Transfer <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="transferADAForm" style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-transfer text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a class="btn border-0 cancel-transfer text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2">Transfer ADA</div>
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="ada">
                      <input type="hidden" name="transfer" value="transfer">
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Address</label>
                      <div class="input-group mb-4">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="walletid" placeholder="Long press to paste" required style="font-size:12px;height:45px;" autocomplete="off" aria-describedby="basic-addon1">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon1"><i class="far fa-address-book text-muted"></i></span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Network <i class="fas fa-exclamation-circle text-muted"></i></label>
                      <div class="input-group mb-4">
                        <select class="form-select w-100 bg-light text-muted border-0" type="text" name="network" required style="font-size:12px;height:45px;" autocomplete="off">
                          <option value="" disabled selected hidden>Automatically match the network</option>
                          <option value="ADA">ADA</option>
                          <option value="BEP20 (BSC)">BEP20 (BSC)</option>
                          <option value="BEP2">BEP2</option>
                        </select>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0 usd-ada-value" type="text" id="transfer-ada-amount" name="amount" required pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">USD</span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0" style="font-size: 12px;">Available: <span class="pr-1"><?php echo number_format($adabalance, 2); ?></span>ADA</label>
                      <div class="py-4">
                        <div class="card-text text-muted font-weight-bold pb-2" style="font-size: 14px;">Tips</div>
                        <p class="card-text text-muted" style="font-size: 12px;">* 24h remaining limit: <span class="text-dark">100/100.0ADA</span></p>
                        <p class="card-text text-muted" style="font-size: 12px;">* Do not transfer directly to a crowdfund or ICO. We will not credit your account with tokens from that sale. *Once you have submitted your transfer request, we will send a comfirmation email. Please click on the confirmation link in your email.</p>
                      </div>
                      <div class="row border-top border-grey py-2">
                        <div class="col">
                          <div class="float-left">
                            <div class="py-0 text-sm"><span class="ada-value h5"></span> ADA</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="transferADABtn" class="btn btn-default mt-2">Confirm Transfer <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="transferXPRForm" style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-transfer text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a class="btn border-0 cancel-transfer text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2">Transfer XPR</div>
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="xpr">
                      <input type="hidden" name="transfer" value="transfer">
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Address</label>
                      <div class="input-group mb-4">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="walletid" placeholder="Long press to paste" required style="font-size:12px;height:45px;" autocomplete="off" aria-describedby="basic-addon1">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon1"><i class="far fa-address-book text-muted"></i></span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Network <i class="fas fa-exclamation-circle text-muted"></i></label>
                      <div class="input-group mb-4">
                        <select class="form-select w-100 bg-light text-muted border-0" type="text" name="network" required style="font-size:12px;height:45px;" autocomplete="off">
                          <option value="XPR" selected>XPR</option>
                        </select>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0 usd-xpr-value" type="text" id="transfer-xpr-amount" name="amount" required pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">USD</span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0" style="font-size: 12px;">Available: <span class="pr-1"><?php echo number_format($xprbalance, 2); ?></span>XPR</label>
                      <div class="py-4">
                        <div class="card-text text-muted font-weight-bold pb-2" style="font-size: 14px;">Tips</div>
                        <p class="card-text text-muted" style="font-size: 12px;">* 24h remaining limit: <span class="text-dark">100/100.0XPR</span></p>
                        <p class="card-text text-muted" style="font-size: 12px;">* Do not transfer directly to a crowdfund or ICO. We will not credit your account with tokens from that sale. *Once you have submitted your transfer request, we will send a comfirmation email. Please click on the confirmation link in your email.</p>
                      </div>
                      <div class="row border-top border-grey py-2">
                        <div class="col">
                          <div class="float-left">
                            <div class="py-0 text-sm"><span class="xpr-value h5"></span> XPR</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="transferXPRBtn" class="btn btn-default mt-2">Confirm Transfer <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="transferDOGEForm" style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-transfer text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a class="btn border-0 cancel-transfer text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2">Transfer DOGE</div>
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="doge">
                      <input type="hidden" name="transfer" value="transfer">
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Address</label>
                      <div class="input-group mb-4">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="walletid" placeholder="Long press to paste" required style="font-size:12px;height:45px;" autocomplete="off" aria-describedby="basic-addon1">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon1"><i class="far fa-address-book text-muted"></i></span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Network <i class="fas fa-exclamation-circle text-muted"></i></label>
                      <div class="input-group mb-4">
                        <select class="form-select w-100 bg-light text-muted border-0" type="text" name="network" required style="font-size:12px;height:45px;" autocomplete="off">
                          <option value="DOGE" selected>DOGE</option>
                        </select>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0 usd-doge-value" type="text" id="transfer-doge-amount" name="amount" required pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">USD</span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0" style="font-size: 12px;">Available: <span class="pr-1"><?php echo number_format($dogebalance, 2); ?></span>DOGE</label>
                      <div class="py-4">
                        <div class="card-text text-muted font-weight-bold pb-2" style="font-size: 14px;">Tips</div>
                        <p class="card-text text-muted" style="font-size: 12px;">* 24h remaining limit: <span class="text-dark">100/100.0DOGE</span></p>
                        <p class="card-text text-muted" style="font-size: 12px;">* Do not transfer directly to a crowdfund or ICO. We will not credit your account with tokens from that sale. *Once you have submitted your transfer request, we will send a comfirmation email. Please click on the confirmation link in your email.</p>
                      </div>
                      <div class="row border-top border-grey py-2">
                        <div class="col">
                          <div class="float-left">
                            <div class="py-0 text-sm"><span class="doge-value h5"></span> DOGE</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="transferDOGEBtn" class="btn btn-default mt-2">Confirm Transfer <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <form id="transferUSDTForm" style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-4">
                          <button type="button" class="btn border-0 cancel-transfer text-secondary px-0 float-left"><i class="fas fa-arrow-left"></i></button>
                          <a class="btn border-0 cancel-transfer text-secondary px-0 float-right"><i class="fas fa-history"></i></a>
                        </div>
                      </div>
                      <div class="row h3 font-weight-normal px-2">Transfer USDT</div>
                      <!-- Username -->
                      <input type="hidden" name="username" value="<?php echo $username; ?>">
                      <input type="hidden" name="method" value="usdt">
                      <input type="hidden" name="transfer" value="transfer">
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Address</label>
                      <div class="input-group mb-4">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="walletid" placeholder="Long press to paste" required style="font-size:12px;height:45px;" autocomplete="off" aria-describedby="basic-addon1">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon1"><i class="far fa-address-book text-muted"></i></span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Network <i class="fas fa-exclamation-circle text-muted"></i></label>
                      <div class="input-group mb-4">
                        <select class="form-select w-100 bg-light text-muted border-0" type="text" name="network" required style="font-size:12px;height:45px;" autocomplete="off">
                          <option value="USDT" selected>USDT</option>
                        </select>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Amount</label>
                      <div class="input-group">
                        <input class="form-control custom-form bg-light text-muted border-0 rounded-0 usd-usdt-value" type="text" id="transfer-usdt-amount" name="amount" required pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                        <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">USD</span>
                      </div>
                      <label class="form-control-label text-muted font-weight-normal my-0" style="font-size: 12px;">Available: <span class="pr-1"><?php echo number_format($usdtbalance, 2); ?></span>USDT</label>
                      <div class="py-4">
                        <div class="card-text text-muted font-weight-bold pb-2" style="font-size: 14px;">Tips</div>
                        <p class="card-text text-muted" style="font-size: 12px;">* 24h remaining limit: <span class="text-dark">100/100.0USDT</span></p>
                        <p class="card-text text-muted" style="font-size: 12px;">* Do not transfer directly to a crowdfund or ICO. We will not credit your account with tokens from that sale. *Once you have submitted your transfer request, we will send a comfirmation email. Please click on the confirmation link in your email.</p>
                      </div>
                      <div class="row border-top border-grey py-2">
                        <div class="col">
                          <div class="float-left">
                            <div class="py-0 text-sm"><span class="usdt-value h5"></span> USDT</div>
                          </div>
                          <div class="float-right">
                            <button type="submit" id="transferUSDTBtn" class="btn btn-default mt-2">Confirm Transfer <i class="fas fa-angle-double-right"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>

                  </div>
                </div>
                <div id="loading" class="overlay dark" style="display: none;"><i class="fa-4x fas fa-spinner fa-spin"></i></div>
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
              
            <div class="col-12 col-lg-10 col-md-11 px-2">
                
              <div class="card rounded-0">
                <div class="card-body">
                  <?php 
                  $sql = $db_conn->query("SELECT * FROM transactions WHERE username = '$username' AND type ='transfer' ORDER BY id DESC");
                  if($sql->num_rows > 0) {
                    echo '
                    <table id="example1" class="table table-hover table-dark" style="font-size: 14px;">
                      <thead>
                        <tr class="bg-secondary">
                          <th>ID</th>
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
                            echo '<td class="">'.date("m-d-Y", strtotime($row['regdate'])).'</td>';
                            echo '<td class="text-info text-uppercase" >'.$row['method'].'</td>';
                            echo '<td class="text-warning" >$'.number_format($row['amount'], 2).'</td>';
                            echo '<td class="text-danger text-capitalize" >'.$row['status'].'</td>';
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
    
    $(document).on('click', '#btc-transfer', function(event) {
      event.preventDefault();
      $('#choose-transfer-method').hide();
      $('#transferBTCForm').show();
    });
    $(document).on('click', '#eth-transfer', function(event) {
      event.preventDefault();
      $('#choose-transfer-method').hide();
      $('#transferETHForm').show();
    });
    $(document).on('click', '#bnb-transfer', function(event) {
      event.preventDefault();
      $('#choose-transfer-method').hide();
      $('#transferBNBForm').show();
    });
    $(document).on('click', '#ada-transfer', function(event) {
      event.preventDefault();
      $('#choose-transfer-method').hide();
      $('#transferADAForm').show();
    });
    $(document).on('click', '#xpr-transfer', function(event) {
      event.preventDefault();
      $('#choose-transfer-method').hide();
      $('#transferXPRForm').show();
    });
    $(document).on('click', '#doge-transfer', function(event) {
      event.preventDefault();
      $('#choose-transfer-method').hide();
      $('#transferDOGEForm').show();
    });
    $(document).on('click', '#usdt-transfer', function(event) {
      event.preventDefault();
      $('#choose-transfer-method').hide();
      $('#transferUSDTForm').show();
    });
    $(document).on('click', '.cancel-transfer', function(event) {
      event.preventDefault();
      $('#transferBTCForm, #transferETHForm, #transferBNBForm, #transferADAForm, #transferXPRForm, #transferDOGEForm, #transferUSDTForm')[0].reset();
      $('#choose-transfer-method').show();
      $('#transferBTCForm').hide();
      $('#transferETHForm').hide();
      $('#transferBNBForm').hide();
      $('#transferADAForm').hide();
      $('#transferXPRForm').hide();
      $('#transferDOGEForm').hide();
      $('#transferUSDTForm').hide();
    });

    $(document).on('submit', '#transferBTCForm', function(e) {
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
          $('#transferBTCForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#transferBTCForm').css("opacity","");
            $('#transferBTCForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
          }
        }
      });
    });
    
    $(document).on('submit', '#transferETHForm', function(e) {
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
          $('#transferETHForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '2') {
            $('#transferETHForm').css("opacity","");
            $('#transferBTCForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
          }
        }
      });
    });
    
    $(document).on('submit', '#transferBNBForm', function(e) {
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
          $('#transferBNBForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '3') {
            $('#transferBNBForm').css("opacity","");
            $('#transferBTCForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
          }
        }
      });
    });
    
    $(document).on('submit', '#transferADAForm', function(e) {
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
          $('#transferADAForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '4') {
            $('#transferADAForm').css("opacity","");
            $('#transferADAForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
          }
        }
      });
    });
    
    $(document).on('submit', '#transferXPRForm', function(e) {
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
          $('#transferXPRForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '5') {
            $('#transferXPRForm').css("opacity","");
            $('#transferXPRForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
          }
        }
      });
    });
    
    $(document).on('submit', '#transferDOGEForm', function(e) {
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
          $('#transferDOGEForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '6') {
            $('#transferDOGEForm').css("opacity","");
            $('#transferDOGEForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
          }
        }
      });
    });
    
    $(document).on('submit', '#transferUSDTForm', function(e) {
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
          $('#transferUSDTForm').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '7') {
            $('#transferUSDTForm').css("opacity","");
            $('#transferUSDTForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
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
        "searching": false,
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

    $('#transfer-btc-amount, #transfer-eth-amount, #transfer-bnb-amount, #transfer-ada-amount, #transfer-xpr-amount, #transfer-doge-amount, #transfer-usdt-amount').keyup(function() {
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