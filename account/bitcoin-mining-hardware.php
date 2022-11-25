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
  <title>Buy Bitcoin Mining Hardware - BexCrypt</title>
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
  <style>.referral{cursor: copy;}</style>
  <style>
    .rounded-5 {
      border-radius: 10px;
    }
    .ribbon {
      position: absolute;
      right: -5px;
      top: -5px;
      z-index: 1;
      overflow: hidden;
      width: 93px;
      height: 93px;
      text-align: right;
    }
    .ribbon span {
      font-size: 0.8rem;
      color: #fff;
      text-transform: uppercase;
      text-align: center;
      font-weight: bold;
      line-height: 32px;
      transform: rotate(45deg);
      width: 125px;
      display: block;
      background: #79a70a;
      background: linear-gradient(#9bc90d 0%, #79a70a 100%);
      box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
      position: absolute;
      top: 17px;
      right: -29px;
    }

    .ribbon span::before {
       content: '';
       position: absolute; 
       left: 0px; top: 100%;
       z-index: -1;
       border-left: 3px solid #79A70A;
       border-right: 3px solid transparent;
       border-bottom: 3px solid transparent;
       border-top: 3px solid #79A70A;
    }
    .ribbon span::after {
       content: '';
       position: absolute; 
       right: 0%; top: 100%;
       z-index: -1;
       border-right: 3px solid #79A70A;
       border-left: 3px solid transparent;
       border-bottom: 3px solid transparent;
       border-top: 3px solid #79A70A;
    }
    .blue span {
      background: linear-gradient(#2989d8 0%, #1e5799 100%);
    }
    .blue span::before {
      border-left-color: #1e5799;
      border-top-color: #1e5799;
    }
    .blue span::after {
      border-right-color: #1e5799;
      border-top-color: #1e5799;
    }
    .qtySelector{
      border: 1px solid #ddd;
      width: 107px;
      height: 35px;
    }
    .qtySelector .fa{
      padding: 10px 5px;
      width: 35px;
      height: 100%;
      float: left;
      cursor: pointer;
    }
    .qtySelector .fa.clicked{
      font-size: 12px;
      padding: 12px 5px;
    }
    .qtySelector .fa-minus{
      border-right: 1px solid #ddd;
    }
    .qtySelector .fa-plus{
      border-left: 1px solid #ddd;
    }
    .qtySelector .qtyValue{
      border: none;
      padding: 5px;
      width: 35px;
      height: 100%;
      float: left;
      text-align: center
    }
  </style>
</head>
<body id="results" class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">

  <!-- Modal -->
  <div class="modal fade" id="orderHistoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-5">
        <div id="loading" class="overlay"><i class="fas fa-4x fa-sync fa-spin"></i></div>
        <div class="modal-header border-0">
          <div class="modal-title h5">Hardware Purchase</div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card shadow-none border-0">
            <div class="card-body text-center pt-0">
              <div id="orderHistory" style="display:none;">
                <div id="response_icon" class="pb-5">
                  <i class="far fa-6x fa-check-circle text-success"></i>
                </div>

                <div id="hardware_comment" class="card-text h4 font-weight-bold">
                  Payment successful!
                </div>
                <div id="hardware_message" class="card-text py-4 px-sm-4">
                  Your purchase order has been sent. Transaction ID: 5390387
                </div>
                <button id="payBtn" type="button" class="btn btn-default px-4" data-dismiss="modal">Finish</button>
              </div>

              <form id="orderHistoryForm" class="text-left" style="display:none;">
                <input type="hidden" id="userid" name="userid" value="<?php echo $username ?>">
                <input type="hidden" id="costPrice" name="cost" value="">
                <input type="hidden" id="hardware_type" name="type" value="">
                <input type="hidden" id="unitPrice1" name="price" value="">
                <input type="hidden" id="units" name="units" value="1">
                <input type="hidden" name="pay">
                <div class="row">
                  <div id="hardware_img" class="col-auto" style="max-width: 7.5rem;"></div>
                  <div class="col-auto">
                    <div class="hardware_type card-text h5 font-weight-bold"></div>
                    <div class="unit-price card-text"></div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-auto my-auto h-100 font-weight-bold">Unit(s): <span class="unit-value">1</span></div>
                  <div class="col">
                    <div class="qtySelector text-center float-right">
                      <i class="fa fa-minus decreaseQty"></i>
                      <input type="text" name="units" class="qtyValue" value="1" />
                      <i class="fa fa-plus increaseQty"></i>
                    </div>
                  </div>
                </div>

                <div class="card-title w-100 border-bottom my-3">
                  Order Summary
                </div>
                <div class="row">
                  <div class="col h-100 my-auto"><span class="unit-value">1</span> &times; <span class="hardware_type"></span></div>
                  <div class="col-auto" style="width:150px;">
                    <span id="unitPrice2" class="rounded-5 border-0 bg-light text-center px-4 py-2"></span>
                  </div>
                </div>
                <div class="row"></div>
                <div class="form-group mt-4 mb-0 pb-0">
                  <button type="submit" class="btn btn-outline-primary px-4">Pay</button>
                  <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">Cancel</button>
                </div>
              </form>
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
    <nav class="main-header navbar navbar-expand navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        
      </ul>
     
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        
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
              <a href="dashboard" class="nav-link active">
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
        <div class="container px-sm-4">
          <div class="row">

            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Antminer S19j Pro 104 TH" data-price="12500" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/Antminer_S19_Pro.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Antminer S19j Pro 104 TH (AHM)</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$12500</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">104 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3150 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Antminer S19j Pro 104 TH" data-price="12500" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Antminer S19 Pro" data-price="21000" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/Antminer_S19_Pro.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Antminer S19 Pro</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$21000</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">110 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3250 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Antminer S19 Pro" data-price="21000" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Antminer Z15" data-price="20000" data-id="<?php echo $username; ?>" data-hardware="Antminer_Z15.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/Antminer_Z15.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Antminer Z15</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$20000</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">420 kSol/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">1510 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Antminer Z15" data-price="20000" data-id="<?php echo $username; ?>" data-hardware="Antminer_Z15.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Whatsminer M30S+ 100 TH" data-price="15000" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M30S.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/WhatsMiner_M30S.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Whatsminer M30S+ 100 TH</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$15000</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">100 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3400 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Whatsminer M30S+ 100 TH" data-price="15000" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M30S.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Whatsminer M32 68 TH" data-price="8900" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M32.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/WhatsMiner_M32.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Whatsminer M32 68 TH</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$8900</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">68 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3400 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Whatsminer M32 68 TH" data-price="8900" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M32.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Whatsminer M32 66 TH" data-price="9000" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M32.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/WhatsMiner_M32.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Whatsminer M32 66 TH</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$9000</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">66 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3300 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Whatsminer M32 66 TH" data-price="9000" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M32.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Whatsminer M31S 74 TH" data-price="11000" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M31S.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/WhatsMiner_M31S.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Whatsminer M31S 74 TH</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$11000</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">74 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3404 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Whatsminer M31S 74 TH" data-price="11000" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M31S.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Whatsminer M32 68 TH" data-price="11000" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M31S.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/WhatsMiner_M31S.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Whatsminer M32 68 TH</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$11000</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">68 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3400 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Whatsminer M32 68 TH" data-price="11000" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M31S.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Whatsminer M31S 74 TH" data-price="11222" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M31S.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/WhatsMiner_M31S.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Whatsminer M31S 74 TH</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$11222</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">74 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3404 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Whatsminer M31S 74 TH" data-price="11000" data-id="<?php echo $username; ?>" data-hardware="WhatsMiner_M31S.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Antminer T19 84 TH" data-price="11500" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/Antminer_S19_Pro.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Antminer T19 84 TH</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$11500</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">84 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3150 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Antminer T19 84 TH" data-price="11500" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="AvalonMiner 1166 Pro" data-price="12000" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/Antminer_S19_Pro.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">AvalonMiner 1166 Pro</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$12000</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">78 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3400 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="AvalonMiner 1166 Pro" data-price="12000" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 mb-4">
              <div class="card border-0 shadow-none rounded-5">
                <div class="ribbon blue"><span>New</span></div>
                <div class="card-header bg-transparent border-0">
                  <div class="card-title font-weight-bold">Hosted at Home</div>
                </div>
                <div class="mx-auto" style="width: 60%;">
                  <a data-type="Antminer T19 81 TH" data-price="8100" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" role="button" class="buy_hardware"><img class="card-img-top" height="200" src="mining-hardware/Antminer_S19_Pro.png" alt="..."></a>
                </div>
                <div class="card-body">
                  <div class="h5 mb-4 font-weight-bold w-100">Antminer T19 81 TH (AHM)</div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Price:</p>
                    <p class="text-dark mb-2">$8100</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Hashrate:</p>
                    <p class="text-dark mb-2">81 TH/s</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Energy Cons:</p>
                    <p class="text-dark mb-2">3050 Watts</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Minimum Order:</p>
                    <p class="text-dark mb-2">1 units</p>
                  </div>
                  <div class="card-text d-flex w-100">
                    <p class="text-muted mb-2" style="width: 7.25rem;">Shipping date:</p>
                    <p class="text-dark font-weight-bold mb-2">2-3 Weeks</p>
                  </div>
                  <div class="card-footer bg-transparent text-center mt-4">
                    <a data-type="Antminer T19 81 TH" data-price="8100" data-id="<?php echo $username; ?>" data-hardware="Antminer_S19_Pro.png" class="buy_hardware btn btn-dark px-4 py-2 font-weight-bold">Buy & Ship <i class="fas fa-arrow-right pl-2"></i></a>
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
    var minVal = 1, maxVal = 20; // Set Max and Min values
    // Increase product quantity on cart page
    $(".increaseQty").on('click', function(){
        var cost = $("#costPrice").val();
        var $parentElm = $(this).parents(".qtySelector");
        $(this).addClass("clicked");
        setTimeout(function(){
          $(".clicked").removeClass("clicked");
        },100);
        var value = $parentElm.find(".qtyValue").val();
        if (value < maxVal) {
          value++;
        }
        var price = cost * value;
        $parentElm.find(".qtyValue").val(value);
        $("#units").val(value);
        $(".unit-value").html(value);
        $("#unitPrice1").val(price);
        $("#unitPrice2").html(price);
        formatValue();
    });
    // Decrease product quantity on cart page
    $(".decreaseQty").on('click', function(){
        var cost = $("#costPrice").val();
        var $parentElm = $(this).parents(".qtySelector");
        $(this).addClass("clicked");
        setTimeout(function(){
          $(".clicked").removeClass("clicked");
        },100);
        var value = $parentElm.find(".qtyValue").val();
        if (value > 1) {
          value--;
        }
        var price = cost * value;
        $parentElm.find(".qtyValue").val(value);
        $("#units").val(value);
        $(".unit-value").html(value);
        $("#unitPrice1").val(price);
        $("#unitPrice2").html(price);
        formatValue();
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

    $(document).on('click', '.buy_hardware', function() {
      var userid = $(this).attr('data-id');
      var type = $(this).attr('data-type');
      var price = $(this).attr('data-price');
      var buy = $(this).attr('data-type');
      var hardware = $(this).attr('data-hardware');

      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: {userid:userid, type:type, price:price, buy:buy, hardware:hardware},
        dataType: 'json',
        encode: true,
        success: function(response) {
          if(response.status == '1') {
            $('#orderHistoryModal').modal('show');
            $('#orderHistory').hide();
            $('#orderHistoryForm').show();
            $('#costPrice').val(response.price);
            $('#hardware_type').val(response.type);
            $('.hardware_type').html(response.type);
            $('#unitPrice1').val(response.price);
            $('#unitPrice2').html(response.price);
            $('.unit-price').html(response.price);
            $('#hardware_img').html(response.hardware);
            formatValue();
            formatNumber();
            setTimeout(function() {
              $('#loading').hide();
            }, 1000);
          }
        }
      });
    });



    $(document).on('submit', '#orderHistoryForm', function(e) {
      e.preventDefault();
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        success: function(response) {
          if(response.status == '1') {
            $('#orderHistoryForm').hide();
            $('#orderHistory').show();
            $('#hardware_message').html(''+response.message+'').removeClass('text-danger').addClass('text-success');
            $('#response_icon').html('<i class="far fa-6x fa-check-circle"></i>').removeClass('text-danger').addClass('text-success');
            $('#hardware_comment').html(''+response.type+'');
            $('#payBtn').html('Finish');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
          }
          else {
            $('#orderHistoryForm').hide();
            $('#orderHistory').show();
            $('#hardware_message').html(''+response.message+'').removeClass('text-success').addClass('text-danger');
            $('#response_icon').html('<i class="far fa-6x fa-file-excel fa-rotate-90"></i>').removeClass('text-danger').addClass('text-success');
            $('#hardware_comment').html(''+response.type+'');
            $('#payBtn').html('Close');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
          }
        }
      });
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

    function formatValue() {
      let x = document.querySelectorAll('#unitPrice2');
      for (let i = 0, len = x.length; i < len; i++) {
       let num = Number(x[i].innerHTML) 
                  .toLocaleString('en',{ style: 'currency', currency: 'USD'}); 
        x[i].innerHTML = num;
      }
    }

    function formatNumber() {
      let x = document.querySelectorAll('.unit-price');
      for (let i = 0, len = x.length; i < len; i++) {
       let num = Number(x[i].innerHTML) 
                  .toLocaleString('en',{ style: 'currency', currency: 'USD'}); 
        x[i].innerHTML = num;
      }
    }

    formatValue();
    formatNumber();
  </script>
</body>
</html>