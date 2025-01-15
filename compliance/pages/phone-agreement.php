<?php
    require_once($com_root."/db/db.php");
    require_once($com_root."/actions/get_profile.php");
    
    $date = date("Y-m-d");
    $Year = date("Y");
    $Month = date("m");
    $Day = date("d");
    $yearMonth = date("Y-m");
    $globe = Profile::GetGlobe();

?><div class="page-wrapper">
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
                  <li class="has-submenu">
                    <a href="#dashboard">
                      <p>
                        <img src="/Portal/assets/img/phoneset.png" width="40" height="40" style="margin-right: 5px;">Phone Setting
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
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
                            <div class="col-lg-12 col-xl-12">                                      
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs md-tabs" role="tablist">
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link active" data-toggle="tab" href="#globe" role="tab">Globe Postpaid</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#smart" role="tab">Smart Postpaid</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#sun" role="tab">Sun Postpaid</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#gcash" role="tab">Globe G-Cash</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#maya" role="tab">Maya</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#sign" role="tab">For Signature</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#release" role="tab">For Release</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#issued" role="tab">Issued</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#returned" role="tab">Returned</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content" style="background-color: white;padding: 10px;">
                                    <div class="tab-pane active" id="globe" role="tabpanel">
                                        <div id="globe_agr"></div>
                                    </div>
                                    <div class="tab-pane" id="smart" role="tabpanel">
                                        
                                    </div>
                                    <div class="tab-pane" id="sun" role="tabpanel">
                                        
                                    </div>
                                    <div class="tab-pane" id="gcash" role="tabpanel">
                                        
                                    </div>
                                    <div class="tab-pane" id="maya" role="tabpanel">
                                        
                                    </div>
                                    <div class="tab-pane" id="sign" role="tabpanel">
                                        
                                    </div>
                                    <div class="tab-pane" id="release" role="tabpanel">
                                        
                                    </div>
                                    <div class="tab-pane" id="issued" role="tabpanel">
                                        
                                    </div>
                                    <div class="tab-pane" id="returned" role="tabpanel">
                                        
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
<script type="text/javascript" src="../assets/js/_PA.js"></script>
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