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

                echo '<div class="contact" style="margin-bottom:10px;">';
                echo '<div class="numbers">
                        <div class="content">
                          <p style="font-size: 14px !important;">Own family</p>
                        </div>
                      </div>';
                echo'</div>';
                
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
                              <p>' . htmlspecialchars($spouseName ?: 'NA') . '</p><br> 
                              <span>Spouse Full Name</span>
                            </div>
                          </div>';
                    echo '<div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-iphone"></i>
                            </div>
                            <div class="content">
                              <p>' . htmlspecialchars($spousePhone ?: 'NA') . '</p><br> 
                              <span>Contact Number</span>
                            </div>
                          </div>';
                
                    echo '<div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-labour"></i>
                            </div>
                            <div class="content">
                              <p>' . htmlspecialchars($spouseWork ?: 'NA') . '</p><br> 
                              <span>Occupation</span>
                            </div>
                          </div>';
                    
                    
                    echo '<div class="numbers">
                            <div class="icon">
                              <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                              <p>' . htmlspecialchars($spouseBirth ?: 'NA') . '</p><br> 
                              <span>Age</span>
                            </div>
                          </div>';
                
                } else {
                    
                }
                
                echo '</div>'; // End the spouse contact section
                // SPOUSE END

                // Children START
                    $stmt = $port_db->prepare("SELECT 
                        fam_relationship,
                        CONCAT(fam_firstname, ' ', fam_midname, ' ', fam_lastname) AS full_name,
                        fam_contact,
                        fam_sex,
                        fam_birthdate
                        FROM tbl201_family
                        WHERE fam_empno = ? AND (fam_relationship = 'Son' OR fam_relationship = 'Daughter')
                        ORDER BY fam_relationship");
                    $stmt->execute([$user_id]);
                    $child = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($child)) {
                            echo '<div class="contact" style="margin-top:20px;margin-bottom:10px;">';
                            echo '<div class="numbers">
                                    <div class="content">
                                      <p style="font-size: 14px !important;"></p>
                                    </div>
                                  </div>';
                            echo'</div>';
                        foreach ($child as $c) {
                            echo '<div class="contact" style="margin-top: 20px;">';
                            
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="icofont icofont-user-alt-1"></i>
                                    </div>
                                    <div class="content">
                                      <p>' . htmlspecialchars($c['full_name']) . '</p><br> 
                                      <span>Child Full Name</span>
                                    </div>
                                  </div>';
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="icofont icofont-iphone"></i>
                                    </div>
                                    <div class="content">
                                      <p>' . htmlspecialchars($c['fam_contact'] ?? 'NA') . '</p><br> 
                                      <span>Contact Number</span>
                                    </div>
                                  </div>';
                            
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="zmdi zmdi-male-female"></i>
                                    </div>
                                    <div class="content">
                                      <p>' . htmlspecialchars($c['fam_sex'] ?? 'NA') . '</p><br> 
                                      <span>Sex</span>
                                    </div>
                                  </div>';
                            
                            // Calculate age if birthdate is available
                            $age = !empty($c['fam_birthdate']) ? (date('Y') - date('Y', strtotime($c['fam_birthdate']))) : 'NA';
                            
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                                    </div>
                                    <div class="content">
                                      <p>' . $age . '</p><br> 
                                      <span>Age</span>
                                    </div>
                                  </div>';
                            
                            echo '</div>'; // End of child contact
                        }
                    } else {
                        echo '<div class="contact" style="margin-top:20px;margin-bottom:10px;">';
                        echo '<div class="numbers">
                                <div class="content">
                                  <p style="font-size: 14px !important;"></p>
                                </div>
                              </div>';
                        echo'</div>';
                        echo '<div class="contact" style="margin-top: 5px;">';
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="icofont icofont-user-alt-1"></i>
                                    </div>
                                    <div class="content">
                                      <p>None</p><br> 
                                      <span>Child Full Name</span>
                                    </div>
                                  </div>';
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="icofont icofont-iphone"></i>
                                    </div>
                                    <div class="content">
                                      <p>None</p><br> 
                                      <span>Contact Number</span>
                                    </div>
                                  </div>';
                            
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="zmdi zmdi-male-female"></i>
                                    </div>
                                    <div class="content">
                                      <p>None</p><br> 
                                      <span>Sex</span>
                                    </div>
                                  </div>';
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                                    </div>
                                    <div class="content">
                                      <p>None</p><br> 
                                      <span>Age</span>
                                    </div>
                                  </div>';
                            
                            echo '</div>'; // End of child contact
                  }
                  // Children END
                echo '</div>';  //prof-card end
          
                // PERSONAL FAMILY INFO END
                // FAMILY INFO START
                  echo '<div class="card-block" id="prof-card">';  // prof-card start

                  // MOTHER FATHER START
                  $stmt = $port_db->prepare("SELECT 
                      CASE WHEN fam_relationship = 'Father' THEN CONCAT(fam_firstname, ' ', fam_midname, ' ', fam_lastname) END AS Father,
                      CASE WHEN fam_relationship = 'Father' THEN fam_contact END AS contactF,
                      CASE WHEN fam_relationship = 'Father' THEN fam_occupation END AS occupationF,
                      CASE WHEN fam_relationship = 'Father' THEN fam_sex END AS sexF,
                      CASE WHEN fam_relationship = 'Father' THEN fam_birthdate END AS birthdateF,
                      CASE WHEN fam_relationship = 'Mother' THEN CONCAT(fam_firstname, ' ', fam_maidenname, ' ', fam_lastname) END AS Mother,
                      CASE WHEN fam_relationship = 'Mother' THEN fam_contact END AS contactM,
                      CASE WHEN fam_relationship = 'Mother' THEN fam_occupation END AS occupationM,
                      CASE WHEN fam_relationship = 'Mother' THEN fam_birthdate END AS birthdateM
                      FROM tbl201_family
                      WHERE fam_empno = ?");
                  $stmt->execute([$user_id]);
                  $momdad = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (!empty($momdad)) {
                        echo '<div class="contact" style="margin-bottom:10px;">';
                        echo '<div class="numbers">
                                <div class="content">
                                  <p style="font-size: 14px !important;">Family of Origin</p>
                                </div>
                              </div>';
                        echo'</div>';
                      foreach ($momdad as $md) {
                          echo '<div class="contact">'; // contact start
                          if (!empty($md['Mother'])) {
                          echo '<div class="numbers">
                                  <div class="icon">
                                      <i class="icofont icofont-girl-alt"></i>
                                  </div>
                                  <div class="content">
                                    <p>' . htmlspecialchars($md['Mother']) . '</p><br> 
                                    <span>Mother Full Maiden Name</span>
                                  </div>
                                </div>';
                          echo '<div class="numbers">
                                  <div class="icon">
                                      <i class="icofont icofont-iphone"></i>
                                  </div>
                                  <div class="content">
                                    <p>' . htmlspecialchars($md['contactM']) . '</p><br> 
                                    <span>Contact Number</span>
                                  </div>
                                </div>';
                          echo '<div class="numbers">
                                  <div class="content">
                                    <p>' . htmlspecialchars($md['occupationM']) . '</p><br> 
                                    <span>Occupation</span>
                                  </div>
                                </div>';
                          echo '<div class="numbers">
                                  <div class="icon">
                                      <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                                  </div>
                                  <div class="content">
                                    <p>';
                                      if ($md['birthdateM']) {
                                          function calculateMAge($birthdate) {
                                              $birthDate = new DateTime($birthdate);
                                              $currentDate = new DateTime();
                                              $age = $birthDate->diff($currentDate);
                                              return $age->y;
                                          }
                                          
                                          echo calculateMAge($md['birthdateM']);
                                      } else {
                                          echo '0';
                                      }

                                    echo'</p><br>
                                    <span>Age</span>
                                  </div>
                                </div>';
                          }
                          echo '</div>'; // contact end
                          echo '<div class="contact" style="margin-bottom: 20px;">'; // contact start
                          if (!empty($md['Father'])) {
                              echo '<div class="numbers">
                                      <div class="icon">
                                          <i class="icofont icofont-business-man-alt-1"></i>
                                      </div>
                                      <div class="content">
                                        <p>' . htmlspecialchars($md['Father']) . '</p><br> 
                                        <span>Father Full Name</span>
                                      </div>
                                    </div>';
                          echo '<div class="numbers">
                                  <div class="icon">
                                      <i class="icofont icofont-iphone"></i>
                                  </div>
                                  <div class="content">
                                    <p>' . htmlspecialchars($md['contactF']) . '</p><br> 
                                    <span>Contact Number</span>
                                  </div>
                                </div>';
                          echo '<div class="numbers">
                                  <div class="content">
                                    <p>' . htmlspecialchars($md['occupationF']) . '</p><br> 
                                    <span>Occupation</span>
                                  </div>
                                </div>';
                          echo '<div class="numbers">
                                  <div class="icon">
                                      <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                                  </div>
                                  <div class="content">
                                    <p>';
                                      if ($md['birthdateF']) {
                                          function calculateAge($birthdate) {
                                              $birthDate = new DateTime($birthdate);
                                              $currentDate = new DateTime();
                                              $age = $birthDate->diff($currentDate);
                                              return $age->y;
                                          }
                                          
                                          echo calculateAge($md['birthdateF']);
                                      } else {
                                          echo '0';
                                      }

                                    echo'</p><br>
                                    <span>Age</span>
                                  </div>
                                </div>';
                          }
                          echo '</div>'; // contact end
                      }
                  }
                  // MOTHER FATHER END

                  // SIBLINGS START
                    $stmt = $port_db->prepare("SELECT 
                        fam_relationship,
                        CONCAT(fam_firstname, ' ', fam_midname, ' ', fam_lastname) AS full_name,
                        fam_contact,
                        fam_sex,
                        fam_birthdate
                        FROM tbl201_family
                        WHERE fam_empno = ? AND (fam_relationship = 'Brother' OR fam_relationship = 'Sister')
                        ORDER BY fam_relationship");
                    $stmt->execute([$user_id]);
                    $siblings = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($siblings)) {
                        foreach ($siblings as $sibling) {
                            echo '<div class="contact" style="margin-top: 20px;">';
                            
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="icofont icofont-user-alt-1"></i>
                                    </div>
                                    <div class="content">
                                      <p>' . htmlspecialchars($sibling['full_name']) . '</p><br> 
                                      <span>Sibling Full Name</span>
                                    </div>
                                  </div>';
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="icofont icofont-iphone"></i>
                                    </div>
                                    <div class="content">
                                      <p>' . htmlspecialchars($sibling['fam_contact'] ?? 'NA') . '</p><br> 
                                      <span>Contact Number</span>
                                    </div>
                                  </div>';
                            
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="zmdi zmdi-male-female"></i>
                                    </div>
                                    <div class="content">
                                      <p>' . htmlspecialchars($sibling['fam_sex'] ?? 'NA') . '</p><br> 
                                      <span>Sex</span>
                                    </div>
                                  </div>';
                            
                            // Calculate age if birthdate is available
                            $age = !empty($sibling['fam_birthdate']) ? (date('Y') - date('Y', strtotime($sibling['fam_birthdate']))) : 'NA';
                            
                            echo '<div class="numbers">
                                    <div class="icon">
                                      <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                                    </div>
                                    <div class="content">
                                      <p>' . $age . '</p><br> 
                                      <span>Age</span>
                                    </div>
                                  </div>';
                            
                            echo '</div>'; // End of sibling contact
                        }
                    } else {
                      echo '<div class="contact" style="margin-top: 20px;">'; 
                      echo '<div class="numbers">
                              <div class="icon">
                                <i class="icofont icofont-user-alt-1"></i>
                              </div>
                              <div class="content">
                                <p>NA</p><br> 
                                <span>Sibling Full Name</span>
                              </div>
                            </div>';
                      echo '<div class="numbers">
                              <div class="icon">
                                <i class="icofont icofont-iphone"></i>
                              </div>
                              <div class="content">
                                <p>NA</p><br> 
                                <span>Contact Number</span>
                              </div>
                            </div>';
                      
                      echo '<div class="numbers">
                              <div class="icon">
                                <i class="zmdi zmdi-male-female"></i>
                              </div>
                              <div class="content">
                                <p>NA</p><br> 
                                <span>Sex</span>
                              </div>
                            </div>';
                      
                      
                      echo '<div class="numbers">
                              <div class="icon">
                                <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                              </div>
                              <div class="content">
                                <p>NA</p><br> 
                                <span>Age</span>
                              </div>
                            </div>';
                      
                      echo '</div>'; // End of sibling contact
                  }
                  // SIBLINGS END

                  echo '</div>';  // prof-card end
                      
                  //FAMILY INFO END

                  //MODAL EDIT FAMILY BACKGROUND START
                  echo '<div class="modal fade" id="Family-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
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
                              <div id="alert-message" class="alert" style="display:none;"></div>
                              
                              <p>Please provide accurate and complete information...</p>

                              <div id="personal-form">
                                  <div id="pers-name">
                                      <label>Last Name<span id="required">*</span> 
                                          <input class="form-control" type="text" id="lastname" value=""/>
                                      </label>
                                      <label>Middle Name 
                                          <input class="form-control" type="text" id="midname" value=""/>
                                      </label>
                                      <label>First Name<span id="required">*</span> 
                                          <input class="form-control" type="text" id="firstname" value=""/>
                                      </label>
                                      <label>Maiden Name 
                                          <input class="form-control" type="text" id="maidenname" value=""/>
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
                                          <input class="form-control" type="text" id="person_num" value=""/>
                                      </label>
                                      <label>Birthdate 
                                          <input class="form-control" type="date" id="birthdate" value=""/>
                                      </label>
                                      <label>Occupation 
                                          <input class="form-control" type="text" id="occupation" value=""/>
                                      </label>
                                  </div>
                                  
                                  <div id="pers-name">
                                      <label>Sex<span id="required">*</span>
                                          <div id="sex"><input id="gender" type="radio" name="sex" value="Male" /> <p>Male</p> </div>
                                          <div id="sex"><input id="gender" type="radio" name="sex" value="Female" /> <p>Female</p></div>
                                      </label>
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer" id="footer">
                              <button type="button" class="btn btn-default btn-mini waves-effect" data-dismiss="modal">Close</button>
                              <button type="button" id="save-personal" class="btn btn-primary btn-mini waves-effect waves-light">Save changes</button>
                          </div>
                      </div>
                  </div>
                </div>';
                //MODAL EDIT FAMILY BACKGROUND END
        } else {
                //MODAL EDIT FAMILY BACKGROUND START
                echo '<div class="modal fade" id="Family-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
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
                            <div id="alert-message" class="alert" style="display:none;"></div>
                            
                            <p>Please provide accurate and complete information...</p>

                            <div id="personal-form">
                                <div id="pers-name">
                                    <label>Last Name<span id="required">*</span> 
                                        <input class="form-control" type="text" id="lastname" value=""/>
                                    </label>
                                    <label>Middle Name 
                                        <input class="form-control" type="text" id="midname" value=""/>
                                    </label>
                                    <label>First Name<span id="required">*</span> 
                                        <input class="form-control" type="text" id="firstname" value=""/>
                                    </label>
                                    <label>Maiden Name 
                                        <input class="form-control" type="text" id="maidenname" value=""/>
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
                                        <input class="form-control" type="text" id="person_num" value=""/>
                                    </label>
                                    <label>Birthdate 
                                        <input class="form-control" type="date" id="birthdate" value=""/>
                                    </label>
                                    <label>Occupation 
                                        <input class="form-control" type="text" id="occupation" value=""/>
                                    </label>
                                </div>
                                
                                <div id="pers-name">
                                    <label>Sex<span id="required">*</span>
                                        <div id="sex"><input id="gender" type="radio" name="sex" value="Male" /> <p>Male</p> </div>
                                        <div id="sex"><input id="gender" type="radio" name="sex" value="Female" /> <p>Female</p></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" id="footer">
                            <button type="button" class="btn btn-default btn-mini waves-effect" data-dismiss="modal">Close</button>
                            <button type="button" id="save-personal" class="btn btn-primary btn-mini waves-effect waves-light">Save changes</button>
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
