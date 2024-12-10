<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <!-- <div class="col-md-2" id="left-side" style="">
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
                  </li>
                  <li class="has-submenu">
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd_icons/request.png" width="40" height="40" style="margin-right: 5px;">Request
                      </p>
                    </a>
                    <ul class="submenu" style="display: none; list-style-type: none; padding-left: 20px;">
                      <li>
                        <a href="request">HR Request</a>
                      </li>
                      <li>
                        <a href="request">Accounting Request</a>
                      </li>
                      <li>
                        <a href="request">Employee Request</a>
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
            </div> -->
            <div class="col-md-12" id="req-list" style="">
                <div class="card">
                    <div class="card-block" style="padding-left: 1.25rem !important;padding-right: 1rem !important;">
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">                                      
                                
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