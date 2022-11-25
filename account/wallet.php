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
  <title>Wallet - Bitcoptions</title>
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
                <p>Overview</p>
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
              <a href="wallet" class="nav-link active">
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
      
      <div class="row pb-4">
        <div class="col-12 noclick">
          <!-- BTC MARQUEE-->
          <script type="text/javascript">
              baseUrl = "https://widgets.cryptocompare.com/";
              var scripts = document.getElementsByTagName("script");
              var embedder = scripts[scripts.length - 1];
              var cccTheme = { "General": { "background": "#454d55", "priceText": "#fff" }, "Currency": { "color": "#fff" } };
              (function () {
                  var appName = encodeURIComponent(window.location.hostname);
                  if (appName == "") { appName = "local"; }
                  var s = document.createElement("script");
                  s.type = "text/javascript";
                  s.async = true;
                  var theUrl = baseUrl + 'serve/v1/coin/chartscroller?fsyms=BTC,ETH,BNB,BUSD,ADA,LTC,SOL,TRX,USDT&tsyms=USD';
                  s.src = theUrl + (theUrl.indexOf("?") >= 0 ? "&" : "?") + "app=" + appName;
                  embedder.parentNode.appendChild(s);
              })();
          </script>
        </div>
      </div>

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

          <!-- Main row -->
          <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-md-11 px-sm-2 px-0">
              <div class="card rounded-0">
                <div class="card-body text-right py-2 px-sm-3 px-2">
                  <span class="float-left">
                    <img src="img/icon_title_ac.png" alt="Icon">
                  </span>
                  <span class="float-right">
                    <div class="text-white card-text border-bottom border-secondary">Referral Code</div>
                    <div id="referralCode" class="text-warning referral h5" onclick="copyReferralCode(referralCode)" data-toggle="tooltip" data-original-title="Copy"><?php echo $data['userid']; ?>
                    </div>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row (main row) -->

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

                    $accbalance_btc_value = $accbalance / $btc_rate;
                    $bal_btc_value = $btcbalance / $btc_rate;
                    $bal_eth_value = $ethbalance / $eth_rate;
                    $bal_bnb_value = $bnbbalance / $bnb_rate;
                    $bal_ada_value = $adabalance / $ada_rate;
                    $bal_xpr_value = $xprbalance / $xpr_rate;
                    $bal_doge_value = $dogebalance / $doge_rate;
                    $bal_usdt_value = $usdtbalance / $usdt_rate;
                    ?>
                    <span class="h4" style="letter-spacing: 0px;"><?php echo number_format($accbalance_btc_value, 8, '.', ''); ?></span>
                    <span class="pl-1 card-text text-muted text-sm">&#x2248; $<?php echo number_format($accbalance, 2); ?></span>
                  </div>
                  <div class="row px-sm-0 pt-2 text-center">
                    <a href="deposit" class="btn btn-warning rounded border-0 py-1 px-2 mr-1" style="font-size:12px;">Deposit</a>
                    <a href="withdraw" class="btn btn-light rounded border-0 py-1 px-2 mr-1" style="font-size:12px;">Withdraw</a>
                    <a href="transfer" class="btn btn-light rounded border-0 py-1 px-2" style="font-size:12px;">Transfer</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row justify-content-center pb-2">
            <div class="col-12 col-sm-6 px-sm-2 px-0 pb-3">
              <div class="card rounded-0 h-100">
                <div class="card-body">
                  <div class="row">
                    <div class="text-muted border border-secondary border-top-0 border-right-0 border-left-0 w-100">Portfolio</div>
                  </div>
                  <div class="row py-3">
                    <div class="col-12 px-sm-0 px-1">
                      <div class="float-left">
                        <div class="row">
                          <div class="col-auto">
                            <img src="img/bitcoin.png" alt="Bitcoin" class=" rounded-circle" style="height:20px;width:20px;">
                          </div>
                          <div class="col">
                            <div class="h6 mb-0">BTC</div>
                            <div class="text-muted" style="font-size:12px;">Bitcoin</div>
                          </div>
                        </div>
                      </div>
                      <div class="float-right">
                        <div class="h6 mb-0"><?php echo number_format($bal_btc_value, 10, '.', ''); ?></div>
                        <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($btcbalance, 2); ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="row py-3">
                    <div class="col-12 px-sm-0 px-1">
                      <div class="float-left">
                        <div class="row">
                          <div class="col-auto">
                            <img src="img/ethereum.png" alt="Ethereum" class=" rounded-circle bg-warning" style="height:20px;width:20px;">
                          </div>
                          <div class="col">
                            <div class="h6 mb-0">ETH</div>
                            <div class="text-muted" style="font-size:12px;">Ethereum</div>
                          </div>
                        </div>
                      </div>
                      <div class="float-right">
                        <div class="h6 mb-0"><?php echo number_format($bal_eth_value, 10, '.', ''); ?></div>
                        <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($ethbalance, 2); ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="row py-3">
                    <div class="col-12 px-sm-0 px-1">
                      <div class="float-left">
                        <div class="row">
                          <div class="col-auto">
                            <img src="img/binance_coin.png" alt="BNB" class=" rounded-circle" style="height:20px;width:20px;">
                          </div>
                          <div class="col">
                            <div class="h6 mb-0">BNB</div>
                            <div class="text-muted" style="font-size:12px;">BNB</div>
                          </div>
                        </div>
                      </div>
                      <div class="float-right">
                        <div class="h6 mb-0"><?php echo number_format($bal_bnb_value, 10, '.', ''); ?></div>
                        <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($bnbbalance, 2); ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="row py-3">
                    <div class="col-12 px-sm-0 px-1">
                      <div class="float-left">
                        <div class="row">
                          <div class="col-auto">
                            <img src="img/cardano.png" alt="Cardano" class=" rounded-circle" style="height:20px;width:20px;">
                          </div>
                          <div class="col">
                            <div class="h6 mb-0">ADA</div>
                            <div class="text-muted" style="font-size:12px;">Cardano</div>
                          </div>
                        </div>
                      </div>
                      <div class="float-right">
                        <div class="h6 mb-0"><?php echo number_format($bal_ada_value, 8, '.', ''); ?></div>
                        <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($adabalance, 2); ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="row py-3">
                    <div class="col-12 px-sm-0 px-1">
                      <div class="float-left">
                        <div class="row">
                          <div class="col-auto">
                            <img src="img/proton.png" alt="Proton" class=" rounded-circle" style="height:20px;width:20px;">
                          </div>
                          <div class="col">
                            <div class="h6 mb-0">XPR</div>
                            <div class="text-muted" style="font-size:12px;">Proton</div>
                          </div>
                        </div>
                      </div>
                      <div class="float-right">
                        <div class="h6 mb-0"><?php echo number_format($bal_xpr_value, 8, '.', ''); ?></div>
                        <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($xprbalance, 2); ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="row py-3">
                    <div class="col-12 px-sm-0 px-1">
                      <div class="float-left">
                        <div class="row">
                          <div class="col-auto">
                            <img src="img/dogecoin.png" alt="Dogecoin" class=" rounded-circle" style="height:20px;width:20px;">
                          </div>
                          <div class="col">
                            <div class="h6 mb-0">DOGE</div>
                            <div class="text-muted" style="font-size:12px;">Dogecoin</div>
                          </div>
                        </div>
                      </div>
                      <div class="float-right">
                        <div class="h6 mb-0"><?php echo number_format($bal_doge_value, 8, '.', ''); ?></div>
                        <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($dogebalance, 2); ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="row py-3">
                    <div class="col-12 px-sm-0 px-1">
                      <div class="float-left">
                        <div class="row">
                          <div class="col-auto">
                            <img src="img/tether.png" alt="Tether" class=" rounded-circle" style="height:20px;width:20px;">
                          </div>
                          <div class="col">
                            <div class="h6 mb-0">USDT</div>
                            <div class="text-muted" style="font-size:12px;">Tether</div>
                          </div>
                        </div>
                      </div>
                      <div class="float-right">
                        <div class="h6 mb-0"><?php echo number_format($bal_usdt_value, 8, '.', ''); ?></div>
                        <div class="text-muted text-right" style="font-size:12px;">$<?php echo number_format($usdtbalance, 2); ?></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 px-sm-2 px-0">
              <div class="card rounded-0">
                <div class="card-body p-0">
                  <script>!function(){var e=document.getElementsByTagName("script"),t=e[e.length-1],n=document.createElement("script");function r(){var e=crCryptocoinPriceWidget.init({base:"USD,BTC,ETH,BNB",items:"BTC,ETH,BNB,ADA,LTC,TRX,BUSD,USDT",backgroundColor:"#454d55",streaming:"1",rounded:"0",boxShadow:"1",border:"1"});t.parentNode.insertBefore(e,t)}n.src="https://co-in.io/widget/pricelist.js?items=BTC%2CETH%2CBNB%2CADA%2CLTC%2CTRX%2CBUSD%2CUSDT",n.async=!0,n.readyState?n.onreadystatechange=function(){"loaded"!=n.readyState&&"complete"!=n.readyState||(n.onreadystatechange=null,r())}:n.onload=function(){r()},t.parentNode.insertBefore(n,null)}();</script>
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
    
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true, "searching": false, "processing": true,
        buttons: ['pdf', 'print']

      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });

    $(document).ready(function() {
      $('.buttons-pdf').removeClass('btn-secondary').addClass('btn-default rounded text-info mr-2');
      $('.buttons-print').removeClass('btn-secondary').addClass('btn-default rounded text-info');
      $('.buttons-pdf').html('<i class="fas fa-download"></i>');
      $('.buttons-print').html('<i class="fas fa-print"></i>');
      $('#example1_wrapper .col-md-6').removeClass('col-md-6 ').addClass('text-right');
    });
    $('.noclick').click(false);
  </script>
</body>
</html>