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

   
        
      echo '<div class="card-block" id="prof-card">';  //prof-card start
        // foreach ($skills_category as $sc) {
          
        // }
      echo '<div id="specialSkills" class="contact" style="margin-bottom:10px;">';
      //START OF SKILLS
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhOzQqql-XZmOEXz7cit9yEFtuaMBTp7XM0GYLd2RpJmXRLKw2hkSVmWaMj3TdgAzvSWOkDEodZmqSYvAm3YFGIy09LXwh8Vk9R3ETs87Qc4TbLQhn9LdAHJsymi_FWSMZuIDy-coYH6mA_/s1600/ecfinal+-+Copy.png');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">Carreer Service Professional</p>
      </div>
      ';
      echo'
      <div class="skill-types">
          <p id="type"><i class="icofont icofont-calendar"></i> January 20, 2022 </p>
          <p id="type"><i class="icofont icofont-location-pin"></i> Zamboanga City</p>
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END SKILLS
      //START OF SKILLS
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('https://cashmart.ph/wp-content/uploads/2023/11/prc-id-ph.jpg');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title">PRC - Architect </p>
      </div>
      ';
      echo'
      <div class="skill-types">
          <p id="type"><i class="icofont icofont-calendar"></i> March 10, 2019 </p>
          <p id="type"><i class="icofont icofont-location-pin"></i> Zamboanga City</p>
      </div>
      ';
      echo'</div>';
      echo'</div>'; 
      //END SKILLS
      //START OF SKILLS
      echo'<div class="skill">';
      echo "<div class='image-skill' style=\"background-image: url('');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title"> </p>
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
      echo "<div class='image-skill' style=\"background-image: url('');\"></div>";
      echo'<div class="desc-skill">';
      echo'
      <div class="skill-title">
          <p id="title"> </p>
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
    

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
