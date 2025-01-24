<?php
    require_once($com_root."/db/db.php");
    require_once($com_root."/actions/get_profile.php");
    require_once($com_root."/actions/get_person.php");
?>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-2" id="left-side" style="">
                <ul class="sidebar-menu">
                    <li>
                    <a href="phoneA">
                      <p>
                        <img src="assets/img/atd_icons/home.png" width="40" height="40" style="margin-right: 5px;">Dashboard
                      </p>
                    </a>
                  </li>
                  <li class="has-submenu">
                    <a href="phoneSetting">
                      <p>
                        <img src="/Portal/assets/img/phoneset.png" width="40" height="40" style="margin-right: 5px;">Phone Setting
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="mobileAcc">
                      <p>
                        <img src="/Portal/assets/img/mobileacc.png" width="40" height="40" style="margin-right: 5px;">Mobile Account Setting
                      </p>
                    </a>
                  </li>
                </ul>
            </div>
            <div class="col-md-10" id="right-div">
                <div class="card">
                    <div class="card-block" id="cardblock" style="padding-right: 1rem !important;">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-md-11" id="phone-agreement"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pagreement" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Agreement Details</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                 </button>
             </div>
             <div class="modal-body" style="padding: 5px !important;">
               <div id="personal-form" style="display: flex; flex-direction: column; gap: 15px;">
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">SIM No.:</label>
                   <select class="mdb-select md-form" searchable="Search here..">
                     <option value="" selected>Select</option>
                   </select>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">SIM Serial No:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">SIM Type:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Account Name:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Account No:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Plan:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Plan Features:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Monthly Service Fee:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">QRPH:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Merchant Desc:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
               </div>

               <div id="personal-form" style="display: flex; flex-direction: column; gap: 15px;">
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">IMEI 1:</label>
                   <select class="mdb-select md-form" searchable="Search here..">
                     <option value="" selected>Select</option>
                   </select>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">IMEI 2:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Phone Model:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Unit Serial No:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Accessories:</label>
                   <span id="accountTypeDisplay"></span>
                 </div>
               </div>

               <div id="personal-form" style="display: flex; flex-direction: column; gap: 15px;">
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Custodian:</label>
                    <select class="selectpicker" multiple data-live-search="true" name="ccnames" id="ccInput">
                      <?php if (!empty($employee)) { 
                          foreach ($employee as $k) { ?>
                              <option value="<?=$k['bi_empno']?>"><?=$k['bi_emplname'].' '.$k['bi_empfname']?></option>       
                      <?php } } ?>
                    </select>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Department/ Outlet::</label>
                   <input type="text" class="form-control" name="model" id="modelInput">
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Witness::</label>
                    <select class="selectpicker" multiple data-live-search="true" name="ccnames" id="ccInput">
                      <?php if (!empty($employee)) { 
                          foreach ($employee as $k) { ?>
                              <option value="<?=$k['bi_empno']?>"><?=$k['bi_emplname'].' '.$k['bi_empfname']?></option>       
                      <?php } } ?>
                    </select>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Released by::</label>
                    <select class="selectpicker" multiple data-live-search="true" name="ccnames" id="ccInput">
                      <?php if (!empty($employee)) { 
                          foreach ($employee as $k) { ?>
                              <option value="<?=$k['bi_empno']?>"><?=$k['bi_emplname'].' '.$k['bi_empfname']?></option>       
                      <?php } } ?>
                    </select>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Authorized by::</label>
                   <input type="text" class="form-control" name="author" id="authorInput">
                 </div>
               </div>

               <div id="personal-form" style="display: flex; flex-direction: column; gap: 15px;">
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Date Issued:</label>
                    <input type="date" class="form-control" name="dtissued" id="dtissuedInput">
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Recontracted:</label>
                   <input type="month" class="form-control" name="recont" id="recontInput">
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Date Returned:</label>
                    <input type="date" class="form-control" name="dtreturn" id="dtreturnInput">
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Remarks:</label>
                    <textarea name="remark" id="remarkInput"></textarea>
                 </div>
               </div>

               <div id="ir-message" class="alert" style="display: none;"></div>
             </div>

             <div class="modal-footer" id="footer">
                 <button type="button" id="save-irdraft" class="btn btn-outline-danger btn-mini waves-effect waves-light">Cancel</button>
                 <button type="button" id="save-ir" class="btn btn-primary btn-mini waves-effect waves-light ">Save</button>
             </div>
         </div>
     </div>
 </div>
 <script type="text/javascript">
    $(function () {
        $('select').selectpicker();
    });
</script>
<script type="text/javascript" src="../assets/js/_PA.js"></script>
