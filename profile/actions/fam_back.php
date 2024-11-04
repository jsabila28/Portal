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
                          <p></p><br> 
                          <span>Spouse Full Name</span>
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
                          <p></p><br> 
                          <span>Occupation</span>
                        </div>
                      </div>';

                echo '<div class="numbers">
                        <div class="icon">
                          
                        </div>
                        <div class="content">
                          <p></p><br> 
                          <span>Sex</span>
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
                //SPOUSE END
                //CHILDREN START
                echo '<div class="contact" style="margin-top: 20px;">'; //contact start
                echo '<div class="numbers">
                        <div class="icon">
                            
                        </div>
                        <div class="content">
                          <p></p><br> 
                          <span>Child Full Name</span>
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
                          <p></p><br> 
                          <span>Sex</span>
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
                //CHILDREN END
                echo '</div>';  //prof-card end
            }
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
                          <p></p><br> 
                          <span>Mother Full Maiden Name</span>
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
                          <p></p><br> 
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
                          <p></p><br> 
                          <span>Father Full Name</span>
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
                          <p></p><br> 
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
                          <p></p><br> 
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
                          <p></p><br> 
                          <span>Sex</span>
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
                //SIBLINGS END
                echo '</div>';  //prof-card end
            
            //FAMILY INFO END

        }
    } else {
        echo "No data available.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
