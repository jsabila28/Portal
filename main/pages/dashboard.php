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
                        <img src="assets/img/atdmenu.png" width="25" height="25" style="margin-right: 20px;">ATD
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/sign.png" width="25" height="25" style="margin-right: 20px;">Requisition and Purchasing
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/ris.png" width="25" height="25" style="margin-right: 20px;">Requisition / Issue Slip
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd.png" width="25" height="25" style="margin-right: 20px;">ATD
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd.png" width="25" height="25" style="margin-right: 20px;">ATD
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd.png" width="25" height="25" style="margin-right: 20px;">ATD
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/atd.png" width="25" height="25" style="margin-right: 20px;">ATD
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
                    <div class="card-block" style="background-color: transparent; padding: 10px !important;">
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