<?php 
session_start();
if(isset($_POST['transid'])) {
    include_once '../database/dbconfig.php';
    $transid = $_POST['transid'];
    $username = $_POST['username'];
    $output = "";

    $mysqli = $db_conn->query("SELECT * FROM transactions WHERE transid = '$transid' AND username = '$username' AND type = 'deposit' ");
    if ($mysqli->num_rows > 0) {
        $row = $mysqli->fetch_assoc();
        $output .= '
        <div class="row">
            <div class="col-12">
              <div class="text-muted h5 pb-2">Transaction Reference Number (TRN): <span class="text-warning" style="font-family: monospace;">'.$row['transid'].'</span></div>
            </div>
            <div class="col-12 table-responsive">
              <table class="table table-bordered text-center table-sm" style="font-size: 14px;">
                <thead>
                  <th>Coin</th>
                  <th>Amount</th>
                  <th>Status</th>
                </thead>
                <tbody>
                  <td class="text-warning">'.$row['method'].'</td>
                  <td class="text-warning">$'.number_format($row['amount']).'</td>
                  <td class="text-warning">'.$row['status'].'</td>
                </tbody>
              </table>
            </div>
        </div>
          
        <div class="form-group">
            <label for="exampleInput2" style="font-weight: normal;">Transaction Hash/ID <span class="text-danger">*</span></label>
            <input type="text" name="hash" class="form-control bg-light" required/>
            <ul class="text-muted" style="font-size: 14px; list-style: none; padding-left: 0;">
              <li><span class="text-warning">*</span> A transaction hash/id is a unique string of characters that is given to every transaction that is verified and added to the blockchain.</li>
              <li><span class="text-warning">*</span> It commonly appears at the top of the page when viewing your transaction through a block explorer website, or can be found by copying the URL from that same page.</li>
            </ul>
        </div>

        <div class="form-group float-right">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

        <div id="loadEx" class="h-100 w-100" style="z-index: 10000000; display: none;">
            <div class="row h-100">
              <div id="response_msg" class="col-12 text-center h-100 d-flex justify-content-center align-items-center">
                <i class="fa-2x fas fa-spinner fa-spin"></i>
              </div>
            </div>
        </div>
        ';
    } else {
        $output .= '
        <div class="row">
            <div class="col-12">
              <div class="text-danger h5">Invalid Transaction Reference Number (TRN)</div>
            </div>
            <div class="col-12 table-responsive">
              <table class="table table-bordered text-center table-sm" style="font-size: 14px;">
                <thead>
                  <th>Coin</th>
                  <th>Amount</th>
                  <th>Status</th>
                </thead>
                <tbody>
                  <td class="text-warning">N/A</td>
                  <td class="text-warning">N/A</td>
                  <td class="text-warning">N/A</td>
                </tbody>
              </table>
            </div>
        </div>

        <div class="form-group">
            <ul class="text-muted" style="font-size: 14px; list-style: none; padding-left: 0;">
              <li><span class="text-warning">*</span> A transaction reference number (TRN) is a unique number given to every transaction made on BexCrypt.</li>
              <li><span class="text-warning">*</span> An email containing the TRN was sent to your email for every transaction made on BexCrypt</li>
              <li><span class="text-warning">*</span> It commonly appears at the first column of the transaction row in the history table.</li>
            </ul>
        </div>
        ';
    }
}
echo $output;
?>