<?php
if (!isset($_GET['r'])) {
  header("location:login");
  exit();
} else {
  $token = $_GET['r'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recover Password | Bitcoptions</title>
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    #videobcg {
      width: 100vw;
      height: 100vh;
      object-fit: cover;
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      z-index: -1;
    }
  </style>
</head>
<body class="hold-transition login-page">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <div class="spinner-border text-primary" role="status"></div>
  </div>
  <video id="videobcg" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0" poster="/img/Version3/landing/gm-home-sec-1-1920px.jpg">
      <source src="video/gm-home-sec-1.mp4" type="video/mp4">
  </video>
  <div class="row">
    <div class="login-box w-100">
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">You are only one step away from your new password, recover your password now.</p>

          <form id="recoverPasswordForm">
            <input type="hidden" name="recover_password">
            <input type="hidden" name="token" value="<?php echo $token; ?> ">
            <div class="input-group mb-3">
              <input type="password" name="password" id="password_1" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text text-info">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="password_2" placeholder="Confirm Password">
              <div class="input-group-append">
                <div class="input-group-text text-info">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <p id="error" class="login-box-msg" style="height: 30px;"></p>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-info btn-block">Change password</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <p class="mt-3 mb-1">
            <a class="text-info" href="login">Login</a>
          </p>
        </div>
        <div id="loading" class="w-100 h-100" style="position: absolute; z-index: 100; background: rgba(0, 0, 0, 0.5); display: none;">
          <div class="row h-100">
            <div class="col-12 text-center h-100 d-flex justify-content-center align-items-center">
              <i class="fa-4x fas fa-spinner fa-spin"></i>
            </div>
          </div>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
  </div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>

  $('#password_2').keyup(function() {
    if ($('#password_1').val() != $('#password_2').val()) {
      $('#error').html("Both passwords do not match").addClass('text-danger');
      setTimeout(function() {
        $('#error').html('');
      }, 5000);

    }else{
      $('#error').html("Both passwords match").removeClass('text-danger').addClass('text-success');
      setTimeout(function() {
        $('#error').html('');
      }, 5000);
    }
  });

  $('#recoverPasswordForm').on('submit', function(e){
    e.preventDefault();
    if ($('#password_1').val() != $('#password_2').val()) {
      $('#error').html("Both passwords do not match").addClass('text-danger');
      setTimeout(function() {
        $('#error').html('');
      }, 5000);

    }else{
      $.ajax({
        url: 'server.php',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        encode: true,
        beforeSend: function() {
          $('#loading').show();
        },
        success: function(response) {
          if (response.status == '1') {
            $('#error').html(response.message).addClass('text-success');
            setTimeout(function() {
            window.location.href = "login";
          }, 5000);
            
          } else {
            $('#loading').hide();
            $('#error').html(response.message).addClass('text-danger');
          }
        }
      });
    }
  });
</script>
</body>
</html>
