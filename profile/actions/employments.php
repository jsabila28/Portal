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

   
    $stmt = $port_db->prepare("SELECT * FROM tbl201_family WHERE fam_empno = ? GROUP BY fam_empno");
    $stmt->execute([$user_id]);
    $family = $stmt->fetchAll(PDO::FETCH_ASSOC);    


    if (!empty($family)) {
          
                // PERSONAL FAMILY INFO START
                echo '<div class="card-block" id="prof-card">';  //prof-card start
                // SPOUSE START
                $stmt = $port_db->prepare("SELECT 
                    CASE WHEN fam_relationship = 'Wife' THEN CONCAT(fam_firstname, ' ', fam_maidenname, ' ', fam_lastname) END AS Wife,
                    CASE WHEN fam_relationship = 'Wife' THEN fam_contact END AS Wife_phone,
                    CASE WHEN fam_relationship = 'Wife' THEN fam_occupation END AS Wife_work,
                    CASE WHEN fam_relationship = 'Wife' THEN fam_birthdate END AS Wife_birth,
                    CASE WHEN fam_relationship = 'Husband' THEN CONCAT(fam_firstname, ' ', fam_midname, ' ', fam_lastname) END AS Husband,
                    CASE WHEN fam_relationship = 'Husband' THEN fam_contact END AS Husband_phone,
                    CASE WHEN fam_relationship = 'Husband' THEN fam_occupation END AS Husband_work,
                    CASE WHEN fam_relationship = 'Husband' THEN fam_birthdate END AS Husband_birth
                    FROM tbl201_family
                    WHERE fam_empno = ?");
                $stmt->execute([$user_id]);
                $member = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo '<div class="contact">'; // Start the spouse contact section
                
                if (!empty($member)) {
                    $spouseName = '';
                    $spousePhone = '';
                    $spouseWork = '';
                    $spouseBirth = '';
                    foreach ($member as $m) {
                        if (!empty($m['Husband']) || !empty($m['Wife'])) {
                            $spouseName = !empty($m['Husband']) ? $m['Husband'] : $m['Wife'];
                            $spousePhone = !empty($m['Husband']) ? $m['Husband_phone'] : $m['Wife_phone'];
                            $spouseWork = !empty($m['Husband']) ? $m['Husband_work'] : $m['Wife_work'];
                            $spouseBirth = !empty($m['Husband']) ? $m['Husband_birth'] : $m['Wife_birth'];
                            break;
                        }
                    }
                
                    echo '<div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-love"></i>
                            </div>
                            <div class="content">
                              <p>' . htmlspecialchars($spouseName ?: 'None') . '</p><br> 
                              <span>Spouse Full Name</span>
                            </div>
                          </div>';
                    echo '<div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-iphone"></i>
                            </div>
                            <div class="content">
                              <p>' . htmlspecialchars($spousePhone ?: 'None') . '</p><br> 
                              <span>Contact Number</span>
                            </div>
                          </div>';
                
                    echo '<div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-labour"></i>
                            </div>
                            <div class="content">
                              <p>' . htmlspecialchars($spouseWork ?: 'None') . '</p><br> 
                              <span>Occupation</span>
                            </div>
                          </div>';
                    
                    
                    echo '<div class="numbers">
                            <div class="icon">
                              <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                              <p>' . htmlspecialchars($spouseBirth ?: 'None') . '</p><br> 
                              <span>Age</span>
                            </div>
                          </div>';
                
                } else {
                    
                }
                
                echo '</div>'; // End the spouse contact section
                // SPOUSE END
                echo '</div>';  //prof-card end
               

                  //MODAL EDIT FAMILY BACKGROUND START
                  echo '<div class="modal fade" id="Emp-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title">Employments</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                              </button>
                          </div>
                          <div class="modal-body" style="padding: 5px !important;">
                              
                              <!-- Alert Message -->
                              <div id="family-message" class="alert" style="display:none;"></div>
                              
                              <p>Please provide accurate and complete information...</p>

                              <div id="personal-form">
                                  <div id="pers-name">
                                      <label>Last Name<span id="required">*</span> 
                                          <input class="form-control" type="text" id="Famlastname" value=""/>
                                      </label>
                                      <label>Middle Name 
                                          <input class="form-control" type="text" id="Fammidname" value=""/>
                                      </label>
                                      <label>First Name<span id="required">*</span> 
                                          <input class="form-control" type="text" id="Famfirstname" value=""/>
                                      </label>
                                      <label>Suffix 
                                          <input class="form-control" type="text" id="Famsuffixname" value=""/>
                                      </label>
                                  </div>
                                  
                                  <div id="pers-name">
                                      <label>Maiden Name 
                                          <input class="form-control" type="text" id="Fammaidenname" value=""/>
                                      </label>
                                      <label>Relationship<span id="required">*</span> 
                                          <select id="relationship">
                                              <option>Select Relation</option>
                                              <option>Spouse</option>
                                              <option>Mother</option>
                                              <option>Father</option>
                                              <option>Son</option>
                                              <option>Daughter</option>
                                              <option>Sister</option>
                                              <option>Brother</option>
                                              <option>Live-in Partner</option>
                                          </select>
                                      </label>
                                      <label>Contact Number<span id="required">*</span> 
                                          <input class="form-control" type="text" id="Famperson_num" value=""/>
                                      </label>
                                      <label>Birthdate 
                                          <input class="form-control" type="date" id="Fambirthdate" value=""/>
                                      </label>
                                  </div>
                                  
                                  <div id="pers-name">
                                      <label>Occupation 
                                          <input class="form-control" type="text" id="Famoccupation" value=""/>
                                      </label>
                                      <label>Work Place 
                                          <input class="form-control" type="text" id="Famworkplace" value=""/>
                                      </label>
                                      <label>Work Address 
                                          <input class="form-control" type="text" id="Famworkadd" value=""/>
                                      </label>
                                      <label>Sex<span id="required">*</span>
                                          <div id="sex"><input id="Famgender" type="radio" name="Famsex" value="Male" /> <p>Male</p> </div>
                                          <div id="sex"><input id="Famgender" type="radio" name="Famsex" value="Female" /> <p>Female</p></div>
                                      </label>
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer" id="footer">
                              <button type="button" class="btn btn-default btn-mini waves-effect" data-dismiss="modal">Close</button>
                              <button type="button" id="save-family" class="btn btn-primary btn-mini waves-effect waves-light">Save changes</button>
                          </div>
                      </div>
                  </div>
                </div>';
                //MODAL EDIT FAMILY BACKGROUND END
        } else {
                //MODAL EDIT FAMILY BACKGROUND START
                echo '<div class="modal fade" id="Emp-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Family Information</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                            </button>
                        </div>
                        <div class="modal-body" style="padding: 5px !important;">
                            
                            <!-- Alert Message -->
                            <div id="family-message" class="alert" style="display:none;"></div>
                            
                            <p>Please provide accurate and complete information...</p>

                            <div id="personal-form">
                                <div id="pers-name">
                                    <label>Last Name<span id="required">*</span> 
                                        <input class="form-control" type="text" id="Famlastname" value=""/>
                                    </label>
                                    <label>Middle Name 
                                        <input class="form-control" type="text" id="Fammidname" value=""/>
                                    </label>
                                    <label>First Name<span id="required">*</span> 
                                        <input class="form-control" type="text" id="Famfirstname" value=""/>
                                    </label>
                                    <label>Maiden Name 
                                        <input class="form-control" type="text" id="Fammaidenname" value=""/>
                                    </label>
                                </div>
                                
                                <div id="pers-name">
                                    <label>Relationship<span id="required">*</span> 
                                        <select id="relationship">
                                            <option>Select Relation</option>
                                            <option>Spouse</option>
                                            <option>Mother</option>
                                            <option>Father</option>
                                            <option>Son</option>
                                            <option>Daughter</option>
                                            <option>Sister</option>
                                            <option>Brother</option>
                                            <option>Live-in Partner</option>
                                        </select>
                                    </label>
                                    <label>Contact Number<span id="required">*</span> 
                                        <input class="form-control" type="text" id="Famperson_num" value=""/>
                                    </label>
                                    <label>Birthdate 
                                        <input class="form-control" type="date" id="Fambirthdate" value=""/>
                                    </label>
                                    <label>Occupation 
                                        <input class="form-control" type="text" id="Famoccupation" value=""/>
                                    </label>
                                </div>
                                
                                <div id="pers-name">
                                    <label>Sex<span id="required">*</span>
                                        <div id="sex"><input id="Famgender" type="radio" name="Famsex" value="Male" /> <p>Male</p> </div>
                                        <div id="sex"><input id="Famgender" type="radio" name="Famsex" value="Female" /> <p>Female</p></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" id="footer">
                            <button type="button" class="btn btn-default btn-mini waves-effect" data-dismiss="modal">Close</button>
                            <button type="button" id="save-family" class="btn btn-primary btn-mini waves-effect waves-light">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>';
            //MODAL EDIT FAMILY BACKGROUND END
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
