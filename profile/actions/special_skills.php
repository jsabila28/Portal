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
    }else {
            
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
