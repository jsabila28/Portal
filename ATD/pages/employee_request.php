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
                                <div class="page-header">
    							    <div class="page-header-title">
    							        <!-- <h4>Group Add-ons</h4> -->
    							        <!-- <span>Lorem ipsum dolor sit <code>amet</code>, consectetur adipisicing elit</span> -->
    							    </div>
    							    <div class="page-header-breadcrumb">
    							        <ul class="breadcrumb-title">
    							            <li class="breadcrumb-item">
    							                <a href="dashboard">
    							                    <i class="icofont icofont-home"></i>
    							                </a>
    							            </li>
    							            <li class="breadcrumb-item"><a href="#!">ATD</a>
    							            </li>
    							            <li class="breadcrumb-item"><a href="index.html">Employee Request Form</a>
    							            </li>
    							        </ul>
    							    </div>
    							</div>
    						</div>
    						<div class="col-sm-9">
    							<div class="row">
            				<div class="col-sm-6">
            				    <div class="input-group input-group-primary">
            				        <span class="input-group-addon">
            				           Category
            				        </span>
            				        <select class="js-example-basic-single col-sm-9">
            				                <option value="AL">Alabama</option>
            				                <option value="WY">Wyoming</option>
            				                <option value="WY">Peter</option>
            				                <option value="WY">Hanry Die</option>
            				                <option value="WY">Soeng Souy</option>
            				        </select>
            				    </div>
            				</div>
            				<div class="col-sm-6">
            				    <div class="input-group input-group-primary">
            				        <span class="input-group-addon">
            				           Item
            				        </span>
            				        <select class="js-example-basic-single col-sm-9">
                                    <option value="AL">Alabama</option>
                                    <option value="WY">Wyoming</option>
                                    <option value="WY">Peter</option>
                                    <option value="WY">Hanry Die</option>
                                    <option value="WY">Soeng Souy</option>
                            </select>
            				    </div>
            				</div>
            			</div>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group input-group-primary">
                            <span class="input-group-addon">
                               Total Amount
                            </span>
                            <input type="text" class="form-control money">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group input-group-primary">
                            <span class="input-group-addon">
                               Monthly Amortization
                            </span>
                            <input type="text" class="form-control money">
                        </div>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group input-group-primary">
                            <span class="input-group-addon">
                               # of Payroll
                            </span>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-primary">
                            <span class="input-group-addon">
                              <input type="checkbox" name=""> 15
                            </span>
                            <input type="text" class="form-control money">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-primary">
                            <span class="input-group-addon">
                              <input type="checkbox" name=""> 30
                            </span>
                            <input type="text" class="form-control money" readonly="readonly">
                        </div>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group input-group-primary">
                            <span class="input-group-addon">
                              Start Date
                            </span>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-primary">
                            <span class="input-group-addon">
                              End Date
                            </span>
                            <input type="date" class="form-control">
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