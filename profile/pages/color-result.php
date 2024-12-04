<?php
		if($test_score!=""){ ?>

			<div class="col-lg-12 col-xl-12">                                       
                <!-- Nav tabs -->
                <ul class="nav nav-tabs  tabs" role="tablist">
                	<?php 	foreach($test_score as $tscore){ ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if($test_score[0]==$tscore){echo "class='active'";}?>" data-toggle="tab" href="#colortab_<?=$tscore;?>" role="tab"><b><?=$tscore;?></b></a>
                    </li>
                    <?php } ?>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabs card-block" style="height: 380px; overflow:auto;">
                	<?php if(in_array("Blue", $test_score)){ ?>
                    <div class="tab-pane <?php if($test_score[0]=="Blue"){echo "in active";}?>" id="colortab_Blue" role="tabpanel">
                        <div class="container-fluid">
							<br>
								<p style="margin-left:0in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:10.0pt">BLUE (Controller)</span></strong></span></span></p>

								<p><span style="font-size:10.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Blue is the color of the sky and the ocean. It also serves as the color of authority. Explorers have long been the pioneers of then land, the ocean and in space and their characteristics match this style. They enjoy looking at the &ldquo;big picture&rdquo;, being in charge, and are comfortable taking appropriate risk for themselves and their group. They are goal-oriented people and love to have their fingers in many pies. They are generally motivated by challenge and like competition. People of other &ldquo;styles&rdquo; get frustrated with these &ldquo;blues&rdquo; because they see them sometimes as impatient and abrupt people, selective listeners, but they appreciate the strong leadership qualities that they display. </span></span></p>
			             </div>
                    </div>
                	<?php } ?>
                	<?php if(in_array("Green", $test_score)){ ?>
                    <div class="tab-pane <?php if($test_score[0]=="Green"){echo "in active";}?>" id="colortab_Green" role="tabpanel">
                        <div class="container-fluid">
							<br>
								<p style="margin-left:0in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:10.0pt">GREEN (Analyst)</span></strong></span></span></p>

								<p><span style="font-size:10.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Green is the color of money and was one of the original colors of the computer screen. Of all the types, &ldquo;greens&rdquo; are the most comfortable where accuracy and numbers are important. Precision is inherent in their style. &ldquo;If a job is worth doing, it is worth doing right, the first time&rdquo; might be their motto. They are willing to take the time to get the job done right. They are the best of the four styles at critical thinking and planning. They make the best administrators as they like order, structure, following guidelines and plans (especially if they initiate them). Other styles complain that greens are too rigid, too slow at making decisions too &ldquo;picky&rdquo; but value their planning and problem solving skills. </span></span></p>
			             </div>
                    </div>
                	<?php } ?>
                	<?php if(in_array("Red", $test_score)){ ?>
                    <div class="tab-pane <?php if($test_score[0]=="Red"){echo "in active";}?>" id="colortab_Red" role="tabpanel">
                        <div class="container-fluid">
							<br>
								<p style="margin-left:0in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:10.0pt">RED (Promoter)</span></strong></span></span></p>

								<p><span style="font-size:10.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Red is the color of Valentines and tends to connote passion and enthusiasm, which sounds a lot like the &ldquo;reds&rdquo;. Reds are happiest when they are influencing or entertaining other people. Like the blues, they are comfortable taking risks and enjoy trying new things. They get bored if they have to do the same old thing all the time. They are charming, playful, spontaneous, talkative types who are energized by being the center of attention. They are motivated by recognition. They want to be liked. Other styles see them as unfocused, as they go along with everything, but appreciate their talents as great promoters who can sell anything. </span></span></p>
			             </div>
                    </div>
                	<?php } ?>
                	<?php if(in_array("Yellow", $test_score)){ ?>
                    <div class="tab-pane <?php if($test_score[0]=="Yellow"){echo "in active";}?>" id="colortab_Yellow" role="tabpanel">
                        <div class="container-fluid">
							<br>
								<p style="margin-left:0in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:10.0pt">BLUE (Controller)</span></strong></span></span></p>

								<p><span style="font-size:10.0pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Yellow is the color of the sun and &ldquo;yellows&rdquo; are like a ray of sunshine when they enter a room with their warm and caring style. Family is their number one priority. They tend to be more concerned with the needs of others. They are the best team builders, always listening to, encouraging and bringing out the best in others. They are motivated by appreciation or work done and have a strong need to please others. Like the &ldquo;greens&rdquo;, they dislike confrontation and will give into others to avoid conflict. Other styles see &ldquo;yellows&rdquo; as too soft, not hard-nosed enough, indecisive (they can see all sides of an issue) and resistant to change. They are often the &ldquo;glue&rdquo; that holds a group together. </span></span></p>
			             </div>
                    </div>
                	<?php } ?>
                </div>
            </div>

<?php	}
?>