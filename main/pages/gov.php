<div id="memo"> 
    <span><a href="#"><h6>Government</h6></a></span>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="m_widget4_tab1_content">
                    <div class="m-widget4 m-widget4--progress">
                        <?php
                             if (!empty($government)) {
                                  foreach ($government as $gv) {
                        ?>
                        <div class="m-widget4__item">
                            <div class="m-widget4__img m-widget4__img--pic" style="width: auto !important;">
                                <img src="assets/announcement/<?=$gv['ann_content']?>" class="thumbnail" id="thumbnail" style="cursor: pointer; border-radius: 10px !important;width:85px; height:100px;">
                            </div>
                            <div class="m-widget4__info" style="padding-left: 10px;padding-top: 20px;">
                                <span class="m-widget4__title">
                                    <strong ><?=$gv['ann_title']?></strong>
                                </span>
                                <br>
                                <span class="m-widget4__sub">
                                    <!-- <strong class="text-muted"><?=$gv['jrec_department']?></strong> -->
                                </span>
                            </div>
                            <div class="m-widget4__progress" style="width: 90%;">
                                <div class="m-widget4__progress-wrapper">
                                    <span class="m-widget17__progress-number">
                                       <!-- <strong>start: <?= date("M d, Y", strtotime($lv['la_start'])) ?></strong> -->
                                    </span><br>
                                    <span class="m-widget17__progress-label">
                                       <!-- <strong>return: <?= date("M d, Y", strtotime($lv['la_return'])) ?></strong> -->
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
</div>
