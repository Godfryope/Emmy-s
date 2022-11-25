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
  <title>Users</title>
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

  <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header border-0 px-sm-4 px-2">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body px-sm-4 px-2">
          <div id="viewInfo">
            
          </div>
        </div>
        <div class="modal-footer border-0 px-sm-4 px-2">
          <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" id="closeModal">
            <span aria-hidden="true">Close</span>
          </button>
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
              <a href="users" class="nav-link active">
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
                <div class="card-body" id="displayUsers">
                  <?php 
                  $mysqli = $db_conn->query("SELECT * FROM users ORDER BY id DESC");
                  if($mysqli->num_rows > 0) {
                    echo '
                    <table id="example1" class="table table-sm table-hover" style="font-size: 14px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Name</th>
                          <th>E-mail</th>
                          <th>Password</th>
                          <th>Reg. Date</th>
                          <th>Plan</th>
                          <th>Confirmation</th>
                          <th>Status</th>
                          <th>Verification</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      ';
                      while($row = $mysqli->fetch_assoc()) {
                          echo '<tr>';
                            echo '<td>'.$row['id'].'</td>';
                            echo '<td class="text-primary" >'.$row['username'].'</td>';
                            echo '<td class="text-primary" >'.$row['firstname'].' '.$row['lastname'].'</td>';
                            echo '<td class="text-primary" >'.$row['email'].'</td>';
                            echo '<td class="text-primary" >'.$row['password'].'</td>';
                            echo '<td class="text-primary" >'.$row['regdate'].'</td>';
                            echo '<td class="text-primary" >'.$row['plan'].'</td>';
                            echo '<td class="text-primary" >'.$row['confirmation'].'</td>';
                            $status = $row['verification'];
                            if ($status == 'unverified') {
                              $status = '<span class="text-danger text-capitalize">'.$row['verification'].'</span>';
                            } 
                            elseif ($status == 'pending') {
                              $status = '<span class="text-warning text-capitalize">'.$row['verification'].'</span>';
                            }
                            elseif ($status == 'pending') {
                              $status = '<span class="text-success text-capitalize">'.$row['verification'].'</span>';
                            }
                            echo '<td class="text-primary" >'.$status.'</td>';
                          $verification = $row['verification'];
                          if ($verification == 'unverified') {
                            echo '<td class="text-info">No data</td>';
                          } else {
                            echo '<td>
                            <a class="view py-0 my-0 btn btn-info btn-sm" role="button" data-user="'.$row['username'].'" data-type="view_user">View</a>
                          </td>';
                          }
                            echo '<td>
                                    <a class="delete py-0 my-0 btn btn-danger btn-sm" role="button" data-user="'.$row['username'].'" data-type="delete_user">Delete</a>
                                  </td>';
                            
                          echo '</tr>';
                        }
                      echo '
                      </tbody>
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
    $(document).on('click', '.delete', function() {
      var username = $(this).attr('data-user');
      var delete_user = $(this).attr('data-type');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {username:username, delete_user:delete_user},
        beforeSend: function() {
          $('#editOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('#displayUsers').load(location.href + " #displayUsers");
            setTimeout(function() {
              $('#editOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });

    $(document).on('click', '.view', function() {
      var username = $(this).attr('data-user');
      var view_user = $(this).attr('data-type');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {username:username, view_user:view_user},
        beforeSend: function() {
          $('#editOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('#editOverlay').hide();
            $('#viewInfo').html(response.message);
            $('#viewInfoModal').modal('show');
          }
        }
      });
      
    });


    $(document).on('click', '#verifyBtn', function() {
      var username = $(this).attr('data-user');
      var verify = $(this).attr('data-verify');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {username:username, verify:verify},
        success: function (response) {
          if (response.status == '1') {
            $('#viewInfoModal').modal('hide');
            $('#displayUsers').load(location.href + " #displayUsers");
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
      $('.buttons-pdf').removeClass('btn-secondary').addClass('btn-default btn-sm rounded text-primary mr-2');
      $('.buttons-print').removeClass('btn-secondary').addClass('btn-default btn-sm rounded text-primary');
      $('.buttons-pdf').html('Download <i class="fas fa-download"></i>');
      $('.buttons-print').html('Print <i class="fas fa-print"></i>');
      $('#example1_wrapper .col-md-6').removeClass('col-md-6 ').addClass('pb-2');
    });
  </script>
</body>
</html>