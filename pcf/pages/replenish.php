<?php
require_once($pcf_root."/actions/get_pcf.php");

$date = date("Y-m-d");
$Year = date("Y");
$Month = date("m");
$Day = date("d");
$yearMonth = date("Y-m");
if (isset($_GET['rliD'])) {
   $ID = $_GET['rliD'];

   $replenish = PCF::GetReplenish($ID);
   $repl = PCF::GetCOH($ID);

}
$pcf = PCF::GetPCFdetail($user_id,$outlet);
$sign_owner = PCF::GetSign($ID); 

?>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row" style="display: flex;">
            <div class="my-div">
                <?php if (!empty($hotside)) include_once($hotside); ?>
                <div style="height: 50px;padding: 10px;text-align: left;">
                    <span>TNGC | 2025</span>
                </div>
            </div>
            <!-- <div class="col-md-9" id="right-sided"> -->
                <div id="center-sided">
                    <div class="card">
                        <div class="card-block" style="height: 87vh;margin-top: 5px;margin-bottom: 5px;overflow: auto;">
                            <div class="first">
                                <?php if (!empty($repl)) { foreach ($repl as $r) { ?>
                                   <div style="display: flex;">
                                      <i class='bx bxs-buildings'></i>
                                      <input type="text" class="form-control" name="" value="<?=$r['repl_company']?>" readonly>
                                      <input type='hidden' class='form-control' id='pcfIDs' name='pcfID' value='<?=$r['repl_no']?>'/>
                                  </div>
                              <?php } } ?>
                          </div>
                          <div class="third">
                            <div class="table-container">
                              <table class="table table-striped table-bordered nowrap">
                                  <thead>
                                      <tr>
                                         <th></th>
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
                                 <tbody id="myTable">
                                <?php 
                                $showUpdateButton = false; // Flag to track if "Update" button should show
                                if (!empty($replenish)) { 
                                    foreach ($replenish as $r) {
                                        if($r['dis_status'] == 'returned') {
                                            $showUpdateButton = true; // Set flag to true if 'returned' status found
                                ?>
                                                <tr class="clickable-row" data-id="<?= $r['dis_no'] ?>" data-stat="<?= $r['dis_status'] ?>">
                                                    <td id="a"><input type="checkbox" name="" checked disabled=""></td>
                                                    <td id="a" class="entry-id" style="display:none;" data-field="dis_no"><?= $r['dis_no'] ?></td>
                                                    <td id="a">
                                                        <input type="date" class="date-input" data-field="dis_date" id="datePCF" value="<?= $r['dis_date'] ?>">
                                                    </td>
                                                    <td id="a" contenteditable data-field="dis_pcv"><?= $r['dis_pcv'] ?></td>
                                                    <td id="a" contenteditable data-field="dis_or"><?= $r['dis_or'] ?></td>
                                                    <?php if (($r['dis_status']) == 'cancelled') { ?>
                                                        <td style="text-align: center; color: red">Cancelled</td>
                                                    <?php } else { ?>
                                                        <td id="p" contenteditable data-field="dis_payee"><?= $r['dis_payee'] ?></td>
                                                    <?php } ?>
                                                    <td id="n" contenteditable data-field="dis_office_store"><?= $r['dis_office_store'] ?></td>
                                                    <td id="n" contenteditable data-field="dis_transpo"><?= number_format($r['dis_transpo'], 2) ?></td>
                                                    <td id="n" contenteditable data-field="dis_repair_maint"><?= number_format($r['dis_repair_maint'], 2) ?></td>
                                                    <td id="n" contenteditable data-field="dis_commu"><?= number_format($r['dis_commu'], 2) ?></td>
                                                    <td id="n" contenteditable data-field="dis_misc"><?= number_format($r['dis_misc'], 2) ?></td>
                                                    <td id="total" class="num" data-field="dis_total"><?= number_format($r['dis_total'], 2) ?></td>
                                                    <td><a href="#" id="cancel<?= $r['dis_no'] ?>" class="btn btn-outline-danger btn-mini"><i class="ion-close"></i></a></td>
                                                </tr>
                                            <?php 
                                            } else { 
                                            ?>
                                                <tr class="clickable-row" data-id="<?= $r['dis_no'] ?>" data-stat="<?= $r['dis_status'] ?>">
                                                    <td id="a"><input type="checkbox" name="" disabled=""></td>
                                                    <td id="a" class="entry-id" style="display:none;" data-field="dis_no"><?= $r['dis_no'] ?></td>
                                                    <td id="a">
                                                        <?= !empty($r['dis_date']) ? date('m/d/Y', strtotime($r['dis_date'])) : 'N/A'; ?>
                                                    </td>
                                                    <td id="a" data-field="dis_pcv"><?= $r['dis_pcv'] ?></td>
                                                    <td id="a" data-field="dis_or"><?= $r['dis_or'] ?></td>
                                                    <?php if (($r['dis_status']) == 'cancelled') { ?>
                                                        <td style="text-align: center; color: red">Cancelled</td>
                                                    <?php } else { ?>
                                                        <td id="p" data-field="dis_payee"><?= $r['dis_payee'] ?></td>
                                                    <?php } ?>
                                                    <td id="n" data-field="dis_office_store"><?= $r['dis_office_store'] ?></td>
                                                    <td id="n" data-field="dis_transpo"><?= number_format($r['dis_transpo'], 2) ?></td>
                                                    <td id="n" data-field="dis_repair_maint"><?= number_format($r['dis_repair_maint'], 2) ?></td>
                                                    <td id="n" data-field="dis_commu"><?= number_format($r['dis_commu'], 2) ?></td>
                                                    <td id="n" data-field="dis_misc"><?= number_format($r['dis_misc'], 2) ?></td>
                                                    <td id="total" class="num" data-field="dis_total"><?= number_format($r['dis_total'], 2) ?></td>
                                                </tr>
                                            <?php } 
                                        } 
                                    } 
                                    ?>
                                </tbody>
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
                                      <td class="foot" id="t">Cash on hand</td>
                                      <?php if (!empty($pcf)) { foreach ($pcf as $p) {
                                          $dept = $p['outlet_dept'];
                                          $assigned = PCF::GetPCFAsignatory($dept,$user_id);  ?>
                                          <td class="foot" id="cash">
                                            <p style="text-align: right;font-size: 14px;font-weight: 700;"><?=$p['cash_on_hand']?></p>
                                        </td>
                                    <?php }} ?>
                                    <td></td>
                                </tr>
                                <tr>
                                  <td id="t" colspan="9" style="background-color: transparent!important;"></td>
                                  <td class="foot" id="t">Variance</td>
                                  <td class="foot" id="variance"></td>
                                  <td></td>
                              </tr>
                              <?php if (!empty($assigned)) { ?>
                                <?php if ($r['dis_status'] = 'submit') { ?>
                                    <tr>
                                      <td id="t" colspan="10" style="background-color: transparent!important;"></td>
                                      <td style="text-align: center;"><button class="btn btn-primary btn-mini" id="open-modal">Approve</button></td>
                                      <td></td>
                                  </tr>
                              <?php } ?>
                                <?php if ($showUpdateButton) { ?>
                                    <tr>
                                        <td id="t" colspan="10" style="background-color: transparent!important;"></td>
                                        <td style="text-align: center;"><button class="btn btn-primary btn-mini" id="update">Update</button></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                          <?php } ?>
                      </tfoot>
                  </table>
              </div>
          </div>
          <?php if (!empty($sign_owner)) { ?>
             <div class="fourth">
                <?php foreach ($sign_owner as $so) { ?>
                    <?php if (!empty($so['cust_name'])) { ?>
                        <div class="sign-card">
                            <div class="app-detail">
                                <h4 class="prep">Prepared by:</h4>
                                <h5><?php echo htmlspecialchars($so['cust_name'] ?? ''); ?></h5>
                            </div>
                            <div class="app-sign">
                                <p class="sign">Signature: </p>
                                <img src="<?php echo htmlspecialchars($so['cust_signature']); ?>" width="100" height="50">
                            </div>
                            <div class="app-sign">
                                <p>Date: </p>
                                <p class="dt"><?= !empty($so['cust_date']) ? date('m/d/Y', strtotime($so['cust_date'])) : 'N/A'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($so['approve_name'])) { ?>
                        <div class="sign-card">
                            <div class="app-detail">
                                <h4 class="prep">Approved by:</h4>
                                <h5><?php echo htmlspecialchars($so['approve_name'] ?? 'Not Approved'); ?></h5>
                            </div>
                            <div class="app-sign">
                                <p class="sign">Signature: </p>
                                <img src="<?php echo htmlspecialchars($so['approve_sign']); ?>" width="100" height="50">
                            </div>
                            <div class="app-sign">
                                <p>Date: </p>
                                <p class="dt"><?= !empty($so['approve_date']) ? date('m/d/Y', strtotime($so['approve_date'])) : 'N/A'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($so['checker_name'])) { ?>
                        <div class="sign-card">
                            <div class="app-detail">
                                <h4 class="prep">Checked by:</h4>
                                <h5><?php echo htmlspecialchars($so['checker_name'] ?? 'Checker Name'); ?></h5>
                            </div>
                            <div class="app-sign">
                                <p class="sign">Signature: </p>
                                <div id="signature-container"><img src="<?php echo htmlspecialchars($so['check_sign']); ?>" width="100" height="50"></div>
                            </div>
                            <div class="app-sign">
                                <p>Date: </p>
                                <p class="dt"><?= !empty($so['check_date']) ? date('m/d/Y', strtotime($so['check_date'])) : 'N/A'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($so['director_name'])) { ?>
                        <div class="sign-card">
                            <div class="app-detail">
                                <h4 class="prep">Finance Director:</h4>
                                <h5><?php echo htmlspecialchars($so['director_name'] ?? 'Director Name'); ?></h5>
                            </div>
                            <div class="app-sign">
                                <p class="sign">Signature: </p>
                                <div id="signature-container"><img src="<?php echo htmlspecialchars($so['fin_sign']); ?>" width="100" height="50"></div>
                            </div>
                            <div class="app-sign">
                                <p>Date: </p>
                                <p class="dt"><?= !empty($so['check_date']) ? date('m/d/Y', strtotime($so['fin_date'])) : 'N/A'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } }?>
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
<?php if (!empty($replenish)) { 
    foreach ($replenish as $dd) {
        $disbNo = $dd['dis_no'];
        $custodian = $dd['dis_empno'];
        $attachment = PCF::GetAttachment($disbNo);
        $comment = PCF::GetComment($disbNo); 
        ?>
        <div class="right-side" id="<?= $dd['dis_no'] ?>">
            <input type="hidden" name="entryID" value="<?= $dd['dis_no'] ?>">
            <div class="comm-card">
                <?php if (!empty($attachment)) { 
                    foreach ($attachment as $at) { ?>
                        <!-- <input type="text" name="disbur_no<?= $disbNo ?>" value="<?= $at['disbur_no'] ?>"> -->
                        <?php if ($dd['dis_status'] == 'returned') { ?>
                            <input type="hidden" name="disbur_no" value="<?= $disbNo ?>">
                            <div style="display: flex; margin-bottom: 5px; width: 95%;">
                                <p style="width: 70px; margin-right: 5px;">PCV | OR</p>
                                <input type="file" name="attachment[]" class="form-control" multiple>
                            </div>
                            <div id="proofApproval" style="display: none; width: 95%;">
                                <p style="width: 70px; margin-right: 5px;">Approval</p>
                                <input type="file" name="screenshot[]" class="form-control" multiple>
                            </div>
                            <div style="text-align: right; width: 95%;">
                                <button class="btn btn-primary btn-mini" id="saveFile">Save</button>
                            </div>
                            <div class="alert alert-success" style="display: none; width: 95%;">
                                <strong>Attachment added!</strong>
                            </div>
                        <?php } ?>
                        <div class="attachment-card">
                            <div class="image-container">
                                <?php
                                if (!empty($at['file'])) {
                                    $files = explode(',', $at['file']);
                                        $index = 0; // Initialize index counter
                                        foreach ($files as $file) {
                                            $file = trim($file); // Remove extra spaces
                                            if (!empty($file)) { ?>
                                                <!-- Clickable Image Thumbnail -->
                                                <a href="#!" data-toggle="modal" data-target="#imageModal<?= $index ?>">
                                                    <img src="http://192.168.105.170/Portal/pcf/<?= htmlspecialchars($file) ?>" 
                                                    width="150" height="90" 
                                                    style="cursor:pointer; margin:5px;">
                                                </a>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="imageModal<?= $index ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Attachment</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"><i class="ion-close-circled"></i></span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img src="http://192.168.105.170/Portal/pcf/<?= htmlspecialchars($file) ?>" 
                                                                class="img-fluid" 
                                                                alt="Attachment">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger btn-mini" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php  
                                                $index++; // Increment index for next modal
                                            }
                                        }
                                    } else {
                                        echo '<p>No attachments found.</p>';
                                    }
                                    ?>
                                </div>
                            </div>

                        <?php } 
                    } else { ?>
                        <div class="attachment-card">
                            <input type="hidden" name="disbur_no" value="<?= $disbNo ?>">
                            <div style="display: flex; margin-bottom: 5px; width: 95%;">
                                <p style="width: 70px; margin-right: 5px;">PCV | OR</p>
                                <input type="file" name="attachment[]" class="form-control" multiple>
                            </div>
                            <div id="proofApproval" style="display: none; width: 95%;">
                                <p style="width: 70px; margin-right: 5px;">Approval</p>
                                <input type="file" name="screenshot[]" class="form-control" multiple>
                            </div>
                            <div style="text-align: right; width: 95%;">
                                <button class="btn btn-primary btn-mini" id="saveFile">Save</button>
                            </div>
                            <div class="alert alert-success" style="display: none; width: 95%;">
                                <strong>Attachment added!</strong>
                            </div>
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
                            <?php } } ?>
                            <?php if ($dd['dis_status'] == 'returned') { ?>
                                <div class="message-card">
                                    <div class="message received">Returned</div>
                                </div>
                            <?php }elseif ($dd['dis_status'] == 'updated') { ?>
                                <div class="message sent">Updated</div>
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
<script type="text/javascript">
    $(document).ready(function () {
        function updateCashOnHand() {
        let cashOnHandElement = $("#cash p"); // Select cash on hand cell
        let etotalElement = $("#etotal"); // Select expense total cell
        
        let cashOnHand = parseFloat(cashOnHandElement.text().replace(/,/g, '')) || 0;
        let etotal = parseFloat(etotalElement.text().replace(/,/g, '')) || 0;
        
        let updatedCash = cashOnHand - etotal;
        
        // Update the displayed value with formatted output
        cashOnHandElement.text(updatedCash.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }

    // Call the function on page load
    updateCashOnHand();

    // Recalculate whenever the expense total (`etotal`) changes dynamically
    $(document).on("input", "#etotal", function () {
        updateCashOnHand();
    });
});

    $(document).ready(function () {
        $("#update").click(function () {
        var cashOnHand = $("#sec-coh").text().replace(/,/g, '').trim(); // Get cash_on_hand value and remove commas
        var replenosh_no = "<?= isset($_GET['rliD']) ? $_GET['rliD'] : '' ?>"; // Get the replenosh_no

        if (replenosh_no === "") {
            alert("No replenishment ID found.");
            return;
        }

        $.ajax({
            url: "update_COH", // Create this PHP file for updating
            type: "POST",
            data: {
                replenosh_no: replenosh_no,
                cash_on_hand: cashOnHand
            },
            success: function (response) {
                alert(response); // Show success or error message
            },
            error: function () {
                alert("Error updating cash on hand.");
            }
        });
    });
    });
    $(document).ready(function() {
        $('.clickable-row').on('click', function() {
            $('.clickable-row').removeClass('highlighted-row');

            $(this).addClass('highlighted-row');

            $('.right-side').hide();

            const id = $(this).data('id');

            $('#' + id).show();

            $('#center-sided').css('width', '60%');
        });
    });
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
                $('.alert-success').hide();
            }, 3000);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
});
    $(document).ready(function() {
        console.log("Fetched images:", $('.image-container img').map(function() { return $(this).attr('src'); }).get());

        const imageStore = {
            attachment: [],
            screenshot: []
        };

        $('.image-container img').each(function() {
            imageStore.attachment.push($(this).attr('src'));
        });

        function displayAllImages(container) {
            $(container).empty();

            imageStore.attachment.forEach(image => {
                $(container).append(
                    `<img src="${image}" style="width: 100px; height: auto; margin: 5px;" alt="Attachment">`
                    );
            });

            imageStore.screenshot.forEach(image => {
                $(container).append(
                    `<img src="${image}" style="width: 100px; height: auto; margin: 5px;" alt="Screenshot">`
                    );
            });
        }

        function handleFileSelection(input, inputType) {
            if (input.files && input.files.length > 0) {
                for (let i = 0; i < input.files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imageStore[inputType].push(e.target.result);
                        displayAllImages('.image-container');
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            } else {
                displayAllImages('.image-container');
            }
        }

        $('input[name="attachment[]"]').on('change', function() {
            handleFileSelection(this, 'attachment');
        });

        $('input[name="screenshot[]"]').on('change', function() {
            handleFileSelection(this, 'screenshot');
        });

        displayAllImages('.image-container');

        $('#saveFile').on('click', function() {
            const formData = new FormData();
            const disburNo = $('input[name="disbur_no"]').val();

            // Append all attachment files
            $.each($('input[name="attachment[]"]')[0].files, function(i, file) {
                formData.append('attachment[]', file);
            });

            // Append all screenshot files
            $.each($('input[name="screenshot[]"]')[0].files, function(i, file) {
                formData.append('screenshot[]', file);
            });

            // Append disbur_no
            formData.append('disbur_no', disburNo);

            // Send AJAX request
            $.ajax({
                url: 'save_attachment',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('.alert-success').show();
                    setTimeout(function() {
                        $('.alert-success').hide();
                    }, 3000);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        // Handle table row click
        $('.clickable-row').on('click', function() {
            $('.image-container').empty(); // Clear old images
            const disburNo = $(this).data('id');
            
            $.ajax({
                url: 'fetch_attachment',
                type: 'POST',
                data: { disbur_no: disburNo },
                success: function(response) {
                    const images = JSON.parse(response);
                    imageStore.attachment = images; // Store images
                    displayAllImages('.image-container'); // Display them
                },
                error: function(error) {
                    console.log('Error fetching images:', error);
                }
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
    // Get today's date in YYYY-MM-DD format
    let today = new Date().toISOString().split("T")[0];

    // Select all date inputs with class 'date-input' and set the max attribute
    document.querySelectorAll(".date-input").forEach(function (input) {
        input.setAttribute("max", today);
    });
});
</script>
<script src="../assets/js/pcf.js"></script>