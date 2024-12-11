<div id="personal-info1" style="background-color: white; padding: 10px;">
     <div class="basic-info">
       <span id="userName">
       Incident Report
       </span>
     </div>
     <div class="basic-info">
        <div class="col-lg-12 col-xl-12">                                       
            <!-- Nav tabs -->
            <ul class="nav nav-tabs md-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#draft" role="tab">Draft</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#posted" role="tab">Posted</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#explain" role="tab">Need Explanation</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#solved" role="tab">Resolved</a>
                    <div class="slide"></div>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content card-block">
                <div class="tab-pane active" id="draft" role="tabpanel"><br>
                <div class="card">
                    <div class="card-block">
                    <div class="table-container" id="IRdraft">
                        
                    </div>
                    </div>
                </div>
                </div>
                <div class="tab-pane" id="posted" role="tabpanel"><br>
                    <div class="card">
                    <div class="card-block">
                    <div class="table-container" id="IRposted">
                        
                    </div>
                    </div>
                </div>
                </div>
                <div class="tab-pane" id="explain" role="tabpanel"><br>
                    <div class="card">
                    <div class="card-block">
                    <div class="table-container" id="IRexplain">
                        
                    </div>
                    </div>
                </div>
                </div>
                <div class="tab-pane" id="solved" role="tabpanel"><br>
                    <div class="card">
                    <div class="card-block">
                    <div class="table-container" id="IRsolved">
                        
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
     </div>
 </div>
<?php
    require_once($sr_root."/db/db.php");
    
    try {
        // $scms_db = Database::getConnection('scms');
        // $pi_db = Database::getConnection('pi');
        $hr_db = Database::getConnection('hr');
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        error_log("User ID: $user_id");

        $stmt = $hr_db->prepare("SELECT 
                a.bi_empno, 
                CONCAT(a.bi_empfname, ' ', a.bi_empmname, ' ', a.bi_emplname) AS fullname, 
                jd.jd_title, 
                CONCAT(head.bi_empfname, ' ', head.bi_empmname, ' ', head.bi_emplname) AS headNAME
            FROM 
                tbl201_basicinfo a
            LEFT JOIN 
                tbl201_jobrec b ON a.bi_empno = b.jrec_empno
            LEFT JOIN 
                tbl201_basicinfo head ON b.jrec_reportto = head.bi_empno
            LEFT JOIN 
                tbl_jobdescription jd ON jd.jd_code = b.jrec_position
            WHERE 
                a.bi_empno = :user_id
                AND b.jrec_type = 'Primary'
                AND b.jrec_status = 'Primary'
            GROUP BY a.bi_empno
            ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            error_log("Query Result: " . print_r($user, true));
            $username = $user['fullname'];
            $empno = $user['bi_empno'];
            $position = $user['jd_title'];
            $reportto = $user['headNAME'];
            $date = date('F j, Y');
        } else {
            error_log("No user found for ID: $user_id");
            $username = "Guest";
        }
    } else {
        $username = "Guest";
    }
?>
 <div class="modal fade" id="IRmodal" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Incident Report Form</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                 </button>
             </div>
             <div class="modal-body" style="padding: 5px !important;">
               <div id="personal-form">
                   <label>To: <?php echo $reportto; ?><p></p></label>
                   <label>CC: 
                        <select>
                            <option value="">Select Employee</option>
                            <option value="">Wyoming</option>
                            <option value="">Coming</option>
                            <option value="">Hanry Die</option>
                            <option value="">Soeng Souy</option>
                        </select>
                   </label>
                   <label>From: <?php echo $username; ?><p></p></label>
                   <label>Date: <?php echo $date; ?><p></p></label>
                   <label>Subject: <input type="text" class="form-control" name=""></label>
                   <label>"All fields marked with an asterisk (<span id="required">*</span>) are required. Please complete them."</label>
                    <div id="pers-name">
                         <label style="width:30% !important;">Date of Incident<span id="required">*</span>  
                             <input class="form-control" type="date" name="licensename" id="licenseInput" value=""/>
                         </label>
                         <label style="width:30% !important;">Location of Incident<span id="required">*</span> 
                             <input class="form-control" type="text" name="startdate" id="sdateInput" value=""/>
                         </label>
                         <label>Audit Finding/s<span id="required">*</span> 
                         <div style="display: flex !important;">
                            <input type="radio" id="age1" name="age" value="30">
                            <label for="age1">YES</label>
                            <input type="radio" id="age2" name="age" value="60">
                            <label for="age2">NO</label>
                         </div>  
                         </label>
                    </div>
                    <div id="pers-name">
                         <label style="width:30% !important;">Person Involved<span id="required">*</span>  
                            <?php require_once($sr_root."/pages/employee.php"); ?>
                            <select class="form-control">
                                <option>Select Employee</option>
                            </select>
                         </label>
                         <label style="width:40% !important;">Expected Performance/Standard violated<span id="required">*</span> 
                             <input class="form-control" type="text" value=""/>
                         </label>
                         <label>Amount Involved, if any. 
                            <input class="form-control" type="text" value=""/>
                         </label>
                    </div>
                   <label>Description of Incident (what happened, how it happened, person/s involved) Be as specific as possible.
                    <br><textarea></textarea></label><br>
                    <label>As part of his/her responsibilities (Responsibilidad niya ang), is expected to: Follow the SOP of (sumunod sa SOP na)
                    <br><textarea></textarea></label><br>
                    <label>Protect the Interests of the Company by (protektahan ang kompanya sa pamamagitan ng)<br> 
                    <textarea></textarea></label><br>
               </div>
               <div id="license-message" class="alert" style="display: none;"></div>
             </div>
             <div class="modal-footer" id="footer">
                 <button type="button" class="btn btn-default btn-mini waves-effect " data-dismiss="modal">Close</button>
                 <button type="button" id="save-license" class="btn btn-primary btn-mini waves-effect waves-light ">Save changes</button>
             </div>
         </div>
     </div>
 </div>
