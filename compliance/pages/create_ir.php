<?php
    require_once($com_root."/db/db.php");
    require_once($com_root."/actions/get_profile.php");
    
    $date = date("Y-m-d");
    $Year = date("Y");
    $Month = date("m");
    $Day = date("d");
    $yearMonth = date("Y-m");
    $employee = Profile::GetEmployee();

    try {
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
                CONCAT(head.bi_emplname, ' ', head.bi_empfname) AS headNAME,
                b.jrec_reportto,
                b.`jrec_outlet`,
                b.`jrec_department`,
                b.`jrec_position`
            FROM 
                tbl201_basicinfo a
            LEFT JOIN 
                tbl201_jobrec b ON a.bi_empno = b.jrec_empno
            LEFT JOIN 
                tbl201_basicinfo head ON b.jrec_reportto = head.bi_empno
            LEFT JOIN 
                tbl_jobdescription jd ON jd.jd_code = b.jrec_position
            LEFT JOIN 
                tbl201_jobinfo ji ON ji.ji_empno = a.bi_empno
            WHERE 
                a.bi_empno = :user_id
                AND a.datastat = 'current'
                AND b.jrec_type = 'Primary'
                AND b.jrec_status = 'Primary'
                AND ji.ji_remarks = 'Active'
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
            $reportID = $user['jrec_reportto'];
            $position = $user['jrec_position'];
            $department = $user['jrec_department'];
            $outlet = $user['jrec_outlet'];
            $date = date('F j, Y');
        } else {
            error_log("No user found for ID: $user_id");
            $username = "Guest";
        }
    } else {
        $username = "Guest";
    }
    
?>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-12" style="padding: 20px;">
              <div class="panel panel-default" style="border: 1px solid #a59e9e !important;">
                  <div class="panel-heading" style="background-color: #dfe2e3;color: #000000;">
                      <a class="btn btn-primary btn-mini" href="/Portal/compliance/ir"><i class="icofont icofont-arrow-left"></i> Back</a>
                      <label>Create IR</label>
                  </div>
                  <div class="panel-body" style="padding: 10px;">
                      <div class="card">
                        <div id="personal-info1" style="background-color: white; padding: 20px;">
                            <div class="atdview">
                                <a href="/Portal/compliance/ir"><i class="icofont icofont-arrow-left" style="font-size: 24px;"></i></a>
                            </div>
                              <input type="hidden" name="position" id="posInput" value="<?=$position?>">
                              <input type="hidden" name="department" id="deptInput" value="<?=$department?>">
                              <input type="hidden" name="outlet" id="outInput" value="<?=$outlet?>">
                              <label id="_13aLabel">
                                <p style="width: 100px;">To: </p> 
                                <?php echo $reportto; ?><input type="hidden" name="sendto" id="sendtoInput" value="<?=$reportID?>">
                              </label>
                              <label id="_13aLabel">
                                <p style="width: 100px;">CC: </p> 
                                <select class="selectpicker " multiple data-live-search="true" name="ccnames" id="ccInput">
                                  <?php if (!empty($employee)) { 
                                      foreach ($employee as $k) { ?>
                                          <option value="<?=$k['bi_empno']?>"><?=$k['bi_emplname'].' '.$k['bi_empfname']?></option>       
                                  <?php } } ?>
                                </select>
                              </label>
                              <label id="_13aLabel">
                                <p style="width: 100px;">From: </p> 
                                <p><?php echo $username; ?></p> 
                              </label>
                              <label id="_13aLabel">
                                <p style="width: 100px;">Date: </p> 
                                <p> <?php echo $date; ?></p>
                              </label>        
                              <label id="_13aLabel">
                                <p style="width: 100px;">Subject: </p> 
                                <input type="text" class="form-control" name="irsubject" id="irsubInput"> 
                              </label>
                              <hr><br>
                              <p>INFORMATION ABOUT THE INCIDENT</p><br>
                              <div style="display: flex;">
                                <div id="ir-sm-div">
                                  <p>Date of Incident</p>
                                  <input class="form-control" type="date" name="incdate" id="incdateInput" required />
                                </div>
                                <div id="ir-sm-div">
                                  <p>Location of Incident</p>
                                  <p><input class="form-control" type="text" name="inclocation" id="inclocInput" required /></p>
                                </div>
                                <div id="ir-sm-div">
                                  <p>Amount Involved, if any.</p>
                                  <p><input class="form-control" type="text" name="amount" id="amtInput" /></p>
                                </div>
                                <div id="ir-sm-div">
                                  <p>Expected Performance/Standard violated</p>
                                  <p><input class="form-control" type="text" name="violation" id="vioInput" /></p>
                                </div>
                              </div>

                              <div style="display: flex;">
                                  <div id="ir-sm-div">
                                    <p>Person Involved</p>
                                      <select class="selectpicker" multiple data-live-search="true" name="ccnames" id="ccInput">
                                        <?php if (!empty($employee)) { 
                                            foreach ($employee as $k) { ?>
                                                <option value="<?=$k['bi_empno']?>"><?=$k['bi_emplname'].' '.$k['bi_empfname']?></option>       
                                        <?php } } ?>
                                      </select>
                                  </div>
                                  <div id="ir-sm-div" style="width: 10%;">
                                    <p>Audit Finding/s</p>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                      <label style="width:20%;"><input type="radio" class="form-control" id="yes" name="audyn" value="yes"> No</label>
                                      <label style="width:20%;"><input type="radio" class="form-control" id="no" name="audyn" value="no"> Yes</label>
                                    </div>
                                  </div>
                              </div>
                              <p>Description of Incident (what happened, how it happened, person/s involved) Be as specific as possible.</p>
                              <textarea class="form-control" name="ir_desc" id="descInput"></textarea>
                              <hr>
                              <p>As part of his/her responsibilities (Responsibilidad niya ang), is expected to:</p>
                              <textarea class="form-control" name="ir_res1" id="res1Input"></textarea>
                              <p>Protect the Interests of the Company by (protektahan ang kompanya sa pamamagitan ng)</p>
                              <textarea class="form-control" name="ir_res2" id="res2Input"></textarea>
                              <br>
                              <div id="ir-bottom">
                                <div id="ir-sign" style="display: flex;height: 30px;">
                                  <button type="button" id="save-irdraft" class="btn btn-success btn-mini waves-effect waves-light">Save as draft</button>
                                  <button type="button" id="save-ir" class="btn btn-primary btn-mini waves-effect waves-light ">Save</button>
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
<script type="text/javascript" src="../assets/js/incident-report.js"></script>