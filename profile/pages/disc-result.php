<?php
if (!empty($test_score)) { 
    // Get the first value of the $test_score array
    $score = $test_score[0]; 
    ?>
    <div class="col-lg-12 col-xl-12"> 
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
                <?php 
                break;

            default: ?>
                <p>Unknown category.</p>
                <?php 
                break;
        } ?>
    </div>
<?php } ?>
