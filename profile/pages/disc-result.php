<?php
if (!empty($test_score)) { 
    // Get the first value of the $test_score array
    $score = $test_score[0]; 
    ?>
    <div class="col-lg-12 col-xl-12" id="disc-row"> 
        <?php
        switch ($score) {
            case "d":
            case "i": // Combined case for "d" and "i"
                ?>
                <div id="disc-square">
                    <div class="scale" id="one" style="background-image: url(/Portal/assets/img/DISC/1.PNG);">
                    </div>
                    <div class="scale" id="two" style="background-image: url(/Portal/assets/img/DISC/8.PNG);">
                    </div>
                    <div class="scale" id="three" style="background-image: url(/Portal/assets/img/DISC/20.PNG);">
                    </div>
                    <div class="scale" id="four" style="background-image: url(/Portal/assets/img/DISC/15.PNG);">
                    </div>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Dominance</span>
                    <p>Person places emphasis on accomplishing results, the bottom line, confidence</p><br>
                    <span>Behavior</span>
                    <p>- Sees the big picture</p>
                    <p>- Can be blunt</p>
                    <p>- Accepts challenges</p>
                    <p>- Gets straight to the point</p>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Influence</span>
                    <p>Person places emphasis on influencing or persuading others, openness, relationships</p><br>
                    <span>Behavior</span>
                    <p>- Shows enthusiasm</p>
                    <p>- Is optimistic</p>
                    <p>- Likes to collaborate</p>
                    <p>- Dislikes being ignored</p>
                </div>
                <?php 
                break;

            case "s":
            case "c": ?>
                <div id="disc-square">
                    <div class="scale" id="one" style="background-image: url(/Portal/assets/img/DISC/5.PNG);">
                    </div>
                    <div class="scale" id="two" style="background-image: url(/Portal/assets/img/DISC/10.PNG);">
                    </div>
                    <div class="scale" id="three" style="background-image: url(/Portal/assets/img/DISC/19.PNG);">
                    </div>
                    <div class="scale" id="four" style="background-image: url(/Portal/assets/img/DISC/12.PNG);">
                    </div>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Steadiness</span>
                    <p>Person places emphasis on cooperation, sincerity, dependability</p><br>
                    <span>Behavior</span>
                    <p>- Doesn&#39;t like to be rushed</p>
                    <p>- Calm manner</p>
                    <p>- Calm approach</p>
                    <p>- Supportive actions</p>
                    <p>- Humility</p>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Conscientiousness</span>
                    <p>Person places emphasis on quality and accuracy, expertise, competency</p><br>
                    <span>Behavior</span>
                    <p>- Enjoys independence</p>
                    <p>- Objective reasoning</p>
                    <p>- Wants the details</p>
                    <p>- Fears being wrong</p>
                </div>
                <?php 
                break;

            case "d":
            case "c": ?>
                <div id="disc-square">
                    <div class="scale" id="one" style="background-image: url(/Portal/assets/img/DISC/1.PNG);">
                    </div>
                    <div class="scale" id="two" style="background-image: url(/Portal/assets/img/DISC/10.PNG);">
                    </div>
                    <div class="scale" id="three" style="background-image: url(/Portal/assets/img/DISC/19.PNG);">
                    </div>
                    <div class="scale" id="four" style="background-image: url(/Portal/assets/img/DISC/15.PNG);">
                    </div>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Dominance</span>
                    <p>Person places emphasis on accomplishing results, the bottom line, confidence</p><br>
                    <span>Behavior</span>
                    <p>- Sees the big picture</p>
                    <p>- Can be blunt</p>
                    <p>- Accepts challenges</p>
                    <p>- Gets straight to the point</p>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Conscientiousness</span>
                    <p>Person places emphasis on quality and accuracy, expertise, competency</p><br>
                    <span>Behavior</span>
                    <p>- Enjoys independence</p>
                    <p>- Objective reasoning</p>
                    <p>- Wants the details</p>
                    <p>- Fears being wrong</p>
                </div>
                <?php 
                break;

            case "d":
            case "s": ?>
                <div id="disc-square">
                    <div class="scale" id="one" style="background-image: url(/Portal/assets/img/DISC/1.PNG);">
                    </div>
                    <div class="scale" id="two" style="background-image: url(/Portal/assets/img/DISC/10.PNG);">
                    </div>
                    <div class="scale" id="three" style="background-image: url(/Portal/assets/img/DISC/20.PNG);">
                    </div>
                    <div class="scale" id="four" style="background-image: url(/Portal/assets/img/DISC/12.PNG);">
                    </div>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Dominance</span>
                    <p>Person places emphasis on accomplishing results, the bottom line, confidence</p><br>
                    <span>Behavior</span>
                    <p>- Sees the big picture</p>
                    <p>- Can be blunt</p>
                    <p>- Accepts challenges</p>
                    <p>- Gets straight to the point</p>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Steadiness</span>
                    <p>Person places emphasis on cooperation, sincerity, dependability</p><br>
                    <span>Behavior</span>
                    <p>- Doesn&#39;t like to be rushed</p>
                    <p>- Calm manner</p>
                    <p>- Calm approach</p>
                    <p>- Supportive actions</p>
                    <p>- Humility</p>
                </div>
                <?php 
                break;

            case "i":
            case "s": ?>
                <div id="disc-square">
                    <div class="scale" id="one" style="background-image: url(/Portal/assets/img/DISC/5.PNG);">
                    </div>
                    <div class="scale" id="two" style="background-image: url(/Portal/assets/img/DISC/8.PNG);">
                    </div>
                    <div class="scale" id="three" style="background-image: url(/Portal/assets/img/DISC/20.PNG);">
                    </div>
                    <div class="scale" id="four" style="background-image: url(/Portal/assets/img/DISC/12.PNG);">
                    </div>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Influence</span>
                    <p>Person places emphasis on influencing or persuading others, openness, relationships</p><br>
                    <span>Behavior</span>
                    <p>- Shows enthusiasm</p>
                    <p>- Is optimistic</p>
                    <p>- Likes to collaborate</p>
                    <p>- Dislikes being ignored</p>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Steadiness</span>
                    <p>Person places emphasis on cooperation, sincerity, dependability</p><br>
                    <span>Behavior</span>
                    <p>- Doesn&#39;t like to be rushed</p>
                    <p>- Calm manner</p>
                    <p>- Calm approach</p>
                    <p>- Supportive actions</p>
                    <p>- Humility</p>
                </div>
                <?php 
                break;

            case "i":
            case "c": ?>
                <div id="disc-square">
                    <div class="scale" id="one" style="background-image: url(/Portal/assets/img/DISC/5.PNG);">
                    </div>
                    <div class="scale" id="two" style="background-image: url(/Portal/assets/img/DISC/8.PNG);">
                    </div>
                    <div class="scale" id="three" style="background-image: url(/Portal/assets/img/DISC/19.PNG);">
                    </div>
                    <div class="scale" id="four" style="background-image: url(/Portal/assets/img/DISC/15.PNG);">
                    </div>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Influence</span>
                    <p>Person places emphasis on influencing or persuading others, openness, relationships</p><br>
                    <span>Behavior</span>
                    <p>- Shows enthusiasm</p>
                    <p>- Is optimistic</p>
                    <p>- Likes to collaborate</p>
                    <p>- Dislikes being ignored</p>
                </div>
                <div id="disc-square" style="margin-left: 5%">
                    <span>Conscientiousness</span>
                    <p>Person places emphasis on quality and accuracy, expertise, competency</p><br>
                    <span>Behavior</span>
                    <p>- Enjoys independence</p>
                    <p>- Objective reasoning</p>
                    <p>- Wants the details</p>
                    <p>- Fears being wrong</p>
                </div>
                <?php 
                break;

            default: ?>
                <p>Unknown category.</p>
                <?php 
                break;
        } ?>
    </div>
<?php } ?>
