<link rel="stylesheet" type="text/css" href="/Portal/assets/css/memo.css">
<div id="memo"> 
    <span style="display: flex;justify-content: space-between;height: 25px;">
        <a href="#" data-toggle="modal" data-target="#all_memo"><h6>Memo</h6></a>
        <a href="add_memo" class="btn btn-outline-primary btn-mini"><h6><i class="fa fa-plus-circle"></i></h6></a>
    </span>
    <div class="modal fade" id="all_memo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title"><a href="add_memo" class="btn btn-primary btn-mini">Add Memo</a></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i style="cursor: pointer;font-size: 30px;" class="fa fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <ol>
                        <?php
                            if (!empty($memoAll)) {
                                foreach ($memoAll as $ml) {
                        ?>
                        <li>
                        <a href="#" data-toggle="modal" data-target="#memo<?=$ml['memo_no'];?>" style="text-decoration: none;">
                          <strong><?=$ml['memo_subject'];?></strong><br>
                          <small><?= date("F j, Y", strtotime($ml['memo_date'])) ?> | <?=$ml['memo_no'];?></small>
                        </a>
                        </li>
                        <?php } } ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <ol>
        <?php
             if (!empty($memos)) {
                  foreach ($memos as $memo) {
        ?>
        <li>
        <input type="hidden" name="memoIdInput" id="memoId" value="<?=$memo['memo_no']?>">
        <a href="#" data-toggle="modal" data-target="#memo<?=$memo['memo_no'];?>" style="text-decoration: none;">
          <strong><?=$memo['memo_subject'];?></strong><br>
          <small><?= date("F j, Y", strtotime($memo['memo_date'])) ?> | <?=$memo['memo_no'];?></small>
        </a>
        </li>
        
        <?php } } ?>
    </ol>
        <?php
            if (!empty($memoAll)) {
                foreach ($memoAll as $ml) {
        ?>
        <div class="modal fade" id="memo<?=$ml['memo_no'];?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?=$ml['memo_subject'];?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i style="cursor: pointer;font-size: 30px;" class="fa fa-times-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <iframe class="pdf" src="https://teamtngc.com/hris2/pages/memo/<?=$ml['memo_pdf'];?>" width="100%" height="500"></iframe>
                        <!-- <embed src="<?=$memo['memo_pdf'];?>"></embed> -->
                    </div>
                </div>
            </div>
        </div>
        <?php } } ?>
</div>