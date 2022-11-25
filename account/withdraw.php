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
  <title>Withdraw - Bitcoptions</title>
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
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/custom-css.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <style>.coin-hover:hover{background:#454d55;}</style>
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
              <a href="withdraw" class="nav-link active">
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
              <div class="card rounded-0">
                <div class="card-body pb-0">
                  <div class="row">
                    <div class="col-12 px-0">
                      <div class="row">
                        <div class="col-12">
                          <div class="card card-light card-outline-tabs w-100" style="height: 540px;">
                            <div class="card-header p-0 border-0">
                              <ul class="nav nav-tabs px-0 mx-0 w-100 row" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item w-100 col-6 x-0 mx-0 mx-0 px-0 text-center">
                                  <a class="nav-link active border-top-0 rounded-0 w-100" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false" style="font-size: 14px;"><i class="fas fa-money-check"></i> BANK TRANSFER</a>
                                </li>
                                <li class="nav-item w-100 col-6 mx-0 px-0">
                                  <a class="nav-link border-top-0 rounded-0 w-100 text-center" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false" style="font-size: 14px;"><i class="far fa-credit-card"></i> CARD</a>
                                </li>
                                
                              </ul>
                            </div>
                            <div class="card-body">
                              <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                  <form id="withdrawBankForm">
                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                    <input type="hidden" name="withdraw" value="withdraw">
                                    <input type="hidden" name="method" value="Bank">
                                    <input type="hidden" name="network" value="btc">

                                    <div class="form-group">
                                      <label for="exampleInput1">Receiver name <span class="text-danger">*</span></label>
                                      <input type="text" name="fullname" class="form-control" id="exampleInput1" placeholder="John Aldridge" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInput2">Country <span class="text-danger">*</span></label>
                                      <select name="country" class="form-control select2" style="width: 100%;" reqiuired>
                                        <option value="Afganistan">Afghanistan</option>
                                        <option value="Albania" selected>Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bonaire">Bonaire</option>
                                        <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canary Islands">Canary Islands</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Channel Islands">Channel Islands</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos Island">Cocos Island</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cote DIvoire">Cote DIvoire</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Curaco">Curacao</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor">East Timor</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands">Falkland Islands</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Ter">French Southern Ter</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Great Britain">Great Britain</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Hawaii">Hawaii</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="India">India</option>
                                        <option value="Iran">Iran</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Isle of Man">Isle of Man</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea North">Korea North</option>
                                        <option value="Korea Sout">Korea South</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libya">Libya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedonia">Macedonia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Midway Islands">Midway Islands</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Nambia">Nambia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherland Antilles">Netherland Antilles</option>
                                        <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                        <option value="Nevis">Nevis</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau Island">Palau Island</option>
                                        <option value="Palestine">Palestine</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Phillipines">Philippines</option>
                                        <option value="Pitcairn Island">Pitcairn Island</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Republic of Montenegro">Republic of Montenegro</option>
                                        <option value="Republic of Serbia">Republic of Serbia</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="St Barthelemy">St Barthelemy</option>
                                        <option value="St Eustatius">St Eustatius</option>
                                        <option value="St Helena">St Helena</option>
                                        <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                        <option value="St Lucia">St Lucia</option>
                                        <option value="St Maarten">St Maarten</option>
                                        <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                        <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                        <option value="Saipan">Saipan</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="Samoa American">Samoa American</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syria</option>
                                        <option value="Tahiti">Tahiti</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Erimates">United Arab Emirates</option>
                                        <option value="United States of America">United States of America</option>
                                        <option value="Uraguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vatican City State">Vatican City State</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                        <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                        <option value="Wake Island">Wake Island</option>
                                        <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zaire">Zaire</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInput3">IBAN <span class="text-danger">*</span></label>
                                      <input type="text" name="walletid" class="form-control" id="exampleInput3" placeholder="GB 26 MIDL 400515 12345678" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInput4">Amount: <span class="text-danger">*</span></label>
                                      <input id="bank-value" type="text" name="amount" class="form-control usd-btc-value" id="exampleInput4" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="1,000,000" required>
                                    </div>
                                    
                                    <div class="card-text pt-2 pb-3">
                                      <span class="text-warning text-sm">*</span> The payment will be made in the currency of your bank account at the current Bitcoin exchange rate.
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                  </form>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                  <form id="withdrawCardForm">
                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                    <input type="hidden" name="withdraw" value="withdraw">
                                    <input type="hidden" name="method" value="Card">
                                    <input type="hidden" name="network" value="btc">
                                    <div class="form-group">
                                      <label for="exampleInput1">Full name <span class="text-danger">*</span></label>
                                      <input type="text" name="fullname" class="form-control" id="exampleInput1" placeholder="John Aldridge" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInput2">Card number <span class="text-danger">*</span></label>
                                      <input type="number" name="walletid" class="form-control" id="exampleInput2" placeholder="000 000 000 0000" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInput4">Amount: <span class="text-danger">*</span></label>
                                      <input id="card-value" type="text" name="amount" class="form-control usd-btc-value" id="exampleInput4" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="1,000,000" required>
                                    </div>
                                    
                                    <div class="card-text pt-2 pb-3">
                                      <span class="text-warning text-sm">*</span> The payment will be made in the currency of your credit card at the current Bitcoin exchange rate.
                                    </div>

                                    <div class="card-text pb-3 text-sm">
                                      <span class="text-warning">*</span> This method is only available for credit cards that support direct payments.
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- /.card -->
                            <div id="loading" class="overlay dark" style="display: none;"><i class="fa-4x fas fa-spinner fa-spin"></i></div>
                          </div>
                        </div>               
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-5 col-lg-4 px-sm-2 px-0">
              <div class="card rounded-0 h-100">
                <div class="card-body px-0">
                  <script>!function(){var e=document.getElementsByTagName("script"),t=e[e.length-1],n=document.createElement("script");function r(){var e=crCryptocoinPriceWidget.init({base:"USD,BTC,ETH,BNB",items:"BTC,ETH,BNB,ADA,LTC,TRX,BUSD,USDT",backgroundColor:"#454d55",streaming:"1",rounded:"0",boxShadow:"1",border:"1"});t.parentNode.insertBefore(e,t)}n.src="https://co-in.io/widget/pricelist.js?items=BTC%2CETH%2CBNB%2CADA%2CLTC%2CTRX%2CBUSD%2CUSDT",n.async=!0,n.readyState?n.onreadystatechange=function(){"loaded"!=n.readyState&&"complete"!=n.readyState||(n.onreadystatechange=null,r())}:n.onload=function(){r()},t.parentNode.insertBefore(n,null)}();</script>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center pb-2">
            
            <div class="col-12 col-lg-10 col-md-11 px-sm-2 px-0">
                
              <div class="card rounded-0">
                <div class="card-body">
                  <?php 
                  $sql = $db_conn->query("SELECT * FROM transactions WHERE username = '$username' AND type ='withdraw' AND status = 'pending' ORDER BY id DESC");
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
      <div class="footer-copyright">All Rights Reserved &copy; 2010-<?php echo date("Y"); ?></div>
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
  <!-- Select2 -->
  <script src="../plugins/select2/js/select2.full.min.js"></script>
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

    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    })
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

    $(document).on('submit', '#withdrawBankForm', function(e) {
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
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#withdrawBankForm')[0].reset();
            $('#loading').html('<i class="fa-5x fas fa-check-circle text-success"></i>');
            setTimeout(function() {
              $('#loading').hide();
            }, 3000);
          }
            
        }
      });
    });

    $(document).on('submit', '#withdrawCardForm', function(e) {
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
          $('#loading').show();
        },
        success: function(response) {
          if(response.status == '1') {
            $('#withdrawCardForm')[0].reset();
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
            $('#usd-bnb.value').html(usd);
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
      let x = document.querySelectorAll('#bank-value, #card-value');
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