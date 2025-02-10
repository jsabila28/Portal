<div id="memo"> 
    <!-- <span><a href="#"><h6>Government</h6></a></span> -->
    <span style="display: flex;justify-content: space-between;height: 25px;">
        <a href="#" data-toggle="modal" data-target="#"><h6>Government</h6></a>
        <a href="#" class="btn btn-outline-primary btn-mini" data-toggle="modal" data-target="#gov-Modal"><h6><i class="fa fa-plus-circle"></i></h6></a>
    </span>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="m_widget4_tab1_content">
                    <div class="m-widget4 m-widget4--progress">
                        <?php
                             if (!empty($government)) {
                                  foreach ($government as $gv) {
                        ?>
                        <div class="m-widget4__item" style="display: flex !important;">
                            <div class="m-widget4__img m-widget4__img--pic"  style="width: 40% !important;">
                                <!-- <img src="assets/announcement/<?=$gv['ann_content']?>" class="thumbnail" id="thumbnail" style="cursor: pointer; border-radius: 10px !important;width:100px; height:120px;" onclick="openImageOverlay('assets/announcement/<?=$gv['ann_content']?>')"> -->
                                <?php 
                                    if (strpos($gv['ann_content'], '<figure') !== false) {

                                        $imagePattern = '/<img\s+[^>]*src=["\']([^"\']+)["\']/i';

                                        // Match image sources
                                        preg_match_all($imagePattern, $gv['ann_content'], $imageMatches);
                                        $sources = $imageMatches[1];

                                        foreach ($sources as $imgv) {
                                            echo '<img class="img-fluid" style="cursor: pointer; border-radius: 10px !important;width:100px; height:120px;" src="https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($imgv) . '" onclick="openImageOverlay(\'https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($imgv) . '\')">';
                                        }

                                        } else if (strpos($gv['ann_content'], '<figure') !== false) {
                                            echo str_replace('../announcement', 'https://teamtngc.com/hris2/pages/announcement', $gv['ann_content']);
                                        } else {
                                            echo '<img class="img-fluid" style="cursor: pointer; border-radius: 10px !important;width:100px; height:120px;" src="https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($gv['ann_content']) . '" onclick="openImageOverlay(\'https://teamtngc.com/hris2/pages/announcement/' . htmlspecialchars($gv['ann_content']) . '\')">';
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
<div class="modal fade" id="gov-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Government Announcement</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icofont icofont-close-circled"></i></span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px;">
                <div id="personal-form">
                  <div id="pers-name">
                      <label style="width:100% !important;">Title<span id="required">*</span>  
                          <input class="form-control" type="text" name="govname" id="govInput" value=""/>
                      </label>
                  </div>
                  <div id="pers-name">
                      <label style="width:50% !important;">Start Date<span id="required">*</span>  
                          <input class="form-control" type="date" name="gtartdate" id="gsdateInput" value=""/>
                      </label>
                      <label style="width:45% !important;">End Date<span id="required">*</span> 
                          <input class="form-control" type="date" name="genddate" id="gedateInput" value=""/>
                      </label>
                  </div>
                  <div id="pers-name">
                      
                      <label style="width:100% !important;">Image<span id="required">*</span> 
                          <input class="form-control" type="file" multiple name="govimg" id="govimgInput" value=""/>
                      </label>
                  </div>
                </div>
                <div id="event-message" class="alert" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-mini " data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-mini waves-light" id="save-government">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function openImage() {
    console.log('Input clicked');
    window.open('https://i.pinimg.com/564x/b0/68/56/b06856d929b6066d2281c9f065a29e31.jpg', '_blank');
}
document.getElementById('save-government').addEventListener('click', function () {
    // Get input values
    const govname = document.getElementById('govInput').value;
    const gstartdate = document.getElementById('gsdateInput').value;
    const genddate = document.getElementById('gedateInput').value;
    const govimgFiles = document.getElementById('govimgInput').files; 

    if (!govname || !gstartdate || !genddate || !govimgFiles.length === 0) {
        alert('All fields are required!');
        return;
    }

    const formData = new FormData();
    formData.append('govname', govname);
    formData.append('gtartdate', gstartdate);
    formData.append('genddate', genddate);

    for (let i = 0; i < govimgFiles.length; i++) {
        formData.append('govimg[]', govimgFiles[i]);
    }

    fetch('save_gov', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Event saved successfully!');
            document.getElementById("govInput").value = "";
            document.getElementById("gsdateInput").value = "";
            document.getElementById("gedateInput").value = "";
            document.getElementById("govimgInput").value = "";
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

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
