<?php 
session_start();
if(isset($_POST['username'])) {
    include_once '../database/dbconfig.php';
    $username = $_POST['username'];
    $userid = $_POST['userid'];
    $output = "";

    $mysqli = $db_conn->query("SELECT * FROM account WHERE id = '$userid'");
    if ($mysqli->num_rows > 0) {
      $row = $mysqli->fetch_assoc();
      $sqli = $db_conn->query("SELECT * FROM users WHERE username = '$username'");
      $data = $sqli->fetch_assoc();

      $output .= '
      <form id="editUserAccForm" class="row">
        <div class="col-12 h4 text-muted text-capitalize">'.$data['firstname'].' '.$data['lastname'].'</div>
        <input type="hidden" name="edit_user">
        <input type="hidden" name="userid" value="'.$row['id'].'">
        <div class="col-sm-6">
          <div class="form-group"><label>Total Balance</label><input type="text" class="form-control" name="totalbalance" value="'.$row['totalbalance'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Active Deposit</label><input type="text" class="form-control" name="activedeposit" value="'.$row['activedeposit'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Last Deposit</label><input type="text" class="form-control" name="lastdeposit" value="'.$row['lastdeposit'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Total Deposit</label><input type="text" class="form-control" name="totaldeposit" value="'.$row['totaldeposit'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Last Withdrawal</label><input type="text" class="form-control" name="lastwithdrawal" value="'.$row['lastwithdrawal'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Total Withdrawal</label><input type="text" class="form-control" name="totalwithdrawal" value="'.$row['totalwithdrawal'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Profit</label><input type="text" class="form-control" name="newearn" value="'.$row['earn'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Bonus</label><input type="text" class="form-control" name="newbonus" value="'.$row['bonus'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Bitcoin (BTC)</label><input type="text" class="form-control" name="btc" value="'.$row['btc'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Ethereum (ETH)</label><input type="text" class="form-control" name="eth" value="'.$row['eth'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Binance (BNB)</label><input type="text" class="form-control" name="bnb" value="'.$row['bnb'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Cardano (ADA)</label><input type="text" class="form-control" name="ada" value="'.$row['ada'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Proton (XPR)</label><input type="text" class="form-control" name="xpr" value="'.$row['xpr'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Dogecoin (DOGE)</label><input type="text" class="form-control" name="doge" value="'.$row['doge'].'" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group"><label>Tether (USDT)</label><input type="text" class="form-control" name="usdt" value="'.$row['usdt'].'" required>
          </div>
        </div>
        <div class="col-12">
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-default" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </div>
          
      </form>
      ';
    }
}
echo $output;
?>