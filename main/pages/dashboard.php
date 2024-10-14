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
            <div class="col-md-2" id="left-side">
                <ul class="sidebar-menu">
                  <li>
                    <a href="/Portal/leave/">
                      <p>
                        <img src="assets/img/atd.png" width="30" height="30" style="margin-right: 5px;">Authority to Deduct
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/rps.png" width="30" height="30" style="margin-right: 5px;">Requisition and Purchasing
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/ris.png" width="30" height="30" style="margin-right: 5px;">Requisition / Issue Slip
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/jrs.png" width="30" height="30" style="margin-right: 5px;">Jewellery Requisition
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#dashboard">
                      <p>
                        <img src="assets/img/abs.png" width="30" height="30" style="margin-right: 5px;">Annual Budget
                      </p>
                    </a>
                  </li>
                </ul>
            </div>
            <!-- <div class="col-xm-1">
            </div> -->
            <div class="col-md-5" id="center">
                <div class="card">
                    <div class="card-block">
                        <?php require_once($main_root."/pages/postfeeds.php"); ?>
                    </div>
                </div>
            </div>
            <!-- <div class="col-xm-1">
            </div> -->
            <div class="col-md-3 col-md-offset-1" id="right-side">
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
        // Toggle reaction options on click of the reaction trigger
        $('.reaction-trigger').on('click', function () {
            $(this).siblings('.reaction-options').toggle();
        });

        // Handle reaction click
        $('.reaction').on('click', function () {
            var reactionType = $(this).data('reaction');
            var postBy = $(this).data('posted-by');
            var postId = $(this).closest('.reaction-container').find('.reaction-trigger').attr('id').split('-')[2]; // Get post ID from the button ID

            // Send AJAX request to store reaction
            $.ajax({
                url: 'reaction', // Create this PHP file to handle reactions
                method: 'POST',
                data: { post_id: postId, reaction: reactionType, posted-by: postBy },
                success: function (response) {
                    // Update the UI dynamically after the server responds
                    alert('Reaction submitted: ' + reactionType);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
