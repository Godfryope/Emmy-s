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
  <title>Accounts</title>
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

  <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header border-0 px-sm-4 px-2">
          <h4>Update Account (Profit/Bonus)</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body px-sm-4 px-2">
          <div id="getUserAccount">
            <form id="enterUserDetails">
              <div class="form-group mb-0">
                <label for="exampleInput1" style="font-weight: normal;">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" id="username" class="form-control bg-light" required/>

              </div>

              <div class="form-group py-0">
                <p class="text-danger response_msg" style="font-size:12px;"></p>
              </div>

              <div class="form-group d-flex justify-content-end">
                <button type="button" id="getUserAccountBtn" class="btn btn-default">Continue</button>
              </div>
            </form>
          </div>


          <div id="updateUserAccount" style="display: none;">
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editAccModal" tabindex="-1" role="dialog" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="col-12">
            <div class="card mb-0 border-0 rounded-0 shadow-none">
              <div class="card-body">
                <div id="editUserAccount">
                  <form id="editUserAccForm" class="row">
                    <div class="col-12 h4 text-muted text-capitalize">Name of user</div>
                    <input type="hidden" name="edit_user">
                    <div class="col-sm-6">
                      <div class="form-group"><label>Total Balance</label><input type="text" class="form-control" name="totalbalance" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group"><label>Active Deposit</label><input type="text" class="form-control" name="activedeposit" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group"><label>Last Deposit</label><input type="text" class="form-control" name="lastdeposit" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group"><label>Total Deposit</label><input type="text" class="form-control" name="totaldeposit" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group"><label>Last Withdrawal</label><input type="text" class="form-control" name="lastwithdrawal" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group"><label>Total Withdrawal</label><input type="text" class="form-control" name="totalwithdrawal" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group"><label>Profit</label><input type="text" class="form-control" name="earn" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group"><label>Bonus</label><input type="text" class="form-control" name="bonus" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn primary"></button>
                    </div>
                  </form>
                </div>
                  
              </div>
              <div id="editUserOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
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
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        
      </ul>

      <ul class="navbar-nav">
        <li class="nav-item">
          <a id="getUpdateModal" class="btn btn-primary btn-sm float-right py-0">Update Account <span class="fas fa-edit"></span></a>
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
              <a href="accounts" class="nav-link active">
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
                <div class="card-body">
                  <?php 
                  $mysqli = $db_conn->query("SELECT * FROM account ORDER BY id DESC");
                  if($mysqli->num_rows > 0) {
                    echo '
                    <table id="example1" class="update table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Status</th>
                          <th>Plan</th>
                          <th>Balance</th>
                          <th>A. Deposit</th>
                          <th>Profit</th>
                          <th>Bonus</th>
                          <th>Earnings</th>
                          <th>Action</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>';
                      while($row = $mysqli->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>'.$row['id'].'</td>';
                        echo '<td class="text-primary" >'.$row['username'].'</td>';
                        $status = $row['status'];
                        if ($status == 'suspended') {
                          echo '<td class="edit1 text-danger text-capitalize" >'.$row['status'].'</td>';
                        } else {
                          echo '<td class="text-success text-capitalize edit1" >'.$row['status'].'</td>';
                        }
                        echo '<td class="text-primary" >'.$row['plan'].'</td>';
                        echo '<td class="text-primary" >'.number_format($row['totalbalance']).'</td>';
                        echo '<td class="text-primary" >'.number_format($row['activedeposit']).'</td>';
                        echo '<td class="text-primary" >'.number_format($row['earn']).'</td>';
                        echo '<td class="text-primary" >'.number_format($row['bonus']).'</td>';
                        echo '<td><a class="add py-0 my-0 btn btn-dark btn-sm" role="button" data-user="'.$row['username'].'">Update</a></td>';
                        $status = $row['status'];
                        if ($status == 'suspended') {
                          $status_btn = "Activate";
                        } else {
                          $status_btn = "Deactivate";
                        }
                        echo '<td class="edit2"><a class="status py-0 my-0 btn btn-info btn-sm" role="button" data-user="'.$row['username'].'" data-type="'.$row['status'].'">'.$status_btn.'</a></td>';
                        echo '<td><a class="edit_acc py-0 my-0 btn btn-danger btn-sm" role="button"  data-id="'.$row['id'].'"data-user="'.$row['username'].'" data-type="edit_acc">Edit</a></td>';
                        echo '</tr>';
                      }echo '</tbody>
                    </table>
                  ';
                  } 
                  ?>
                    
                </div>
                <div id="editOverlay" class="overlay" style="display: none;"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
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
        <div class="">All Rights Reserved &copy; 2018-<?php echo date("Y"); ?></div>
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
    $(document).on('click', '.status', function() {
      var username = $(this).attr('data-user');
      var user_status = $(this).attr('data-type');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {username:username, user_status:user_status},
        beforeSend: function() {
          $('#editOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('.update').load(location.href + " .update");
            setTimeout(function() {
              $('#editOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });

    $(document).on('click', '.add', function () {
      var username = $(this).attr('data-user');
     
      $.ajax({
        url: 'get-acc.php',
        type: 'POST',
        data: {username:username},
        beforeSend: function() {
          $('#editOverlay').show();
        },
        success: function(data) {
          $('#editOverlay').hide();
          $('#updateModal').modal('show');
          $('#getUserAccount').hide();
          $('#updateUserAccount').show();
          $('#updateUserAccount').html(data);
        }
      });
    });

    $(document).on('click', '.edit_acc', function () {
      var username = $(this).attr('data-user');
      var edit_acc = $(this).attr('data-type');
      var userid = $(this).attr('data-id');
     
      $.ajax({
        url: 'get-user.php',
        type: 'POST',
        data: {username:username, edit_acc:edit_acc, userid:userid},
        beforeSend: function() {
          $('#editUserOverlay').show();
        },
        success: function(data) {
          $('#editAccModal').modal('show');
          setTimeout(function() {
            $('#editUserAccount').html(data);
          }, 1000);
          setTimeout(function() {
            $('#editUserOverlay').hide();
          }, 2000);
        }
      });
    });

    $(document).on('click', '#getUpdateModal', function() {
      $('#updateModal').modal('show');
    });

    $('#getUserAccountBtn').click(function () {
      var username = $('#username').val();
      if(username == ''){
        $('.response_msg').html('Enter a username');
      }
      else{
        $('#getUserAccount').hide();
        $('#updateUserAccount').show();
      }
      
      get_acc();
    });

    $('#closeModal').click(function () {
      $('#updateUserAccount').hide();
      $('#enterUserDetails')[0].reset();
      $('#getUserAccount').show();
    });

    $(document).on('click', '#closeModalBtn', function() {
      $('#updateUserAccount').hide();
      $('#enterUserDetails')[0].reset();
      $('#getUserAccount').show();
      $('#updateModal').modal('hide');
      $('.response_msg').html('');
    });

    function get_acc() {
      var username = $('#username').val();
      $.ajax({
        url: 'get-acc.php',
        type: 'POST',
        data: {username:username},
        success: function(data) {
          $('#updateUserAccount').html(data);
        }
      });
    }

    $(document).on('submit', '#editUserAccForm', function(e) {
      e.preventDefault();
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#editUserAccForm').css("opacity",".5");
          $('#editUserOverlay').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#editUserAccForm').css("opacity","");
            $('#editAccModal').modal('hide');
            $('.update').load(location.href + " .update");
          }
        }
      });
    });

    $(document).on('submit', '#addProfit', function(e) {
      e.preventDefault();
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#addProfit').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#addBonus')[0].reset();
            $('#addBonus').css("opacity","");
            $('#loading').hide();
            $('#updateUserAccount').html(''+response.message+'');
            $('.update').load(location.href + " .update");
          }
        }
      });
    });

    $(document).on('submit', '#addBonus', function(e) {
      e.preventDefault();
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        encode: true,
        beforeSend:function() {
          $('#addBonus').css("opacity",".5");
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#addBonus')[0].reset();
            $('#addBonus').css("opacity","");
            $('#loading').hide();
            $('#updateUserAccount').html(''+response.message+'');
            $('.update').load(location.href + " .update");
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
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "order": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });

    $(document).ready(function() {
      $('.buttons-pdf').removeClass('btn-secondary').addClass('btn-default btn-sm py-0 rounded text-primary mr-2');
      $('.buttons-print').removeClass('btn-secondary').addClass('btn-default btn-sm py-0 rounded text-primary');
      $('.buttons-pdf').html('Download <i class="fas fa-download"></i>');
      $('.buttons-print').html('Print <i class="fas fa-print"></i>');
      $('#example1_wrapper .col-md-6').removeClass('col-md-6 ').addClass('pb-2');
    });
  </script>
</body>
</html>