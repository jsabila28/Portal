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
                            <div class="m-widget4__img m-widget4__img--pic" style="width: 40% !important;">
                                <!-- <img src="assets/announcement/<?=$gv['ann_content']?>" class="thumbnail" id="thumbnail" style="cursor: pointer; border-radius: 10px !important;width:100px; height:120px;" onclick="openImageOverlay('assets/announcement/<?=$gv['ann_content']?>')"> -->
                                <?php 
                                    if(strpos($gv['ann_content'], '<figure') !== false){

                                        $imagePattern = '/<img\s+[^>]*src=["\']([^"\']+)["\']/i';

                                        // Match image sources
                                        preg_match_all($imagePattern, $gv['ann_content'], $imageMatches);
                                        $sources = $imageMatches[1];

                                        foreach ($sources as $imgv) {
                                            echo '<img class="img-fluid" style="cursor: pointer; border-radius: 10px !important;width:100px; height:120px;"  src="https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($imgv) . '" onclick="openImageOverlay("https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($gv['ann_content']) . '")">';
                                        }

                                    }else if(strpos($gv['ann_content'], '<figure') !== false){
                                        echo str_replace('../announcement', 'https://teamtngc.com/hris2/pages/announcement', $gv['ann_content']);
                                    }else{
                                        echo '<img class="img-fluid" style="cursor: pointer; border-radius: 10px !important;width:100px; height:120px;" src="https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($gv['ann_content']) . '" onclick="openImageOverlay("https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($gv['ann_content']) . '")">';
                                    }

                                ?>
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
<script>
document.addEventListener("DOMContentLoaded", function() {
    window.openImageOverlay = function(src) {
        document.getElementById('overlayImage').src = src;
        document.getElementById('imageOverlay').style.display = 'flex';
    }

    window.closeImageOverlay = function() {
        document.getElementById('imageOverlay').style.display = 'none';
    }
});
</script>
