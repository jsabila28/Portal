<?php
require_once($main_root."/actions/memo.php");
// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['error' => 'User not authenticated']);
//     exit;
// }

// $user_id = $_SESSION['user_id'];

$date = date("Y-m-d");
$Year = date("Y");
$Month = date("m");
$Day = date("d");
$yearMonth = date("Y-m");
$memos = Portal::GetMemo($Year);
$memoAll = Portal::GetAllMemo($Year);
$leave = Portal::GetLeave($date);
$ongoingleave = Portal::GetOngoingLeave($date);
$resigning = Portal::GetResigning($date);
$government = Portal::GetGovAnn($yearMonth);
$birthday = Portal::GetBirthday($Month,$Day);
$moods = Portal::GetMood($date);
$MyMood = Portal::GetMyMood($date,$user_id);
?>
<?php if (!empty($MyMood)) { ?>
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-3" id="left-side">
                <?php if (!empty($hotside)) include_once($hotside); ?>
                <?php require_once($main_root."/pages/events.php"); ?>
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
                <div class="user-card-block card">
                    <div class="card-block" id="right-bar">
                        <!-- GOVERNMENT -->
                        <?php require_once($main_root."/pages/gov.php"); ?>
                        <hr>
                        <!-- MEMO -->
                        <?php require_once($main_root."/pages/memo.php"); ?>

                        <?php require_once($main_root."/pages/leave.php"); ?>
                        
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