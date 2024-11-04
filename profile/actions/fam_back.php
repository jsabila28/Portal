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

   
        $stmt = $port_db->prepare("SELECT * FROM tbl201_family WHERE fam_empno = ?");
        $stmt->execute([$user_id]);
        $family = $stmt->fetchAll(PDO::FETCH_ASSOC);    


    if (!empty($family)) {
        foreach ($family as $f) {
          
                // PERSONAL FAMILY INFO START
                echo '<div class="card-block" id="prof-card">';  //prof-card start
                echo '<div class="contact">'; //contact start
                echo '<div class="numbers">
                        <div class="content">
                          <p style="font-size: 14px !important;">For Married</p><br> 
                        </div>
                      </div>';
                echo '</div><br> '; //contact end
                //SPOUSE START
                echo '<div class="contact">'; //contact start
                echo '<div class="numbers">
                        <div class="icon">
                            
                        </div>
                        <div class="content">
                          <p>NA</p><br> 
                          <span>Spouse Full Name</span>
                        </div>
                      </div>';
                      
                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>NA</p><br> 
                          <span>Contact Number</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>NA</p><br> 
                          <span>Occupation</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>NA</p><br> 
                          <span>Sex</span>
                        </div>
                      </div>';
                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>NA</p><br> 
                          <span>Age</span>
                        </div>
                      </div>';
                echo '</div>'; //contact end
                //SPOUSE END
                //CHILDREN START
                echo '<div class="contact" style="margin-top: 20px;">'; //contact start
                echo '<div class="numbers">
                        <div class="icon">
                            
                        </div>
                        <div class="content">
                          <p>NA</p><br> 
                          <span>Child Full Name</span>
                        </div>
                      </div>';
                      
                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>NA</p><br> 
                          <span>Contact Number</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>NA</p><br> 
                          <span>Sex</span>
                        </div>
                      </div>';
                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>NA</p><br> 
                          <span>Age</span>
                        </div>
                      </div>';
                echo '</div>'; //contact end
                //CHILDREN END
                echo '</div>';  //prof-card end
          
            // PERSONAL FAMILY INFO END
            // FAMILY INFO START
                echo '<div class="card-block" id="prof-card">';  //prof-card start
                echo '<div class="contact">'; //contact start
                // echo '<div class="numbers">
                //         <div class="content">
                //           <p style="font-size: 14px !important;">For Married</p><br> 
                //         </div>
                //       </div>';
                echo '</div><br> '; //contact end
                //MOTHER FATHER START
                echo '<div class="contact">'; //contact start
                echo '<div class="numbers">
                        <div class="icon">
                            
                        </div>
                        <div class="content">
                          <p>Margie Nabio Sallao</p><br> 
                          <span>Mother Full Maiden Name</span>
                        </div>
                      </div>';
                      
                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>09501432700</p><br> 
                          <span>Contact Number</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>BHW</p><br> 
                          <span>Occupation</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p></p><br> 
                          <span>Age</span>
                        </div>
                      </div>';
                echo '</div>'; //contact end
                echo '<div class="contact" style="margin-top: 20px;">'; //contact start
                echo '<div class="numbers">
                        <div class="icon">
                            
                        </div>
                        <div class="content">
                          <p>Noli Langta Abila</p><br> 
                          <span>Father Full Name</span>
                        </div>
                      </div>';
                      
                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>09000000000</p><br> 
                          <span>Contact Number</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>Farmer</p><br> 
                          <span>Occupation</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p></p><br> 
                          <span>Age</span>
                        </div>
                      </div>';
                echo '</div>'; //contact end
                //MOTHER FATHER END
                //SIBLINGS START
                echo '<div class="contact" style="margin-top: 20px;">'; //contact start
                echo '<div class="numbers">
                        <div class="icon">
                            
                        </div>
                        <div class="content">
                          <p>Andrian Sallao Abila</p><br> 
                          <span>Sibling Full Name</span>
                        </div>
                      </div>';
                      
                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p></p><br> 
                          <span>Contact Number</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>Male</p><br> 
                          <span>Sex</span>
                        </div>
                      </div>';
                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p>19</p><br> 
                          <span>Age</span>
                        </div>
                      </div>';
                echo '</div>'; //contact end
                //SIBLINGS END
                echo '</div>';  //prof-card end
            
            //FAMILY INFO END

            //MODAL EDIT FAMILY BACKGROUND START
            echo '<div class="modal fade" id="Family-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
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

                                    $sql = "SELECT pers_id FROM tbl201_family WHERE fam_id LIKE :pattern ORDER BY fam_id DESC LIMIT 1";
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

                                    echo '<input class="form-control" type="hidden" name="pers_id"  value=""/>';

                                        echo'<div id="pers-name">
                                            <label>Last Name<span id="required">*</span> 
                                                <input class="form-control" type="text" name="lastname" required value=""/>
                                            </label>
                                            <label>Middle Name 
                                                <input class="form-control" type="text" name="midname" value=""/>
                                            </label>
                                            <label>First Name<span id="required">*</span> 
                                                <input class="form-control" type="text" name="firstname" required value=""/>
                                            </label>
                                            <label>Maiden Name 
                                                <input class="form-control" type="text" name="maidenname" value=""/>
                                            </label>
                                        </div>';
                                        echo'<div id="pers-name">
                                            <label>Personal Contact<span id="required">*</span> 
                                                <input class="form-control" type="text" name="person_num" required value=""/>
                                            </label>
                                            <label>Company Contact 
                                                <input class="form-control" type="text" name="company_num" value=""/>
                                            </label>
                                            <label>Email<span id="required">*</span> 
                                                <input class="form-control" type="email" name="email" required value=""/>
                                            </label>
                                            <label>Telephone 
                                                <input class="form-control" type="text" name="telephone" value=""/>
                                            </label>
                                        </div>';
                                        
                                        echo'<div id="pers-name">
                                            <label>SSS Number<span id="required">*</span> 
                                                <input class="form-control" type="text" name="sss" value="" required />
                                            </label>
                                            <label>Pagibig Number<span id="required">*</span> 
                                                <input class="form-control" type="text" name="pagibig" value="" required />
                                            </label>
                                            <label>Philhealth Number<span id="required">*</span> 
                                                <input class="form-control" type="text" name="philhealth" value="" required />
                                            </label>
                                            <label>Tin Number<span id="required">*</span> 
                                                <input class="form-control" type="text" name="tin" value="" required />
                                            </label>
                                        </div>';
                                        
                                        echo'
                                        <div id="pers-name">
                                            <label>Birth Date<span id="required">*</span> 
                                                <input class="form-control" type="date" name="birthdate" value="" required/>
                                            </label>
                                            <label>Civil Status<span id="required">*</span> 
                                                <input class="form-control" type="text" name="civilstat" required value=""/>
                                            </label>
                                            <label>Sex<span id="required">*</span> <br>';
                                              echo'<input type="checkbox" name="sex" value="Male"/> Male ';
                                              echo'<input type="checkbox" name="sex" value="Female" checked/> Female';
                                                
                                                
                                                
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
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-default btn-mini waves-effect " data-dismiss="modal">Close</button>
                                  <button type="button" id="save-personal" class="btn btn-primary btn-mini waves-effect waves-light ">Save changes</button>
                              </div>
                          </div>
                      </div>
                  </div>';
            //MODAL EDIT FAMILY BACKGROUND END

        }
    } else {
        //MODAL EDIT FAMILY BACKGROUND START
        echo '<div class="modal fade" id="Family-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
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
                                          <label>Spouse(if married)</label>
                                         </div>';
                                    echo'<div id="pers-name">
                                        <label>Last Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="lastname"  value=""/>
                                        </label>
                                        <label>Middle Name 
                                            <input class="form-control" type="text" name="midname" value=""/>
                                        </label>
                                        <label>First Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="firstname"  value=""/>
                                        </label>
                                        <label>Maiden Name 
                                            <input class="form-control" type="text" name="maidenname" value=""/>
                                        </label>
                                    </div>';
                                    
                                    echo'<div id="pers-name">
                                        <label>Contact Number<span id="required">*</span> 
                                            <input class="form-control" type="text" name="person_num"  value=""/>
                                        </label>
                                        <label>Birthdate 
                                            <input class="form-control" type="date" name="company_num" value=""/>
                                        </label>
                                        <label>Sex<span id="required">*</span> <br>';
                                          echo'<input type="checkbox" name="sex" value="Male"/> Male ';
                                          echo'<input type="checkbox" name="sex" value="Female"/> Female';
                                        echo'</label>
                                    </div>';
                                    echo '<hr>';
                                    echo'<div id="pers-name">
                                          <label>Children</label>
                                         </div>';
                                    echo'<div id="pers-name">
                                        <label>Last Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="sss" value=""  />
                                        </label>
                                        <label>First Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="pagibig" value=""  />
                                        </label>
                                        <label>Middle Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="philhealth" value=""  />
                                        </label>
                                    </div>
                                    <div id="pers-name">
                                        <label>Birth Date<span id="required">*</span> 
                                            <input class="form-control" type="date" name="sss" value=""  />
                                        </label>
                                        <label>Sex<span id="required">*</span> <br>';
                                          echo'<input type="checkbox" name="sex" value="Male"/> Male ';
                                          echo'<input type="checkbox" name="sex" value="Female"/> Female';
                                        echo'</label>
                                        <label> 
                                            <a class="btn btn-primary btn-mini">add child</a>
                                        </label>
                                    </div>';
                                    echo '<hr>';
                                    echo'<div id="pers-name">
                                          <label>Mother</label>
                                         </div>';
                                    echo'
                                    <div id="pers-name">
                                        <label>Last Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="sss" value=""  />
                                        </label>
                                        <label>First Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="pagibig" value=""  />
                                        </label>
                                        <label>Maiden Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="philhealth" value=""  />
                                        </label>
                                        <label>Birth Date<span id="required">*</span> 
                                            <input class="form-control" type="date" name="sss" value=""  />
                                        </label>
                                    </div>';
                                    echo '<hr>';
                                    echo'<div id="pers-name">
                                          <label>Father</label>
                                         </div>';
                                    echo'
                                    <div id="pers-name">
                                        <label>Last Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="sss" value=""  />
                                        </label>
                                        <label>First Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="pagibig" value=""  />
                                        </label>
                                        <label>Middle Name<span id="required">*</span> 
                                            <input class="form-control" type="text" name="philhealth" value=""  />
                                        </label>
                                        <label>Birth Date<span id="required">*</span> 
                                            <input class="form-control" type="date" name="sss" value=""  />
                                        </label>
                                    </div>';
                          echo'</div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default btn-mini waves-effect " data-dismiss="modal">Close</button>
                              <button type="button" id="save-personal" class="btn btn-primary btn-mini waves-effect waves-light ">Save changes</button>
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
