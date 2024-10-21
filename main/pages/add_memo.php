<?php
require_once($main_root."/actions/memo.php");

$departments = Portal::GetDepartments();
$employees = Portal::GetEmployee();
?>
<div class="page-wrapper">
    <div class="page-header">
         <div class="page-header-title">
             <!-- <h4>Add Memo</h4> -->
             <!-- <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
         </div>
         <div class="page-header-breadcrumb">
             <ul class="breadcrumb-title">
                 <li class="breadcrumb-item">
                     <a href="index.html">
                         <i class="icofont icofont-home"></i>
                     </a>
                 </li>
                 <li class="breadcrumb-item"><a href="#!">Portal</a>
                 </li>
                 <li class="breadcrumb-item"><a href="#!">Memo</a>
                 </li>
             </ul>
         </div>
    </div>
    <div class="page-body">
        <div class="row" style="margin-left: 0px !important;margin-right: 0px !important;">
            <div class="col-sm-8">
                <div class="card" id="addmemo-card">
                    <!-- <div class="card-header">
                        <div class="card-header-left">
                            <h5>Badges</h5>
                            <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                        </div>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div> -->
                    <div class="card-block" style="padding: 1.25rem;">
                    <form>
                        <div class="form-group row" id="form-g">
                            <label class="col-sm-4 col-form-label">Date:
                                <?php
                                    echo date('F d, Y');
                                ?>

                            </label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Memo Number:
                                <?php require_once($main_root."/actions/get_memo_no.php"); ?>
                            </label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">To</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="selectCategory">
                                    <option value="">Select</option>
                                    <option value="all">All</option>
                                    <option value="company">Company</option>
                                    <option value="department">Department</option>
                                    <option value="employee">Employee</option>
                                    <option value="outlet">Outlet</option>
                                    <option value="area">Area</option>
                                </select>
                            </div>
                        
                            <!-- Company Select -->
                            <div class="col-sm-5" id="companySelect" style="display:none;">
                                <select class="form-control">
                                    <option>Select Company</option>
                                    <option>AGENCY</option>
                                    <option>ALAHAS BARATILYO</option>
                                    <option>AMEGA MICROFINANCE FOUNDATION, INC.</option>
                                    <option>GROW YOUR BUSINESS PINOY</option>
                                    <option>ICONIQLAST</option>
                                    <option>JACKSON SECURITY AGENCY</option>
                                    <option>PROMETE ME</option>
                                    <option>SOPHIA JEWELLERY INC.</option>
                                    <option>SUN GATE PAWN SHOP</option>
                                    <option>SUNGOLD TECHNOLOGIES INC.</option>
                                </select>
                            </div>
                        
                            <!-- Department Select -->
                            <div class="col-sm-5" id="departmentSelect" style="display:none;">
                                <select class="form-control">
                                    <option>Select Department</option>
                                    <?php
                                        if (!empty($departments)) {
                                            foreach ($departments as $d) {
                                    ?>
                                    <option><?=$d['Dept_Name']?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                        
                            <!-- Employee Select -->
                            <div class="col-sm-5" id="employeeSelect" style="display:none;">
                                <select class="form-control">
                                    <option>Select Employee</option>
                                    <?php
                                        if (!empty($employees)) {
                                            foreach ($employees as $e) {
                                    ?>
                                    <option><?=$e['bi_emplname'].' '.$e['bi_empfname'].', '.$e['bi_empmname'] ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                            
                            <!-- Outlet Select -->
                            <div class="col-sm-5" id="outletSelect" style="display:none;">
                                <select class="form-control">
                                    <option>Select Outlet</option>
                                    <!-- Add outlet options here -->
                                </select>
                            </div>
                        
                            <!-- Area Select -->
                            <div class="col-sm-5" id="areaSelect" style="display:none;">
                                <select class="form-control">
                                    <option>Select Area</option>
                                    <!-- Add area options here -->
                                </select>
                            </div>
                        </div>
                        
                        <!-- jQuery Script -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $('#selectCategory').change(function() {
                                    var selectedValue = $(this).val();
                                    // Hide all selects
                                    $('#companySelect, #departmentSelect, #employeeSelect, #outletSelect, #areaSelect').hide();
                        
                                    // Show the correct select based on the selected option
                                    if (selectedValue == 'company') {
                                        $('#companySelect').show();
                                    } else if (selectedValue == 'department') {
                                        $('#departmentSelect').show();
                                    } else if (selectedValue == 'employee') {
                                        $('#employeeSelect').show();
                                    } else if (selectedValue == 'outlet') {
                                        $('#outletSelect').show();
                                    } else if (selectedValue == 'area') {
                                        $('#areaSelect').show();
                                    }
                                });
                            });
                        </script>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Subject</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Follow the rules">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Upload File</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control">
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card" id="addmemo-card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <h5>Memo Guide</h5>
                            <!-- <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                        </div>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div>
                    <div class="card-block">
                       
                    </div>
                </div>

                <div class="card" id="addmemo-card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <h5>Sample</h5>
                            <!-- <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                        </div>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div>
                    <div class="card-block">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>