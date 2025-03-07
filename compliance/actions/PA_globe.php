<?php
require_once($com_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

   
$stmt = $port_db->prepare("
        SELECT * FROM
            tbl_account_agreement
            WHERE `acca_account_desc` = 'Globe Postpaid'
            -- AND `acca_stat` = ''
            -- AND `acca_stat` = null
    ");
$stmt->execute();
$phone_agreement = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($phone_agreement)) {

echo '<button class="btn btn-inverse btn-outline-inverse btn-mini" id="forsign">Batch For Signature</button>';
echo '<button style="margin-left: 10px;" class="btn btn-inverse btn-outline-inverse btn-mini" id="forrelease">Batch Release Signing</button>';
echo "<div class='table-wrapper' style='max-height:400px; overflow:auto;'>";
echo "<table class='sticky-table' id='filterable-table' style='width:100%; border-collapse:collapse;'>";
echo "<thead style='position:sticky; top:0; background-color:#f9f9f9; z-index:1;'>";
echo "<tr>";
echo '<th></th>';
echo '<th></th>';
echo '<th>Company</th>';
echo '<th>Dept/Outlet</th>';
echo '<th>Custodian</th>';
echo '<th>ACC No</th>';
echo '<th>ACC Name</th>';
echo '<th>SIM No</th>';
echo '<th>SIM Serial No</th>';
echo '<th>SIM Type</th>';
echo '<th>Plan Type</th>';
echo '<th>Plan Features</th>';
echo '<th>Monthly Service Fee</th>';
echo '<th>Authorized By</th>';
echo '<th>QRPH</th>';
echo '<th>Merchant Desc</th>';
echo '<th>Model</th>';
echo '<th>IMEI 1</th>';
echo '<th>IMEI 2</th>';
echo '<th>Unit Serial No</th>';
echo '<th>Accessories</th>';
echo '<th>Date Issued</th>';
echo '<th>Date Returned </th>';
echo '<th>Remarks</th>';
echo '<th></th>';
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($phone_agreement as $p) {
    echo "<tr>";
    echo "<td></td>";
    echo "<td><input type='checkbox' class='row-checkbox' data-accountno='".$p['acca_id']."'></td>";
    echo "<td>".$p['acca_custodiancompany']."</td>";
    echo "<td>".$p['acca_deptol']."</td>";
    // echo "<td>".$p['acca_custodian']."</td>";
    echo "<td>" . htmlspecialchars(
    is_array($decoded = json_decode($p['acca_custodian'], true)) 
        ? implode(', ', array_filter($decoded)) 
        : '') . "</td>";

    echo "<td>".$p['acca_accountno']."</td>";
    echo "<td>".$p['acca_accountname']."</td>";
    echo "<td>".$p['acca_sim']."</td>";
    echo "<td>".$p['acca_simserialno']."</td>";
    echo "<td>".$p['acca_simtype']."</td>";
    echo "<td>".$p['acca_plantype']."</td>";
    echo "<td>".$p['acca_planfeatures']."</td>";
    echo "<td>".$p['acca_msf']."</td>";
    echo "<td>".$p['acca_authorized']."</td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td>".$p['acca_model']."</td>";
    echo "<td>".$p['acca_imei1']."</td>";
    echo "<td>".$p['acca_imei2']."</td>";
    echo "<td>".$p['acca_serial']."</td>";
    // echo "<td>".$p['acca_accessories']."</td>";
    echo "<td>" . htmlspecialchars(
    is_array($decoded = json_decode($p['acca_accessories'], true)) 
        ? implode(', ', array_filter($decoded)) 
        : '') . "</td>";
    echo "<td>".date('F d, Y', strtotime($p['acca_dtissued']))."</td>";
    echo "<td>".date('F d, Y', strtotime($p['acca_dtreturned']))."</td>";
    echo "<td>".$p['acca_remarks']."</td>";
    echo "<td>
            <a class='btn btn-default btn-mini'><i class='zmdi zmdi-eye'></i></a>
            <a class='btn btn-default btn-mini' data-toggle='modal' data-target='#myModal".$p['acca_id']."'><i class='fa fa-edit'></i></a>
            <a class='btn btn-outline-danger btn-mini'><i class='fa fa-trash-o'></i></a>
    </td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";
foreach ($phone_agreement as $pa) {
// echo '<div class="modal fade" id="myModal' . $pa['acca_id'] . '" ...';
echo '<div class="modal fade" id="myModal' . $pa['acca_id'] . '" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Phone Agreement Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 10px !important;">
                <form>
                  <div id="phone-agr">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">SIM No.</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="simNo" id="simNoinput" value="' . $pa['acca_sim'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">SIM Serial No: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="serialNum" id="serialNumDisplay" value="' . $pa['acca_simserialno'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">SIM Type: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="simType" id="simTypeDisplay" value="' . $pa['acca_simtype'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Account Name: </label>
                        <div class="col-sm-8">
                             <input class="form-control" name="accname" id="accnameDisplay" value="' . $pa['acca_accountname'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Account No: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="accno" id="accnoDisplay" value="' . $pa['acca_accountno'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Plan: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="plan" id="planDisplay" value="' . $pa['acca_plantype'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Plan Features: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="plnfeat" id="plnfeatDisplay" value="' . $pa['acca_planfeatures'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Monthly Service Fee: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="msf" id="msfDisplay" value="' . $pa['acca_msf'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">QRPH: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="qrph" id="qrphDisplay" value="' . $pa['acca_qrph'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Merchant Desc: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="merch" id="merchDisplay" value="" readonly>
                        </div>
                    </div>
                  </div>
                  <div id="phone-agr">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">IMEI 1: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="imei1" id="imei1Input" value="' . $pa['acca_imei1'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">IMEI 2: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="imei2" id="imei2Display" value="' . $pa['acca_imei2'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Phone Model: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="phmod" id="phmodDisplay" value="' . $pa['acca_model'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Unit Serial No: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="untserial" id="untserialDisplay" value="' . $pa['acca_serial'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Accessories: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="accessrs" id="accessrsDisplay" value="' . htmlspecialchars(is_array($decoded = json_decode($p['acca_accessories'], true)) ? implode(', ', array_filter($decoded)) : '') . '" readonly>
                        </div>
                    </div>
                  </div>
                  <div id="phone-agr">
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Custodian: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="custodian" id="cstnInput" value="' . htmlspecialchars(is_array($decoded = json_decode($p['acca_custodian'], true)) ? implode(', ', array_filter($decoded)) : '') . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Department/ Outlet: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="dept" id="deptInput">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Witness: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="wtness" id="wtnessInput" value="' . $pa['acca_witness'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Released by: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="relby" id="rbyInput" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Authorized by: </label>
                        <div class="col-sm-8">
                            <input class="form-control" name="author" id="authorInput" value="' . $pa['acca_authorized'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Date Issued: </label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="dtissued" id="dtissuedInput" value="' . $pa['acca_dtissued'] . '">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Recontracted: </label>
                        <div class="col-sm-8">
                            <input type="month" class="form-control" name="recont" id="recontInput" value="">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Date Returned: </label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="dtreturn" id="dtreturnInput" value="' . $pa['acca_dtreturned'] . '">
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center">
                        <label class="col-sm-4 col-form-label">Remarks: </label>
                        <div class="col-sm-8">
                            <textarea name="remark" id="remarkInput"  value="' . $pa['acca_remarks'] . '"></textarea>
                        </div>
                    </div>
                  </div>
                </form>
                <div id="pa-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-mini" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-mini" id="save-phagr">Submit</button>
            </div>
        </div>
    </div>
</div>';
    }
}   

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
