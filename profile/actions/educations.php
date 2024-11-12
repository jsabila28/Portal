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

   
        $stmt = $port_db->prepare("SELECT * FROM tbl_skill_category WHERE sc_stat = '1'");
        $stmt->execute();
        $skills_category = $stmt->fetchAll(PDO::FETCH_ASSOC);    


    if (!empty($skills_category)) {
      echo '<div class="card-block" id="prof-card">';  //prof-card start
        // foreach ($skills_category as $sc) {
          
        // }
      echo '<div id="specialSkills" class="contact" style="margin-bottom:10px;">';
      //START OF EDUCATION
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://i.pinimg.com/564x/06/b5/36/06b5360652ec5ad7f166757f01206fbc.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">Primary</p>
      </div>
      ';
      echo'
      <div class="skill-types">
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END EDUCATION
      //START OF EDUCATION
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://i.pinimg.com/564x/30/75/8d/30758d3b5cfc8e511cf75226624e2ef0.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">Secondary </p>
      </div>
      ';
      echo'
      <div class="skill-types">
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END EDUCATION
      //START OF EDUCATION
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://i.pinimg.com/564x/40/60/42/4060427192995c16f753d98bd3f88bdc.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">Tertiary </p>
      </div>
      ';
      echo'
      <div class="skill-types">
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END EDUCATION
      //START OF EDUCATION
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://i.pinimg.com/564x/da/33/ab/da33ab649db62cdef457a32e9c5f7385.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">Postraduate </p>
      </div>
      ';
      echo'
      <div class="skill-types">
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END EDUCATION
      //START OF EDUCATION
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://i.pinimg.com/736x/1a/ba/ba/1ababa41a8bf6f069e83bdd6baf0bb79.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">Vocational </p>
      </div>
      ';
      echo'
      <div class="skill-types">
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END EDUCATION
      echo'</div>';  
      echo'</div>';

      //MODAL EDIT EDUCATION START
        echo '<div class="modal fade" id="Educ-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
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
                                <div id="pers-name">
                                    <label style="width:30% !important;">Level<span id="required">*</span> 
                                        <select name="levelSchool" id="SchLevel">
                                          <option value="">Select Education Level</option>
                                          <option value="">Primary</option>
                                          <option value="">Secondary</option>
                                          <option value="">Tertiary</option>
                                          <option value="">Postgraduate</option>
                                          <option value="">Vocational</option>
                                        </select>
                                    </label>
                                    <label style="width:30% !important;">Degree Title 
                                        <input class="form-control" type="text" name="Degree" id="degreeInput" value="" placeholder="Specify Other Type"/>
                                    </label>
                                    <label style="width:30% !important;">Major 
                                        <input class="form-control" type="text" name="Major" id="majorInput" value="" placeholder="Specify Other Type"/>
                                    </label>
                                </div>
                                <div id="pers-name">
                                    <label style="width:30% !important;">School<span id="required">*</span> 
                                        <input class="form-control" type="text" name="School" id="schoolInput" value="" placeholder="Specify Other Type"/>
                                    </label>
                                    <label style="width:30% !important;">School Address<span id="required">*</span> 
                                        <input class="form-control" type="text" name="SchoolAdd" id="addressInput" value="" placeholder="Specify Other Type"/>
                                    </label>
                                    <label style="width:30% !important;">Date Graduated<span id="required">*</span> 
                                        <input class="form-control" type="date" name="DateGrad" id="dateInput" value="" placeholder="Specify Other Type"/>
                                    </label>
                                </div>
                                <div id="pers-name">
                                    <label style="width:30% !important;">Current Status<span id="required">*</span> 
                                        <select name="Status" id="statusInput">
                                            <option value="Graduate">Graduate</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Dropped Out">Dropped Out</option>
                                            <option value="Withdrawn">Withdrawn</option>
                                            <option value="Pending Admission">Pending Admission</option>
                                        </select>
                                    </label>
                                </div>       
                            </div>
                            <div id="educ-message" class="alert" style="display: none;"></div>
                          </div>
                          <div class="modal-footer" id="footer">
                              <button type="button" class="btn btn-default btn-mini waves-effect " data-dismiss="modal">Close</button>
                              <button type="button" id="save-education" class="btn btn-primary btn-mini waves-effect waves-light ">Save changes</button>
                          </div>
                      </div>
                  </div>
              </div>';
        //MODAL EDIT EDUCATION END
    }else {
            
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
