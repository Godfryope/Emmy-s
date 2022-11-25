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
  <title>Portfolio - Bitcoptions</title>
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
  <style>.referral{cursor: copy;}.btn-dark:hover{background-color: #454d55 !important}.btn-check{position:absolute;clip:rect(0,0,0,0);pointer-events:none;}.btn-check:checked + .btn-secondary{color: #fff;background-color:#0000;border-color:#fd7e14;}.custom-form{color:#fff;background-color:#454d55;}</style>
  <style>.dark-mode .table td{border-top-color: #343a40 !important;}</style>
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
              <a href="earn" class="nav-link active">
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

                    $sbtcbalance = $xy['sbtc'];
                    $sethbalance = $xy['seth'];
                    $sbnbbalance = $xy['sbnb'];
                    $sadabalance = $xy['sada'];
                    $sxprbalance = $xy['sxpr'];
                    $sdogebalance = $xy['sdoge'];
                    $susdtbalance = $xy['susdt'];

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

                    $accbalance_btc_value = $accbalance / $btc_rate;

                    $bal_btc_value = $btcbalance / $btc_rate;
                    $bal_eth_value = $ethbalance / $eth_rate;
                    $bal_bnb_value = $bnbbalance / $bnb_rate;
                    $bal_ada_value = $adabalance / $ada_rate;
                    $bal_xpr_value = $xprbalance / $xpr_rate;
                    $bal_doge_value = $dogebalance / $doge_rate;
                    $bal_usdt_value = $usdtbalance / $usdt_rate;

                    $bal_sbtc_value = $sbtcbalance / $btc_rate;
                    $bal_seth_value = $sethbalance / $eth_rate;
                    $bal_sbnb_value = $sbnbbalance / $bnb_rate;
                    $bal_sada_value = $sadabalance / $ada_rate;
                    $bal_sxpr_value = $sxprbalance / $xpr_rate;
                    $bal_sdoge_value = $sdogebalance / $doge_rate;
                    $bal_susdt_value = $susdtbalance / $usdt_rate;
                    ?>
                    <span class="h5" style="letter-spacing: 0px;"><?php echo number_format($accbalance_btc_value, 8, '.', ''); ?></span>
                    <span class="pl-1 card-text text-muted text-sm">&#x2248; $<?php echo number_format($accbalance, 2); ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-md-11 px-sm-2 px-0">
              <div class="row">

                <div class="col-12 col-sm-6 px-sm-2 px-0 pb-3">
                  <div class="card rounded-0 h-100">
                    <div id="assetDiv" class="card-body">
                      <div class="row px-sm-1 pb-4">
                        <div class="text-muted border border-secondary border-top-0 border-right-0 border-left-0 w-100">Staked Assets (Pool)</div>
                      </div>
                      <div class="row py-3 px-sm-1">
                        <div class="col-12 px-sm-0 px-1">
                          <div class="float-left">
                            <div class="row">
                              <div class="col-auto pr-2">
                                <img src="img/bitcoin.png" alt="Bitcoin" class=" rounded-circle" height="25">
                              </div>
                              <div class="col pt-1">
                                <div class="h6 mb-1">BTC</div>
                                <div class="text-muted" style="font-size:12px;">Bitcoin</div>
                              </div>
                            </div>
                          </div>
                          <div class="float-right">
                            <div class="h6 mb-1"><?php echo number_format($bal_sbtc_value, 10, '.', ''); ?></div>
                            <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($sbtcbalance, 2); ?></div>
                          </div>
                        </div>
                      </div>

                      <div class="row py-3 px-sm-1">
                        <div class="col-12 px-sm-0 px-1 pt-2">
                          <div class="float-left">
                            <div class="row">
                              <div class="col-auto pr-2">
                                <img src="img/ethereum.png" alt="Ethereum" class=" rounded-circle bg-warning" height="25">
                              </div>
                              <div class="col pt-1">
                                <div class="h6 mb-1">ETH</div>
                                <div class="text-muted" style="font-size:12px;">Ethereum</div>
                              </div>
                            </div>
                          </div>
                          <div class="float-right">
                            <div class="h6 mb-1"><?php echo number_format($bal_seth_value, 10, '.', ''); ?></div>
                            <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($sethbalance, 2); ?></div>
                          </div>
                        </div>
                      </div>

                      <div class="row py-3 px-sm-1">
                        <div class="col-12 px-sm-0 px-1 pt-2">
                          <div class="float-left">
                            <div class="row">
                              <div class="col-auto pr-2">
                                <img src="img/binance_coin.png" alt="BNB" class=" rounded-circle" height="25">
                              </div>
                              <div class="col pt-1">
                                <div class="h6 mb-1">BNB</div>
                                <div class="text-muted" style="font-size:12px;">Binance</div>
                              </div>
                            </div>
                          </div>
                          <div class="float-right">
                            <div class="h6 mb-1"><?php echo number_format($bal_sbnb_value, 10, '.', ''); ?></div>
                            <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($sbnbbalance, 2); ?></div>
                          </div>
                        </div>
                      </div>

                      <div class="row py-3 px-sm-1">
                        <div class="col-12 px-sm-0 px-1 pt-2">
                          <div class="float-left">
                            <div class="row">
                              <div class="col-auto pr-2">
                                <img src="img/cardano.png" alt="Cardano" class=" rounded-circle" height="25">
                              </div>
                              <div class="col">
                                <div class="h6 mb-1">ADA</div>
                                <div class="text-muted" style="font-size:12px;">Cardano</div>
                              </div>
                            </div>
                          </div>
                          <div class="float-right">
                            <div class="h6 mb-1"><?php echo number_format($bal_sada_value, 8, '.', ''); ?></div>
                            <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($sadabalance, 2); ?></div>
                          </div>
                        </div>
                      </div>

                      <div class="row py-3 px-sm-1">
                        <div class="col-12 px-sm-0 px-1 pt-2">
                          <div class="float-left">
                            <div class="row">
                              <div class="col-auto pr-2">
                                <img src="img/proton.png" alt="Cardano" class=" rounded-circle" height="25">
                              </div>
                              <div class="col">
                                <div class="h6 mb-1">XPR</div>
                                <div class="text-muted" style="font-size:12px;">Proton</div>
                              </div>
                            </div>
                          </div>
                          <div class="float-right">
                            <div class="h6 mb-1"><?php echo number_format($bal_sxpr_value, 8, '.', ''); ?></div>
                            <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($sxprbalance, 2); ?></div>
                          </div>
                        </div>
                      </div>

                      <div class="row py-3 px-sm-1">
                        <div class="col-12 px-sm-0 px-1 pt-2">
                          <div class="float-left">
                            <div class="row">
                              <div class="col-auto pr-2">
                                <img src="img/dogecoin.png" alt="Dogecoin" class=" rounded-circle" height="25">
                              </div>
                              <div class="col">
                                <div class="h6 mb-1">DOGE</div>
                                <div class="text-muted" style="font-size:12px;">Dogecoin</div>
                              </div>
                            </div>
                          </div>
                          <div class="float-right">
                            <div class="h6 mb-1"><?php echo number_format($bal_sdoge_value, 8, '.', ''); ?></div>
                            <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($sdogebalance, 2); ?></div>
                          </div>
                        </div>
                      </div>

                      <div class="row py-3 px-sm-1">
                        <div class="col-12 px-sm-0 px-1 pt-2">
                          <div class="float-left">
                            <div class="row">
                              <div class="col-auto pr-2">
                                <img src="img/tether.png" alt="Tether" class=" rounded-circle" height="25">
                              </div>
                              <div class="col">
                                <div class="h6 mb-1">USDT</div>
                                <div class="text-muted" style="font-size:12px;">Tether</div>
                              </div>
                            </div>
                          </div>
                          <div class="float-right">
                            <div class="h6 mb-1"><?php echo number_format($bal_susdt_value, 8, '.', ''); ?></div>
                            <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($susdtbalance, 2); ?></div>
                          </div>
                        </div>
                      </div>

                      <div class="row pt-3 px-sm-1">
                        <div class="col-12 px-sm-0 px-1">
                          <button id="redeemCoinDivBtn" class="btn btn-primary btn-block">Redeem</button>
                        </div>
                      </div>
                    </div>
                    <div id="redeemCoinDiv" class="card-body px-1" style="display: none;">
                      <div class="row">
                        <div class="col-12 pb-2 px-1">
                          <button type="button" class="btn border-0 redeem-back text-warning float-right">Back</button>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12 px-4">
                          <div class="row px-0 border border-secondary border-top-0 border-right-0 border-left-0">
                            <div class="text-muted w-100">Coin List</div>
                          </div>
                        </div>
                      </div>
                        

                      <div class="row">
                        <div class="col-12 px-1">
                          <button type="button" id="btc-redeem" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-12">
                                <span><img src="img/bitcoin.png" alt="Bitcoiin" class=" rounded-circle" height="25"><span class="ml-2 h5 align-middle">BTC<span class="text-muted" style="font-size:12px;"> Bitcoin</span></span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Available: <?php echo number_format($bal_sbtc_value, 8, '.', ''); ?></div>
                                </span>
                              </div>
                            </span>
                          </button>

                          <button type="button" id="eth-redeem" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-12">
                                <span><img src="img/ethereum.png" alt="Ethereum" class=" rounded-circle" height="25"><span class="ml-2 h5 align-middle">ETH<span class="text-muted" style="font-size:12px;"> Ethereum</span></span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Available: <?php echo number_format($bal_seth_value, 8, '.', ''); ?></div>
                                </span>
                              </div>
                            </span>
                          </button>

                          <button type="button" id="bnb-redeem" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-12">
                                <span><img src="img/binance_coin.png" alt="Binance" class=" rounded-circle" height="25"><span class="ml-2 h5 align-middle">BNB<span class="text-muted" style="font-size:12px;"> Binance</span></span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Available: <?php echo number_format($bal_sbnb_value, 8, '.', ''); ?></div>
                                </span>
                              </div>
                            </span>
                          </button>

                          <button type="button" id="ada-redeem" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-12">
                                <span><img src="img/cardano.png" alt="Cardano" class=" rounded-circle" height="25"><span class="ml-2 h5 align-middle">ADA<span class="text-muted" style="font-size:12px;"> Cardano</span></span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Available: <?php echo number_format($bal_sada_value, 8, '.', ''); ?></div>
                                </span>
                              </div>
                            </span>
                          </button>

                          <button type="button" id="xpr-redeem" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-12">
                                <span><img src="img/proton.png" alt="Proton" class=" rounded-circle" height="25"><span class="ml-2 h5 align-middle">XPR<span class="text-muted" style="font-size:12px;"> Proton</span></span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Available: <?php echo number_format($bal_sxpr_value, 8, '.', ''); ?></div>
                                </span>
                              </div>
                            </span>
                          </button>

                          <button type="button" id="doge-redeem" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-12">
                                <span><img src="img/dogecoin.png" alt="Dogecoin" class=" rounded-circle" height="25"><span class="ml-2 h5 align-middle">DOGE<span class="text-muted" style="font-size:12px;"> Dogecoin</span></span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Available: <?php echo number_format($bal_sdoge_value, 8, '.', ''); ?></div>
                                </span>
                              </div>
                            </span>
                          </button>

                          <button type="button" id="usdt-redeem" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-12">
                                <span><img src="img/tether.png" alt="Tether" class=" rounded-circle" height="25"><span class="ml-2 h5 align-middle">USDT<span class="text-muted" style="font-size:12px;"> Tether</span></span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Available: <?php echo number_format($bal_susdt_value, 8, '.', ''); ?></div>
                                </span>
                              </div>
                            </span>
                          </button>

                        </div>
                      </div>
                    </div>

                    <div id="redeemFormDiv" class="card-body">
                      <form id="redeemBTCForm" style="display: none;">
                        <div class="row">
                          <div class="col-12 pb-4">
                            <button type="button" class="btn border-0 cancel-redeem text-warning float-right">Back</button>
                            
                          </div>
                        </div>
                        <div class="row h3 font-weight-normal px-2 pb-4">Redeem BTC</div>
                        <!-- Username -->
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="method" value="btc">
                        <input type="hidden" name="redeem" value="redeem">
                        <input type="hidden" name="network" value="pool">
                        <div class="card-text pb-4">Your BTC will be returned back to your BTC wallet from your staked account</div>
                        <label class="form-control-label text-muted font-weight-normal my-0 text-sm w-100">
                          <span class="float-left">Pool Balance</span>
                          <span class="float-right">
                            Available: <?php echo $bal_sbtc_value; ?>
                          </span>
                        </label>
                        <div class="input-group mb-4">
                          <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                          <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">BTC</span>
                        </div>
                        
                        <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="status_msg"></span></label>
                        
                        <div class="row pt-4">
                          <div class="col">
                            <div class="float-left">
                              <button type="button" class="btn btn-default cancel-redeem-form">Not now</button>
                            </div>
                            <div class="float-right">
                              <button type="submit" id="redeemBTCBtn" class="btn btn-warning">Redeem</button>
                            </div>
                          </div>
                        </div>
                      </form>

                      <form id="redeemETHForm" style="display: none;">
                        <div class="row">
                          <div class="col-12 pb-4">
                            <button type="button" class="btn border-0 cancel-redeem text-warning float-right">Back</button>
                            
                          </div>
                        </div>
                        <div class="row h3 font-weight-normal px-2 pb-4">Redeem ETH</div>
                        <!-- Username -->
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="method" value="eth">
                        
                        <input type="hidden" name="redeem" value="redeem">
                        <input type="hidden" name="network" value="pool">
                        <div class="card-text pb-4">Your ETH will be returned back to your ETH wallet from your staked account</div>
                        <label class="form-control-label text-muted font-weight-normal my-0 text-sm w-100">
                          <span class="float-left">Pool Balance</span>
                          <span class="float-right">
                            Available: <?php echo $bal_seth_value; ?>
                          </span>
                        </label>
                        <div class="input-group mb-4">
                          <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                          <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">ETH</span>
                        </div>
                        
                        <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="status_msg"></span></label>

                        <div class="row pt-4">
                          <div class="col">
                            <div class="float-left">
                              <button type="button" class="btn btn-default cancel-redeem-form">Not now</button>
                            </div>
                            <div class="float-right">
                              <button type="submit" id="redeemETHBtn" class="btn btn-warning">Redeem</button>
                            </div>
                          </div>
                        </div>
                      </form>

                      <form id="redeemBNBForm" style="display: none;">
                        <div class="row">
                          <div class="col-12 pb-4">
                            <button type="button" class="btn border-0 cancel-redeem text-warning float-right">Back</button>
                            
                          </div>
                        </div>
                        <div class="row h3 font-weight-normal px-2 pb-4">Redeem BNB</div>
                        <!-- Username -->
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="method" value="bnb">
                        
                        <input type="hidden" name="redeem" value="redeem">
                        <input type="hidden" name="network" value="pool">
                        <div class="card-text pb-4">Your BNB will be returned back to your BNB wallet from your staked account</div>
                        <label class="form-control-label text-muted font-weight-normal my-0 text-sm w-100">
                          <span class="float-left">Pool Balance</span>
                          <span class="float-right">
                            Available: <?php echo $bal_sbnb_value; ?>
                          </span>
                        </label>
                        <div class="input-group mb-4">
                          <input class="form-control custom-form bg-light text-muted border-0 rounded-0" type="text" name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                          <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">BNB</span>
                        </div>

                        <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="status_msg"></span></label>
                        
                        
                        <div class="row pt-4">
                          <div class="col">
                            <div class="float-left">
                              <button type="button" class="btn btn-default cancel-redeem-form">Not now</button>
                            </div>
                            <div class="float-right">
                              <button type="submit" id="redeemBNBBtn" class="btn btn-warning">Redeem</button>
                            </div>
                          </div>
                        </div>
                      </form>

                      <form id="redeemADAForm" style="display: none;">
                        <div class="row">
                          <div class="col-12 pb-4">
                            <button type="button" class="btn border-0 cancel-redeem text-warning float-right">Back</button>
                            
                          </div>
                        </div>
                        <div class="row h3 font-weight-normal px-2 pb-4">Redeem ADA</div>
                        <!-- Username -->
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="method" value="ada">
                        
                        <input type="hidden" name="redeem" value="redeem">
                        <input type="hidden" name="network" value="pool">
                        <div class="card-text pb-4">Your ADA will be returned back to your ADA wallet from your staked account</div>
                        <label class="form-control-label text-muted font-weight-normal my-0 text-sm w-100">
                          <span class="float-left">Pool Balance</span>
                          <span class="float-right">
                            Available: <?php echo $bal_sada_value; ?>
                          </span>
                        </label>
                        <div class="input-group mb-4">
                          <input class="form-control custom-form bg-light text-muted border-0 rounded-0 ada-usd-value" type="text" name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                          <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">ADA</span>
                        </div>
                        
                        <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="status_msg"></span></label>
                        
                        <div class="row pt-4">
                          <div class="col">
                            <div class="float-left">
                              <button type="button" class="btn btn-default cancel-redeem-form">Not now</button>
                            </div>
                            <div class="float-right">
                              <button type="submit" id="redeemADABtn" class="btn btn-warning">Redeem</button>
                            </div>
                          </div>
                        </div>
                      </form>

                      <form id="redeemXPRForm" style="display: none;">
                        <div class="row">
                          <div class="col-12 pb-4">
                            <button type="button" class="btn border-0 cancel-redeem text-warning float-right">Back</button>
                            
                          </div>
                        </div>
                        <div class="row h3 font-weight-normal px-2 pb-4">Redeem XPR</div>
                        <!-- Username -->
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="method" value="xpr">
                        
                        <input type="hidden" name="redeem" value="redeem">
                        <input type="hidden" name="network" value="pool">
                        <div class="card-text pb-4">Your SPR will be returned back to your XPR wallet from your staked account</div>
                        <label class="form-control-label text-muted font-weight-normal my-0 text-sm w-100">
                          <span class="float-left">Pool Balance</span>
                          <span class="float-right">
                            Available: <?php echo $bal_sxpr_value; ?>
                          </span>
                        </label>
                        <div class="input-group mb-4">
                          <input class="form-control custom-form bg-light text-muted border-0 rounded-0 xpr-usd-value" type="text" name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                          <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">XPR</span>
                        </div>
                        
                        <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="status_msg"></span></label>
                        
                        <div class="row pt-4">
                          <div class="col">
                            <div class="float-left">
                              <button type="button" class="btn btn-default cancel-redeem-form">Not now</button>
                            </div>
                            <div class="float-right">
                              <button type="submit" id="redeemXPRBtn" class="btn btn-warning">Redeem</button>
                            </div>
                          </div>
                        </div>
                      </form>

                      <form id="redeemDOGEForm" style="display: none;">
                        <div class="row">
                          <div class="col-12 pb-4">
                            <button type="button" class="btn border-0 cancel-redeem text-warning float-right">Back</button>
                            
                          </div>
                        </div>
                        <div class="row h3 font-weight-normal px-2 pb-4">Redeem DOGE</div>
                        <!-- Username -->
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="method" value="doge">
                        
                        <input type="hidden" name="redeem" value="redeem">
                        <input type="hidden" name="network" value="pool">
                        <div class="card-text pb-4">Your DOGE will be returned back to your DOGE wallet from your staked account</div>
                        <label class="form-control-label text-muted font-weight-normal my-0 text-sm w-100">
                          <span class="float-left">Pool Balance</span>
                          <span class="float-right">
                            Available: <?php echo $bal_sdoge_value; ?>
                          </span>
                        </label>
                        <div class="input-group mb-4">
                          <input class="form-control custom-form bg-light text-muted border-0 rounded-0 doge-usd-value" type="text" name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                          <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">DOGE</span>
                        </div>
                        
                        <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="status_msg"></span></label>
                        
                        <div class="row pt-4">
                          <div class="col">
                            <div class="float-left">
                              <button type="button" class="btn btn-default cancel-redeem-form">Not now</button>
                            </div>
                            <div class="float-right">
                              <button type="submit" id="redeemDOGEBtn" class="btn btn-warning">Redeem</button>
                            </div>
                          </div>
                        </div>
                      </form>

                      <form id="redeemUSDTForm" style="display: none;">
                        <div class="row">
                          <div class="col-12 pb-4">
                            <button type="button" class="btn border-0 cancel-redeem text-warning float-right">Back</button>
                            
                          </div>
                        </div>
                        <div class="row h3 font-weight-normal px-2 pb-4">Redeem USDT</div>
                        <!-- Username -->
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="method" value="usdt">
                        
                        <input type="hidden" name="redeem" value="redeem">
                        <input type="hidden" name="network" value="pool">
                        <div class="card-text pb-4">Your USDT will be returned back to your USDT wallet from your staked account</div>
                        <label class="form-control-label text-muted font-weight-normal my-0 text-sm w-100">
                          <span class="float-left">Pool Balance</span>
                          <span class="float-right">
                            Available: <?php echo $bal_susdt_value; ?>
                          </span>
                        </label>
                        <div class="input-group mb-4">
                          <input class="form-control custom-form bg-light text-muted border-0 rounded-0 usdt-usd-value" type="text" name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                          <span class="input-group-text bg-light border-0 px-1 border-0 rounded-0" id="basic-addon2">USDT</span>
                        </div>
                        
                        <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="status_msg"></span></label>
                        
                        <div class="row pt-4">
                          <div class="col">
                            <div class="float-left">
                              <button type="button" class="btn btn-default cancel-redeem-form">Not now</button>
                            </div>
                            <div class="float-right">
                              <button type="submit" id="redeemUSDTBtn" class="btn btn-warning">Redeem</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>

                    <div id="loading" class="overlay dark" style="display: none;"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
                  </div>
                </div>

                <div class="col-12 col-sm-6 px-sm-2 px-0 pb-3">
                  <div class="card rounded-0 h-100">
                    
                    <div class="card-body px-1 pt-4 pb-0">
                      <div id="choose-earn-method" class="row">

                        <div class="col-12 px-4 pb-4">
                          <div class="row px-0 border border-secondary border-top-0 border-right-0 border-left-0">
                            <div class="text-muted w-100">Buy Product</div>
                          </div>
                        </div>

                        <div class="col-12 px-4">
                          <div class="row">
                            <div class="col-5 text-muted px-0" style="font-size: 12px;">Coin/Product</div>
                            <div class="col-3 text-muted text-center px-0" style="font-size: 12px;">Est.APY</div>
                            <div class="col-4 text-muted text-right px-0" style="font-size: 12px;">Duration</div>
                          </div>
                        </div>
                        <div class="col-12 px-1">
                          <button type="button" id="btc-earn" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-5">
                                <span><img src="img/bitcoin.png" alt="Bitcoin" class=" rounded-circle" height="25"><span class="pl-2 h6"></span>BTC</span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Bitcoin</div>
                                </span>
                              </div>
                              <div class="col-3 text-center text-success pt-0">
                                11.2%
                              </div>
                              <div class="col-4 text-right pt-0">
                                Flexible
                              </div>
                            </span>
                          </button>

                          <button type="button" id="eth-earn" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-5">
                                <span><img src="img/ethereum.png" alt="Ethereum" class=" rounded-circle" height="25"><span class="pl-2 h6"></span>ETH</span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Ethereum</div>
                                </span>
                              </div>
                              <div class="col-3 text-center text-success pt-0">
                                6.86%
                              </div>
                              <div class="col-4 text-right pt-0">
                                Flexible
                              </div>
                            </span>
                          </button>

                          <button type="button" id="bnb-earn" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-5">
                                <span><img src="img/binance_coin.png" alt="Binance" class=" rounded-circle" height="25"><span class="pl-2 h6"></span>BNB</span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Binance</div>
                                </span>
                              </div>
                              <div class="col-3 text-center text-success pt-0">
                                8.88%
                              </div>
                              <div class="col-4 text-right pt-0">
                                Flexible
                              </div>
                            </span>
                          </button>

                          <button type="button" id="ada-earn" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-5">
                                <span><img src="img/cardano.png" alt="Cardano" class=" rounded-circle" height="25"><span class="pl-2 h6"></span>ADA</span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Cardano</div>
                                </span>
                              </div>
                              <div class="col-3 text-center text-success pt-0">
                                4.44%
                              </div>
                              <div class="col-4 text-right pt-0">
                                Flexible
                              </div>
                            </span>
                          </button>

                          <button type="button" id="xpr-earn" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-5">
                                <span><img src="img/proton.png" alt="Proton" class=" rounded-circle" height="25"><span class="pl-2 h6"></span>XPR</span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Proton</div>
                                </span>
                              </div>
                              <div class="col-3 text-center text-success pt-0">
                                4.44%
                              </div>
                              <div class="col-4 text-right pt-0">
                                Flexible
                              </div>
                            </span>
                          </button>

                          <button type="button" id="doge-earn" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-5">
                                <span><img src="img/dogecoin.png" alt="Cardano" class=" rounded-circle" height="25"><span class="pl-2 h6"></span>DOGE</span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Dogecoin</div>
                                </span>
                              </div>
                              <div class="col-3 text-center text-success pt-0">
                                4.44%
                              </div>
                              <div class="col-4 text-right pt-0">
                                Flexible
                              </div>
                            </span>
                          </button>

                          <button type="button" id="usdt-earn" class="btn btn-dark btn-block rounded-0 border-0 text-left py-3">
                            <span class="row">
                              <div class="col-5">
                                <span><img src="img/tether.png" alt="Cardano" class=" rounded-circle" height="25"><span class="pl-2 h6"></span>USDT</span>
                                <span>
                                <div class="text-muted" style="padding-left:32px;font-size:12px;">Tether</div>
                                </span>
                              </div>
                              <div class="col-3 text-center text-success pt-0">
                                4.44%
                              </div>
                              <div class="col-4 text-right pt-0">
                                Flexible
                              </div>
                            </span>
                          </button>


                        </div>
                          
                      </div>
                      
                      <div id="process-earn-request" class="px-2">
                        <form id="earnBTCForm" style="display: none;">
                          <div class="row">
                            <div class="col-12 pb-4">
                              <button type="button" class="btn border-0 cancel-earn text-warning px-0 float-left">Back</button>
                              <a href="history" class="btn border-0 cancel-earn text-warning px-0 float-right"><i class="fas fa-history"></i></a>
                            </div>
                          </div>
                          <div class="row h3 font-weight-normal px-2 pb-4">Stake BTC</div>
                          <!-- Username -->
                          <input type="hidden" name="username" value="<?php echo $username; ?>">
                          <input type="hidden" name="method" value="btc">
                          <input type="hidden" name="earn" value="stake">

                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Duration</label>
                          
                          <div class="row">
                            <div class="col-12">
                              <input type="radio" class="btn-check mx-auto" name="network" id="option1" value="30 Days" autocomplete="off" checked>
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option1" style="font-size:12px;font-weight:normal;">30 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option2" value="60 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option2" style="font-size:12px;font-weight:normal;">60 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option3" value="90 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option3" style="font-size:12px;font-weight:normal;">90 Days</label>
                            </div>  
                          </div>
                          
                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Lock Amount</label>
                          <div class="input-group border border-top-0 border-right-0 border-left-0 border-secondary mb-0 pb-0">
                            <input class="form-control custom-form text-muted px-0 border-0 rounded-0 mb-0 pb-0" type="text" placeholder="Please enter the quantity." name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                            <span class="input-group-text custom-form border-0 px-1 border-0 rounded-0 mb-0 pb-0" id="basic-addon2">BTC<span class="text-warning pl-2">Max</span></span>
                          </div>
                          <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="response_msg"></span></label>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Available: <span class="pr-1 text-white"><?php echo number_format($bal_btc_value, 10, '.', ''); ?></span>BTC</label>
                          </div>
                          
                          <div class="input-group">
                            <label class="form-control-label text-white font-weight-normal mt-2" style="font-size: 12px;">Locked Amount Limitation</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Minimum: <span class="pr-1 text-white">0.0000001</span> BTC</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Maximum: <span class="pr-1 text-white">100.0000000 BTC</label>
                          </div>

                          <div class="row border-top border-secondary mt-2">
                            <button type="submit" id="earnBTCBtn" class="btn btn-secondary btn-block">Confirm</button>
                          </div>
                        </form>
                        
                        <form id="earnETHForm" style="display: none;">
                          <div class="row">
                            <div class="col-12 pb-4">
                              <button type="button" class="btn border-0 cancel-earn text-warning px-0 float-left">Back</button>
                              <a href="history" class="btn border-0 cancel-earn text-warning px-0 float-right"><i class="fas fa-history"></i></a>
                            </div>
                          </div>
                          <div class="row h3 font-weight-normal px-2 pb-4">Stake ETH</div>
                          <!-- Username -->
                          <input type="hidden" name="username" value="<?php echo $username; ?>">
                          <input type="hidden" name="method" value="eth">
                          <input type="hidden" name="earn" value="stake">

                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Duration</label>
                          
                          <div class="row">
                            <div class="col-12">
                              <input type="radio" class="btn-check mx-auto" name="network" id="option11" value="30 Days" autocomplete="off" checked>
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option11" style="font-size:12px;font-weight:normal;">30 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option21" value="60 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option21" style="font-size:12px;font-weight:normal;">60 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option31" value="90 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option31" style="font-size:12px;font-weight:normal;">90 Days</label>
                            </div>  
                          </div>
                          
                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Lock Amount</label>
                          <div class="input-group border border-top-0 border-right-0 border-left-0 border-secondary mb-0 pb-0">
                            <input class="form-control custom-form text-muted px-0 border-0 rounded-0 mb-0 pb-0" type="text" placeholder="Please enter the quantity." name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                            <span class="input-group-text custom-form border-0 px-1 border-0 rounded-0 mb-0 pb-0" id="basic-addon2">ETH<span class="text-warning pl-2">Max</span></span>
                          </div>

                          <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="response_msg"></span></label>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Available: <span class="pr-1 text-white"><?php echo number_format($bal_eth_value, 10, '.', ''); ?></span>ETH</label>
                          </div>
                          
                          <div class="input-group">
                            <label class="form-control-label text-white font-weight-normal mt-2" style="font-size: 12px;">Locked Amount Limitation</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Minimum: <span class="pr-1 text-white">0.0000001</span> ETH</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Maximum: <span class="pr-1 text-white">100.0000000 ETH</label>
                          </div>

                          <div class="row border-top border-secondary mt-2">
                            <button type="submit" id="earnETHBtn" class="btn btn-secondary btn-block">Confirm</button>
                          </div>
                        </form>
                        
                        <form id="earnBNBForm" style="display: none;">
                          <div class="row">
                            <div class="col-12 pb-4">
                              <button type="button" class="btn border-0 cancel-earn text-warning px-0 float-left">Back</button>
                              <a href="history" class="btn border-0 cancel-earn text-warning px-0 float-right"><i class="fas fa-history"></i></a>
                            </div>
                          </div>
                          <div class="row h3 font-weight-normal px-2 pb-4">Stake BNB</div>
                          <!-- Username -->
                          <input type="hidden" name="username" value="<?php echo $username; ?>">
                          <input type="hidden" name="method" value="bnb">
                          <input type="hidden" name="earn" value="stake">

                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Duration</label>
                          
                          <div class="row">
                            <div class="col-12">
                              <input type="radio" class="btn-check mx-auto" name="network" id="option12" value="30 Days" autocomplete="off" checked>
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option12" style="font-size:12px;font-weight:normal;">30 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option22" value="60 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option22" style="font-size:12px;font-weight:normal;">60 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option32" value="90 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option32" style="font-size:12px;font-weight:normal;">90 Days</label>
                            </div>  
                          </div>
                          
                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Lock Amount</label>
                          <div class="input-group border border-top-0 border-right-0 border-left-0 border-secondary mb-0 pb-0">
                            <input class="form-control custom-form text-muted px-0 border-0 rounded-0 mb-0 pb-0" type="text" placeholder="Please enter the quantity." name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                            <span class="input-group-text custom-form border-0 px-1 border-0 rounded-0 mb-0 pb-0" id="basic-addon2">BNB<span class="text-warning pl-2">Max</span></span>
                          </div>

                          <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="response_msg"></span></label>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Available: <span class="pr-1 text-white"><?php echo number_format($bal_bnb_value, 10, '.', ''); ?></span>BNB</label>
                          </div>
                          
                          <div class="input-group">
                            <label class="form-control-label text-white font-weight-normal mt-2" style="font-size: 12px;">Locked Amount Limitation</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Minimum: <span class="pr-1 text-white">0.0000001</span> BNB</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Maximum: <span class="pr-1 text-white">100.0000000 BNB</label>
                          </div>

                          <div class="row border-top border-secondary mt-2">
                            <button type="submit" id="earnBNBBtn" class="btn btn-secondary btn-block">Confirm</button>
                          </div>
                        </form>
                        
                        <form id="earnADAForm" style="display: none;">
                          <div class="row">
                            <div class="col-12 pb-4">
                              <button type="button" class="btn border-0 cancel-earn text-warning px-0 float-left">Back</button>
                              <a href="history" class="btn border-0 cancel-earn text-warning px-0 float-right"><i class="fas fa-history"></i></a>
                            </div>
                          </div>
                          <div class="row h3 font-weight-normal px-2 pb-4">Stake ADA</div>
                          <!-- Username -->
                          <input type="hidden" name="username" value="<?php echo $username; ?>">
                          <input type="hidden" name="method" value="ada">
                          <input type="hidden" name="earn" value="stake">

                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Duration</label>
                          
                          <div class="row">
                            <div class="col-12">
                              <input type="radio" class="btn-check mx-auto" name="network" id="option13" value="30 Days" autocomplete="off" checked>
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option13" style="font-size:12px;font-weight:normal;">30 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option23" value="60 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option23" style="font-size:12px;font-weight:normal;">60 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option33" value="90 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option33" style="font-size:12px;font-weight:normal;">90 Days</label>
                            </div>  
                          </div>
                          
                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Lock Amount</label>
                          <div class="input-group border border-top-0 border-right-0 border-left-0 border-secondary mb-0 pb-0">
                            <input class="form-control custom-form text-muted px-0 border-0 rounded-0 mb-0 pb-0" type="text" placeholder="Please enter the quantity." name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                            <span class="input-group-text custom-form border-0 px-1 border-0 rounded-0 mb-0 pb-0" id="basic-addon2">ADA<span class="text-warning pl-2">Max</span></span>
                          </div>

                          <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="response_msg"></span></label>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Available: <span class="pr-1 text-white"><?php echo number_format($bal_ada_value, 10, '.', ''); ?></span>ADA</label>
                          </div>
                          
                          <div class="input-group">
                            <label class="form-control-label text-white font-weight-normal mt-2" style="font-size: 12px;">Locked Amount Limitation</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Minimum: <span class="pr-1 text-white">0.0000001</span> ADA</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Maximum: <span class="pr-1 text-white">100.0000000 ADA</label>
                          </div>

                          <div class="row border-top border-secondary mt-2">
                            <button type="submit" id="earnADABtn" class="btn btn-secondary btn-block">Confirm</button>
                          </div>
                        </form>
                        
                        <form id="earnXPRForm" style="display: none;">
                          <div class="row">
                            <div class="col-12 pb-4">
                              <button type="button" class="btn border-0 cancel-earn text-warning px-0 float-left">Back</button>
                              <a href="history" class="btn border-0 cancel-earn text-warning px-0 float-right"><i class="fas fa-history"></i></a>
                            </div>
                          </div>
                          <div class="row h3 font-weight-normal px-2 pb-4">Stake XPR</div>
                          <!-- Username -->
                          <input type="hidden" name="username" value="<?php echo $username; ?>">
                          <input type="hidden" name="method" value="xpr">
                          <input type="hidden" name="earn" value="stake">

                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Duration</label>
                          
                          <div class="row">
                            <div class="col-12">
                              <input type="radio" class="btn-check mx-auto" name="network" id="option13" value="30 Days" autocomplete="off" checked>
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option13" style="font-size:12px;font-weight:normal;">30 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option23" value="60 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option23" style="font-size:12px;font-weight:normal;">60 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option33" value="90 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option33" style="font-size:12px;font-weight:normal;">90 Days</label>
                            </div>  
                          </div>
                          
                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Lock Amount</label>
                          <div class="input-group border border-top-0 border-right-0 border-left-0 border-secondary mb-0 pb-0">
                            <input class="form-control custom-form text-muted px-0 border-0 rounded-0 mb-0 pb-0" type="text" placeholder="Please enter the quantity." name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                            <span class="input-group-text custom-form border-0 px-1 border-0 rounded-0 mb-0 pb-0" id="basic-addon2">XPR<span class="text-warning pl-2">Max</span></span>
                          </div>

                          <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="response_msg"></span></label>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Available: <span class="pr-1 text-white"><?php echo number_format($bal_xpr_value, 10, '.', ''); ?></span>XPR</label>
                          </div>
                          
                          <div class="input-group">
                            <label class="form-control-label text-white font-weight-normal mt-2" style="font-size: 12px;">Locked Amount Limitation</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Minimum: <span class="pr-1 text-white">0.0000001</span> XPR</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Maximum: <span class="pr-1 text-white">100.0000000 XPR</label>
                          </div>

                          <div class="row border-top border-secondary mt-2">
                            <button type="submit" id="earnXPRBtn" class="btn btn-secondary btn-block">Confirm</button>
                          </div>
                        </form>

                        
                        <form id="earnDOGEForm" style="display: none;">
                          <div class="row">
                            <div class="col-12 pb-4">
                              <button type="button" class="btn border-0 cancel-earn text-warning px-0 float-left">Back</button>
                              <a href="history" class="btn border-0 cancel-earn text-warning px-0 float-right"><i class="fas fa-history"></i></a>
                            </div>
                          </div>
                          <div class="row h3 font-weight-normal px-2 pb-4">Stake DOGE</div>
                          <!-- Username -->
                          <input type="hidden" name="username" value="<?php echo $username; ?>">
                          <input type="hidden" name="method" value="doge">
                          <input type="hidden" name="earn" value="stake">

                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Duration</label>
                          
                          <div class="row">
                            <div class="col-12">
                              <input type="radio" class="btn-check mx-auto" name="network" id="option13" value="30 Days" autocomplete="off" checked>
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option13" style="font-size:12px;font-weight:normal;">30 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option23" value="60 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option23" style="font-size:12px;font-weight:normal;">60 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option33" value="90 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option33" style="font-size:12px;font-weight:normal;">90 Days</label>
                            </div>  
                          </div>
                          
                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Lock Amount</label>
                          <div class="input-group border border-top-0 border-right-0 border-left-0 border-secondary mb-0 pb-0">
                            <input class="form-control custom-form text-muted px-0 border-0 rounded-0 mb-0 pb-0" type="text" placeholder="Please enter the quantity." name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                            <span class="input-group-text custom-form border-0 px-1 border-0 rounded-0 mb-0 pb-0" id="basic-addon2">DOGE<span class="text-warning pl-2">Max</span></span>
                          </div>

                          <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="response_msg"></span></label>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Available: <span class="pr-1 text-white"><?php echo number_format($bal_doge_value, 10, '.', ''); ?></span>DOGE</label>
                          </div>
                          
                          <div class="input-group">
                            <label class="form-control-label text-white font-weight-normal mt-2" style="font-size: 12px;">Locked Amount Limitation</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Minimum: <span class="pr-1 text-white">0.0000001</span> DOGE</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Maximum: <span class="pr-1 text-white">100.0000000 DOGE</label>
                          </div>

                          <div class="row border-top border-secondary mt-2">
                            <button type="submit" id="earnDOGEBtn" class="btn btn-secondary btn-block">Confirm</button>
                          </div>
                        </form>

                        
                        <form id="earnUSDTForm" style="display: none;">
                          <div class="row">
                            <div class="col-12 pb-4">
                              <button type="button" class="btn border-0 cancel-earn text-warning px-0 float-left">Back</button>
                              <a href="history" class="btn border-0 cancel-earn text-warning px-0 float-right"><i class="fas fa-history"></i></a>
                            </div>
                          </div>
                          <div class="row h3 font-weight-normal px-2 pb-4">Stake USDT</div>
                          <!-- Username -->
                          <input type="hidden" name="username" value="<?php echo $username; ?>">
                          <input type="hidden" name="method" value="usdt">
                          <input type="hidden" name="earn" value="stake">

                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Duration</label>
                          
                          <div class="row">
                            <div class="col-12">
                              <input type="radio" class="btn-check mx-auto" name="network" id="option13" value="30 Days" autocomplete="off" checked>
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option13" style="font-size:12px;font-weight:normal;">30 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option23" value="60 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option23" style="font-size:12px;font-weight:normal;">60 Days</label>

                              <input type="radio" class="btn-check mx-auto" name="network" id="option33" value="90 Days" autocomplete="off">
                              <label class="btn btn-secondary btn-sm py-1 px-3" for="option33" style="font-size:12px;font-weight:normal;">90 Days</label>
                            </div>  
                          </div>
                          
                          <label class="form-control-label text-muted font-weight-normal my-0 text-sm">Lock Amount</label>
                          <div class="input-group border border-top-0 border-right-0 border-left-0 border-secondary mb-0 pb-0">
                            <input class="form-control custom-form text-muted px-0 border-0 rounded-0 mb-0 pb-0" type="text" placeholder="Please enter the quantity." name="amount" required style="font-size:14px;height:45px;" autocomplete="off" aria-describedby="basic-addon2">
                            <span class="input-group-text custom-form border-0 px-1 border-0 rounded-0 mb-0 pb-0" id="basic-addon2">USDT<span class="text-warning pl-2">Max</span></span>
                          </div>

                          <label class="text-danger text-left" style="font-size: 12px; font-weight: normal;"><span class="response_msg"></span></label>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Available: <span class="pr-1 text-white"><?php echo number_format($bal_usdt_value, 10, '.', ''); ?></span>USDT</label>
                          </div>
                          
                          <div class="input-group">
                            <label class="form-control-label text-white font-weight-normal mt-2" style="font-size: 12px;">Locked Amount Limitation</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Minimum: <span class="pr-1 text-white">0.0000001</span> USDT</label>
                          </div>

                          <div class="input-group">
                            <label class="form-control-label text-muted font-weight-normal mt-2" style="font-size: 12px;">Maximum: <span class="pr-1 text-white">100.0000000 USDT</label>
                          </div>

                          <div class="row border-top border-secondary mt-2">
                            <button type="submit" id="earnUSDTBtn" class="btn btn-secondary btn-block">Confirm</button>
                          </div>
                        </form>


                      </div>
                    </div>
                    <div id="success_modal" class="overlay dark" style="display: none;"><i class="fa-4x fas fa-spinner fa-spin"></i></div>
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
    $(document).on('click', '#redeemCoinDivBtn', function() {
      $('#assetDiv').hide();
      $('#redeemCoinDiv').show();
    });

    $(document).on('click', '#btc-redeem', function(event) {
      event.preventDefault();
      $('#redeemCoinDiv').hide();
      $('#redeemBTCForm').show();
    });
    $(document).on('click', '#eth-redeem', function(event) {
      event.preventDefault();
      $('#redeemCoinDiv').hide();
      $('#redeemETHForm').show();
    });
    $(document).on('click', '#bnb-redeem', function(event) {
      event.preventDefault();
      $('#redeemCoinDiv').hide();
      $('#redeemBNBForm').show();
    });
    $(document).on('click', '#ada-redeem', function(event) {
      event.preventDefault();
      $('#redeemCoinDiv').hide();
      $('#redeemADAForm').show();
    });
    $(document).on('click', '#xpr-redeem', function(event) {
      event.preventDefault();
      $('#redeemCoinDiv').hide();
      $('#redeemXPRForm').show();
    });
    $(document).on('click', '#doge-redeem', function(event) {
      event.preventDefault();
      $('#redeemCoinDiv').hide();
      $('#redeemDOGEForm').show();
    });
    $(document).on('click', '#usdt-redeem', function(event) {
      event.preventDefault();
      $('#redeemCoinDiv').hide();
      $('#redeemUSDTForm').show();
    });

    $(document).on('click', '.redeem-back', function(event) {
      event.preventDefault();
      $('#redeemCoinDiv').hide();
      $('#assetDiv').show();
    });


    $(document).on('click', '.cancel-redeem', function(event) {
      event.preventDefault();
      $('#redeemBTCForm, #redeemETHForm, #redeemBNBForm, #redeemADAForm, #redeemXPRForm, #redeemDOGEForm, #redeemUSDTForm')[0].reset();
      $('#redeemBTCForm').hide();
      $('#redeemETHForm').hide();
      $('#redeemBNBForm').hide();
      $('#redeemADAForm').hide();
      $('#redeemXPRForm').hide();
      $('#redeemDOGEForm').hide();
      $('#redeemUSDTForm').hide();
      $('#redeemCoinDiv').show();

    });


     $(document).on('click', '.cancel-redeem-form', function(event) {
      event.preventDefault();
      $('#redeemBTCForm, #redeemETHForm, #redeemBNBForm, #redeemADAForm, #redeemXPRForm, #redeemDOGEForm, #redeemUSDTForm')[0].reset();
      $('#redeemBTCForm').hide();
      $('#redeemETHForm').hide();
      $('#redeemBNBForm').hide();
      $('#redeemADAForm').hide();
      $('#redeemXPRForm').hide();
      $('#redeemDOGEForm').hide();
      $('#redeemUSDTForm').hide();
      $('#assetDiv').show();

    });


    $(document).on('submit', '#redeemBTCForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#redeemBTCForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#earnBTCForm').hide();
              $('#loading').hide();
              $('#assetDiv').show();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#loading').hide();
            $('.status_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.status_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });

    $(document).on('submit', '#redeemETHForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#redeemETHForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#earnETHForm').hide();
              $('#loading').hide();
              $('#assetDiv').show();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#loading').hide();
            $('.status_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.status_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });

    $(document).on('submit', '#redeemBNBForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#redeemBNBForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#earnBNBForm').hide();
              $('#loading').hide();
              $('#assetDiv').show();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#loading').hide();
            $('.status_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.status_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });

    $(document).on('submit', '#redeemADAForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#redeemADAForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#earnADAForm').hide();
              $('#loading').hide();
              $('#assetDiv').show();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#loading').hide();
            $('.status_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.status_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });

    $(document).on('submit', '#redeemXPRForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#redeemXPRForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#earnXPRForm').hide();
              $('#loading').hide();
              $('#assetDiv').show();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#loading').hide();
            $('.status_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.status_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });

    $(document).on('submit', '#redeemDOGEForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#redeemDOGEForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#earnDOGEForm').hide();
              $('#loading').hide();
              $('#assetDiv').show();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#loading').hide();
            $('.status_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.status_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });

    $(document).on('submit', '#redeemUSDTForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#redeemUSDTForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#earnUSDTForm').hide();
              $('#loading').hide();
              $('#assetDiv').show();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#loading').hide();
            $('.status_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.status_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });

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

    $(document).on('click', '#btc-earn', function(event) {
      event.preventDefault();
      $('#choose-earn-method').hide();
      $('#earnBTCForm').show();
    });
    $(document).on('click', '#eth-earn', function(event) {
      event.preventDefault();
      $('#choose-earn-method').hide();
      $('#earnETHForm').show();
    });
    $(document).on('click', '#bnb-earn', function(event) {
      event.preventDefault();
      $('#choose-earn-method').hide();
      $('#earnBNBForm').show();
    });
    $(document).on('click', '#ada-earn', function(event) {
      event.preventDefault();
      $('#choose-earn-method').hide();
      $('#earnADAForm').show();
    });
    $(document).on('click', '#xpr-earn', function(event) {
      event.preventDefault();
      $('#choose-earn-method').hide();
      $('#earnXPRForm').show();
    });
    $(document).on('click', '#doge-earn', function(event) {
      event.preventDefault();
      $('#choose-earn-method').hide();
      $('#earnDOGEForm').show();
    });
    $(document).on('click', '#usdt-earn', function(event) {
      event.preventDefault();
      $('#choose-earn-method').hide();
      $('#earnUSDTForm').show();
    });
    $(document).on('click', '.cancel-earn', function(event) {
      event.preventDefault();
      $('#earnBTCForm, #earnETHForm, #earnBNBForm, #earnADAForm, #earnXPRForm, #earnDOGEForm, #earnUSDTForm')[0].reset();
      $('#choose-earn-method').show();
      $('#earnBTCForm').hide();
      $('#earnETHForm').hide();
      $('#earnBNBForm').hide();
      $('#earnADAForm').hide();
      $('#earnXPRForm').hide();
      $('#earnDOGEForm').hide();
      $('#earnUSDTForm').hide();
    });

    $(document).on('submit', '#earnBTCForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#success_modal').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#earnBTCForm')[0].reset();
            $('#success_modal').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            $('#earnBTCBtn').html('Confirm');
            setTimeout(function() {
              $('#earnBTCForm').hide();
              $('#choose-earn-method').show();
              $('#success_modal').hide();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#success_modal').hide();
            $('#earnBTCBtn').html('Confirm');
            $('.response_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.response_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });
    
    $(document).on('submit', '#earnETHForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#success_modal').show();
        },
        success: function(response) {
          if(response.status == '2') {
            $('#earnETHForm')[0].reset();
            $('#success_modal').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            $('#earnETHBtn').html('Confirm');
            setTimeout(function() {
              $('#earnETHForm').hide();
              $('#choose-earn-method').show();
              $('#success_modal').hide();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#success_modal').hide();
            $('#earnETHBtn').html('Confirm');
            $('.response_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.response_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });
    
    $(document).on('submit', '#earnBNBForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#success_modal').show();
        },
        success: function(response) {
          if(response.status == '3') {
            $('#earnBNBForm')[0].reset();
            $('#success_modal').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            $('#earnBNBBtn').html('Confirm');
            setTimeout(function() {
              $('#earnBNBForm').hide();
              $('#choose-earn-method').show();
              $('#success_modal').hide();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#success_modal').hide();
            $('#earnBNBBtn').html('Confirm');
            $('.response_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.response_msg').hide('slow');
            }, 5000);
          }
        }
      });
    });
    
    $(document).on('submit', '#earnADAForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#success_modal').show();
        },
        success: function(response) {
          if(response.status == '4') {
            $('#earnADAForm')[0].reset();
            $('#success_modal').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            $('#earnADABtn').html('Confirm');
            setTimeout(function() {
              $('#earnADAForm').hide();
              $('#choose-earn-method').show();
              $('#success_modal').hide();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#success_modal').hide();
            $('#earnBNBBtn').html('Confirm');
            $('.response_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.response_msg').hide('slow');
            }, 5000);

          }
        }
      });
    });
    
    $(document).on('submit', '#earnXPRForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#success_modal').show();
        },
        success: function(response) {
          if(response.status == '4') {
            $('#earnXPRForm')[0].reset();
            $('#success_modal').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            $('#earnXPRBtn').html('Confirm');
            setTimeout(function() {
              $('#earnXPRForm').hide();
              $('#choose-earn-method').show();
              $('#success_modal').hide();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#success_modal').hide();
            $('#earnBNBBtn').html('Confirm');
            $('.response_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.response_msg').hide('slow');
            }, 5000);

          }
        }
      });
    });
    
    $(document).on('submit', '#earnDOGEForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#success_modal').show();
        },
        success: function(response) {
          if(response.status == '4') {
            $('#earnDOGEForm')[0].reset();
            $('#success_modal').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            $('#earnDOGEBtn').html('Confirm');
            setTimeout(function() {
              $('#earnDOGEForm').hide();
              $('#choose-earn-method').show();
              $('#success_modal').hide();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#success_modal').hide();
            $('#earnBNBBtn').html('Confirm');
            $('.response_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.response_msg').hide('slow');
            }, 5000);

          }
        }
      });
    });
    
    $(document).on('submit', '#earnUSDTForm', function(e) {
      e.preventDefault();
      /* Act on the event */
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#success_modal').show();
        },
        success: function(response) {
          if(response.status == '4') {
            $('#earnUSDTForm')[0].reset();
            $('#success_modal').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            $('#earnUSDTBtn').html('Confirm');
            setTimeout(function() {
              $('#earnUSDTForm').hide();
              $('#choose-earn-method').show();
              $('#success_modal').hide();
            }, 2000);
          } 
          if(response.status == '0') {
            $('#success_modal').hide();
            $('#earnBNBBtn').html('Confirm');
            $('.response_msg').html('<span>'+response.message+'</span>');
            setTimeout(function() {
              $('.response_msg').hide('slow');
            }, 5000);

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
        "nfo": true,
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

    $('#earn-btc-amount, #earn-eth-amount, #earn-bnb-amount, #earn-ada-amount, #earn-xpr-amount, #earn-doge-amount, #earn-usdt-amount').keyup(function() {
      get_btc();
      get_eth();
      get_bnb();
      get_ada();
      get_xpr();
      get_doge();
      get_usdt();
    });

    function get_btc() {
      var usd = $('.usd-btc-value').val();
      var btc = $('.btc-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, btc:btc},
          success: function (data) {
            $('.btc-value').html(data);
            $('#usd-value').html(usd);
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
      var usd = $('.usd-eth-value').val();
      var eth = $('.eth-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, eth:eth},
          success: function (data) {
            $('.eth-value').html(data);
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
      var usd = $('.usd-bnb-value').val();
      var bnb = $('.bnb-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, bnb:bnb},
          success: function (data) {
            $('.bnb-value').html(data);
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
      var usd = $('.usd-ada-value').val();
      var ada = $('.ada-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, ada:ada},
          success: function (data) {
            $('.ada-value').html(data);
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
      var usd = $('.usd-xpr-value').val();
      var xpr = $('.xpr-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, xpr:xpr},
          success: function (data) {
            $('.xpr-value').html(data);
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
      var usd = $('.usd-doge-value').val();
      var doge = $('.doge-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, doge:doge},
          success: function (data) {
            $('.doge-value').html(data);
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
      var usd = $('.usd-usdt-value').val();
      var usdt = $('.usdt-value').val();
      if($.isNumeric(usd)) {
        $.ajax({
          url: 'get-coins.php',
          type: 'post',
          data: {usd:usd, usdt:usdt},
          success: function (data) {
            $('.usdt-value').html(data);
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
    $('.noclick').click(false);

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