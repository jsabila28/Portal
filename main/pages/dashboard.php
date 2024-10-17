<?php
require_once($main_root."/actions/memo.php");
// $user_id = '045-2022-013';
$date = date("Y-m-d");
$Year = date("Y");
$memos = Portal::GetMemo($Year);
$leave = Portal::GetLeave($date);
$ongoingleave = Portal::GetOngoingLeave($date);
$resigning = Portal::GetResigning($date);
$government = Portal::GetGovAnn($date);
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
<div id="fullScreenOverlay">
    <span class="closeButton">&times;</span>
    <img id="fullScreenImage" src="" alt="">
</div>

<script>
    var thumbnails = document.getElementsByClassName("thumbnail");
    var overlay = document.getElementById("fullScreenOverlay");
    var fullScreenImage = document.getElementById("fullScreenImage");
    var closeButton = document.getElementsByClassName("closeButton")[0];

    // Loop through thumbnails and add click event
    for (var i = 0; i < thumbnails.length; i++) {
        thumbnails[i].onclick = function() {
            fullScreenImage.src = this.src; // Set the full image source
            overlay.style.display = "block"; // Show the overlay
        }
    }

    // Close the full-screen image on clicking the close button
    closeButton.onclick = function() {
        overlay.style.display = "none"; // Hide the overlay
    }

    // Also close the full-screen image if clicked anywhere on the overlay
    overlay.onclick = function(e) {
        if (e.target !== fullScreenImage) {
            overlay.style.display = "none";
        }
    }
</script>

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

            $.ajax({
                url: 'reaction',
                method: 'POST',
                data: { post_id: postId, reaction: reactionType, reacted_by: postBy },
                success: function (response) {
                    alert('Reaction submitted: ' + reactionType);
                },
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
</script>
