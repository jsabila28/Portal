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
                    <a href="">
                      <p>
                        <img src="assets/img/atd_icons/maintenance.png" width="40" height="40" style="margin-right: 5px;">Maintenance
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd_icons/request.png" width="40" height="40" style="margin-right: 5px;">Request
                      </p>
                    </a>
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
                        <img src="assets/img/atd_icons/receipt.png" width="40" height="40" style="margin-right: 5px;">About
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
                                        <a class="nav-link active" data-toggle="tab" href="#home3" role="tab">Pending</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#profile3" role="tab">Checked</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#messages3" role="tab">Reviewed</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#settings3" role="tab">Approved</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#settings3" role="tab">Confirmed</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#settings3" role="tab">Verified</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                    <li class="nav-item" style="width: 100px !important;">
                                        <a class="nav-link" data-toggle="tab" href="#settings3" role="tab">Clarification</a>
                                        <div class="slide" style="width: 100px !important;"></div>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content" style="background-color: white;padding: 10px;">
                                    <div class="tab-pane active" id="home3" role="tabpanel">
                                        <div class="dt-responsive table-responsive">
                                            <table id="saving-reorder" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Request No.</th>
                                                        <th>Requested by</th>
                                                        <th>Employee</th>
                                                        <th>Amount</th>
                                                        <th>Date Requested</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><label class="badge badge-warning">HR</label> ATD-MIS00020</td>
                                                        <td>Finn Camacho</td>
                                                        <td>Finn Camacho</td>
                                                        <td>30,000.00</td>
                                                        <td>2009/04/07</td>
                                                        <td>Audit Findings | Wrong Computation</td>
                                                        <td>
                                                            <img src="assets/img/atd_icons/edit.png" width="30" height="30">
                                                            <img src="assets/img/atd_icons/deactive.png" width="30" height="30">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="badge badge-danger">Employee</label> ATD-MIS00008</td>
                                                        <td>Serge Baldwin</td>
                                                        <td>Serge Baldwin</td>
                                                        <td>15,500.00</td>
                                                        <td>2012/07/09</td>
                                                        <td>Gov Loan | SSS Salary Loan</td>
                                                        <td>
                                                            <img src="assets/img/atd_icons/edit.png" width="30" height="30">
                                                            <img src="assets/img/atd_icons/deactive.png" width="30" height="30">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <!-- <tfoot>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Position</th>
                                                        <th>Office</th>
                                                        <th>Age</th>
                                                        <th>Start date</th>
                                                        <th>Salary</th>
                                                    </tr>
                                                </tfoot> -->
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profile3" role="tabpanel">
                                        <p class="m-0">2.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                                    </div>
                                    <div class="tab-pane" id="messages3" role="tabpanel">
                                        <p class="m-0">3. This is Photoshop's version of Lorem IpThis is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean mas Cum sociis natoque penatibus et magnis dis.....</p>
                                    </div>
                                    <div class="tab-pane" id="settings3" role="tabpanel">
                                        <p class="m-0">4.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
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
