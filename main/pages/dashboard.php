<?php
require_once($main_root."/actions/memo.php");
// $user_id = '045-2022-013';
$date = date("Y-m-d");
$Year = date("Y");
$yearMonth = date("Y-m");
$memos = Portal::GetMemo($Year);
$memoAll = Portal::GetAllMemo($Year);
$leave = Portal::GetLeave($date);
$ongoingleave = Portal::GetOngoingLeave($date);
$resigning = Portal::GetResigning($date);
$government = Portal::GetGovAnn($yearMonth);
?>
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-3" id="left-side">
                <ul class="sidebar-menu">
                  <li>
                    <a href="/Portal/ATD/">
                      <p>
                        <img src="assets/img/atd.png" width="40" height="40" style="margin-right: 5px;">Authority to Deduct
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/rps.png" width="40" height="40" style="margin-right: 5px;">Requisition and Purchasing
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/ris.png" width="40" height="40" style="margin-right: 5px;">Requisition / Issue Slip
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/jrs.png" width="40" height="40" style="margin-right: 5px;">Jewellery Requisition
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/abs.png" width="40" height="40" style="margin-right: 5px;">Annual Budget
                      </p>
                    </a>
                  </li>
                </ul>
                <?php require_once($main_root."/pages/events.php"); ?>
            </div>
            <div class="col-xm-3">
            </div>
            <div class="col-md-5" id="center">
                <div class="card">
                    <div class="card-block">
                        <input type="hidden" name="reacted_by" value="<?=$user_id?>">
                        <?php require_once($main_root."/pages/postfeeds.php"); ?>
                    </div>
                </div>
            </div>
            <div class="col-xm-1">
            </div>
            <div class="col-md-3" id="right-side">
                <div class="user-card-block card">
                    <div class="card-block" id="right-bar">
                        <!-- GOVERNMENT -->
                        <?php require_once($main_root."/pages/gov.php"); ?>
                        <hr>
                        <!-- MEMO -->
                        <?php require_once($main_root."/pages/memo.php"); ?>
                        <hr>
                        <ul class="nav nav-tabs  tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">Leave/Offset</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">Resigning</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabs card-block">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                                <div id="memo"> 
                                    <div class="m-portlet__body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="m_widget4_tab1_content">
                                                <div class="m-widget4 m-widget4--progress">
                                                    <?php
                                                         if (!empty($ongoingleave)) {
                                                              foreach ($ongoingleave as $ol) {
                                                    ?>
                                                    <div class="m-widget4__item"style="display:flex;justify-content: space-between;">
                                                        <div class="m-widget4__img m-widget4__img--pic">
                                                            <img style="width:30px; height:30px; border-radius:50%" src="assets/image/img/<?=$ol['la_empno'].'.jpg'?>" alt="">
                                                        </div>
                                                        <div class="m-widget4__info">
                                                            <span class="m-widget4__title">
                                                                <strong ><?=$ol['bi_empfname'].' '.$ol['bi_emplname']?></strong>
                                                            </span>
                                                            <br>
                                                            <span class="m-widget4__sub">
                                                                <strong class="text-muted"><?=$ol['Dept_Name']?></strong>
                                                            </span>
                                                        </div>
                                                        <div class="m-widget4__progress">
                                                            <div class="m-widget4__progress-wrapper">
                                                                <span class="m-widget17__progress-number">
                                                                   <strong>start: <?= date("M d, Y", strtotime($ol['la_start'])) ?></strong>
                                                                </span><br>
                                                                <span class="m-widget17__progress-label">
                                                                   <strong>return: <?= date("M d, Y", strtotime($ol['la_return'])) ?></strong>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="m-widget4__ext">
                                                            <label class="label label-inverse-danger"><?=$ol['la_type']?></label>
                                                        </div>
                                                    </div>
                                                    <?php }} ?>
                                                    <?php
                                                         if (!empty($leave)) {
                                                              foreach ($leave as $lv) {
                                                    ?>
                                                    <div class="m-widget4__item"style="display:flex;justify-content: space-between;">
                                                        <div class="m-widget4__img m-widget4__img--pic">
                                                            <img style="width:30px; height:30px; border-radius:50%" src="assets/image/img/<?=$lv['la_empno'].'.jpg'?>" alt="">
                                                        </div>
                                                        <div class="m-widget4__info"style="width: 120px;">
                                                            <span class="m-widget4__title">
                                                                <strong ><?=$lv['bi_empfname'].' '.$lv['bi_emplname']?></strong>
                                                            </span>
                                                            <br>
                                                            <span class="m-widget4__sub">
                                                                <strong class="text-muted"><?=$lv['Dept_Name']?></strong>
                                                            </span>
                                                        </div>
                                                        <div class="m-widget4__progress">
                                                            <div class="m-widget4__progress-wrapper">
                                                                <span class="m-widget17__progress-number">
                                                                   <strong>start: <?= date("M d, Y", strtotime($lv['la_start'])) ?></strong>
                                                                </span><br>
                                                                <span class="m-widget17__progress-label">
                                                                   <strong>return: <?= date("M d, Y", strtotime($lv['la_return'])) ?></strong>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="m-widget4__ext" style="width: 50px;">
                                                            <label class="label label-inverse-danger"><?=$lv['la_type']?></label>
                                                        </div>
                                                    </div>
                                                    <?php }} ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile1" role="tabpanel">
                                <div id="memo"> 
                                    <div class="comment-wrapper">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <ul class="media-list">
                                                    <?php
                                                        if (!empty($resigning)) {
                                                            foreach ($resigning as $rs) {
                                                    ?>
                                                    <li class="media">
                                                        <a href="#" class="pull-left">
                                                            <img src="assets/image/img/<?=$rs['xintvw_empno'].'.jpg'?>" alt="" class="img-circle">
                                                        </a>
                                                        <div class="media-body">
                                                            <span class="text-muted pull-right">
                                                                <strong>Last day: <?= date("F j, Y", strtotime($rs['xintvw_lastday'])) ?></strong>
                                                            </span>
                                                            <strong ><?=$rs['bi_emplname'].', '.$rs['bi_empfname'] ?></strong>
                                                            <p>
                                                                <strong class="text-muted"><?=$rs['jd_title']?></strong>
                                                            </p>
                                                            <strong class="text-muted"><?=$rs['C_Name']?></strong>
                                                        </div>
                                                    </li>
                                                    <?php }} ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="imageOverlay" onclick="closeImageOverlay()">
    <span class="close-btn">&times;</span>
    <img id="overlayImage" src="" alt="Full-screen image">
</div>
<script type="text/javascript" src="/Portal/assets/js/post.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.reaction-trigger').on('click', function () {
        $(this).siblings('.reaction-options').toggle();
    });

    $('.reaction').on('click', function () {
        var reactionType = $(this).data('reaction');
        var postBy = $(this).data('reacted_by');
        var postId = $(this).closest('.reaction-container').find('.reaction-trigger').attr('id').split('-')[2];
        var $reactionTrigger = $(this).closest('.reaction-container').find('.reaction-trigger');

        $.ajax({
            url: 'reaction',
            method: 'POST',
            data: { post_id: postId, reaction: reactionType, reacted_by: postBy },
            success: function (response) {
                // alert('Reaction submitted: ' + reactionType);
                
                // Hide the reaction options for the specific post
                $(this).closest('.reaction-container').find('.reaction-options').hide();
                
                // Hide the reaction trigger
                $reactionTrigger.hide();
                
                // Change the display of the reaction trigger to show the clicked reaction
                // Update with the appropriate reaction image or text
                var reactionImage;
                switch (reactionType) {
                    case 'like':
                        reactionImage = '<img src="https://i.pinimg.com/564x/dc/12/46/dc124679726a20dc2cad0aaefdfdb312.jpg" class="img-fluid rounded-circle" alt="Like">';
                        break;
                    case 'heart':
                        reactionImage = '<img src="https://i.pinimg.com/564x/f0/1b/91/f01b919c68c353f95d58b174761e5df5.jpg" class="img-fluid rounded-circle" alt="Heart">';
                        break;
                    case 'love':
                        reactionImage = '<img src="https://i.pinimg.com/564x/1e/b9/ab/1eb9abce88c9859c08e70330ef8495dc.jpg" class="img-fluid rounded-circle" alt="Love">';
                        break;
                    case 'cry':
                        reactionImage = '<img src="https://i.pinimg.com/736x/7f/3f/f7/7f3ff7ab44c80e30adefdf6b16c3910d.jpg" class="img-fluid rounded-circle" alt="Cry">';
                        break;
                    case 'haha':
                        reactionImage = '<img src="https://i.pinimg.com/564x/d5/8a/76/d58a766054d451198a197c3c6f127b2e.jpg" class="img-fluid rounded-circle" alt="Haha">';
                        break;
                    case 'money':
                        reactionImage = '<img src="https://i.pinimg.com/564x/ee/c6/a1/eec6a14275d6dd51f0592276d74fc35b.jpg" class="img-fluid rounded-circle" alt="Money">';
                        break;
                    case 'angry':
                        reactionImage = '<img src="https://i.pinimg.com/564x/0e/b2/75/0eb275a0b969571ca235168b176949ed.jpg" class="img-fluid rounded-circle" alt="Angry">';
                        break;
                    case 'eey':
                        reactionImage = '<img src="https://i.pinimg.com/564x/cc/12/e0/cc12e02e7eed4491de74e05ea8a019a5.jpg" class="img-fluid rounded-circle" alt="Eey">';
                        break;
                    default:
                        reactionImage = ''; // Fallback if no match
                }

                // Set the reaction trigger to display the selected reaction
                $reactionTrigger.html(reactionImage).show(); // Show it back if you want it visible
            }.bind(this), // Bind 'this' to access the current reaction element
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
});


$(document).ready(function() {
    $('.post-btn').click(function(e) {
        e.preventDefault(); 

        var postedBy = $('input[name="posted-by"]').val();
        var postDesc = $('#post-desc').val();
        var audience = $('input[name="audience"]:checked').val();
        var postContent = new FormData();

        postContent.append('postedBy', postedBy);
        postContent.append('postDesc', postDesc);
        postContent.append('audience', audience);
        
        var fileInput = $('#file-input')[0].files[0];
        if (fileInput) {
            postContent.append('file', fileInput);
        }

        $.ajax({
            url: 'postnews',
            type: 'POST',
            data: postContent,
            processData: false, 
            contentType: false,
            success: function(response) {
                alert(response);
                $('#default-Modal').modal('hide');
                 resetModalForm();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    function resetModalForm() {
        $('#post-desc').val('');  // Clear the textarea
        $('input[name="audience"]').prop('checked', false);  // Uncheck audience radio buttons
        $('#file-input').val('');  // Clear file input
        $('#image-video').css('background-image', 'url(assets/img/upload.png)');  // Reset image preview
        $('.post-btn').prop('disabled', true);  // Disable post button again
        $('#add-photo-video').addClass('hide-image');  // Hide the photo/video section
    }


    $('#post-desc').on('input', function() {
        if ($(this).val().trim() !== '') {
            $('.post-btn').prop('disabled', false);
        } else {
            $('.post-btn').prop('disabled', true);
        }
    });

});

function saveComment() {
    const commentInput = document.querySelector('#input-default');
    const comId = document.querySelector('input[name="com-id"]').value;
    const comment = commentInput.value;

    if (comment.trim() === '') {
        alert('Comment cannot be empty!');
        return;
    }

    // Send AJAX request to save comment
    fetch('save_comment', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `com_id=${encodeURIComponent(comId)}&Mycomment=${encodeURIComponent(comment)}&user_id=${encodeURIComponent('<?php echo $user_id; ?>')}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            commentInput.value = ''; // Clear the input field
            reloadComments(comId); // Reload comments
        } else {
            alert(data.message || 'An error occurred while saving the comment.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function reloadComments(comId) {
    // Fetch the updated comment list
    fetch(`comment?com_id=${encodeURIComponent(comId)}`)
    .then(response => response.text())
    .then(html => {
        const commentSection = document.querySelector('#comment-section'); // Adjust selector as needed
        commentSection.innerHTML = html; // Replace with updated comments
    })
    .catch(error => console.error('Error:', error));
}




</script>