<?php 
session_start();
if(isset($_POST['username'])) {
    include_once '../database/dbconfig.php';
    $username = $_POST['username'];
    $output = "";

    $mysqli = $db_conn->query("SELECT * FROM account WHERE username = '$username'");
    if ($mysqli->num_rows > 0) {
      $row = $mysqli->fetch_assoc();
      $sqli = $db_conn->query("SELECT * FROM users WHERE username = '$username'");
      $data = $sqli->fetch_assoc();

      $output .= '
      <div class="row">
        <div class="col-sm-6">
          <div class="text-muted pb-2 text-capitalize">Name: <span class="text-dark h5">'.$data['firstname'].' '.$data['lastname'].'</span></div>
        </div>
        <div class="col-sm-6">
          <div class="text-muted pb-2">Username: <span class="text-dark h5">'.$username.'</span></div>
        </div>
        <div class="col-12 table-responsive">
          <table class="table table-bordered text-center table-sm" style="font-size: 14px;">
            <thead>
              <th>Plan</th>
              <th>Balance</th>
              <th>Active</th>
              <th>Profit</th>
              <th>Bonus</th>
            </thead>
            <tbody>
              <td class="text-warning">'.$row['plan'].'</td>
              <td class="text-secondary">$'.number_format($row['totalbalance']).'</td>
              <td class="text-secondary">$'.number_format($row['activedeposit']).'</td>
              <td class="text-secondary">$'.number_format($row['earn']).'</td>
              <td class="text-secondary">$'.number_format($row['bonus']).'</td>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card card-primary card-outline-tabs w-100">
        <div class="card-header p-0 border-0">
          <ul class="nav nav-tabs px-0 mx-0 w-100 row" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item w-100 col-6 x-0 mx-0 mx-0 px-0 text-center">
              <a class="nav-link active border-top-0 rounded-0 w-100" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false" style="font-size: 14px;"><i class="fas fa-money-check"></i> PROFIT</a>
            </li>
            <li class="nav-item w-100 col-6 mx-0 px-0">
              <a class="nav-link border-top-0 rounded-0 w-100 text-center" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false" style="font-size: 14px;"><i class="far fa-credit-card"></i> BONUS</a>
            </li>
            
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-four-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
              <form id="addProfit">
                <input type="hidden" name="username" value="'.$username.'">
                <div class="form-group">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio1" value="btc">
                    <label class="form-check-label" for="inlineRadio1">BTC</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio2" value="eth">
                    <label class="form-check-label" for="inlineRadio2">ETH</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio3" value="bnb">
                    <label class="form-check-label" for="inlineRadio3">BNB</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio4" value="ada">
                    <label class="form-check-label" for="inlineRadio4">ADA</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio5" value="xpr">
                    <label class="form-check-label" for="inlineRadio5">XPR</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio6" value="doge">
                    <label class="form-check-label" for="inlineRadio6">DOGE</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio7" value="usdt">
                    <label class="form-check-label" for="inlineRadio7">USDT</label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInput1">Profit <span class="text-danger">*</span></label>
                  <input type="number" name="profit" id="profit" class="form-control" id="exampleInput1" required>
                </div>                

                <button type="submit" id="addProfitBtn" class="btn btn-primary">Update Profit</button>
              </form>
            </div>
            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
              <form id="addBonus">
                <input type="hidden" name="username" value="'.$username.'">
                <div class="form-group">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio1" value="btc">
                    <label class="form-check-label" for="inlineRadio1">BTC</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio2" value="eth">
                    <label class="form-check-label" for="inlineRadio2">ETH</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio3" value="bnb">
                    <label class="form-check-label" for="inlineRadio3">BNB</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio4" value="ada">
                    <label class="form-check-label" for="inlineRadio4">ADA</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio5" value="xpr">
                    <label class="form-check-label" for="inlineRadio5">XPR</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio6" value="doge">
                    <label class="form-check-label" for="inlineRadio6">DOGE</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="wallet" id="inlineRadio7" value="usdt">
                    <label class="form-check-label" for="inlineRadio7">USDT</label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInput2">Bonus <span class="text-danger">*</span></label>
                  <input type="number" name="bonus" id="bonus" class="form-control" id="exampleInput2" required>
                </div>
                

                <button type="submit" id="addBonusBtn" class="btn btn-primary">Update Bonus</button>
              </form>
            </div>
          </div>
        </div>
        <!-- /.card -->
        <div id="loading" class="w-100 h-100" style="position: absolute; z-index: 100; background: rgba(0, 0, 0, 0.7);display: none;">
          <div class="row h-100">
            <div id="response_msg" class="col-12 text-center h-100 d-flex justify-content-center align-items-center">
              <i class="fa-4x fas fa-spinner fa-spin"></i>
            </div>
          </div>
        </div>
      </div>
      ';
    }
    else {
      $output .= '
        <div id="getUserAccount">
          <form id="enterUserDetails">
            <div class="form-group mb-0">
              <label for="exampleInput1" style="font-weight: normal;">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" id="username" class="form-control bg-light" required/>

            </div>

            <div class="form-group py-0">
              <p class="text-danger response_msg" style="font-size:12px;">User does not exist</p>
            </div>

            <div class="form-group d-flex justify-content-end">
              <button type="button" id="getUserAccountBtn" class="btn btn-default">Continue</button>
            </div>

          </form>
        </div>
      ';
    }
}
echo $output;
?>