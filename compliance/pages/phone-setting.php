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
            <div class="col-md-10" style="margin-left: 250px;">
                <div class="card">
                    <div class="card-block" style="padding-left: 1.25rem !important;padding-right: 1rem !important;">
                        <!-- Row start -->
                        <div class="row">
                          <div class="col-md-11">
                          <div class="panel panel-default" style="border: 1px solid #a59e9e !important;">
                              <div class="panel-heading" style="background-color: #ffffff; color: #000000; display: flex; justify-content: space-between; align-items: center;">
                                <p style="margin: 0;">Phone Setting</p>
                                <div style="display: flex; gap: 5px;">
                                  <select class="form-control form-control-sm" id="accountTypeSelect" searchable="Search here..">
                                    <option value="" selected>All</option>
                                    <option value="Globe G-Cash">Globe G-Cash</option>
                                    <option value="Globe/Smart/Sun">Globe/Smart/Sun</option>
                                    <option value="Maya">Maya</option>
                                  </select>
                                  <button type="button" class="btn btn-outline-primary btn-mini waves-effect waves-light" data-toggle="modal" data-target="#psetting" style="width: 150px;">New</button>
                                  <button type="button" class="btn btn-outline-secondary btn-mini waves-effect waves-light" data-toggle="modal" data-target="#_13a-ir" style="width: 150px;">New Phone Agreement</button>
                                </div>
                              </div>
                              <div class="col-md-2">
                                  <div class="input-group input-group-sm" style="margin-bottom: 0px !important;margin-top: 10px !important;">
                                      <span class="input-group-addon" id="basic-addon8"><i class="icofont icofont-search-alt-1"></i></span>
                                      <input type="text" class="form-control" placeholder="search here">
                                  </div>
                              </div>
                              <div class="panel-body" style="padding: 10px;">
                                  <div id="phone-setting"></div>
                              </div>
                          </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="psetting" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <span class="modal-title">Phone Details</span>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                 </button>
             </div>
             <div class="modal-body" style="padding: 5px !important;">
               <div id="personal-form" style="display: flex; flex-direction: column; gap: 15px;">
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Account Type:</label>
                   <span style="flex: 1;" id="accountTypeDisplay"></span>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Model:</label>
                   <input type="text" class="form-control" name="psmodel" id="psmodelInput" style="flex: 1;">
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">IMEI 1:</label>
                   <input type="text" class="form-control" name="psimei1" id="psimei1Input" style="flex: 1;">
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">IMEI 2:</label>
                   <input type="text" class="form-control" name="psimei2" id="psimei2Input" style="flex: 1;">
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Unit Serial No:</label>
                   <input type="text" class="form-control" name="psserialNo" id="psserialNoInput" style="flex: 1;">
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Accessories:</label>
                   <input type="text" class="form-control" name="psaccessories" id="psaccessoriesInput" style="flex: 1;">
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 150px; margin-right: 10px;">Sim No.:</label>
                   <select class="form-control" searchable="Search here.." style="flex: 1;">
                     <option value="" selected>Select</option>
                   </select>
                 </div>
                 <div style="display: flex; align-items: center;">
                   <label style="width: 100px; margin-right: 10px;">Don't close this:</label>
                   <input type="checkbox" name="keepOpen" style="width:20px;" checked>
                 </div>
               </div>
               <div id="ps-message" class="alert" style="display: none;"></div>
             </div>

             <div class="modal-footer" id="footer">
                 <button type="button" class="btn btn-outline-danger btn-mini waves-effect waves-light" data-dismiss="modal">Cancel</button>
                 <button type="button" id="save-ps" class="btn btn-primary btn-mini waves-effect waves-light ">Save</button>
             </div>
         </div>
     </div>
 </div>
<script type="text/javascript" src="../assets/js/_PA.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#accountTypeSelect').on('change', function () {
            var selectedType = $(this).val();

            // Show all rows if no value is selected
            if (selectedType === "") {
                $('table.sticky-table tbody tr').show();
            } else {
                // Hide rows that don't match the selected type
                $('table.sticky-table tbody tr').each(function () {
                    var accountType = $(this).data('account-type');
                    if (accountType === selectedType) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
    });

  const accountTypeSelect = document.getElementById('accountTypeSelect');
  const accountTypeDisplay = document.getElementById('accountTypeDisplay');

  accountTypeSelect.addEventListener('change', function () {
    accountTypeDisplay.textContent = accountTypeSelect.value;
  });
</script>

