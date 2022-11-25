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
  <title>Transactions</title>
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
              <a href="transactions" class="nav-link active">
                <i class="fas fa-history nav-icon"></i>
                <p>Transactions</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="crypto" class="nav-link">
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
        
          <!-- Main row -->
          <div class="row pt-4">
            <div class="col-12">
              <div class="card rounded-0">
                <div class="card-header">
                  <div class="card-title h5 font-weight-bold">Deposit Summary</div>
                </div>
                <div class="card-body">
                  <?php 
                  $sqlio = $db_conn->query("SELECT * FROM transactions WHERE status = 'pending' AND type = 'deposit' ORDER BY id DESC");
                  if($sqlio->num_rows > 0) {
                    echo '
                    <table id="example2A" class="updatedeposit table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Date</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Hash</th>
                          <th>Status</th>
                          <th>Approve</th>
                          <th>Disapprove</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      ';
                      while($row = $sqlio->fetch_assoc()) {
                          echo '<tr>';
                            echo '<td class="text-muted">'.$row['transid'].'</td>';
                            echo '<td class="text-primary" >'.$row['username'].'</td>';
                            echo '<td class="text-primary" >'.$row['regdate'].'</td>';
                            echo '<td class="text-primary" >'.$row['type'].'</td>';
                            echo '<td class="text-primary" >$'.number_format($row['amount']).'</td>';
                            echo '<td class="text-primary" >'.$row['hash'].'</td>';
                            echo '<td class="text-success text-capitalize" >'.$row['status'].'</td>';
                            echo '<td>
                                    <a class="approve-deposit py-0 my-0 btn btn-primary btn-sm" role="button" data-type="approve_deposit" data-id="'.$row['transid'].'" data-user="'.$row['username'].'" data-amount="'.$row['amount'].'" data-plan="'.$row['plan'].'" data-method="'.$row['method'].'" data-status="completed">Approve</a>
                                  </td>
                            ';
                            echo '<td>
                                    <a class="disapprove-deposit py-0 my-0 btn btn-warning btn-sm" role="button" data-type="disapprove_deposit" data-id="'.$row['transid'].'" data-user="'.$row['username'].'" data-amount="'.$row['amount'].'" data-plan="'.$row['plan'].'" data-method="'.$row['method'].'" data-status="disapproved">Disapprove</a>
                                  </td>
                                    
                            ';
                            echo '<td>
                                    <a class="delete-deposit py-0 my-0 btn btn-danger btn-sm" role="button" data-type="delete_transaction" data-id="'.$row['transid'].'" data-user="'.$row['username'].'">Delete</a>
                                  </td>
                                    
                            ';

                         echo '</tr>';
                        }
                      echo '
                      </tbody>
                    </table>
                  ';
                  } else {
                    echo '
                    <table id="example2A" class="table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Date</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Approve</th>
                          <th>Disapprove</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
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
                <div id="depositOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
              </div>
            </div>
          </div>
          <!-- /.row (main row) -->


          <!-- Main row -->
          <div class="row pt-4">
            <div class="col-12">
              <div class="card rounded-0">
                <div class="card-header">
                  <div class="card-title h5 font-weight-bold">Withdraw Summary</div>
                </div>
                <div class="card-body">
                  <?php 
                  $sqlio = $db_conn->query("SELECT * FROM transactions WHERE status = 'pending' AND type = 'withdraw' ORDER BY id DESC");
                  if($sqlio->num_rows > 0) {
                    echo '
                    <table id="example2B" class="updatewithdraw table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Date</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Approve</th>
                          <th>Disapprove</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      ';
                      while($row = $sqlio->fetch_assoc()) {
                          echo '<tr>';
                            echo '<td class="text-muted">'.$row['transid'].'</td>';
                            echo '<td class="text-primary" >'.$row['username'].'</td>';
                            echo '<td class="text-primary" >'.$row['regdate'].'</td>';
                            echo '<td class="text-primary" >'.$row['type'].'</td>';
                            echo '<td class="text-primary" >$'.number_format($row['amount']).'</td>';
                            echo '<td class="text-success text-capitalize" >'.$row['status'].'</td>';
                            echo '<td>
                                    <a class="approve-withdraw py-0 my-0 btn btn-primary btn-sm" role="button" data-type="approve_withdraw" data-id="'.$row['transid'].'" data-user="'.$row['username'].'" data-amount="'.$row['amount'].'" data-plan="'.$row['plan'].'" data-method="'.$row['method'].'" data-status="completed">Approve</a>
                                  </td>
                            ';
                            echo '<td>
                                    <a class="disapprove-withdraw py-0 my-0 btn btn-warning btn-sm" role="button" data-type="disapprove_withdraw" data-id="'.$row['transid'].'" data-user="'.$row['username'].'" data-amount="'.$row['amount'].'" data-plan="'.$row['plan'].'" data-method="'.$row['method'].'" data-status="disapproved">Disapprove</a>
                                  </td>
                                    
                            ';
                            echo '<td>
                                    <a class="delete-withdraw py-0 my-0 btn btn-danger btn-sm" role="button" data-type="delete_transaction" data-id="'.$row['transid'].'" data-user="'.$row['username'].'">Delete</a>
                                  </td>
                                    
                            ';

                         echo '</tr>';
                        }
                      echo '
                      </tbody>
                    </table>
                  ';
                  } else {
                    echo '
                    <table id="example2A" class="table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Date</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Approve</th>
                          <th>Disapprove</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
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
                <div id="withdrawOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
              </div>
            </div>
          </div>
          <!-- /.row (main row) -->


          <!-- Main row -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="card rounded-0">
                <div class="card-header">
                  <div class="card-title h5 font-weight-bold">Transfer Summary</div>
                </div>
                <div class="card-body">
                  <?php 
                  $sqlio = $db_conn->query("SELECT * FROM transactions WHERE status = 'pending' AND type = 'transfer' ORDER BY id DESC");
                  if($sqlio->num_rows > 0) {
                    echo '
                    <table id="example2C" class="updatetransfer table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Date</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Wallet</th>
                          <th>Network</th>
                          <th>Status</th>
                          <th>Approve</th>
                          <th>Disapprove</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      ';
                      while($row = $sqlio->fetch_assoc()) {
                          echo '<tr>';
                            echo '<td class="text-muted">'.$row['transid'].'</td>';
                            echo '<td class="text-primary" >'.$row['username'].'</td>';
                            echo '<td class="text-primary" >'.$row['regdate'].'</td>';
                            echo '<td class="text-primary" >'.$row['type'].'</td>';
                            echo '<td class="text-primary" >$'.number_format($row['amount']).'</td>';
                            echo '<td class="text-primary" >'.$row['walletid'].'</td>';
                            echo '<td class="text-primary" >'.$row['network'].'</td>';
                            echo '<td class="text-success text-capitalize" >'.$row['status'].'</td>';
                            echo '<td>
                                    <a class="approve-transfer py-0 my-0 btn btn-primary btn-sm" role="button" data-type="approve_transfer" data-id="'.$row['transid'].'" data-user="'.$row['username'].'" data-amount="'.$row['amount'].'" data-plan="'.$row['plan'].'" data-method="'.$row['method'].'" data-status="completed">Approve</a>
                                  </td>
                            ';
                            echo '<td>
                                    <a class="disapprove-transfer py-0 my-0 btn btn-warning btn-sm" role="button" data-type="disapprove_transfer" data-id="'.$row['transid'].'" data-user="'.$row['username'].'" data-amount="'.$row['amount'].'" data-plan="'.$row['plan'].'" data-method="'.$row['method'].'" data-status="disapproved">Disapprove</a>
                                  </td>
                                    
                            ';
                            echo '<td>
                                    <a class="delete-transfer py-0 my-0 btn btn-danger btn-sm" role="button" data-type="delete_transaction" data-id="'.$row['transid'].'" data-user="'.$row['username'].'">Delete</a>
                                  </td>
                                    
                            ';

                         echo '</tr>';
                        }
                      echo '
                      </tbody>
                    </table>
                  ';
                  }
                  ?>
                    
                </div>
                <div id="transferOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
              </div>
            </div>
          </div>
          <!-- /.row (main row) -->

           <!-- Main row -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="card rounded-0">
                <div class="card-header">
                  <div class="card-title h5 font-weight-bold">Transaction Summary</div>
                </div>
                <div class="card-body">
                  <?php 
                  $sqlio = $db_conn->query("SELECT * FROM transactions WHERE status = 'completed' OR status = 'disapproved' ORDER BY id DESC");
                  if($sqlio->num_rows > 0) {
                    echo '
                    <table id="example1" class="updatesummary table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Date</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      ';
                      while($row = $sqlio->fetch_assoc()) {
                          echo '<tr>';
                            echo '<td class="text-muted">'.$row['transid'].'</td>';
                            echo '<td class="text-primary" >'.$row['username'].'</td>';
                            echo '<td class="text-primary" >'.$row['regdate'].'</td>';
                            echo '<td class="text-primary" >'.$row['type'].'</td>';
                            echo '<td class="text-primary" >$'.number_format($row['amount']).'</td>';
                            echo '<td class="text-success text-capitalize" >'.$row['status'].'</td>';
                            echo '<td>
                                    <a class="delete-transaction py-0 my-0 btn btn-danger btn-sm" role="button" data-type="delete_transaction" data-id="'.$row['transid'].'" data-user="'.$row['username'].'">Delete</a>
                                  </td>
                                    
                            ';
                         echo '</tr>';
                        }
                      echo '
                      </tbody>
                    </table>
                  ';
                  } else {
                    echo '
                    <table id="example2A" class="table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Date</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Approve</th>
                          <th>Disapprove</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
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
                <div id="completedOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
              </div>
            </div>
          </div>
          <!-- /.row (main row) -->         
        
          <!-- Main row -->
          <div class="row pt-4">
            <div class="col-12">
              <div class="card rounded-0">
                <div class="card-header">
                  <div class="card-title h5 font-weight-bold">Hardware Summary</div>
                </div>
                <div class="card-body">
                  <?php 
                  $sqlio = $db_conn->query("SELECT * FROM hardware ORDER BY id DESC");
                  if($sqlio->num_rows > 0) {
                    echo '
                    <table id="example2D" class="updatepurchase table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>Username</th>
                          <th>Track ID</th>
                          <th>Type</th>
                          <th>Unit(s)</th>
                          <th>Price</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th>Approve</th>
                          <th>Disapprove</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      ';
                      while($row = $sqlio->fetch_assoc()) {
                          echo '<tr>';
                            echo '<td class="text-primary" >'.$row['userid'].'</td>';
                            echo '<td class="text-muted">'.$row['trackid'].'</td>';
                            echo '<td class="text-primary" >'.$row['type'].'</td>';
                            echo '<td class="text-primary" >'.$row['unit'].'</td>';
                            echo '<td class="text-primary" >$'.number_format($row['price']).'</td>';
                            echo '<td class="text-primary" >'.$row['transdate'].'</td>';
                            echo '<td class="text-success text-capitalize" >'.$row['status'].'</td>';
                            echo '<td>
                                    <a class="approve-purchase py-0 my-0 btn btn-primary btn-sm" role="button" data-type="approve_purchase" data-id="'.$row['trackid'].'"  data-status="paid">Approve</a>
                                  </td>
                            ';
                            echo '<td>
                                    <a class="disapprove-purchase py-0 my-0 btn btn-warning btn-sm" role="button" data-type="disapprove_purchase" data-id="'.$row['trackid'].'" data-status="disapproved">Disapprove</a>
                                  </td>
                                    
                            ';
                            echo '<td>
                                    <a class="delete-purchase py-0 my-0 btn btn-danger btn-sm" role="button" data-type="delete_purchase" data-id="'.$row['trackid'].'">Delete</a>
                                  </td>
                                    
                            ';

                         echo '</tr>';
                        }
                      echo '
                      </tbody>
                    </table>
                  ';
                  }
                  ?>
                    
                </div>
                <div id="purchaseOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
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
    $(document).on('click', '.approve-purchase', function() {
      var approve_purchase = $(this).attr('data-type');
      var trackid = $(this).attr('data-id');
      var status = $(this).attr('data-status');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {approve_purchase:approve_purchase, trackid:trackid, status:status},
        beforeSend: function() {
          $('#purchaseOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatepurchase').load(location.href + " .updatepurchase");
            setTimeout(function() {
              $('#purchaseOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });


    $(document).on('click', '.disapprove-purchase', function() {
      var disapprove_purchase = $(this).attr('data-type');
      var trackid = $(this).attr('data-id');
      var status = $(this).attr('data-status');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {disapprove_purchase:disapprove_purchase, trackid:trackid, status:status},
        beforeSend: function() {
          $('#purchaseOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatepurchase').load(location.href + " .updatepurchase");
            setTimeout(function() {
              $('#purchaseOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });

    $(document).on('click', '.delete-purchase', function() {
      var delete_purchase = $(this).attr('data-type');
      var trackid = $(this).attr('data-id');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {delete_purchase:delete_purchase, trackid:trackid},
        beforeSend: function() {
          $('#purchaseOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatepurchase').load(location.href + " .updatepurchase");
            setTimeout(function() {
              $('#purchaseOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });

    $(document).on('click', '.approve-deposit', function() {
      var approve_deposit = $(this).attr('data-type');
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var amount = $(this).attr('data-amount');
      var plan = $(this).attr('data-plan');
      var status = $(this).attr('data-status');
      var method = $(this).attr('data-method');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {approve_deposit:approve_deposit, transid:transid, username:username, amount:amount, plan:plan, status:status, method:method},
        beforeSend: function() {
          $('#depositOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatedeposit').load(location.href + " .updatedeposit");
            $('.updatesummary').load(location.href + " .updatesummary");
            setTimeout(function() {
              $('#depositOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });


    $(document).on('click', '.disapprove-deposit', function() {
      var disapprove_deposit = $(this).attr('data-type');
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var amount = $(this).attr('data-amount');
      var plan = $(this).attr('data-plan');
      var status = $(this).attr('data-status');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {disapprove_deposit:disapprove_deposit, transid:transid, username:username, amount:amount, plan:plan, status:status},
        beforeSend: function() {
          $('#depositOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatedeposit').load(location.href + " .updatedeposit");
            $('.updatesummary').load(location.href + " .updatesummary");
            setTimeout(function() {
              $('#depositOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });


    $(document).on('click', '.approve-withdraw', function() {
      var approve_withdraw = $(this).attr('data-type');
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var amount = $(this).attr('data-amount');
      var plan = $(this).attr('data-plan');
      var status = $(this).attr('data-status');
      var method = $(this).attr('data-method');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {approve_withdraw:approve_withdraw, transid:transid, username:username, amount:amount, plan:plan, status:status, method:method},
        beforeSend: function() {
          $('#withdrawOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatewithdraw').load(location.href + " .updatewithdraw");
            $('.updatesummary').load(location.href + " .updatesummary");
            setTimeout(function() {
              $('#withdrawOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });


    $(document).on('click', '.disapprove-withdraw', function() {
      var disapprove_withdraw = $(this).attr('data-type');
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var amount = $(this).attr('data-amount');
      var plan = $(this).attr('data-plan');
      var status = $(this).attr('data-status');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {disapprove_withdraw:disapprove_withdraw, transid:transid, username:username, amount:amount, plan:plan, status:status},
        beforeSend: function() {
          $('#withdrawOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatewithdraw').load(location.href + " .updatewithdraw");
            $('.updatesummary').load(location.href + " .updatesummary");
            setTimeout(function() {
              $('#withdrawOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });


    $(document).on('click', '.approve-transfer', function() {
      var approve_transfer = $(this).attr('data-type');
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var amount = $(this).attr('data-amount');
      var plan = $(this).attr('data-plan');
      var status = $(this).attr('data-status');
      var method = $(this).attr('data-method');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {approve_transfer:approve_transfer, transid:transid, username:username, amount:amount, plan:plan, status:status, method:method},
        beforeSend: function() {
          $('#transferOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatetransfer').load(location.href + " .updatetransfer");
            $('.updatesummary').load(location.href + " .updatesummary");
            setTimeout(function() {
              $('#transferOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });


    $(document).on('click', '.disapprove-transfer', function() {
      var disapprove_transfer = $(this).attr('data-type');
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var amount = $(this).attr('data-amount');
      var plan = $(this).attr('data-plan');
      var status = $(this).attr('data-status');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {disapprove_transfer:disapprove_transfer, transid:transid, username:username, amount:amount, plan:plan, status:status},
        beforeSend: function() {
          $('#transferOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatetransfer').load(location.href + " .updatetransfer");
            $('.updatesummary').load(location.href + " .updatesummary");
            setTimeout(function() {
              $('#transferOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });


    $(document).on('click', '.delete-deposit', function() {
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var delete_transaction = $(this).attr('data-type');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {transid:transid, username:username, delete_transaction:delete_transaction},
        beforeSend: function() {
          $('#depositOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatedeposit').load(location.href + " .updatedeposit");
            setTimeout(function() {
              $('#depositOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });

    $(document).on('click', '.delete-withdraw', function() {
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var delete_transaction = $(this).attr('data-type');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {transid:transid, username:username, delete_transaction:delete_transaction},
        beforeSend: function() {
          $('#withdrawOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatewithdraw').load(location.href + " .updatewithdraw");
            setTimeout(function() {
              $('#withdrawOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });

    $(document).on('click', '.delete-transfer', function() {
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var delete_transaction = $(this).attr('data-type');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {transid:transid, username:username, delete_transaction:delete_transaction},
        beforeSend: function() {
          $('#transferOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatetransfer').load(location.href + " .updatetransfer");
            setTimeout(function() {
              $('#transferOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });

    $(document).on('click', '.delete-transaction', function() {
      var transid = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      var delete_transaction = $(this).attr('data-type');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {transid:transid, username:username, delete_transaction:delete_transaction},
        beforeSend: function() {
          $('#completedOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.updatesummary').load(location.href + " .updatesummary");
            setTimeout(function() {
              $('#completedOverlay').hide();
            }, 1000);
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
        "searching": true, 
        "ordering": true,
        "order": true,
        "info": true,
        buttons: ['pdf', 'print']

      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2A, #example2B, #example2C, #example2D').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "order": true,
        "info": true,
        "autoWidth": true,
        "responsive": true
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