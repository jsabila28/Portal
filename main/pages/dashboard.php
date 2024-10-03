<?php
require_once($main_root."/actions/memo.php");
// $user_id = '045-2022-013';
$date = date("Y-m-d");
$Year = date("Y");
$memos = Portal::GetMemo($Year);
$leave = Portal::GetLeave($date);
$ongoingleave = Portal::GetOngoingLeave($date);
$resigning = Portal::GetResigning($date);
?>
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-2" id="left-side">
                <ul class="sidebar-menu">
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd.png" width="30" height="30" style="margin-right: 5px;">Authority to Deduct
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/rps.png" width="30" height="30" style="margin-right: 5px;">Requisition and Purchasing
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/ris.png" width="30" height="30" style="margin-right: 5px;">Requisition / Issue Slip
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/jrs.png" width="30" height="30" style="margin-right: 5px;">Jewellery Requisition
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/abs.png" width="30" height="30" style="margin-right: 5px;">Annual Budget
                      </p>
                    </a>
                  </li>
                </ul>
            </div>
            <!-- <div class="col-xm-1">
            </div> -->
            <div class="col-md-5 col-md-offset-2" id="center">
                <div class="card">
                    <div class="card-block">
                        <?php require_once($main_root."/pages/postfeeds.php"); ?>
                    </div>
                </div>
            </div>
            <!-- <div class="col-xm-1">
            </div> -->
            <div class="col-md-3 col-md-offset-1" id="right-side">
                <div class="user-card-block card">
                    <div class="card-block" style="background-color: transparent; padding: 10px !important;overflow: auto !important;height: 100vh !important;">
                        <!-- MEMO -->
                        <?php require_once($main_root."/pages/memo.php"); ?>
                        <hr>
                        <!-- LEVE/OFFSET -->
                        <?php require_once($main_root."/pages/leave.php"); ?>
                        <hr>
                        <!-- RESIGNING -->
                        <?php require_once($main_root."/pages/resign.php"); ?>
                        <hr>
                        <!-- GOVERNMENT -->
                        <?php require_once($main_root."/pages/gov.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>