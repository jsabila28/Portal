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
                            <i class="icofont icofont-ui-call"></i>
                        </div>
                        <div class="content">
                          <p>' . htmlspecialchars($c['cont_telephone']) . '</p><br> 
                          <span>Telephone</span>
                        </div>
                      </div>';
                      
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
                          <p></p><br> 
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

                                    <div id="personal-form"> 
                                        <form>
                                            <div id="pers-name">
                                                <label>Last Name<span id="required">*</span> 
                                                    <input class="form-control" type="text" required value="' . htmlspecialchars($p['pers_lastname']) . '"/>
                                                </label>
                                                <label>Middle Name 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($p['pers_midname']) . '"/>
                                                </label>
                                                <label>First Name<span id="required">*</span> 
                                                    <input class="form-control" type="text" required value="' . htmlspecialchars($p['pers_lastname']) . '"/>
                                                </label>
                                                <label>Maiden Name 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($p['pers_maidenname']) . '"/>
                                                </label>
                                            </div>';
                                            $stmt = $port_db->prepare("SELECT * FROM tbl201_contact WHERE cont_empno = ?");
                                            $stmt->execute([$user_id]);
                                            $contact = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            
                                            foreach ($contact as $c) {
                                            echo'<div id="pers-name">
                                                <label>Personal Contact<span id="required">*</span> 
                                                    <input class="form-control" type="text" required value="' . htmlspecialchars($c['cont_person_num']) . '"/>
                                                </label>
                                                <label>Company Contact 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($c['cont_company_num']) . '"/>
                                                </label>
                                                <label>Email<span id="required">*</span> 
                                                    <input class="form-control" type="email" required value="' . htmlspecialchars($c['cont_email']) . '"/>
                                                </label>
                                                <label>Telephone 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($c['cont_telephone']) . '"/>
                                                </label>
                                            </div>';
                                            }
                                            $stmt = $port_db->prepare("SELECT * FROM tbl201_gov_req WHERE gov_empno = ?");
                                            $stmt->execute([$user_id]);
                                            $gov_num = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            
                                            foreach ($gov_num as $g) {
                                            echo'<div id="pers-name">
                                                <label>SSS Number<span id="required">*</span> 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($g['gov_sss']) . '" required />
                                                </label>
                                                <label>Pagibig Number<span id="required">*</span> 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($g['gov_pagibig']) . '" required />
                                                </label>
                                                <label>Philhealth Number<span id="required">*</span> 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($g['gov_philhealth']) . '" required />
                                                </label>
                                                <label>Tin Number<span id="required">*</span> 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($g['gov_tin']) . '" required />
                                                </label>
                                            </div>';
                                            }
                                            echo'<div id="pers-name">
                                                <label>Permanent Address </label>
                                                <label> 
                                                    <select class="form-control" id="province" name="province">
                                                        <option>Select Province</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="municipal" name="municipal">
                                                        <option>Select Municipality</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="brngy" name="brngy">
                                                        <option>Select Barangay</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div id="pers-name">
                                                <label>Current Address </label>
                                                <label> 
                                                    <select class="form-control" id="provincec" name="province">
                                                        <option>Select Province</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="municipalc" name="municipal">
                                                        <option>Select Municipality</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="brngyc" name="brngy">
                                                        <option>Select Barangay</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div id="pers-name">
                                                <label>Place of Birth </label>
                                                <label> 
                                                    <select class="form-control" id="provincep" name="province">
                                                        <option>Select Province</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="municipalp" name="municipal">
                                                        <option>Select Municipality</option>
                                                    </select>
                                                </label>
                                                <label> 
                                                    <select class="form-control" id="brngyp" name="brngy">
                                                        <option>Select Barangay</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div id="pers-name">
                                                <label>Birth Date<span id="required">*</span> 
                                                    <input class="form-control" type="date" value="'. date('Y-m-d', strtotime($p['pers_birthdate'])) . '" required/>
                                                </label>
                                                <label>Civil Status<span id="required">*</span> 
                                                    <input class="form-control" type="text" required value="' . htmlspecialchars($p['pers_civilstat']) . '"/>
                                                </label>
                                                <label>Sex<span id="required">*</span> <br>';
                                                    if($p['pers_sex'] == 'Male'){
                                                        echo'<input type="checkbox" checked/> Male ';
                                                        echo'<input type="checkbox"/> Female';
                                                    }else{
                                                        echo'<input type="checkbox"/> Male ';
                                                        echo'<input type="checkbox" checked/> Female';
                                                    }
                                                    
                                                    
                                                echo'</label>
                                                <label>Religion 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($p['pers_religion']) . '"/>
                                                </label>
                                            </div>
                                            <div id="pers-name">
                                                <label>Height(cm) 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($p['pers_height']) . '"/>
                                                </label>
                                                <label>Weight(kg) 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($p['pers_weight']) . '"/>
                                                </label>
                                                <label>Blood Type 
                                                    <input class="form-control" type="text" value="' . htmlspecialchars($p['pers_bloodtype']) . '"/>
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-default btn-mini waves-effect " data-dismiss="modal">Close</button>
                                      <button type="button" class="btn btn-primary btn-mini waves-effect waves-light ">Save changes</button>
                                  </div>
                              </div>
                          </div>
                      </div>';
                //MODAL EDIT PROFILE END
                      // <input class="form-control" type="text" value="' . htmlspecialchars($p['pers_sex']) . '" required/>
        }
    } else {
        echo "No data available.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
