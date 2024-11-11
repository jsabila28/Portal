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
                        <!-- LEVE/OFFSET -->
                        <?php require_once($main_root."/pages/leave.php"); ?>
                        <hr>
                        <!-- RESIGNING -->
                        <?php require_once($main_root."/pages/resign.php"); ?>
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
    // Get the values from the inputs
    const comment = document.querySelector("input[name='Mycomment']").value;
    const postId = document.querySelector("input[name='post-id']").value;

    // Create an AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save_comment", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send the data as POST parameters
    xhr.send("Mycomment=" + encodeURIComponent(comment) + "&post-id=" + encodeURIComponent(postId));

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.success);
            } else {
                alert(response.error);
            }
        }
    };
}


</script>