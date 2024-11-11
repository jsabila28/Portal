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
      //END SKILLS
      //START OF SKILLS
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
      //END SKILLS
      //START OF SKILLS
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
      //END SKILLS
      //START OF SKILLS
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
      //END SKILLS
      echo'</div>';  
      echo'</div>';
    }else {
            
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
