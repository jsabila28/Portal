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
                        <div class="m-widget4__item" style="display: flex !important;">
                            <div class="m-widget4__img m-widget4__img--pic" style="width: auto !important;">
                                <img src="assets/announcement/<?=$gv['ann_content']?>" class="thumbnail" id="thumbnail" style="cursor: pointer; border-radius: 10px !important;width:100px; height:120px;">
                            </div>
                            <div class="m-widget4__info" style="padding-left: 10px;padding-top: 20px;">
                                <span class="m-widget4__title">
                                    <strong ><?=$gv['ann_title']?></strong>
                                </span>
                            </div>
                            
                        </div>
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
</div>
