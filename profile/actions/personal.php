<?php
require_once($sr_root . "/db/db.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $port_db = Database::getConnection('port');
    $hr_db = Database::getConnection('hr');

   
        $stmt = $port_db->prepare("SELECT * FROM tbl201_persinfo WHERE pers_empno = ?");
        $stmt->execute([$user_id]);
        $personal = $stmt->fetchAll(PDO::FETCH_ASSOC);    


    if (!empty($personal)) {
        foreach ($personal as $p) {
            // Fetching contact info
            $stmt = $port_db->prepare("SELECT * FROM tbl201_contact WHERE cont_empno = ?");
            $stmt->execute([$user_id]);
            $contact = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($contact as $c) {
                // CONTACT INFO START
                echo '<div class="card-block" id="prof-card">';  //prof-card start
                echo '<div class="contact">'; //contact start
                      
                echo '<div class="numbers">
                        <div class="icon">
                          <i class="icofont icofont-ipod-touch"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($c['cont_person_num']) . '</p><br> 
                          <span>Phone Number</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          <i class="icofont icofont-ipod-touch"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($c['cont_company_num']) . '</p><br> 
                          <span>Company Phone</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          <i class="icofont icofont-email"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($c['cont_email']) . '</p><br> 
                          <span>Email</span>
                        </div>
                      </div>';
                      
                echo '<div class="numbers">
                        <div class="icon">
                            <i class="icofont icofont-ui-call"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($c['cont_telephone']) . '</p><br> 
                          <span>Telephone</span>
                        </div>
                      </div>';
                echo '</div>'; //contact end
                echo '</div>';  //prof-card end
            }
            // CONTACT INFO END
            // ADDRESS INFO START
            $stmt = $port_db->prepare("
                SELECT 
                    permanent.pr_name AS permanent_province,
                    permanent.ct_name AS permanent_city,
                    current.pr_name AS current_province,
                    current.ct_name AS current_city,
                    birth.pr_name AS birth_province,
                    birth.ct_name AS birth_city
                FROM (
                    SELECT a.*, b.*, c.*
                    FROM tbl201_address a
                    LEFT JOIN tbl_province b ON b.pr_code = a.add_perm_prov
                    LEFT JOIN tbl_municipality c ON c.ct_id = a.add_perm_city
                ) AS permanent
                JOIN (
                    SELECT a.*, b.*, c.*
                    FROM tbl201_address a
                    LEFT JOIN tbl_province b ON b.pr_code = a.add_cur_prov
                    LEFT JOIN tbl_municipality c ON c.ct_id = a.add_cur_city
                ) AS current ON current.add_empno = permanent.add_empno
                JOIN (
                    SELECT a.*, b.*, c.*
                    FROM tbl201_address a
                    LEFT JOIN tbl_province b ON b.pr_code = a.add_birth_prov
                    LEFT JOIN tbl_municipality c ON c.ct_id = a.add_birth_city
                ) AS birth ON birth.add_empno = permanent.add_empno
                WHERE permanent.add_empno = ?
            ");
            $stmt->execute([$user_id]);
            $address = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($address as $a) {
                // Address Info
                echo '<div class="card-block" id="prof-card">';  //prof-card start
                echo '<div class="contact">'; //contact start
                echo '<div class="numbers">
                        <div class="icon">
                            <i class="fa fa-home" aria-hidden="true"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($a['permanent_city'] . ', ' . $a['permanent_province']) . '</p><br> 
                          <span>Permanent Address</span>
                        </div>
                      </div>';
                      
                echo '<div class="numbers">
                        <div class="icon">
                          <i class="typcn typcn-location"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($a['current_city'] . ', ' . $a['current_province']) . '</p><br> 
                          <span>Current Address</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          <i class="icofont icofont-social-gnome"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($a['birth_city'] . ', ' . $a['birth_province']) . '</p><br>  
                          <span>Place of Birth</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          <i class="icofont icofont-map-search"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($a['permanent_province']) . '</p><br>  
                          <span>Province</span>
                        </div>
                      </div>';

                echo '</div>'; //contact end
                echo '</div>';  //prof-card end
                }
                //ADDRESS INFO END 
                //OTHER PERSONAL INFO START
                echo '<div class="card-block" id="prof-card">'; 
                echo '<div class="contact">'; //contact start
                echo '<div class="numbers">
                        <div class="icon">
                            <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                        </div>
                        <div class="content">
                          <p>'. date("F j, Y", strtotime($p['pers_birthdate'])) . '</p><br> 
                          <span>Date of birth</span>
                        </div>
                      </div>';
                      
                echo '<div class="numbers">
                        <div class="icon">
                          <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                        </div>
                        <div class="content">
                          <p>';
                          if ($p['pers_birthdate']) {
                              function calculateAge($birthdate) {
                                  $birthDate = new DateTime($birthdate);
                                  $currentDate = new DateTime();
                                  $age = $birthDate->diff($currentDate);
                                  return $age->y;
                              }
                              
                              echo calculateAge($p['pers_birthdate']);
                          } else {
                              echo '0';
                          }

                          echo'</p><br> 
                          <span>Age</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          <i class="typcn typcn-heart-half-outline"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($p['pers_civilstat']) . '</p><br>  
                          <span>Civil Status</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          <i class="zmdi zmdi-male-female"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($p['pers_sex']) . '</p><br>  
                          <span>Sex</span>
                        </div>
                      </div>';
                echo '</div>'; //contact end
                echo '<div class="contact" style="margin-top: 25px;">'; //contact start
                echo '<div class="numbers">
                        <div class="icon">
                            <i class="icofont icofont-throne"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($p['pers_religion']) . '</p><br> 
                          <span>Religion</span>
                        </div>
                      </div>';
                      
                echo '<div class="numbers">
                        <div class="icon">
                          <i class="wi wi-raindrop"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($p['pers_bloodtype']) . '</p><br> 
                          <span>Blood type</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          <i class="ti-ruler"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($p['pers_height']) . 'cm</p><br>  
                          <span>Height</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          <i class="ti-dashboard"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($p['pers_weight']) . 'kg</p><br>  
                          <span>Weight</span>
                        </div>
                      </div>';
                echo '</div>'; //contact end
                echo '</div>';//prof-card end 
                //OTHER PERSONAL INFO END

                #COMPLETE GOVERNMENT ID
                echo'<div class="card-block" id="prof-card">
                      <div class="contact">
                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-id-card"></i>
                            </div>
                            <div class="content">
                              <p> 35-0017545-8</p><br> 
                              <span>SSS</span>
                            </div>
                          </div>
                          
                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-id-card"></i>
                            </div>
                            <div class="content">
                              <p> 1212-7646-3910</p><br> 
                              <span>PAGIBIG</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-id-card"></i>
                            </div>
                            <div class="content">
                              <p> 382-592-170</p><br> 
                              <span>TIN</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-id-card"></i>
                            </div>
                            <div class="content">
                              <p> 100253981606</p><br> 
                              <span>PHILHEALTH</span>
                            </div>
                          </div>
                      </div>
                    </div>';
                    #COMPLETE GOVERNMENT ID END-->

                //MODAL EDIT PROFILE START
                echo '<div class="modal fade" id="Personal-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
                          <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <p style="width:90%;"> Please provide accurate and complete information in all fields. This information is required for reference purposes only within the company and will not be used for any illegal purposes. All personal data will be securely stored and handled in accordance with company privacy policies and applicable data protection laws. It will not be shared externally without your consent.</p>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                                      </button>
                                  </div>
                                  <div class="modal-body" style="padding: 5px !important;">
                                    

                                    <div id="personal-form">';
                                        $deptSql = "SELECT jrec_department 
                                                    FROM tbl201_jobrec
                                                    WHERE jrec_empno = :employeeId";
                                        $deptStmt = $port_db->prepare($deptSql);
                                        $deptStmt->execute(['employeeId' => $user_id]);
                                        
                                        $department = $deptStmt->fetchColumn();
                                        $year = date('y');
                                        $month = date('m');
                                        
                                        if (!$department) {
                                            throw new Exception("No department found for employee ID $employeeId");
                                        }

                                        $sql = "SELECT pers_id FROM tbl201_persinfo WHERE pers_id LIKE :pattern ORDER BY pers_id DESC LIMIT 1";
                                        $stmt = $port_db->prepare($sql);
                                        $stmt->execute(['pattern' => "$year-$month-%-$department"]);

                                        $lastId = $stmt->fetchColumn();

                                        if ($lastId) {
                                            $lastSequence = (int)substr($lastId, 6, 3);
                                            $nextSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT); 
                                        } else {
                                            $nextSequence = '001';
                                        }

                                        $newId = "$year-$month-$nextSequence-$department";

                                        echo '<input class="form-control" type="hidden" name="pers_id"  value="' . htmlspecialchars($newId) . '"/>';

                                            echo'<div id="pers-name">
                                                <label style="width:22% !important">Last Name<span id="required">*</span> 
                                                    <input class="form-control" type="text" name="lastname" required value="' . htmlspecialchars($p['pers_lastname']) . '"/>
                                                </label>
                                                <label style="width:22% !important">Middle Name 
                                                    <input class="form-control" type="text" name="midname" value="' . htmlspecialchars($p['pers_midname']) . '"/>
                                                </label>
                                                <label style="width:22% !important">First Name<span id="required">*</span> 
                                                    <input class="form-control" type="text" name="firstname" required value="' . htmlspecialchars($p['pers_firstname']) . '"/>
                                                </label>
                                                <label style="width:22% !important">Maiden Name 
                                                    <input class="form-control" type="text" name="maidenname" value="' . htmlspecialchars($p['pers_maidenname']) . '"/>
                                                </label>
                                                <label style="width:10% !important">Suffix 
                                                    <input class="form-control" type="text" name="maidenname" value="' . htmlspecialchars($p['pers_prefname']) . '"/>
                                                </label>
                                            </div>';
                                            $stmt = $port_db->prepare("SELECT * FROM tbl201_contact WHERE cont_empno = ?");
                                            $stmt->execute([$user_id]);
                                            $contact = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            
                                            foreach ($contact as $c) {
                                            echo'<div id="pers-name">
                                                <label>Personal Contact<span id="required">*</span> 
                                                    <input class="form-control" type="text" name="person_num" required value="' . htmlspecialchars($c['cont_person_num']) . '"/>
                                                </label>
                                                <label>Company Contact 
                                                    <input class="form-control" type="text" name="company_num" value="' . htmlspecialchars($c['cont_company_num']) . '"/>
                                                </label>
                                                <label>Email<span id="required">*</span> 
                                                    <input class="form-control" type="email" name="email" required value="' . htmlspecialchars($c['cont_email']) . '"/>
                                                </label>
                                                <label>Telephone 
                                                    <input class="form-control" type="text" name="telephone" value="' . htmlspecialchars($c['cont_telephone']) . '"/>
                                                </label>
                                            </div>';
                                            }
                                            $stmt = $port_db->prepare("SELECT * FROM tbl201_gov_req WHERE gov_empno = ?");
                                            $stmt->execute([$user_id]);
                                            $gov_num = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            
                                            foreach ($gov_num as $g) {
                                            echo'<div id="pers-name">
                                                <label>SSS Number<span id="required">*</span> 
                                                    <input class="form-control" type="text" name="sss" value="' . htmlspecialchars($g['gov_sss']) . '" required />
                                                </label>
                                                <label>Pagibig Number<span id="required">*</span> 
                                                    <input class="form-control" type="text" name="pagibig" value="' . htmlspecialchars($g['gov_pagibig']) . '" required />
                                                </label>
                                                <label>Philhealth Number<span id="required">*</span> 
                                                    <input class="form-control" type="text" name="philhealth" value="' . htmlspecialchars($g['gov_philhealth']) . '" required />
                                                </label>
                                                <label>Tin Number<span id="required">*</span> 
                                                    <input class="form-control" type="text" name="tin" value="' . htmlspecialchars($g['gov_tin']) . '" required />
                                                </label>
                                            </div>';
                                            }
                                            $stmt = $port_db->prepare("SELECT 
                                                b.`pr_name` AS P_province, 
                                                c.`ct_name` AS P_city,
                                                d.`br_name` AS P_barangay,
                                                e.`pr_name` AS C_province, 
                                                f.`ct_name` AS C_city,
                                                g.`br_name` AS C_barangay,
                                                h.`pr_name` AS B_province, 
                                                i.`ct_name` AS B_city,
                                                j.`br_name` AS B_barangay
                                            FROM 
                                                tbl201_address a
                                            LEFT JOIN 
                                                tbl_province b ON b.`pr_code` = a.`add_perm_prov`
                                            LEFT JOIN 
                                                tbl_municipality c ON c.`ct_id` = a.`add_perm_city`
                                            LEFT JOIN 
                                                tbl_barangay d ON d.`br_id` = a.`add_perm_brngy`
                                            LEFT JOIN 
                                                tbl_province e ON e.`pr_code` = a.`add_cur_prov`
                                            LEFT JOIN 
                                                tbl_municipality f ON f.`ct_id` = a.`add_cur_city`
                                            LEFT JOIN 
                                                tbl_barangay g ON g.`br_id` = a.`add_cur_brngy`
                                            LEFT JOIN 
                                                tbl_province h ON h.`pr_code` = a.`add_birth_prov`
                                            LEFT JOIN 
                                                tbl_municipality i ON i.`ct_id` = a.`add_birth_city`
                                            LEFT JOIN 
                                                tbl_barangay j ON j.`br_id` = a.`add_birth_brngy`
                                            WHERE 
                                                a.`add_empno` = ?
                                            
                                            ");
                                            $stmt->execute([$user_id]);
                                            $address = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            
                                            foreach ($address as $ad) {
                                            echo'<div id="pers-name">
                                                <label>Permanent Address </label>
                                                <label> 
                                                    <select class="form-control" id="province-perm1" name="Pprovince">
                                                      <option value="" selected>' . htmlspecialchars($ad['P_province']) . '</option>  
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="municipal-perm1" name="Pmunicipal">
                                                        <option value="">Select Municipality</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="brngy-perm1" name="Pbrngy">
                                                        <option value="">Select Barangay</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div id="pers-name">
                                                <label>Current Address </label>
                                                <label> 
                                                    <select class="form-control" id="province-cur1" name="Cprovince">
                                                        <option>Select Province</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="municipal-cur1" name="Cmunicipal">
                                                        <option>Select Municipality</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="brngy-cur1" name="Cbrngy">
                                                        <option>Select Barangay</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div id="pers-name">
                                                <label>Place of Birth </label>
                                                <label> 
                                                    <select class="form-control" id="province-birth1" name="Bprovince">
                                                        <option>Select Province</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="municipal-birth1" name="Bmunicipal">
                                                        <option>Select Municipality</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="brngy-birth1" name="Bbrngy">
                                                        <option>Select Barangay</option>
                                                    </select>
                                                </label>
                                            </div>';
                                          }
                                          echo'<div id="pers-name">
                                                <label>Birth Date<span id="required">*</span> 
                                                    <input class="form-control" type="date" name="birthdate" value="'. date('Y-m-d', strtotime($p['pers_birthdate'])) . '" required/>
                                                </label>
                                                <label>Civil Status<span id="required">*</span> 
                                                    <input class="form-control" type="text" name="civilstat" required value="' . htmlspecialchars($p['pers_civilstat']) . '"/>
                                                </label>
                                                <label>Sex<span id="required">*</span> <br>';
                                                    if($p['pers_sex'] == 'Male'){
                                                        echo'<div id="sex"><input type="radio" id="gender" name="sex" value="Male" checked/> <p>Male</p></div>';
                                                        echo'<div id="sex"><input type="radio" id="gender" name="sex" value="Female"/><p>Female</p></div>';
                                                    }else{
                                                        echo'<div id="sex"><input type="radio" id="gender" name="sex" value="Male"/><p>Male</p></div>';
                                                        echo'<div id="sex"><input type="radio" id="gender" name="sex" value="Female" checked/><p>Female</p></div>';
                                                    }
                                                    
                                                    
                                                echo'</label>
                                                <label>Religion 
                                                    <input class="form-control" type="text" name="religion" value="' . htmlspecialchars($p['pers_religion']) . '"/>
                                                </label>
                                            </div>
                                            <div id="pers-name">
                                                <label>Height(cm) 
                                                    <input class="form-control" type="text" name="height" value="' . htmlspecialchars($p['pers_height']) . '"/>
                                                </label>
                                                <label>Weight(kg) 
                                                    <input class="form-control" type="text" name="weight" value="' . htmlspecialchars($p['pers_weight']) . '"/>
                                                </label>
                                                <label>Blood Type 
                                                    <input class="form-control" type="text" name="bloodtype" value="' . htmlspecialchars($p['pers_bloodtype']) . '"/>
                                                </label>
                                            </div>
                                            <div id="pers-name">
                                                <label>Dialect
                                                    <input class="form-control" type="text" name="dialect" value="' . htmlspecialchars($p['pers_dialect']) . '"/>
                                                </label>
                                            </div>
                                    </div>
                                    <div id="PersonalMessage" class="mt-3"></div>
                                  </div>
                                  <div class="modal-footer" id="footer">
                                      <button type="button" class="btn btn-default btn-mini waves-effect " data-dismiss="modal">Close</button>
                                      <button type="button" id="save-personal" class="btn btn-primary btn-mini waves-effect waves-light ">Save changes</button>
                                  </div>
                              </div>
                          </div>
                      </div>';
                //MODAL EDIT PROFILE END
                // <input class="form-control" type="text" value="' . htmlspecialchars($p['pers_sex']) . '" required/>
        }
    } else {
        //MODAL EDIT PROFILE START
        echo '<div class="modal fade" id="Personal-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title"></h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                              </button>
                          </div>
                          <div class="modal-body" style="padding: 5px !important;">
                            <p> Please provide accurate and complete information in all fields. This information is required for reference purposes only within the company and will not be used for any illegal purposes. All personal data will be securely stored and handled in accordance with company privacy policies and applicable data protection laws. It will not be shared externally without your consent.</p>

                            <div id="personal-form">';
                                $deptSql = "SELECT jrec_department 
                                            FROM tbl201_jobrec
                                            WHERE jrec_empno = :employeeId";
                                $deptStmt = $port_db->prepare($deptSql);
                                $deptStmt->execute(['employeeId' => $user_id]);
                                
                                $department = $deptStmt->fetchColumn();
                                $year = date('y');
                                $month = date('m');
                                
                                if (!$department) {
                                    throw new Exception("No department found for employee ID $employeeId");
                                }

                                $sql = "SELECT pers_id FROM tbl201_persinfo WHERE pers_id LIKE :pattern ORDER BY pers_id DESC LIMIT 1";
                                $stmt = $port_db->prepare($sql);
                                $stmt->execute(['pattern' => "$year-$month-%-$department"]);

                                $lastId = $stmt->fetchColumn();

                                if ($lastId) {
                                    $lastSequence = (int)substr($lastId, 6, 3);
                                    $nextSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT); 
                                } else {
                                    $nextSequence = '001';
                                }

                                $newId = "$year-$month-$nextSequence-$department";

                                echo '<input class="form-control" type="hidden" name="pers_id"  value="' . htmlspecialchars($newId) . '"/>';

                                    echo'<div id="pers-name">
                                        <label style="width:22% !important">Last Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="lastname"  value=""/>
                                        </label>
                                        <label style="width:22% !important">Middle Name 
                                            <input class="form-control" type="text" name="midname" value=""/>
                                        </label>
                                        <label style="width:22% !important">First Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="firstname"  value=""/>
                                        </label>
                                        <label style="width:22% !important">Maiden Name 
                                            <input class="form-control" type="text" name="maidenname" value=""/>
                                        </label>
                                        <label style="width:10% !important">Suffix
                                            <input class="form-control" type="text" name="prefixname" value=""/>
                                        </label>
                                    </div>';
                                    
                                    echo'<div id="pers-name">
                                        <label>Personal Contact<span id="required">*</span> 
                                            <input class="form-control" type="text" name="person_num"  value=""/>
                                        </label>
                                        <label>Company Contact 
                                            <input class="form-control" type="text" name="company_num" value=""/>
                                        </label>
                                        <label>Email<span id="required">*</span> 
                                            <input class="form-control" type="email" name="email"  value=""/>
                                        </label>
                                        <label>Telephone 
                                            <input class="form-control" type="text" name="telephone" value=""/>
                                        </label>
                                    </div>';
                                    echo'<div id="pers-name">
                                        <label>SSS Number<span id="required">*</span> 
                                            <input class="form-control" type="text" name="sss" value=""  />
                                        </label>
                                        <label>Pagibig Number<span id="required">*</span> 
                                            <input class="form-control" type="text" name="pagibig" value=""  />
                                        </label>
                                        <label>Philhealth Number<span id="required">*</span> 
                                            <input class="form-control" type="text" name="philhealth" value=""  />
                                        </label>
                                        <label>Tin Number<span id="required">*</span> 
                                            <input class="form-control" type="text" name="tin" value=""  />
                                        </label>
                                    </div>';
                                    echo'<div id="pers-name">
                                        <label>Permanent Address </label>
                                        <label> 
                                            <select class="form-control" id="province-perm2" name="Pprovince">
                                                <option value="">Select Province</option>
                                            </select>
                                        </label>
                                        <label> 
                                            <select class="form-control" id="municipal-perm2" name="Pmunicipal">
                                                <option value="">Select Municipality</option>
                                            </select>
                                        </label>
                                        <label> 
                                            <select class="form-control" id="brngy-perm2" name="Pbrngy">
                                                <option value="">Select Barangay</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div id="pers-name">
                                        <label>Current Address </label>
                                        <label> 
                                            <select class="form-control" id="province-cur2" name="Cprovince">
                                                <option>Select Province</option>
                                            </select>
                                        </label>
                                        <label> 
                                            <select class="form-control" id="municipal-cur2" name="Cmunicipal">
                                                <option>Select Municipality</option>
                                            </select>
                                        </label>
                                        <label> 
                                            <select class="form-control" id="brngy-cur2" name="Cbrngy">
                                                <option>Select Barangay</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div id="pers-name">
                                        <label>Place of Birth </label>
                                        <label> 
                                            <select class="form-control" id="province-birth2" name="Bprovince">
                                                <option>Select Province</option>
                                            </select>
                                        </label>
                                        <label> 
                                            <select class="form-control" id="municipal-birth2" name="Bmunicipal">
                                                <option>Select Municipality</option>
                                            </select>
                                        </label>
                                        <label> 
                                            <select class="form-control" id="brngy-birth2" name="Bbrngy">
                                                <option>Select Barangay</option>
                                            </select>
                                        </label>
                                    </div>';
                                    echo'<div id="pers-name">
                                        <label>Birth Date<span id="required">*</span> 
                                            <input class="form-control" type="date" name="birthdate" value="" />
                                        </label>
                                        <label>Civil Status<span id="required">*</span> 
                                            <input class="form-control" type="text" name="civilstat"  value=""/>
                                        </label>
                                        <label>Sex<span id="required">*</span> <br>';
                                          echo'<div id="sex"><input type="radio" id="gender" name="sex" value="Male"/> <p>Male</p> </div>';
                                          echo'<div id="sex"><input type="radio" id="gender" name="sex" value="Female"/> <p>Female</p></div>';
                                            
                                        echo'</label>
                                        <label>Religion 
                                            <input class="form-control" type="text" name="religion" value=""/>
                                        </label>
                                    </div>
                                    <div id="pers-name">
                                        <label>Height(cm) 
                                            <input class="form-control" type="text" name="height" value=""/>
                                        </label>
                                        <label>Weight(kg) 
                                            <input class="form-control" type="text" name="weight" value=""/>
                                        </label>
                                        <label>Blood Type 
                                            <input class="form-control" type="text" name="bloodtype" value=""/>
                                        </label>
                                    </div>
                                    <div id="pers-name">
                                        <label>Dialect
                                            <input class="form-control" type="text" name="dialect" value=""/>
                                        </label>
                                    </div>
                            </div>
                          </div>
                          <div class="modal-footer" id="footer">
                              <button type="button" class="btn btn-default btn-mini waves-effect " data-dismiss="modal">Close</button>
                              <button type="button" id="save-personal" class="btn btn-primary btn-mini waves-effect waves-light ">Save changes</button>
                          </div>
                      </div>
                  </div>
              </div>';
        //MODAL EDIT PROFILE END
        }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
