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
  <title>Support</title>
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
              <a href="support" class="nav-link active">
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
                  <div class="row">
                    <div class="col-md-3">
                      <a role="button" id="composeMsgDivBtn" class="btn btn-primary btn-block mb-3">Compose</a>

                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Customers</h3>

                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body p-0">
                          <ul class="nav nav-pills flex-column">
                            <?php
                            $mysqli = $db_conn->query("SELECT * FROM help ORDER BY id DESC");
                            if ($mysqli->num_rows > 0) {
                              while ($row = $mysqli->fetch_assoc()) {
                                echo '
                                <li class="nav-item text-capitalize">
                                  <a class="msg nav-link" role="button" data-id="'.$row['id'].'" data-type="getmsg">'.$row['name'].' <span class="float-right text-success text-sm"><i class="fas fa-star"></i></span></a>
                                </li>
                                ';
                              }
                            } else {
                                echo '
                                <li class="nav-item">
                                    <a class="nav-link">No messages</a>
                                </li>
                                ';
                            }
                            ?>
                                
                          </ul>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                      <div class="card card-primary card-outline" id="displayMsgDiv">
                        <div class="card-header">
                          <h3 class="card-title">Read Mail</h3>
                        </div>


                        <!-- /.card-header -->
                        <div id="displayMsg" class="card-body px-2">
                          <div class="mailbox-read-info">
                            <h5>Message Subject Is Placed Here</h5>
                            <h6>From: support@adminlte.io
                              <span class="mailbox-read-time float-right">15 Feb. 2015 11:03 PM</span></h6>
                          </div>
                          <!-- /.mailbox-read-info -->
                          <div class="mailbox-controls with-border text-center">
                            <div class="btn-group">
                              <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
                                <i class="far fa-trash-alt"></i>
                              </button>
                              <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                                <i class="fas fa-reply"></i>
                              </button>
                              <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                                <i class="fas fa-share"></i>
                              </button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm" title="Print">
                              <i class="fas fa-print"></i>
                            </button>
                          </div>
                          <!-- /.mailbox-controls -->
                          <div class="mailbox-read-message">
                            <p class="text-center text-info">Click on a user to view message</p>
                          </div>
                          <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.card-body -->
                        <div id="msgOverlay" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                       
                        <!-- /.card-footer -->
                        <div class="card-footer">
                          <div class="float-right">
                            <button type="button" id="replyMsgDivBtn" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                            
                          </div>
                          <button type="button" id="forwardMsgDivBtn" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
                        </div>
                        <!-- /.card-footer -->
                      </div>
                      <!-- /.card -->

                      <div class="card card-primary card-outline" id="composeMsgDiv" style="display:none">
                        <div class="card-header">
                          <h3 class="card-title">Compose New Message</h3>
                        </div>
                        <form id="composeMessage" enctype="multipart/form-data">
                          <input type="hidden" name="compose">
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="form-group">
                              <input type="email" name="email" class="form-control" placeholder="To:">
                            </div>
                            <div class="form-group">
                              <input type="text" name="subject" class="form-control" placeholder="Subject:">
                            </div>
                            <div class="form-group">
                                <textarea name="message" id="compose-textarea" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                              <div class="btn btn-default btn-file">
                                <i class="fas fa-paperclip"></i> Attachment
                                <input type="file" name="attachment">
                              </div>
                              <p class="help-block">Max. 32MB</p>
                            </div>
                          </div>

                          <!-- /.card-body -->
                          <div class="card-footer">
                            <div class="float-right">
                              <button type="button" id="cancelComposeDiv" class="btn btn-default"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                          </div>
                          <!-- /.card-footer -->
                        </form>

                        <div id="composeOverlay" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                      </div>
                      <!-- /.card -->

                      <div class="card card-primary card-outline" id="replyMsgDiv" style="display:none">
                        <div class="card-header">
                          <h3 class="card-title">New Message</h3>
                        </div>
                        <form id="replyMessage" enctype="multipart/form-data">
                          <input type="hidden" name="reply">
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="form-group">
                              <input type="email" name="email" class="form-control" placeholder="To:">
                            </div>
                            <div class="form-group">
                              <input type="text" name="subject" class="form-control" placeholder="Subject:">
                            </div>
                            <div class="form-group">
                                <textarea name="message" id="compose-textarea" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                              <div class="btn btn-default btn-file">
                                <i class="fas fa-paperclip"></i> Attachment
                                <input type="file" name="attachment">
                              </div>
                              <p class="help-block">Max. 32MB</p>
                            </div>
                          </div>

                          <!-- /.card-body -->
                          <div class="card-footer">
                            <div class="float-right">
                              <button type="button" id="cancelReplyDiv" class="btn btn-default"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                          </div>
                          <!-- /.card-footer -->
                        </form>

                        <div id="replyOverlay" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                      </div>
                      <!-- /.card -->

                    </div>
                    <!-- /.col -->
                  </div>
                </div>
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
    $(document).on('click', '.msg', function() {
      var id = $(this).attr('data-id');
      var getmsg = $(this).attr('data-type');
      $.ajax({
        url: 'server.php',
        type: 'POST',
        dataType: 'json',
        data: {id:id, getmsg:getmsg},
        beforeSend: function() {
          $('#composeMsgDiv').hide();
          $('#replyMsgDiv').hide();
          $('#displayMsgDiv').show();
          $('#msgOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            $('#displayMsg').html(response.message);
            setTimeout(function() {
              $('#msgOverlay').hide();
            }, 1000);
          }
        }
      });
      
    });

    $(document).on('click', '#composeMsgDivBtn', function() {
      $('#displayMsgDiv').hide();
      $('#composeMsgDiv').show();
      setTimeout(function() {
        $('#composeOverlay').hide();
      }, 1000);
    });

    $(document).on('click', '#forwardMsgDivBtn, #replyMsgDivBtn', function() {
      $('#displayMsgDiv').hide();
      $('#replyMsgDiv').show();
      setTimeout(function() {
        $('#replyOverlay').hide();
      }, 1000);
    });

    $(document).on('click', '#cancelComposeDiv', function() {
      $('#composeMsgDiv').hide();
      $('#displayMsgDiv').show();
    });

    $(document).on('click', '#cancelReplyDiv', function() {
      $('#replyMsgDiv').hide();
      $('#displayMsgDiv').show();
    });

    $(document).on('submit', '#composeMessage', function() {
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function() {
          $('#composeOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            setTimeout(function() {
              $('#composeOverlay').removeClass('fas fa-2x fa-sync-alt fa-spin').addClass('fas fa-2x fa-check-circle');
            }, 1000);
          }
        }
      });
      
    });

    $(document).on('submit', '#replyMessage', function() {
      $.ajax({
        url: 'server.php',
        type: 'POST',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function() {
          $('#replyOverlay').show();
        },
        success: function (response) {
          if (response.status == '1') {
            setTimeout(function() {
              $('#replyOverlay').removeClass('fas fa-2x fa-sync-alt fa-spin').addClass('fas fa-2x fa-check-circle');
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