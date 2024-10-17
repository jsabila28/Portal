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
        <a href="#" data-toggle="modal" data-target="#large-Modal" style="text-decoration: none;">
          <strong><?=$memo['memo_subject'];?> <label class="badge badge-danger" style="float: right;">unread</label></strong><br>
          <small><?= date("F j, Y", strtotime($memo['memo_date'])) ?> | <?=$memo['memo_no'];?></small>
        </a>
        </li>
        <div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i style="cursor: pointer;font-size: 30px;" class="fa fa-times-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <iframe class="pdf" src="assets/memo/<?=$memo['memo_pdf'];?>" width="100%" height="500"></iframe>
                        <!-- <embed src="<?=$memo['memo_pdf'];?>"></embed> -->
                    </div>
                </div>
            </div>
        </div>
        <?php } } ?>
    </ol>
</div>