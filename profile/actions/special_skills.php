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
      //START OF SKILLS
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://i.pinimg.com/564x/c9/ea/cb/c9eacb1bb4fe8cfaed682ae10405f07e.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">COMPUTER LITERACY</p>
      </div>
      ';
      echo'
      <div class="skill-types">
          <p id="type"><i class="icofont icofont-star"></i> Basic Computer Operations</p>
          <p id="type"><i class="icofont icofont-star"></i> Word Processing</p>
          <p id="type"><i class="icofont icofont-star"></i> Spreadsheet </p>
          <p id="type"><i class="icofont icofont-star"></i> Presentation Software</p>
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END SKILLS
      //START OF SKILLS
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://i.pinimg.com/564x/72/97/78/7297780dee8e909d45dca5c974895bce.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">Communication </p>
      </div>
      ';
      echo'
      <div class="skill-types">
          <p id="type"><i class="icofont icofont-star"></i> Verbal Communication</p>
          <p id="type"><i class="icofont icofont-star"></i> Written Communication</p>
          <p id="type"><i class="icofont icofont-star"></i> Customer Communication</p>
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END SKILLS
      //START OF SKILLS
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://i.pinimg.com/564x/de/33/a5/de33a58a3934fa701e4c25cfdf6ea6e2.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">Leadership and Interpersonal Skills </p>
      </div>
      ';
      echo'
      <div class="skill-types">
          <p id="type"><i class="icofont icofont-star"></i> Team Management</p>
          <p id="type"><i class="icofont icofont-star"></i> Collaboration</p>
          <p id="type"><i class="icofont icofont-star"></i> Adaptability and Flexibility</p>
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END SKILLS
      //START OF SKILLS
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://i.pinimg.com/564x/63/d9/6d/63d96d32bdd381d359f90438ad9bb722.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">Creative and Design </p>
      </div>
      ';
      echo'
      <div class="skill-types">
          <p id="type"><i class="icofont icofont-star"></i> Graphic Design</p>
          <p id="type"><i class="icofont icofont-star"></i> Content Creation</p>
          <p id="type"><i class="icofont icofont-star"></i> Product and User Experience (UX) Design</p>
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END SKILLS
      echo'</div>';  
      echo'</div>';

      //MODAL EDIT SKILLS START
        echo '<div class="modal fade" id="Skill-' . htmlspecialchars($user_id) . '" tabindex="-1" role="dialog">
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
                                    <label style="width:50% !important;">Category<span id="required">*</span> 
                                        <select id="skillCategory" name="Scategory">
                                          <option value="">Select Skill Category</option>
                                        </select>
                                    </label>
                                    <label style="width:50% !important;">Type<span id="required">*</span> 
                                        <select id="skillType" name="Stype">
                                          <option value="">Select Skill Type</option>
                                        </select>
                                        <input class="form-control" type="text" name="Others" id="othersInput" value="" style="display:none;" placeholder="Specify Other Type"/>
                                    </label>
                                </div>      
                            </div>
                            <div id="alert-message" class="alert" style="display: none;"></div>
                          </div>
                          <div class="modal-footer" id="footer">
                              <button type="button" class="btn btn-default btn-mini waves-effect " data-dismiss="modal">Close</button>
                              <button type="button" id="save-skills" class="btn btn-primary btn-mini waves-effect waves-light ">Save changes</button>
                          </div>
                      </div>
                  </div>
              </div>';
        //MODAL EDIT SKILLS END
    }else {
            
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
