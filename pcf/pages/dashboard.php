<?php
require_once($pcf_root."/actions/get_pcf.php");

$date = date("Y-m-d");
$Year = date("Y");
$Month = date("m");
$Day = date("d");
$yearMonth = date("Y-m");
$pcf = PCF::GetPCFdetail($user_id,$outlet);
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
            <?php
              if (!empty($pcf)) {
                foreach ($pcf as $p) {
                  $custodian = $p['custodian'];
                  $outlet = $p['outlet_dept'];
                  $coh = PCF::GetCashOnHand($custodian,$outlet);
                  $disb = PCF::GetDisburement($outlet,$custodian);
            ?>
            <div id="center-sided">
                <div class="card">
                    <div class="card-block" style="height: 87vh;margin-top: 5px;margin-bottom: 5px;overflow: auto;">
                      <div class="first">
                          <div class="widget-card">
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
                          <?php if (!empty($coh)) { foreach ($coh as $i) { ?>
                          <div class="widget-card">
                              <div class="coh-cards">
                                <div class="sec-icon">
                                  <img src="assets/img/atm.png" width="60" height="60">
                                </div>
                                <div class="coh-detail">
                                      <div class="int-bal"><p><?=number_format($i['repl_expense'],2)?></p></div> 
                                      <div class="int-title">In transit</div> 
                                </div>
                                <!-- <div class="coh-detail">
                                      <div class="int-bal"><p>0.00</p></div> 
                                      <div class="int-title">In transit</div> 
                                </div> -->
                              </div>
                          </div>
                          <?php } } ?>
                      </div>
                      <div class="third" style="display:none;">
                        <div class="table-container">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th id="a">
                                            <!-- <input type="checkbox" id="checkAll" checked=""> -->
                                        </th>
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
                                    <?php if (!empty($disb)) { foreach ($disb as $d) { if (($d['dis_status']) == 'cancelled') { ?>
                                        <tr class="clickable-row" data-id="<?= $d['dis_no'] ?>" data-stat="<?= $d['dis_status'] ?>">
                                            <td id="a"><input type="checkbox" name="" checked disabled></td>
                                            <td id="a" class="entry-id" style="display:none;" data-field="dis_no"><?= $d['dis_no'] ?></td>
                                            <td id="a">
                                                <input type="date" class="date-input" data-field="dis_date" id="datePCF" value="<?= $d['dis_date'] ?>" disabled>
                                            </td>
                                            <td id="a" data-field="dis_pcv"><?= $d['dis_pcv'] ?></td>
                                            <td id="a" data-field="dis_or"><?= $d['dis_or'] ?></td>
                                            <td style="text-align: left; color: red">Cancelled</td>
                                            <td id="n" data-field="dis_office_store"><?= $d['dis_office_store'] ?></td>
                                            <td id="n" data-field="dis_transpo"><?= number_format($d['dis_transpo'],2) ?></td>
                                            <td id="n" data-field="dis_repair_maint"><?= number_format($d['dis_repair_maint'],2) ?></td>
                                            <td id="n" data-field="dis_commu"><?= number_format($d['dis_commu'],2) ?></td>
                                            <td id="n" data-field="dis_misc"><?= number_format($d['dis_misc'],2) ?></td>
                                            <td id="total" class="num" data-field="dis_total"><?= number_format($d['dis_total'],2) ?></td>
                                            <td></td>
                                        </tr>
                                    <?php }else{ ?>
                                      <tr class="clickable-row" data-id="<?= $d['dis_no'] ?>" data-stat="<?= $d['dis_status'] ?>">
                                            <td id="a"><input type="checkbox" name="" checked></td>
                                            <td id="a" class="entry-id" style="display:none;" data-field="dis_no"><?= $d['dis_no'] ?></td>
                                            <td id="a">
                                                <input type="date" class="date-input" data-field="dis_date" id="datePCF" value="<?= $d['dis_date'] ?>">
                                            </td>
                                            <td id="a" contenteditable data-field="dis_pcv"><?= $d['dis_pcv'] ?></td>
                                            <td id="a" contenteditable data-field="dis_or"><?= $d['dis_or'] ?></td>
                                            <td id="p" contenteditable data-field="dis_payee"><?= $d['dis_payee'] ?></td>
                                            <td id="n" contenteditable data-field="dis_office_store"><?= $d['dis_office_store'] ?></td>
                                            <td id="n" contenteditable data-field="dis_transpo"><?= number_format($d['dis_transpo'],2) ?></td>
                                            <td id="n" contenteditable data-field="dis_repair_maint"><?= number_format($d['dis_repair_maint'],2) ?></td>
                                            <td id="n" contenteditable data-field="dis_commu"><?= number_format($d['dis_commu'],2) ?></td>
                                            <td id="n" contenteditable data-field="dis_misc"><?= number_format($d['dis_misc'],2) ?></td>
                                            <td id="total" class="num" data-field="dis_total"><?= number_format($d['dis_total'],2) ?></td>
                                            <td>
                                                <a href="#" class="btn btn-outline-danger btn-mini cancel-btn" data-id="<?= $d['dis_no'] ?>">
                                                    <i class="ion-close"></i>
                                                </a>
                                            </td>

                                        </tr>
                                    <?php } } } ?>
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
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/pcf.js"></script>

<?php } } ?>