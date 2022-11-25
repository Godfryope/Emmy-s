<?php
session_start();
include('../database/dbconfig.php');
if (!isset($_SESSION['adminid'])) {
  header('Location:login');
  exit();
} else {
  $adminid = $_SESSION['adminid'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crypto</title>
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

  <style>
    .coin-hover:hover {background:#c2c6ca !important;cursor: pointer;}
  </style>
</head>
<body id="results" class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <div class="spinner-grow text-info" role="status"></div>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        
      </ul>
     
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Live Chat Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <?php 
            $sqli = $db_conn->query("SELECT * FROM conversations WHERE source = 'user' ORDER BY msg_id DESC");
            $msg_count = $sqli->num_rows;
          ?>
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span id="msg-count" class="badge badge-danger navbar-badge"><?php echo $msg_count; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <?php
            $sqli = $db_conn->query("SELECT DISTINCT userid FROM conversations WHERE source = 'user' ORDER BY msg_id DESC LIMIT 5");
            if($sqli->num_rows > 0) {
              while($show_msgs = $sqli->fetch_assoc()) {
                $userid = $show_msgs['userid'];
                $sqlio = $db_conn->query("SELECT DISTINCT name FROM conversations WHERE userid = '$userid' ORDER BY msg_id DESC");
                $stmt = $sqlio->fetch_assoc();     
            ?>
            <a href="live-chat?user_chat_id=<?php echo $show_msgs['userid']; ?>" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <div class="media-body">
                  <h3 class="dropdown-item-title font-weight-bold">
                    <?php echo $stmt['name']; ?>
                    <span class="float-right text-sm text-success"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm text-success"><i class="fas fa-dot-circle mr-1"></i>Online</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <?php
              }
            }
            else {
              echo '<a class="dropdown-item dropdown-footer">No messages</a>';
            }
            ?>
            <div class="dropdown-divider"></div>
          </div>
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
          
            <li class="nav-item mt-4">
              <a href="overview" class="nav-link">
                <i class="fas fa-house-user nav-icon"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="users" class="nav-link">
                <i class="fas fa-users nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="accounts" class="nav-link">
                <i class="fas fa-expand-arrows-alt nav-icon"></i>
                <p>Accounts</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="transactions" class="nav-link">
                <i class="fas fa-history nav-icon"></i>
                <p>Transactions</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="Crypto" class="nav-link active">
                <i class="fas fa-coins nav-icon"></i>
                <p>Crypto</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="support" class="nav-link">
                <i class="fas fa-question nav-icon"></i>
                <p>Support</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="live-chat" class="nav-link">
                <i class="fas fa-comment nav-icon"></i>
                <p>Live chat</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="logout" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Sign out
                </p>
              </a>
            </li>
            
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <?php
          $a = $db_conn->query("SELECT * FROM coins WHERE coin = 'btc'");
          $btc = $a->fetch_assoc();
          $btc_rate = $btc['value'];
          $btc_barcode = $btc['barcode'];

          $b = $db_conn->query("SELECT * FROM coins WHERE coin = 'eth'");
          $eth = $b->fetch_assoc();
          $eth_rate = $eth['value'];
          $eth_barcode = $eth['barcode'];

          $c = $db_conn->query("SELECT * FROM coins WHERE coin = 'bnb'");
          $bnb = $c->fetch_assoc();
          $bnb_rate = $bnb['value'];
          $bnb_barcode = $bnb['barcode'];

          $d = $db_conn->query("SELECT * FROM coins WHERE coin = 'ada'");
          $ada = $d->fetch_assoc();
          $ada_rate = $ada['value'];
          $ada_barcode = $ada['barcode'];

          $e = $db_conn->query("SELECT * FROM coins WHERE coin = 'xpr'");
          $xpr = $e->fetch_assoc();
          $xpr_rate = $ada['value'];
          $xpr_barcode = $xpr['barcode'];

          $f = $db_conn->query("SELECT * FROM coins WHERE coin = 'doge'");
          $doge = $f->fetch_assoc();
          $doge_rate = $doge['value'];
          $doge_barcode = $doge['barcode'];

          $g = $db_conn->query("SELECT * FROM coins WHERE coin = 'usdt'");
          $usdt = $g->fetch_assoc();
          $usdt_rate = $usdt['value'];
          $usdt_barcode = $usdt['barcode'];

          
          ?>
          <!-- Main row -->
          <div class="row pt-4">

            <div class="col-12 col-sm-6">
              <div class="card rounded-0">
                <div class="card-body px-2">
                  <div class="text-info h3 pb-4">
                    Update coin value
                  </div>
                  <div id="choose-coin-value">

                    <div id="bitcoinValueBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/bitcoin.png" alt="Bitcoin" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">BTC</div>
                              <div class="text-muted" style="font-size:12px;">Biticoin</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($btc_rate); ?></span> <span style="font-size:16px;">USD / BTC</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="ethereumValueBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/ethereum.png" alt="Ethereum" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">ETH</div>
                              <div class="text-muted" style="font-size:12px;">Ethereum</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($eth_rate); ?></span> <span style="font-size:16px;">USD / ETH</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="binanceValueBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/binance_coin.png" alt="Binance" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">BNB</div>
                              <div class="text-muted" style="font-size:12px;">Binance</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($bnb_rate); ?></span> <span style="font-size:16px;">USD / BNB</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="cardanoValueBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/cardano.png" alt="Cardano" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">ADA</div>
                              <div class="text-muted" style="font-size:12px;">Cardano</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($ada_rate); ?></span> <span style="font-size:16px;">USD / ADA</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="protonValueBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/proton.png" alt="Proton" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">XPR</div>
                              <div class="text-muted" style="font-size:12px;">Proton</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($xpr_rate); ?></span> <span style="font-size:16px;">USD / XPR</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="dogecoinValueBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/dogecoin.png" alt="Dogecoin" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">DOGE</div>
                              <div class="text-muted" style="font-size:12px;">Dogecoin</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($doge_rate); ?></span> <span style="font-size:16px;">USD / DOGE</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="tetherValueBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/tether.png" alt="Tether" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">USDT</div>
                              <div class="text-muted" style="font-size:12px;">Tether</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($usdt_rate); ?></span> <span style="font-size:16px;">USD / USDT</span></div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div id="update-coin-value">
                    <form id="updateBtcValue" class="px-2" style="display: none;">
                      <h5>Update BTC Value</h5>
                      <input type="hidden" name="coin-value" value="btc">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateBtcValueBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelBtcValueUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse_msg"></div>
                    </form>

                    <form id="updateEthValue" class="px-2" style="display: none;">
                      <h5>Update ETH Value</h5>
                      <input type="hidden" name="coin-value" value="eth">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateEthValueBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelEthValueUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse_msg2"></div>
                    </form>

                    <form id="updateBnbValue" class="px-2" style="display: none;">
                      <h5>Update BNB Value</h5>
                      <input type="hidden" name="coin-value" value="bnb">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateBnbValueBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelBnbValueUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse_msg3"></div>
                    </form>

                    <form id="updateAdaValue" class="px-2" style="display: none;">
                      <h5>Update ADA Value</h5>
                      <input type="hidden" name="coin-value" value="ada">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateAdaValueBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelAdaValueUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse_msg4"></div>
                    </form>

                    <form id="updateXprValue" class="px-2" style="display: none;">
                      <h5>Update XPR Value</h5>
                      <input type="hidden" name="coin-value" value="xpr">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateXprValueBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelXprValueUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse_msg5"></div>
                    </form>

                    <form id="updateDogeValue" class="px-2" style="display: none;">
                      <h5>Update DOGE Value</h5>
                      <input type="hidden" name="coin-value" value="doge">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateDogeValueBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelDogeValueUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse_msg6"></div>
                    </form>

                    <form id="updateUsdtValue" class="px-2" style="display: none;">
                      <h5>Update USDT Value</h5>
                      <input type="hidden" name="coin-value" value="usdt">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateUsdtValueBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelUsdtValueUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse_msg7"></div>
                    </form>

                  </div>

                </div>
                <div id="loadex" class="overlay" style="display:none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="card rounded-0">
                <div class="card-body px-2">
                  <div class="text-info h3 pb-4">
                    Update coin
                  </div>
                  <div id="choose-coin">

                    <div id="bitcoinBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/bitcoin.png" alt="Bitcoin" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">BTC</div>
                              <div class="text-muted" style="font-size:12px;">Biticoin</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($btc_rate); ?></span> <span style="font-size:16px;">USD / BTC</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="ethereumBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/ethereum.png" alt="Ethereum" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">ETH</div>
                              <div class="text-muted" style="font-size:12px;">Ethereum</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($eth_rate); ?></span> <span style="font-size:16px;">USD / ETH</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="binanceBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/binance_coin.png" alt="Binance" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">BNB</div>
                              <div class="text-muted" style="font-size:12px;">Binance</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($bnb_rate); ?></span> <span style="font-size:16px;">USD / BNB</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="cardanoBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/cardano.png" alt="Cardano" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">ADA</div>
                              <div class="text-muted" style="font-size:12px;">Cardano</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($ada_rate); ?></span> <span style="font-size:16px;">USD / ADA</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="protonBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/proton.png" alt="Proton" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">XPR</div>
                              <div class="text-muted" style="font-size:12px;">Proton</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($xpr_rate); ?></span> <span style="font-size:16px;">USD / XPR</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="dogecoinBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/dogecoin.png" alt="Dogecoin" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">DOGE</div>
                              <div class="text-muted" style="font-size:12px;">Dogecoin</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($doge_rate); ?></span> <span style="font-size:16px;">USD / DOGE</span></div>
                        </div>
                      </div>
                    </div>

                    <div id="tetherBtn" class="row py-1 bg-light coin-hover my-2">
                      <div class="col-12">
                        <div class="float-left">
                          <div class="row">
                            <div class="col-auto">
                              <img src="../account/img/tether.png" alt="Tether" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                            </div>
                            <div class="col">
                              <div class="h6 mb-0">USDT</div>
                              <div class="text-muted" style="font-size:12px;">Tether</div>
                            </div>
                          </div>
                        </div>
                        <div class="float-right">
                          <div class="h6 mb-0" style="font-size:18px;"><span class="text-primary"><?php echo number_format($usdt_rate); ?></span> <span style="font-size:16px;">USD / USDt</span></div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div id="update-coin">
                    <form id="updateBtc" enctype="multipart/form-data" class="px-2" style="display: none;">
                      <h5>Update BTC</h5>
                      <input type="hidden" name="coin" value="btc">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Address: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="walletid" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Barcode: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="barcode" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateBtcBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelBtcUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse"></div>
                    </form>

                    <form id="updateEth" enctype="multipart/form-data" class="px-2" style="display: none;">
                      <h5>Update ETH</h5>
                      <input type="hidden" name="coin" value="eth">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Address: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="walletid" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Barcode: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="barcode" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateEthBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelEthUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse2"></div>
                    </form>

                    <form id="updateBnb" enctype="multipart/form-data" class="px-2" style="display: none;">
                      <h5>Update BNB</h5>
                      <input type="hidden" name="coin" value="bnb">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Address: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="walletid" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Barcode: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="barcode" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateBnbBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelBnbUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse3"></div>
                    </form>

                    <form id="updateAda" enctype="multipart/form-data" class="px-2" style="display: none;">
                      <h5>Update ADA</h5>
                      <input type="hidden" name="coin" value="ada">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Address: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="walletid" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Barcode: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="barcode" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateAdaBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelAdaUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse4"></div>
                    </form>

                    <form id="updateXpr" enctype="multipart/form-data" class="px-2" style="display: none;">
                      <h5>Update XPR</h5>
                      <input type="hidden" name="coin" value="xpr">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Address: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="walletid" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Barcode: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="barcode" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateXprBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelXprUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse5"></div>
                    </form>

                    <form id="updateDoge" enctype="multipart/form-data" class="px-2" style="display: none;">
                      <h5>Update DOGE</h5>
                      <input type="hidden" name="coin" value="doge">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Address: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="walletid" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Barcode: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="barcode" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateDogeBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelDogeUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse6"></div>
                    </form>

                    <form id="updateUsdt" enctype="multipart/form-data" class="px-2" style="display: none;">
                      <h5>Update USDT</h5>
                      <input type="hidden" name="coin" value="usdt">
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Value: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="value" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Address: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="walletid" value="" required>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-normal text-mute text-sm">Barcode: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="barcode" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" id="updateUsdtBtn" class="btn btn-primary">Update</button>
                        <button type="button" id="cancelUsdtUpdate" class="btn btn-default">Cancel</button>
                      </div>
                      <div id="reponse7"></div>
                    </form>

                  </div>
                </div>
                <div id="load" class="overlay" style="display:none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
              </div>
            </div>
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!--Footer-->
    <footer class="main-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn">
      <!--Copyright-->
      <div class="footer-copyright py-3">
        <div class="pt-2">All Rights Reserved &copy; 2018-<?php echo date("Y"); ?></div>
      </div>
      <!--/.Copyright-->

    </footer>
    <!--/.Footer-->
    
  </div>
  <!-- ./wrapper -->

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
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>

  <script>

    $("#updateBtcValue").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true,
            beforeSend: function(){
                $('#loadex').show();
                $('#updateBtcValue').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateBtcValue')[0].reset();
                    $('#loadex').hide();
                    $("#updateBtcValueBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateBtcValue').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response_msg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#loadex').hide();
                    $('#updateBtcValue').css("opacity","");
                }
                
            }
        });
    });

    $("#updateEthValue").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true,
            beforeSend: function(){
                $('#loadex').show();
                $('#updateEthValue').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateEthValue')[0].reset();
                    $('#loadex').hide();
                    $("#updateEthValueBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateEthValue').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response_msg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#loadex').hide();
                    $('#updateEthValue').css("opacity","");
                }
                
            }
        });
    });


    $("#updateBnbValue").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true,
            beforeSend: function(){
                $('#loadex').show();
                $('#updateBnbValue').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateBnbValue')[0].reset();
                    $('#loadex').hide();
                    $("#updateBnbValueBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateBnbValue').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response_msg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#loadex').hide();
                    $('#updateBnbValue').css("opacity","");
                }
                
            }
        });
    });

    $("#updateAdaValue").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true,
            beforeSend: function(){
                $('#loadex').show();
                $('#updateAdaValue').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateAdaValue')[0].reset();
                    $('#loadex').hide();
                    $("#updateAdaValueBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateAdaValue').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response_msg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#loadex').hide();
                    $('#updateAdaValue').css("opacity","");
                }
                
            }
        });
    });

    $("#updateXprValue").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true,
            beforeSend: function(){
                $('#loadex').show();
                $('#updateXprValue').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateXprValue')[0].reset();
                    $('#loadex').hide();
                    $("#updateXprValueBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateXprValue').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response_msg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#loadex').hide();
                    $('#updateXprValue').css("opacity","");
                }
                
            }
        });
    });

    $("#updateDogeValue").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true,
            beforeSend: function(){
                $('#loadex').show();
                $('#updateDogeValue').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateDogeValue')[0].reset();
                    $('#loadex').hide();
                    $("#updateDogeValueBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateDogeValue').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response_msg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#loadex').hide();
                    $('#updateDogeValue').css("opacity","");
                }
                
            }
        });
    });

    $("#updateUsdtValue").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true,
            beforeSend: function(){
                $('#loadex').show();
                $('#updateUsdtValue').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateUsdtValue')[0].reset();
                    $('#loadex').hide();
                    $("#updateUsdtValueBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateUsdtValue').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response_msg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#loadex').hide();
                    $('#updateUsdtValue').css("opacity","");
                }
                
            }
        });
    });

    $('#bitcoinValueBtn').click(function() {
      $('#choose-coin-value').hide();
      $('#updateBtcValue').show();
      $('#updateEthValue').hide();
      $('#updateBnbValue').hide();
      $('#updateAdaValue').hide();
      $('#updateXprValue').hide();
      $('#updateDogeValue').hide();
      $('#updateUsdtValue').hide();
    });

    $('#ethereumValueBtn').click(function() {
      $('#choose-coin-value').hide();
      $('#updateEthValue').show();
      $('#updateBtcValue').hide();
      $('#updateBnbValue').hide();
      $('#updateAdaValue').hide();
      $('#updateXprValue').hide();
      $('#updateDogeValue').hide();
      $('#updateUsdtValue').hide();
    });

    $('#binanceValueBtn').click(function() {
      $('#choose-coin-value').hide();
      $('#updateBnbValue').show();
      $('#updateBtcValue').hide();
      $('#updateEthValue').hide();
      $('#updateAdaValue').hide();
      $('#updateXprValue').hide();
      $('#updateDogeValue').hide();
      $('#updateUsdtValue').hide();
    });

    $('#cardanoValueBtn').click(function() {
      $('#choose-coin-value').hide();
      $('#updateAdaValue').show();
      $('#updateBtcValue').hide();
      $('#updateEthValue').hide();
      $('#updateBnbValue').hide();
      $('#updateXprValue').hide();
      $('#updateDogeValue').hide();
      $('#updateUsdtValue').hide();
    });

    $('#protonValueBtn').click(function() {
      $('#choose-coin-value').hide();
      $('#updateXprValue').show();
      $('#updateBtcValue').hide();
      $('#updateEthValue').hide();
      $('#updateBnbValue').hide();
      $('#updateAdaValue').hide();
      $('#updateDogeValue').hide();
      $('#updateUsdtValue').hide();
    });

    $('#dogecoinValueBtn').click(function() {
      $('#choose-coin-value').hide();
      $('#updateDogeValue').show();
      $('#updateBtcValue').hide();
      $('#updateEthValue').hide();
      $('#updateBnbValue').hide();
      $('#updateAdaValue').hide();
      $('#updateXprValue').hide();
      $('#updateUsdtValue').hide();
    });

    $('#tetherValueBtn').click(function() {
      $('#choose-coin-value').hide();
      $('#updateUsdtValue').show();
      $('#updateBtcValue').hide();
      $('#updateEthValue').hide();
      $('#updateBnbValue').hide();
      $('#updateAdaValue').hide();
      $('#updateXprValue').hide();
      $('#updateDogeValue').hide();
    });

    $('#cancelBtcValueUpdate, #cancelEthValueUpdate, #cancelBnbValueUpdate, #cancelAdaValueUpdate, #cancelXprValueUpdate, #cancelDogeValueUpdate, #cancelUsdtValueUpdate').click(function() {
      $('#updateBtcValue').hide();
      $('#updateEthValue').hide();
      $('#updateBnbValue').hide();
      $('#updateAdaValue').hide();
      $('#updateXprValue').hide();
      $('#updateDogeValue').hide();
      $('#updateUsdtValue').hide();
      $('#choose-coin-value').show();
    });

    $("#updateBtc").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#load').show();
                $('#updateBtc').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateBtc')[0].reset();
                    $('#load').hide();
                    $("#updateBtcBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateBtc').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#load').hide();
                    $('#updateBtc').css("opacity","");
                }
                
            }
        });
    });

    $("#updateEth").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#load').show();
                $('#updateEth').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateEth')[0].reset();
                    $('#load').hide();
                    $("#updateEthBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateEth').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#load').hide();
                    $('#updateEth').css("opacity","");
                }
                
            }
        });
    });

    $("#updateBnb").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#load').show();
                $('#updateBnb').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateBnb')[0].reset();
                    $('#load').hide();
                    $("#updateBnbBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateBnb').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#load').hide();
                    $('#updateBnb').css("opacity","");
                }
                
            }
        });
    });

    $("#updateAda").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#load').show();
                $('#updateAda').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateAda')[0].reset();
                    $('#load').hide();
                    $("#updateAdaBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateAda').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#load').hide();
                    $('#updateAda').css("opacity","");
                }
                
            }
        });
    });

    $("#updateXpr").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#load').show();
                $('#updateXpr').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateXpr')[0].reset();
                    $('#load').hide();
                    $("#updateXprBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateXpr').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#load').hide();
                    $('#updateXpr').css("opacity","");
                }
                
            }
        });
    });

    $("#updateDoge").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#load').show();
                $('#updateDoge').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateDoge')[0].reset();
                    $('#load').hide();
                    $("#updateDogeBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateDoge').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#load').hide();
                    $('#updateDoge').css("opacity","");
                }
                
            }
        });
    });

    $("#updateUsdt").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#load').show();
                $('#updateUsdt').css("opacity",".5");
            },
            success: function(response){
                if(response.status == 1){
                    $('#updateUsdt')[0].reset();
                    $('#load').hide();
                    $("#updateUsdtBtn").html("Saved").removeClass('btn-primary').addClass('btn-success');
                    $('#updateUsdt').css("opacity","");
                    $("#choose-coin").load(location.href + " #choose-coin");
                    $("#choose-coin-value").load(location.href + " #choose-coin-value");
                }else{
                    $('#response').html('<p class="alert alert-danger">'+response.message+'</p>');
                    $('#load').hide();
                    $('#updateUsdt').css("opacity","");
                }
                
            }
        });
    });

    $('#bitcoinBtn').click(function() {
      $('#choose-coin').hide();
      $('#updateBtc').show();
      $('#updateEth').hide();
      $('#updateBnb').hide();
      $('#updateAda').hide();
      $('#updateXpr').hide();
      $('#updateDoge').hide();
      $('#updateUsdt').hide();
    });

    $('#ethereumBtn').click(function() {
      $('#choose-coin').hide();
      $('#updateEth').show();
      $('#updateBtc').hide();
      $('#updateBnb').hide();
      $('#updateAda').hide();
      $('#updateXpr').hide();
      $('#updateDoge').hide();
      $('#updateUsdt').hide();
    });

    $('#binanceBtn').click(function() {
      $('#choose-coin').hide();
      $('#updateBnb').show();
      $('#updateBtc').hide();
      $('#updateEth').hide();
      $('#updateAda').hide();
      $('#updateXpr').hide();
      $('#updateDoge').hide();
      $('#updateUsdt').hide();
    });

    $('#cardanoBtn').click(function() {
      $('#choose-coin').hide();
      $('#updateAda').show();
      $('#updateBtc').hide();
      $('#updateEth').hide();
      $('#updateBnb').hide();
      $('#updateXpr').hide();
      $('#updateDoge').hide();
      $('#updateUsdt').hide();
    });

    $('#protonBtn').click(function() {
      $('#choose-coin').hide();
      $('#updateAda').hide();
      $('#updateBtc').hide();
      $('#updateEth').hide();
      $('#updateBnb').hide();
      $('#updateXpr').show();
      $('#updateDoge').hide();
      $('#updateUsdt').hide();
    });

    $('#dogecoinBtn').click(function() {
      $('#choose-coin').hide();
      $('#updateAda').hide();
      $('#updateBtc').hide();
      $('#updateEth').hide();
      $('#updateBnb').hide();
      $('#updateXpr').hide();
      $('#updateDoge').show();
      $('#updateUsdt').hide();
    });

    $('#tetherBtn').click(function() {
      $('#choose-coin').hide();
      $('#updateAda').hide();
      $('#updateBtc').hide();
      $('#updateEth').hide();
      $('#updateBnb').hide();
      $('#updateXpr').hide();
      $('#updateDoge').hide();
      $('#updateUsdt').show();
    });

    $('#cancelBtcUpdate, #cancelEthUpdate, #cancelBnbUpdate, #cancelAdaUpdate, #cancelXprUpdate, #cancelDogeUpdate, #cancelUsdtUpdate').click(function() {
      $('#updateBtc').hide();
      $('#updateEth').hide();
      $('#updateBnb').hide();
      $('#updateAda').hide();
      $('#updateXpr').hide();
      $('#updateDoge').hide();
      $('#updateUsdt').hide();
      $('#choose-coin').show();
    });

    


    $(function () {
      $("#example1").DataTable({
        "paging": true,
        "responsive": true, 
        "lengthChange": true, 
        "autoWidth": true, 
        "searching": true, 
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
  </script>
</body>
</html>