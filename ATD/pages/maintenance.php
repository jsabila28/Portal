<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-2" id="left-side" style="">
                <ul class="sidebar-menu">
                    <li>
                    <a href="/Portal/ATD/">
                      <p>
                        <img src="assets/img/atd_icons/home.png" width="40" height="40" style="margin-right: 5px;">Dashboard
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="maintenance">
                      <p>
                        <img src="assets/img/atd_icons/maintenance.png" width="40" height="40" style="margin-right: 5px;">Maintenance
                      </p>
                    </a>
                    <!-- Start of Sub-menu -->
                    <!-- <ul class="submenu" style="display: none; list-style-type: none; padding-left: 20px;">
                      <li>
                        <a href="#daily-report">ATD Type</a>
                      </li>
                      <li>
                        <a href="#weekly-report">ATD Category</a>
                      </li>
                      <li>
                        <a href="#monthly-report">ATD Item</a>
                      </li>
                    </ul> -->
                  </li>
                  <li class="has-submenu">
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd_icons/request.png" width="40" height="40" style="margin-right: 5px;">Request
                      </p>
                    </a>
                    <!-- Start of Sub-menu -->
                    <ul class="submenu" style="display: none; list-style-type: none; padding-left: 20px;">
                      <li>
                        <a href="#daily-report">HR Request</a>
                      </li>
                      <li>
                        <a href="#weekly-report">Accounting Request</a>
                      </li>
                      <li>
                        <a href="employee">Employee Request</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd_icons/report.png" width="40" height="40" style="margin-right: 5px;">Report
                      </p>
                    </a>
                  </li>

                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd_icons/monitoring.png" width="40" height="40" style="margin-right: 5px;">Payments Monitoring
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd_icons/about.png" width="40" height="40" style="margin-right: 5px;">About
                      </p>
                    </a>
                  </li>
                </ul>
            </div>
            <div class="col-md-9" id="req-list" style="">
                <div class="card">
                    <div class="card-block" style="padding-left: 1.25rem !important;padding-right: 1rem !important;">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">                                      
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs md-tabs" role="tablist">
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link active" data-toggle="tab" href="#list" role="tab">Maintenance List</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#type" role="tab">ATD Type</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#category" role="tab">ATD Category</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#item" role="tab">ATD Item</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content" style="background-color: white;padding: 10px;">
                                    <div class="tab-pane active" id="list" role="tabpanel">
                                        <div class="dt-responsive table-responsive">
                                            <table id="saving-reorder" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>ATD Type</th>
                                                        <th>ATD Category</th>
                                                        <th>ATD Item</th>
                                                        <th># of Payroll</th>
                                                        <th>Take-Home Pay (%)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Employee</td>
                                                        <td>Surplus assets</td>
                                                        <td>Chair</td>
                                                        <td id="num">1</td>
                                                        <td id="num">0%</td>
                                                        <td>
                                                            <img src="assets/img/atd_icons/edit.png" width="30" height="30">
                                                            <img src="assets/img/atd_icons/deactive.png" width="30" height="30">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>HR</td>
                                                        <td>Audit Findings</td>
                                                        <td>Wrong Computation</td>
                                                        <td id="num">10</td>
                                                        <td id="num">80%</td>
                                                        <td>
                                                            <img src="assets/img/atd_icons/edit.png" width="30" height="30">
                                                            <img src="assets/img/atd_icons/deactive.png" width="30" height="30">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Accounting</td>
                                                        <td>Travel Fees</td>
                                                        <td>Plane ticket</td>
                                                        <td id="num">1</td>
                                                        <td id="num">0</td>
                                                        <td>
                                                            <img src="assets/img/atd_icons/edit.png" width="30" height="30">
                                                            <img src="assets/img/atd_icons/deactive.png" width="30" height="30">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="type" role="tabpanel">
                                        <form>
                                            
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="category" role="tabpanel">
                                        <form>
                                            
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="item" role="tabpanel">
                                        <form>
                                            
                                        </form>
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
<script type="text/javascript">
$(document).ready(function(){
  $(".has-submenu > a").click(function(e){
    e.preventDefault(); // Prevent the default action of the link

    var $submenu = $(this).siblings(".submenu");
    
    // Slide toggle the submenu and ensure that it pushes other elements down
    $submenu.slideToggle('fast', function(){
      // Optional: Adjust the sidebar height dynamically if needed
    });
  });
});

</script>