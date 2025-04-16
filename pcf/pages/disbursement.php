<?php
require_once($pcf_root."/actions/get_pcf.php");

$date = date("Y-m-d");
$Year = date("Y");
$Month = date("m");
$Day = date("d");
$yearMonth = date("Y-m");
$pcf = PCF::GetPCFdetail($user_id,$outlet);
$pcfacc = PCF::GetPCFAcc($user_id);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row" style="display: flex;">
            <div class="my-div">
                <?php if (!empty($hotside)) include_once($hotside); ?>
                <div style="height: 50px;padding: 10px;text-align: center;">
                    <span>TNGC | 2025</span>
                </div>
            </div>
            <!-- <div class="col-md-9" id="right-sided"> -->
            <div id="center-sided">
                <div class="card">
                    <div class="card-block" style="height: 87vh;margin-top: 5px;margin-bottom: 5px;overflow: auto;">
                      <div class="first" style="justify-content: space-between;">
                          <div class="col-sm-3" style="display: flex;">
                            <i class='bx bxs-buildings'></i>
                            <select class="form-control">
                              <?php
                                if (!empty($pcfacc)) {
                                  foreach ($pcfacc as $pa) { ?>
                                      <option value="<?=$pa['outlet_dept']?>"><?=$pa['outlet_dept']?></option>
                              <?php }} ?>
                            </select>
                          </div>
                          <?php
                            if (!empty($pcfacc)) {
                              foreach ($pcfacc as $pa) { ?>
                          <div style="display: flex;">
                            <i class='bx bxs-buildings'></i>
                            <input type="text" class="form-control" name="company" value="<?=$pa['company']?>" readonly="">
                          </div>
                          <?php }} ?>
                          <div style="display: flex;height: 40px;">
                              <!-- <i class='bx bxs-calendar' style="font-size: 30px;"></i> -->
                              <?php require_once($pcf_root."/actions/get_pcf_no.php");?>
                              <input type="hidden" name="outlet" value="<?=$outlet?>">
                          </div>
                        <?php
                          if (!empty($pcf)) {
                            foreach ($pcf as $p) {
                              $custodian = $p['custodian'];
                              $outlet = $p['outlet_dept'];
                              $coh = PCF::GetCashOnHand($custodian,$outlet);
                        ?>
                        <div class="widget-card" style="display:none;">
                              <div class="coh-cards">
                                <div class="sec-icon">
                                  <img src="assets/img/coh.png" width="60" height="60">
                                </div>
                                <div class="coh-detail">
                                  <?php if (!empty($coh)) { foreach ($coh as $c) { ?>
                                      <div class="sec-coh"><p><?= number_format($c['repl_cash_on_hand'],2) ?></p> <i class="fa fa-exclamation-circle" id="warning" style="color: red!important"></i></div> 
                                      <div class="sec-bal" style="display: none;"><?= $c['repl_cash_on_hand'] ?></div>
                                      <div class="coh"><?= number_format($p['cash_on_hand']) ?></div>
                                  <?php } }else{ ?>
                                      <div class="sec-coh"><p><?= number_format($p['cash_on_hand']) ?></p> <i class="fa fa-exclamation-circle" id="warning" style="color: red!important"></i></div> 
                                      <div class="sec-bal"><?= number_format($p['cash_on_hand']) ?></div> 
                                  <?php } ?>
                                </div>
                              </div>
                          </div>
                          <?php }} ?>
                      </div>
                      <?php
                        if (!empty($pcf)) {
                          foreach ($pcf as $p) {
                            $custodian = $p['custodian'];
                            $outlet = $p['outlet_dept'];
                            $coh = PCF::GetCashOnHand($custodian,$outlet);
                            $disb = PCF::GetDisburement($outlet,$custodian);
                            $disb_rows = '';
                            
                            if (!empty($disb)) {
                              foreach ($disb as $d) {
                                $row = '';
                            
                                if ($d['dis_status'] == 'cancelled') {
                                  $row .= '<tr class="clickable-row" data-id="' . $d['dis_no'] . '" data-stat="' . $d['dis_status'] . '">';
                                  $row .= '<td id="a"><input type="checkbox" name="" checked disabled></td>';
                                  $row .= '<td id="a" class="entry-id" style="display:none;" data-field="dis_no">' . $d['dis_no'] . '</td>';
                                  $row .= '<td id="a"><input type="date" class="date-input" data-field="dis_date" id="datePCF" value="' . $d['dis_date'] . '" disabled></td>';
                                  $row .= '<td id="a" data-field="dis_pcv">' . $d['dis_pcv'] . '</td>';
                                  $row .= '<td id="a" data-field="dis_or">' . $d['dis_or'] . '</td>';
                                  $row .= '<td style="text-align: left; color: red">Cancelled</td>';
                                  $row .= '<td id="n" data-field="dis_office_store">' . $d['dis_office_store'] . '</td>';
                                  $row .= '<td id="n" data-field="dis_transpo">' . number_format($d['dis_transpo'], 2) . '</td>';
                                  $row .= '<td id="n" data-field="dis_repair_maint">' . number_format($d['dis_repair_maint'], 2) . '</td>';
                                  $row .= '<td id="n" data-field="dis_commu">' . number_format($d['dis_commu'], 2) . '</td>';
                                  $row .= '<td id="n" data-field="dis_misc">' . number_format($d['dis_misc'], 2) . '</td>';
                                  $row .= '<td id="total" class="num" data-field="dis_total">' . number_format($d['dis_total'], 2) . '</td>';
                                  $row .= '<td></td></tr>';
                                } else {
                                  $row .= '<tr class="clickable-row" data-id="' . $d['dis_no'] . '" data-stat="' . $d['dis_status'] . '">';
                                  $row .= '<td id="a"><input type="checkbox" name="" checked></td>';
                                  $row .= '<td id="a" class="entry-id" style="display:none;" data-field="dis_no">' . $d['dis_no'] . '</td>';
                                  $row .= '<td id="a"><input type="date" class="date-input" data-field="dis_date" id="datePCF" value="' . $d['dis_date'] . '"></td>';
                                  $row .= '<td id="a" contenteditable data-field="dis_pcv">' . $d['dis_pcv'] . '</td>';
                                  $row .= '<td id="a" contenteditable data-field="dis_or">' . $d['dis_or'] . '</td>';
                                  $row .= '<td id="p" contenteditable data-field="dis_payee">' . $d['dis_payee'] . '</td>';
                                  $row .= '<td id="n" contenteditable data-field="dis_office_store">' . $d['dis_office_store'] . '</td>';
                                  $row .= '<td id="n" contenteditable data-field="dis_transpo">' . number_format($d['dis_transpo'], 2) . '</td>';
                                  $row .= '<td id="n" contenteditable data-field="dis_repair_maint">' . number_format($d['dis_repair_maint'], 2) . '</td>';
                                  $row .= '<td id="n" contenteditable data-field="dis_commu">' . number_format($d['dis_commu'], 2) . '</td>';
                                  $row .= '<td id="n" contenteditable data-field="dis_misc">' . number_format($d['dis_misc'], 2) . '</td>';
                                  $row .= '<td id="total" class="num" data-field="dis_total">' . number_format($d['dis_total'], 2) . '</td>';
                                  $row .= '<td><a href="#" class="btn btn-outline-danger btn-mini cancel-btn" data-id="' . $d['dis_no'] . '">';
                                  $row .= '<i class="ion-close"></i></a></td></tr>';
                                }
                            
                                $disb_rows .= $row;
                              }
                            }
                      ?>
                      <div class="third">
                        <div class="table-container">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th id="a"><input type="checkbox" id="checkAll"></th>
                                        <th id="a">Date</th>
                                        <th id="a">PCV#</th>
                                        <th id="a">OR#</th>
                                        <th id="a">Payee</th>
                                        <th id="a">Office/Store Supply</th>
                                        <th id="a">Transportation</th>
                                        <th id="a">Repairs & Maintenance</th>
                                        <th id="a">Communication</th>
                                        <th id="a">Miscellaneous</th>
                                        <th id="a">Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="myTable"><?= $disb_rows ?></tbody>
                                <tfoot>
                                    <tr class="foot">
                                      <td id="t" colspan="5">Total</td>
                                      <td id="ftotal"></td>
                                      <td id="ftotal"></td>
                                      <td id="ftotal"></td>
                                      <td id="ftotal"></td>
                                      <td id="ftotal"></td>
                                      <td id="alltotal"></td>
                                    </tr>
                                    <tr>
                                      <td id="t" colspan="9" style="background-color: transparent!important;"></td>
                                      <td class="foot" id="t">Expense</td>
                                      <td class="foot" id="etotal"></td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td id="t" colspan="9" style="background-color: transparent!important;"></td>
                                      <td class="foot" id="t">Request Amount</td>
                                      <td class="foot" id="rtotal"></td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td id="t" colspan="9" style="background-color: transparent!important;"></td>
                                      <td class="foot" id="t">Variance</td>
                                      <td class="foot" id="variance">
                                        <p style="text-align: right;font-size: 14px;font-weight: 700;"></p>
                                      </td>
                                      <td></td>
                                    </tr>
                                    <tr style="display: none;">
                                      <td id="t" colspan="9" style="background-color: transparent!important;"></td>
                                      <td class="foot" id="t">Balance</td>
                                      <td class="foot" id="balance"></td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td id="t" colspan="9" style="background-color: transparent!important;"></td>
                                      <td style="text-align: center;"><button class="btn btn-success btn-mini"onClick="addRow()">Add</button></td>
                                      <td style="text-align: center;"><button class="btn btn-primary btn-mini" id="open-modal">Submit</button></td>
                                      <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                      </div>
                      <div class="fourth">
                          <div class="sign-card">
                            <div class="app-detail">
                              <h4 class="prep">Prepared by:</h4>
                              <h5><?=$username?></h5>
                            </div>
                            <div class="app-sign" style="height: 40px;">
                              <p class="sign">Signature: </p>
                              <div id="signature-container"></div>
                            </div>
                            <div class="app-sign">
                              <p>Date: </p>
                              <p class="dt" id="dateSign"></p>
                            </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            <div id="signature-modal" class="sign-modal">
                <div class="modal-content">
                    <canvas id="signature-pad" width="400" height="200"></canvas>
                    <br>
                    <div style="display: flex;flex-wrap: wrap;gap: 10px;">
                      <button class="btn btn-danger btn-mini" id="cancel-btn">Cancel</button>
                      <button class="btn btn-default btn-mini" id="clear-btn">Clear</button>
                      <button class="btn btn-primary btn-mini" id="confirm-btn">Confirm</button>
                    </div>
                </div>
            </div>
            <?php if (!empty($disb)) { 
                foreach ($disb as $dd) {
                    $disbNo = $dd['dis_no'];
                    $custodian = $dd['dis_empno'];
                    $attachment = PCF::GetAttachment($disbNo);
                    $comment = PCF::GetComment($disbNo, $custodian); 
            ?>
                <div class="right-side" id="<?= $dd['dis_no'] ?>">
                    <input type="hidden" name="entryID" value="<?= $dd['dis_no'] ?>">
                    <div class="comm-card">
                        <?php if (!empty($attachment)) { 
                            foreach ($attachment as $at) { ?>
                            <div class="attachment-card">
                                <div class="image-container">
                                    <?php
                                    if (!empty($at['file'])) {
                                        // Ensure no extra spaces and split file paths correctly
                                        $files = explode(',', $at['file']);
                                        foreach ($files as $file) {
                                            // $file = trim($file); // Trim any spaces
                                            if (!empty($file)) { ?>
                                                <img src="assets/<?= htmlspecialchars($file) ?>" id="thumbnail">
                                              <?php  }
                                            }
                                        } else {
                                            echo '<p>No attachments found.</p>';
                                        }
                                        ?>
                                    </div>
                                </div>

                        <?php } 
                        } else { ?>
                            <input type="hidden" name="disbur_no" value="<?= $disbNo ?>">
                            <div style="display: flex; margin-bottom: 5px; width: 95%;">
                                <p style="width: 70px; margin-right: 5px;">PCV | OR</p>
                                <input type="file" name="attachment[]" class="form-control" multiple>
                            </div>
                            <div id="proofApproval" style="display: none; width: 95%;">
                                <p style="width: 70px; margin-right: 5px;">Approval</p>
                                <input type="file" name="screenshot[]" class="form-control" multiple required="">
                            </div>
                            <div style="text-align: right; width: 95%;">
                                <button class="btn btn-primary btn-mini" id="saveFile">Save</button>
                            </div>
                            <div class="alert alert-success" style="display: none; width: 95%;">
                                <strong>Attachment added!</strong>
                            </div>
                            <div class="attachment-card">
                                <div class="image-container">
                                    <p>No attachments uploaded.</p>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <div class="comment-card">
                                <div class="message-container" id="message-container-<?= $dd['dis_no'] ?>">
                            <?php if (!empty($comment)) { 
                                foreach ($comment as $com) { ?>
                                    <?php if ($com['com_type'] == 'sent') { ?>
                                    <div class="message-card">
                                        <img class="sender" src="https://teamtngc.com/hris2/pages/empimg/<?=$com['com_sender']?>.jpg" width="40" height="40">
                                        <div class="message received"><?=$com['com_content']?></div>
                                    </div>
                                    <?php } elseif ($com['com_type'] == 'reply') { ?>
                                    <div class="message sent"><?=$com['com_content']?></div>
                                    <?php } ?>
                            <?php } 
                            } else { ?>
                                <!-- <div class="message-container" id="message-container"></div> -->
                            <?php } ?>
                                </div>
                            
                              <div class="message-input">
                                <input type="hidden" name="disbNo" value="<?= $disbNo ?>" placeholder="Type a message...">
                                <input type="text" id="commentRep-<?= $dd['dis_no'] ?>" value="" placeholder="Type a message...">
                                <a class="sendMessage" data-disbno="<?= $dd['dis_no'] ?>"><i class='bx bxs-send'></i></a>
                              </div>
                        </div>
                    </div>
                </div>
            <?php 
                } 
            } ?>

        </div>
    </div>
</div>
<script src="../assets/js/pcf.js"></script>
<script type="text/javascript">
$(document).on('click', '.sendMessage', function() {
    const disbNo = $(this).data('disbno');
    const comment = $('#commentRep-' + disbNo).val();

    const formData = new FormData();
    formData.append('disbur_no', disbNo);
    formData.append('comments', comment);

    // Send AJAX request
    $.ajax({
        url: 'save_comment', // PHP script to handle file upload
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // Clear the input field
            $('#commentRep-' + disbNo).val('');

            // Append the new message to the message container
            const newMessage = `
                    <div class="message sent">${comment}</div>
            `;
            $('#message-container-' + disbNo).append(newMessage);

            // Scroll to the bottom of the message container
            $('#message-container-' + disbNo).scrollTop($('#message-container-' + disbNo)[0].scrollHeight);

            // Show success message
            $('.alert-success').show();
            setTimeout(function() {
                $('.alert-success').hide(); // Hide success message after 3 seconds
            }, 3000);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
});
$(document).on("click", ".cancel-btn", function (e) {
    e.preventDefault();

    let disNo = $(this).data("id"); // Get the row ID
    let $row = $(this).closest("tr"); // Select the row

    $.ajax({
        url: "cancel_row", // Your PHP script to update status
        type: "POST",
        data: { dis_no: disNo, status: "cancelled" },
        success: function (response) {
            if (response == "success") {
                // Change status and mark row as cancelled
                $row.attr("data-stat", "cancelled");
                $row.find("td[data-field='dis_payee']").html('<span style="color: red;">Cancelled</span>');

                // Remove cancel button
                $row.find(".cancel-btn").remove();

                // Remove contenteditable attribute from all <td> in the row
                $row.find("td").removeAttr("contenteditable");

                // Uncheck all checkboxes in the cancelled row
                $row.find("input[type='checkbox']").prop("checked","disabled", false);
                // Uncheck all checkboxes in the cancelled row
                $row.find("input[type='checkbox']").prop("disabled", true);

                // Disable all date input fields
                $row.find("input[type='date']").prop("disabled", true);

                // Recalculate totals immediately
                updateFooterTotals();
            } else {
                alert("Failed to update status.");
            }
        },
        error: function () {
            alert("Error in AJAX request.");
        }
    });
});

</script>
<?php } } ?>