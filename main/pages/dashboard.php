<?php
require_once($main_root."/actions/memo.php");
require_once($main_root."/actions/get_personal.php");

$date = date("Y-m-d");
$Year = date("Y");
$Month = date("m");
$Day = date("d");
$yearMonth = date("Y-m");
$directives = Portal::GetDirectives($Year,$empno,$company,$department,$area,$outlet);
$promotions = Portal::GetPromotions($Year,$empno,$company,$department,$area,$outlet);
$memoAll = Portal::GetAllMemo($Year,$empno,$company,$department,$area,$outlet);
// $memo = Portal::GetMemo();
$leave = Portal::GetLeave($date);
$ongoingleave = Portal::GetOngoingLeave($date);
$resigning = Portal::GetResigning($Year);
$government = Portal::GetGovAnn($yearMonth);
$birthday = Portal::GetBirthday($Month,$Day);
$moods = Portal::GetMood($date,$empno);
$MyMood = Portal::GetMyMood($date,$user_id);
$events = Portal::GetEvents($date);
?>
<?php if (!empty($MyMood)) { ?>
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-3" id="left-side">
                <?php if (!empty($hotside)) include_once($hotside); ?>
                <?php require_once($main_root."/pages/events.php"); ?>
                <div style="height: 50px;padding: 10px;">
                    <span>True North Group of Companies | 2025</span>
                </div>
            </div>
            <div class="col-xm-3">
            </div>
            <div class="col-md-5" id="center">
                <div class="card">
                    <div class="card-block">
                        <input type="hidden" name="reacted_by" value="<?=$user_id?>">
                        <?php require_once($main_root."/pages/postfeeds.php"); ?>
                    </div>
                </div>
            </div>
            <div class="col-xm-1">
            </div>
            <div class="col-md-3" id="right-side">
                <div class="user-card-block card" style="padding: 0px !important;">
                    <div class="card-block" id="right-bar">
                        <!-- GOVERNMENT -->
                        <?php require_once($main_root."/pages/gov.php"); ?>
                        <hr>
                        <!-- MEMO -->
                        <?php require_once($main_root."/pages/memo.php"); ?>
                        <div id="memo"> 
                            <ul class="nav nav-tabs  tabs" role="tablist" style="background-color: transparent !important;">
                                <li class="nav-item" style="width: 40% !important;">
                                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab" style="background-color: transparent !important;">Leave | Offset</a>
                                </li>
                                <li class="nav-item" style="width: 40% !important;">
                                    <a class="nav-link" data-toggle="tab" href="#profile1" role="tab" style="background-color: transparent !important;">Resigning</a>
                                </li>
                            </ul>
                            <div class="tab-content tabs card-block">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <div class="m-widget4 m-widget4--progress">
                                        <?php
                                             if (!empty($ongoingleave)) {
                                                  foreach ($ongoingleave as $ol) {
                                        ?>
                                        <!-- <div class="m-widget4__item"style="display:flex;justify-content: space-between;">
                                            <div class="m-widget4__img m-widget4__img--pic">
                                                <img style="width:30px; height:30px; border-radius:50%" src="assets/image/img/<?=$ol['la_empno'].'.jpg'?>" alt="">
                                            </div>
                                            <div class="m-widget4__info"style="width:40% !important;">
                                                <span class="m-widget4__title">
                                                    <strong ><?=$ol['bi_empfname'].' '.$ol['bi_emplname']?></strong>
                                                </span>
                                                <br>
                                                <span class="m-widget4__sub">
                                                    <strong class="text-muted"><?=$ol['Dept_Name']?></strong>
                                                </span>
                                            </div>
                                            <div class="m-widget4__progress"style="width:40% !important;">
                                                <div class="m-widget4__progress-wrapper">
                                                    <span class="m-widget17__progress-number">
                                                       <strong>start: <?= date("M d, Y", strtotime($ol['la_start'])) ?></strong>
                                                    </span><br>
                                                    <span class="m-widget17__progress-label">
                                                       <strong>return: <?= date("M d, Y", strtotime($ol['la_return'])) ?></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-widget4__ext"style="width:20% !important;">
                                                <label class="label label-inverse-danger"><?=$ol['la_type']?></label>
                                            </div>
                                        </div> -->
                                        <?php }} ?>
                                        <?php
                                             if (!empty($leave)) {
                                                  foreach ($leave as $lv) {
                                        ?>
                                        <div class="m-widget4__item"style="display:flex;justify-content: space-between;">
                                            <div class="m-widget4__img m-widget4__img--pic">
                                                <img style="width:30px; height:30px; border-radius:50%" src="https://teamtngc.com/hris2/pages/empimg/<?=$lv['la_empno'].'.jpg'?>" alt="">
                                            </div>
                                            <div class="m-widget4__info"style="width: 120px;">
                                                <span class="m-widget4__title">
                                                    <strong ><?=$lv['bi_empfname'].' '.$lv['bi_emplname']?></strong>
                                                </span>
                                                <br>
                                                <span class="m-widget4__sub">
                                                    <strong class="text-muted"><?=$lv['Dept_Name']?></strong>
                                                </span>
                                            </div>
                                            <div class="m-widget4__progress">
                                                <div class="m-widget4__progress-wrapper">
                                                    <span class="m-widget17__progress-number">
                                                       <strong>start: <?= date("M d, Y", strtotime($lv['la_start'])) ?></strong>
                                                    </span><br>
                                                    <span class="m-widget17__progress-label">
                                                       <strong>return: <?= date("M d, Y", strtotime($lv['la_return'])) ?></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-widget4__ext" style="width: 50px;">
                                                <label class="label label-inverse-danger"><?=$lv['la_type']?></label>
                                            </div>
                                        </div>
                                        <?php }} ?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    <div class="m-widget4 m-widget4--progress">
                                        <?php
                                            if (!empty($resigning)) {
                                                foreach ($resigning as $rs) {
                                        ?>
                                        <div class="m-widget4__item"style="display:flex;justify-content: space-between;">
                                            <div class="m-widget4__img m-widget4__img--pic">
                                                <img style="width:30px; height:30px; border-radius:50%" src="https://teamtngc.com/hris2/pages/empimg/<?=$rs['ji_empno'].'.jpg'?>" alt="">
                                            </div>
                                            <div class="m-widget4__info"style="width: 120px;">
                                                <span class="m-widget4__title">
                                                    <strong ><?=$rs['Fullname'] ?></strong>
                                                </span>
                                                <br>
                                                <span class="m-widget4__sub">
                                                    <strong class="text-muted"><?=$rs['jd_title']?></strong>
                                                </span>
                                                <br>
                                                <span class="m-widget4__sub">
                                                    <strong class="text-muted"><?=$rs['C_Name']?></strong>
                                                </span>
                                            </div>
                                            <div class="m-widget4__progress">
                                                <div class="m-widget4__progress-wrapper">
                                                    <span class="m-widget17__progress-number">
                                                       <strong>last day: <?= date("F j, Y", strtotime($rs['ji_resdate'])) ?></strong>
                                                    </span><br>
                                                </div>
                                            </div>
                                            <div class="m-widget4__ext" style="width: 50px;">
                                                <label class="label label-inverse-danger">resigning</label>
                                            </div>
                                        </div>
                                        <?php }} ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        // require_once($main_root."/pages/leave.php"); 
                        ?>
                        
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="imageOverlay" onclick="closeImageOverlay()">
    <span class="close-btn">&times;</span>
    <img id="overlayImage" src="" alt="Full-screen image">
</div>
<?php }else{
    require_once($main_root."/pages/mood.php");
} ?>

<script type="text/javascript" src="/Portal/assets/js/post.js"></script>
<script type="text/javascript" src="/Portal/assets/js/portal.js"></script>