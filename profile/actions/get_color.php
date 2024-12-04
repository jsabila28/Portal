<div id="personal-info1">
     <div class="basic-info">
       <span id="userName">
       MULTIPLE INTELLIGENCE QUOTIENT Result
       </span>
     </div>
     <div class="basic-info">
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
      
              $test_score=[];
                $test_score1=[];
                $sql_ptest="SELECT * FROM tbl201_whatcolorareyou WHERE wcay_empno='$user_id' ORDER BY wcay_id DESC limit 1";
                foreach ($hr_db->query($sql_ptest) as $tval) {
                    $test_score=[];
                    $test_score1=[];

                    $test_score1["Blue"]=$tval['_1'];
                    $test_score1["Green"]=$tval['_2'];
                    $test_score1["Red"]=$tval['_3'];
                    $test_score1["Yellow"]=$tval['_4'];

                    arsort($test_score1);
                    $tmparr=array_keys($test_score1);
                    $test_score[]=$tmparr[0];
                    if($tmparr[0]==$tmparr[1]){
                        $test_score[]=$tmparr[1];
                        if($tmparr[1]==$tmparr[2]){
                            $test_score[]=$tmparr[2];
                        }
                    }
                }
                require_once($sr_root."/pages/color-result.php");
      
         } catch (PDOException $e) {
             echo "Error: " . $e->getMessage();
         }
       ?>
     </div>
 </div>