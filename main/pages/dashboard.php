<?php
require_once($main_root."/actions/memo.php");
// $user_id = '045-2022-013';
$date = date("Y-m-d");
$Year = date("Y");
$yearMonth = date("Y-m");
$memos = Portal::GetMemo($Year);
$memoAll = Portal::GetAllMemo($Year);
$leave = Portal::GetLeave($date);
$ongoingleave = Portal::GetOngoingLeave($date);
$resigning = Portal::GetResigning($date);
$government = Portal::GetGovAnn($yearMonth);
?>
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-3" id="left-side">
                <ul class="sidebar-menu">
                  <li>
                    <a href="/Portal/ATD/">
                      <p>
                        <img src="assets/img/atd.png" width="40" height="40" style="margin-right: 5px;">Authority to Deduct
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/rps.png" width="40" height="40" style="margin-right: 5px;">Requisition and Purchasing
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/ris.png" width="40" height="40" style="margin-right: 5px;">Requisition / Issue Slip
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/jrs.png" width="40" height="40" style="margin-right: 5px;">Jewellery Requisition
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/abs.png" width="40" height="40" style="margin-right: 5px;">Annual Budget
                      </p>
                    </a>
                  </li>
                </ul>
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
                        <hr>
                        <!-- LEVE/OFFSET -->
                        <?php require_once($main_root."/pages/leave.php"); ?>
                        <hr>
                        <!-- RESIGNING -->
                        <?php require_once($main_root."/pages/resign.php"); ?>
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
<script type="text/javascript" src="/Portal/assets/js/post.js"></script>