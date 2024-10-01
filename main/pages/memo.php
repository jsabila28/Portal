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
<div id="memo"> 
    <span><a href="#"><h6>Memo</h6></a></span>
    <ol>
        <?php
             if (!empty($memos)) {
                  foreach ($memos as $memo) {
        ?>
        <li>
          <strong><?=$memo['memo_subject'];?> <label class="badge badge-danger" style="float: right;">unread</label></strong>
          <p><?= date("F j, Y", strtotime($memo['memo_date'])) ?> | <?=$memo['memo_no'];?></p>
        </li>
        <?php } } ?>
    </ol>
</div>