<div id="personal-info1">
     <div class="basic-info">
       <span id="userName">
       VAK Result
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
                $sql_ptest="SELECT * FROM tbl201_vak WHERE vak_empno='$user_id' ORDER BY vak_id DESC limit 1";
                foreach ($hr_db->query($sql_ptest) as $tval) {
                    $test_score=[];
                    $test_score1=[];

                    $test_score1["Visual"]=$tval['_a'];
                    $test_score1["Auditory"]=$tval['_b'];
                    $test_score1["Kinesthetic"]=$tval['_c'];

                    arsort($test_score1);
                    $tmparr=array_keys($test_score1);
                    $test_score[]=$tmparr[0];
                    if($tmparr[0]==$tmparr[1]){
                        $test_score[]=$tmparr[1];
                    }
                }
                require_once($sr_root."/pages/vak-result.php");
      
         } catch (PDOException $e) {
             echo "Error: " . $e->getMessage();
         }
       ?>
     </div>
 </div>
  <div class="modal fade" id="VAK" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="section1">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>1. When I operate new equipment I generally:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_1" style="width: 15px;margin-right:10px;"> 
                                <p>a)   read the instructions first</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_1" style="width: 15px;margin-right:10px;"> 
                                <p>b)   listen to an explanation from someone who has used it before</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_1" style="width: 15px;margin-right:10px;"> 
                                <p>c)   go ahead and have a go, I can figure it out as I use it</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>2. When I need directions for travelling I usually:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_2" style="width: 15px;margin-right:10px;"> 
                                <p>a)   look at a map</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_2" style="width: 15px;margin-right:10px;"> 
                                <p>b)   ask for spoken directions</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_2" style="width: 15px;margin-right:10px;"> 
                                <p>c)   follow my nose and maybe use a compass</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
                <button type="button" class="btn btn-danger btn-mini waves-effect " data-dismiss="modal">Close</button>
                <button type="button" id="save-tapt" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section2')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section2">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">
              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>3. When I cook a new dish, I like to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>a)   follow a written recipe</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>b)   call a friend for an explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>c)   follow my instincts, testing as I cook</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>4. If I am teaching someone something new, I tend to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>a)   write instructions down for them</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>b)   give them a verbal explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>c)   demonstrate first and then let them have a go</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
                <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section1')">Previous Page</button>
                <button type="button" id="save-tapt" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section3')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section3">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>5. I tend to say:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_5" style="width: 15px;margin-right:10px;"> 
                                <p>a)   watch how I do it</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_5" style="width: 15px;margin-right:10px;"> 
                                <p>b)   listen to me explain</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_5" style="width: 15px;margin-right:10px;"> 
                                <p>c)   you have a go</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>6. During my free time I most enjoy:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_6" style="width: 15px;margin-right:10px;"> 
                                <p>a)   going to museums and galleries</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_6" style="width: 15px;margin-right:10px;"> 
                                <p>b)   listening to music and talking to my friends</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_6" style="width: 15px;margin-right:10px;"> 
                                <p>c)   playing sport or doing DIY</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
                <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section2')">Previous Page</button>
                <button type="button" id="save-tapt" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section4')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section4">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>7. When I go shopping for clothes, I tend to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_7" style="width: 15px;margin-right:10px;"> 
                                <p>a)   imagine what they would look like on</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_7" style="width: 15px;margin-right:10px;"> 
                                <p>b)   discuss them with the shop staff</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_7" style="width: 15px;margin-right:10px;"> 
                                <p>c)   try them on and test them out</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>8. When I am choosing a holiday I usually:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_8" style="width: 15px;margin-right:10px;"> 
                                <p>a)   read lots of brochures</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_8" style="width: 15px;margin-right:10px;"> 
                                <p>b)    listen to recommendations from friends</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_8" style="width: 15px;margin-right:10px;"> 
                                <p>c)   imagine what it would be like to be there</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
                <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section3')">Previous Page</button>
                <button type="button" id="save-tapt" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section5')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section5">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>9. If I was buying a new car, I would:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_9" style="width: 15px;margin-right:10px;"> 
                                <p>a)   read reviews in newspapers and magazines</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_9" style="width: 15px;margin-right:10px;"> 
                                <p>b)   discuss what I need with my friends</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_9" style="width: 15px;margin-right:10px;"> 
                                <p>c)   test-drive lots of different types</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>10. When I am learning a new skill, I am most comfortable:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_10" style="width: 15px;margin-right:10px;"> 
                                <p>a)   watching what the teacher is doing</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_10" style="width: 15px;margin-right:10px;"> 
                                <p>b)   talking through with the teacher exactly what I’m supposed to do</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_10" style="width: 15px;margin-right:10px;"> 
                                <p>c)   giving it a try myself and work it out as I go</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
                <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section4')">Previous Page</button>
                <button type="button" id="save-tapt" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section6')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section6">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>11. If I am choosing food off a menu, I tend to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_11" style="width: 15px;margin-right:10px;"> 
                                <p>a)   imagine what the food will look like</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_11" style="width: 15px;margin-right:10px;"> 
                                <p>b)   talk through the options in my head or with my partner</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_11" style="width: 15px;margin-right:10px;"> 
                                <p>c)   imagine what the food will taste like</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>12. When I listen to a band, I can’t help:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_12" style="width: 15px;margin-right:10px;"> 
                                <p>a)   watching the band members and other people in the audience</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_12" style="width: 15px;margin-right:10px;"> 
                                <p>b)   listening to the lyrics and the beats</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_12" style="width: 15px;margin-right:10px;"> 
                                <p>c)   moving in time with the music</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
                <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section5')">Previous Page</button>
                <button type="button" id="save-tapt" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section7')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section7">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>13. When I concentrate, I most often:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_13" style="width: 15px;margin-right:10px;"> 
                                <p>a)   focus on the words or the pictures in front of me</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_13" style="width: 15px;margin-right:10px;"> 
                                <p>b)   discuss the problem and the possible solutions in my head</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_13" style="width: 15px;margin-right:10px;"> 
                                <p>c)   move around a lot, fiddle with pens and pencils and touch things</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>14. I choose household furnishings because I like:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_14" style="width: 15px;margin-right:10px;"> 
                                <p>a)   their colours and how they look</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_14" style="width: 15px;margin-right:10px;"> 
                                <p>b)   the descriptions the sales-people give me</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_14" style="width: 15px;margin-right:10px;"> 
                                <p>c)   their textures and what it feels like to touch them</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
                <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section6')">Previous Page</button>
                <button type="button" id="save-tapt" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section8')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section8">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>15. My first memory is of:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_15" style="width: 15px;margin-right:10px;"> 
                                <p>a)   looking at something</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_15" style="width: 15px;margin-right:10px;"> 
                                <p>b)   being spoken to</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_15" style="width: 15px;margin-right:10px;"> 
                                <p>c)   doing something</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>16. When I am anxious, I:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_16" style="width: 15px;margin-right:10px;"> 
                                <p>a)   visualise the worst-case scenarios</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_16" style="width: 15px;margin-right:10px;"> 
                                <p>b)   talk over in my head what worries me most</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_16" style="width: 15px;margin-right:10px;"> 
                                <p>c)   can’t sit still, fiddle and move around constantly</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
                <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section7')">Previous Page</button>
                <button type="button" id="save-tapt" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section9')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section9">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>17. I feel especially connected to other people because of:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_17" style="width: 15px;margin-right:10px;"> 
                                <p>a)   how they look</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_17" style="width: 15px;margin-right:10px;"> 
                                <p>b)   what they say to me</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_17" style="width: 15px;margin-right:10px;"> 
                                <p>c)   how they make me feel</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>18. When I have to revise for an exam, I generally:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_18" style="width: 15px;margin-right:10px;"> 
                                <p>a)   write lots of revision notes and diagrams</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_18" style="width: 15px;margin-right:10px;"> 
                                <p>b)   talk over my notes, alone or with other people</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_18" style="width: 15px;margin-right:10px;"> 
                                <p>c)   imagine making the movement or creating the formula</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
                <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section8')">Previous Page</button>
                <button type="button" id="save-tapt" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section10')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section10">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>19. If I am explaining to someone I tend to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_19" style="width: 15px;margin-right:10px;"> 
                                <p>a)   show them what I mean</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_19" style="width: 15px;margin-right:10px;"> 
                                <p>b)   explain to them in different ways until they understand</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_19" style="width: 15px;margin-right:10px;"> 
                                <p>c)   encourage them to try and talk them through my idea as they do it</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>20. I really love:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_20" style="width: 15px;margin-right:10px;"> 
                                <p>a)   watching films, photography, looking at art or people watching</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_20" style="width: 15px;margin-right:10px;"> 
                                <p>b)    listening to music, the radio or talking to friends</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_20" style="width: 15px;margin-right:10px;"> 
                                <p>c)   taking part in sporting activities, eating fine foods and wines or dancing</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
               <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section9')">Previous Page</button>
               <button type="button" id="save-miq" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section11')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section11">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>3. When I cook a new dish, I like to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>a)   follow a written recipe</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>b)   call a friend for an explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>c)   follow my instincts, testing as I cook</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>4. If I am teaching someone something new, I tend to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>a)   write instructions down for them</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>b)   give them a verbal explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>c)   demonstrate first and then let them have a go</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
               <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section10')">Previous Page</button>
                <button type="button" id="save-miq" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section12')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section12">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>3. When I cook a new dish, I like to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>a)   follow a written recipe</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>b)   call a friend for an explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>c)   follow my instincts, testing as I cook</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>4. If I am teaching someone something new, I tend to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>a)   write instructions down for them</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>b)   give them a verbal explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>c)   demonstrate first and then let them have a go</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
               <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section11')">Previous Page</button>
                <button type="button" id="save-miq" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section13')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section13">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>3. When I cook a new dish, I like to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>a)   follow a written recipe</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>b)   call a friend for an explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>c)   follow my instincts, testing as I cook</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>4. If I am teaching someone something new, I tend to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>a)   write instructions down for them</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>b)   give them a verbal explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>c)   demonstrate first and then let them have a go</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
               <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section12')">Previous Page</button>
                <button type="button" id="save-miq" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section14')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section14">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>3. When I cook a new dish, I like to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>a)   follow a written recipe</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>b)   call a friend for an explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>c)   follow my instincts, testing as I cook</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>4. If I am teaching someone something new, I tend to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>a)   write instructions down for them</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>b)   give them a verbal explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>c)   demonstrate first and then let them have a go</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
               <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section13')">Previous Page</button>
                <button type="button" id="save-miq" class="btn btn-primary btn-mini waves-effect waves-light" onclick="goToNextDiv('section15')">Next Page</button>
            </div>
        </div>
        <div class="modal-content hidden" id="section11">
            <div class="modal-header">
                <h4 class="modal-title">VAK Learning Styles Self-Assessment Questionnaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i style="font-size: 30px;" class="fa fa-times-circle"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px !important;">

              <div id="personal-form">
                    <div class="container-fluid" style="border: 1px solid lightgrey; padding: 5px;">
                        <div class="col-md-9" style="border: 1px solid grey;"><br>
                        <span> Instructions: Choose the the answer that most represents how you generally behave.</span>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>3. When I cook a new dish, I like to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>a)   follow a written recipe</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>b)   call a friend for an explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_3" style="width: 15px;margin-right:10px;"> 
                                <p>c)   follow my instincts, testing as I cook</p>
                            </div>
                        </label>
                        <br>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <p>4. If I am teaching someone something new, I tend to:</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="a" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>a)   write instructions down for them</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="b" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>b)   give them a verbal explanation</p>
                            </div>
                        </label>
                        <label style="display: block;font-family: Courier New; font-weight: normal;">
                            <div id="sex">
                                <input q_category="c" type="radio" required name="set_4" style="width: 15px;margin-right:10px;"> 
                                <p>c)   demonstrate first and then let them have a go</p>
                            </div>
                        </label>
                        </div>
                    </div>
              </div>
              <div id="tapt-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer" id="footer">
               <button type="button" class="btn btn-default btn-mini waves-effect " onclick="goToPreviousDiv('section14')">Previous Page</button>
                <button type="button" id="save-color" class="btn btn-primary btn-mini waves-effect waves-light" >Submit Answer</button>
            </div>
        </div>
    </div>
</div>