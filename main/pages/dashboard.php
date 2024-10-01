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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-block">
                        <?php require_once($main_root."/pages/postfeeds.php"); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
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