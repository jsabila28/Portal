<?php
    require_once($com_root."/db/db.php");
    require_once($com_root."/actions/get_profile.php");
    
    $date = date("Y-m-d");
    $Year = date("Y");
    $Month = date("m");
    $Day = date("d");
    $yearMonth = date("Y-m");
    $employee = Profile::GetEmployee();

    try {
        $hr_db = Database::getConnection('hr');
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        error_log("User ID: $user_id");

        $stmt = $hr_db->prepare("SELECT 
                a.bi_empno, 
                CONCAT(a.bi_empfname, ' ', a.bi_empmname, ' ', a.bi_emplname) AS fullname, 
                jd.jd_title, 
                CONCAT(head.bi_emplname, ' ', head.bi_empfname) AS headNAME,
                b.jrec_reportto,
                b.`jrec_outlet`,
                b.`jrec_department`,
                b.`jrec_position`
            FROM 
                tbl201_basicinfo a
            LEFT JOIN 
                tbl201_jobrec b ON a.bi_empno = b.jrec_empno
            LEFT JOIN 
                tbl201_basicinfo head ON b.jrec_reportto = head.bi_empno
            LEFT JOIN 
                tbl_jobdescription jd ON jd.jd_code = b.jrec_position
            LEFT JOIN 
                tbl201_jobinfo ji ON ji.ji_empno = a.bi_empno
            WHERE 
                a.bi_empno = :user_id
                AND a.datastat = 'current'
                AND b.jrec_type = 'Primary'
                AND b.jrec_status = 'Primary'
                AND ji.ji_remarks = 'Active'
            ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            error_log("Query Result: " . print_r($user, true));
            $username = $user['fullname'];
            $empno = $user['bi_empno'];
            $position = $user['jd_title'];
            $reportto = $user['headNAME'];
            $reportID = $user['jrec_reportto'];
            $position = $user['jrec_position'];
            $department = $user['jrec_department'];
            $outlet = $user['jrec_outlet'];
            $date = date('F j, Y');
        } else {
            error_log("No user found for ID: $user_id");
            $username = "Guest";
        }
    } else {
        $username = "Guest";
    }
    
?>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-12" style="padding: 20px;">
              <div class="card">
                  <div id="personal-info1" style="background-color: white; padding: 20px;">
                      <div class="atdview">
                          <a href="/Portal/compliance/ir"><i class="icofont icofont-arrow-left" style="font-size: 24px;"></i></a>
                      </div>
                        <input type="hidden" name="position" id="posInput" value="<?=$position?>">
                        <input type="hidden" name="department" id="deptInput" value="<?=$department?>">
                        <input type="hidden" name="outlet" id="outInput" value="<?=$outlet?>">
                        <label id="_13aLabel">
                          <p style="width: 100px;">To: </p> 
                          <?php echo $reportto; ?><input type="hidden" name="sendto" id="sendtoInput" value="<?=$reportID?>">
                        </label>
                        <label id="_13aLabel">
                          <p style="width: 100px;">CC: </p> 
                          <select class="selectpicker" multiple data-live-search="true" name="ccnames" id="ccInput">
                            <?php if (!empty($employee)) { 
                                foreach ($employee as $k) { ?>
                                    <option value="<?=$k['bi_empno']?>"><?=$k['bi_emplname'].' '.$k['bi_empfname']?></option>       
                            <?php } } ?>
                          </select>
                        </label>
                        <label id="_13aLabel">
                          <p style="width: 100px;">From: </p> 
                          <p><?php echo $username; ?></p> 
                        </label>
                        <label id="_13aLabel">
                          <p style="width: 100px;">Date: </p> 
                          <p> <?php echo $date; ?></p>
                        </label>        
                        <label id="_13aLabel">
                          <p style="width: 100px;">Subject: </p> 
                          <input type="text" class="form-control" name="irsubject" id="irsubInput"> 
                        </label>
                        <hr><br>
                        <p>INFORMATION ABOUT THE INCIDENT</p><br>
                        <div style="display: flex;">
                          <div id="ir-sm-div">
                            <p>Date of Incident</p>
                            <input class="form-control" type="date" name="incdate" id="incdateInput" required />
                          </div>
                          <div id="ir-sm-div">
                            <p>Location of Incident</p>
                            <p><input class="form-control" type="text" name="inclocation" id="inclocInput" required /></p>
                          </div>
                          <div id="ir-sm-div">
                            <p>Amount Involved, if any.</p>
                            <p><input class="form-control" type="text" name="amount" id="amtInput" /></p>
                          </div>
                          <div id="ir-sm-div">
                            <p>Expected Performance/Standard violated</p>
                            <p><input class="form-control" type="text" name="violation" id="vioInput" /></p>
                          </div>
                        </div>

                        <div style="display: flex;">
                            <div id="ir-sm-div">
                              <p>Person Involved</p>
                                <select class="selectpicker" multiple data-live-search="true" name="ccnames" id="ccInput">
                                  <?php if (!empty($employee)) { 
                                      foreach ($employee as $k) { ?>
                                          <option value="<?=$k['bi_empno']?>"><?=$k['bi_emplname'].' '.$k['bi_empfname']?></option>       
                                  <?php } } ?>
                                </select>
                            </div>
                            <div id="ir-sm-div" style="width: 10%;">
                              <p>Audit Finding/s</p>
                              <div style="display: flex; align-items: center; gap: 10px;">
                                <label style="width:20%;"><input type="radio" class="form-control" id="yes" name="audyn" value="yes"> No</label>
                                <label style="width:20%;"><input type="radio" class="form-control" id="no" name="audyn" value="no"> Yes</label>
                              </div>
                            </div>
                        </div>
                        <p>Description of Incident (what happened, how it happened, person/s involved) Be as specific as possible.</p>
                        <textarea class="form-control" name="ir_desc" id="descInput"></textarea>
                        <hr>
                        <p>As part of his/her responsibilities (Responsibilidad niya ang), is expected to:</p>
                        <textarea class="form-control" name="ir_res1" id="res1Input"></textarea>
                        <p>Protect the Interests of the Company by (protektahan ang kompanya sa pamamagitan ng)</p>
                        <textarea class="form-control" name="ir_res2" id="res2Input"></textarea>
                        <p>In support of this, I have attached the following documents (Inilagay rin ang sumusunod na papeles para magpatibay sa report na ito):</p>
                        <textarea class="form-control"></textarea>

                        <hr class="new2">
                        <div id="witness">
                          <p>In support of this, I have attached the following documents (Inilagay rin ang sumusunod na papeles para magpatibay sa report na ito):</p>
                          <div class="col-md-12">
                              <div class="panel panel-default" style="border: 1px solid #a59e9e !important;">
                                  <div class="panel-heading" style="background-color: #dfe2e3;color: #000000;">
                                      Files
                                  </div>
                                  <div class="panel-body" style="padding: 10px;">
                                      <a id="add-files" class="btn btn-mini" data-toggle="modal" data-target="#file-Modal">Add <i class="ion-plus"></i></a>
                                  </div>
                              </div>
                              <div class="modal fade" id="file-Modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h4 class="modal-title" style="text-align: left !important;">Modal title</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body" style="padding: 10px !important;">
                                          <div style="display: flex;">
                                              <p style=" width:100px;margin-right: 10px;">Type:</p>
                                              <select class="form-control" id="typeSelector">
                                                  <option value="Receipts">Receipts</option>
                                                  <option value="Pictures">Pictures</option>
                                                  <option value="Item/Items damaged">Item/Items damaged</option>
                                                  <option value="Related documents">Related documents</option>
                                                  <option value="Audit report">Audit report</option>
                                              </select>
                                          </div>
                                          <div id="secondDiv" style="display: none;">
                                            <div style="display: flex;">
                                                <p style=" width:100px;margin-right: 10px;">Audit Date:</p>
                                                <input type="date" class="form-control" name="">
                                            </div>
                                          </div>
                                          <div style="display: flex;">
                                              <p style=" width:100px;margin-right: 10px;">File:</p>
                                              <input type="file" class="form-control" name="">
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-default btn-mini" data-dismiss="modal">Close</button>
                                          <button type="button" class="btn btn-primary btn-mini">Save</button>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div><br>
                          <div class="col-md-12">
                              <div class="panel panel-default" style="border: 1px solid #a59e9e !important;">
                                  <div class="panel-heading" style="background-color: #dfe2e3;color: #000000;">
                                      Statement of witnesses
                                  </div>
                                  <div class="panel-body" style="padding: 10px;">
                                      <textarea class="form-control" name="witnes-state" disabled></textarea>
                                      <div id="edit-witness-state">
                                        <button class="btn btn-default btn-mini" id="edit-witnes"><i class="fa fa-edit"></i></button>
                                      </div>
                                      <div id="save-witness-state" style="display: none;">
                                        <button class="btn btn-danger btn-mini" id="cancel-edit">Cancel</button>
                                        <button class="btn btn-primary btn-mini" id="wit-state">Save</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <hr>
                         <p>I am reporting this matter to you so that the proper proceedings according to company policy may be begun (Pinapaalam ko ito sa inyo para magawa ang nakalagay sa company policy tungkol dito).</p>
                         <p>I hereby certify that the above information is true and correct (Ang nakasulat sa itaas ay tama at pawang katotohanan lamang).</p>
                        <br>
                        <div id="ir-bottom">
                          <div id="ir-sign">
                            <table>
                              <tbody>
                                <tr>
                                  <td>
                                    <div id="signature-container" style="display: none;">
                                      <canvas id="signature-pad"></canvas>
                                      <div class="buttons">
                                        <button class="btn btn-default btn-mini" id="clear">Clear</button>
                                        <button class="btn btn-primary btn-mini" id="save">Save</button>
                                      </div>
                                    </div>
                                    <div id="signature-image-container">
                                      <img id="signature-image" width="150" alt="Signature will appear here" />
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="text-transform:uppercase;"><?=$username?></td>
                                  <td><a id="show-signature-pad" class="btn btn-mini">sign</a></td>
                                </tr>
                                <tr style="border-top: 1px solid black;">
                                  <td>Signature over printed name</td>
                                </tr>
                              </tbody>
                            </table>
                            <p></p>
                          </div>
                          <div id="ir-sign" style="display: flex;height: 60px;">
                            <button type="button" id="save-irdraft" class="btn btn-success btn-mini waves-effect waves-light">Save as draft</button>
                            <button type="button" id="save-ir" class="btn btn-primary btn-mini waves-effect waves-light ">Save</button>
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/js/incident-report.js"></script>
<script type="text/javascript">
document.getElementById('typeSelector').addEventListener('change', function () {
  const secondDiv = document.getElementById('secondDiv');
  if (this.value === 'Audit report') {
      secondDiv.style.display = 'block';
  } else {
      secondDiv.style.display = 'none';
  }
});
// Select elements
const showSignaturePadButton = document.getElementById('show-signature-pad');
const signatureContainer = document.getElementById('signature-container');
const canvas = document.getElementById('signature-pad');
const clearButton = document.getElementById('clear');
const saveButton = document.getElementById('save');
const signatureImage = document.getElementById('signature-image');
const saveStatement = document.getElementById('wit-state');

// Initialize canvas context
const ctx = canvas.getContext('2d');
canvas.width = canvas.offsetWidth || 300;
canvas.height = canvas.offsetHeight || 150;

// Variables for drawing
let isDrawing = false;
let lastX = 0;
let lastY = 0;

// Functions for drawing
function startDrawing(e) {
    isDrawing = true;
    [lastX, lastY] = [e.offsetX || e.touches[0].pageX, e.offsetY || e.touches[0].pageY];
}

function draw(e) {
    if (!isDrawing) return;
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    const [x, y] = [e.offsetX || e.touches[0].pageX, e.offsetY || e.touches[0].pageY];
    ctx.lineTo(x, y);
    ctx.strokeStyle = '#000';
    ctx.lineWidth = 2;
    ctx.stroke();
    ctx.closePath();
    [lastX, lastY] = [x, y];
}

function stopDrawing() {
    isDrawing = false;
    ctx.beginPath();
}

// Event listeners for drawing
canvas.addEventListener('mousedown', startDrawing);
canvas.addEventListener('mousemove', draw);
canvas.addEventListener('mouseup', stopDrawing);
canvas.addEventListener('mouseout', stopDrawing);

canvas.addEventListener('touchstart', startDrawing, { passive: true });
canvas.addEventListener('touchmove', draw, { passive: true });
canvas.addEventListener('touchend', stopDrawing);

// Show signature pad on button click
showSignaturePadButton.addEventListener('click', () => {
    signatureContainer.style.display = 'table-cell'; // Show the signature pad
});

// Clear the canvas
clearButton.addEventListener('click', () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
});

saveButton.addEventListener('click', () => {
    const dataURL = canvas.toDataURL('image/png');
    signatureImage.src = dataURL;
    signatureContainer.style.display = 'none';

    const irId = document.querySelector('input[name="IRid"]').value;

    // Log data before sending
    console.log({ id: irId, signature: dataURL });

    fetch('IRsign', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: irId, signature: dataURL})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Signature updated successfully!');
        } else {
            alert('Failed to update signature: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

$(document).ready(function() {
  $('#edit-witnes').click(function() {
    $('#edit-witness-state').hide(); 
    $('#save-witness-state').show(); 
    $('textarea[name="witnes-state"]').prop('disabled', false); 
  });

  $('#cancel-edit').click(function() {
    $('#edit-witness-state').show(); 
    $('#save-witness-state').hide();
    $('textarea[name="witnes-state"]').prop('disabled', true); 
  });
});

saveStatement.addEventListener('click', () => {

    const irId = document.querySelector('input[name="IRid"]').value;
    const statement = document.querySelector('textarea[name="witnes-state"]').value;

    // Log data before sending
    console.log({ id: irId, WitState: statement });

    fetch('stateSave', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: irId, WitState: statement})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Witness statement updated successfully!');
            $('textarea[name="witnes-state"]').prop('disabled', true); 
        } else {
            alert('Failed to update witness statement: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>