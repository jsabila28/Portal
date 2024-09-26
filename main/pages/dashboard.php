<?php
require_once($main_root."/actions/memo.php");
// $user_id = '045-2022-013';
$date = date("Y");
$memos = Portal::GetMemo($date);
$leave = Portal::GetLeave($date);
?>
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div id="memo" style="margin-bottom: 5px;"> 
                            <div class="comment-wrapper">
                                <div class="panel panel-info">
                                    <div >
                                        <ul>
                                            <li class="media" style="margin-left: 10px;">
                                                <a href="#" class="pull-left">
                                                    <img src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/<?= $empno ?>.JPG" alt="" class="img-circle">
                                                </a>
                                                <div class="media-body">
                                                   <button class="btn btn-default btn-mini btn-round" data-toggle="modal" data-target="#default-Modal" style="width: 90%;">Post Announcement or Celebration ?</button>
                                                </div>
                                                <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title" style="text-align: center; width: 100%;">Create Post</h6>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"><i style="cursor: pointer;" class="fa fa-times-circle"></i></span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form>
                                                               <main class="post"> 
                                                                    <div class="wrapper"> 
                                                                        <section class="create-post">  
                                                                            <div class="post-header"> 
                                                                                <!-- <div class="profile-pic"></div>  -->
                                                                                <img class="profile-pic" src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/<?= $empno ?>.JPG">
                                                                                <div class="user-info"> 
                                                                                    <div class="full-name"><?php echo $username; ?></div> 
                                                                                    <div class="post-audience"> 
                                                                                        <div class="friends-icon"></div> 
                                                                                        <span class="audience-text">Only Me</span> 
                                                                                        <div class="drop-down"><i class="icofont icofont-caret-down"></i></div> 
                                                                                    </div> 
                                                                                </div> 
                                                                            </div> 
                                                                            <div class="post-content"> 
                                                                                <textarea name="post-desc" id="post-desc" 
                                                                                        cols="30" rows="5" 
                                                                                    placeholder="What's on you mind ?"></textarea> 
                                                                                <!-- <div class="emoji-picker"> 
                                                                                    <emoji-picker class="light"></emoji-picker> 
                                                                                    <i class="emoji" aria-label="Insert an emoji" 
                                                                                    role="img"></i> 
                                                                                </div> -->
                                                                                <div id="add-photo-video" class="hide-image">
                                                                                    <div class="image-video" id="image-video">
                                                                                        <i id="close" onclick="toggleDiv()" style="cursor: pointer;" class="fa fa-times-circle"></i>
                                                                                        <div onclick="document.getElementById('file-input').click();">
                                                                                            <img src="assets/img/plus.png" alt="Add">
                                                                                            <p>Add Photos/Videos</p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="file" id="file-input" style="display: none;" onchange="updateFileContent()">
                                                                                </div>
                                                                                <div class="add-to-your-post"> 
                                                                                    <p class="add-to-post-text">Add to your post</p> 
                                                                                    <div class="add-to-post-icons"> 
                                                                                        <div class="photo-video" id="showIcon" onclick="toggleDiv()"></div> 
                                                                                        <div class="tag-people"></div> 
                                                                                        <div class="feeling-activity"></div> 
                                                                                        <div class="check-in"></div> 
                                                                                        <div class="gif"></div> 
                                                                                        <div class="live-video"></div> 
                                                                                    </div> 
                                                                                </div> 
                                                                                <button class="post-btn" disabled>Post</button> 
                                                                            </div> 
                                                                        </section> 
                                                                        <section class="post-audience-section"> 
                                                                            <header class="post-audience-header"> 
                                                                                <div class="arrow-left-icon"><i class="fa fa-arrow-circle-o-left"></i></div> 
                                                                                <h6>Post Audience</h6> 
                                                                            </header> 
                                                                            <div class="post-audience-content"> 
                                                                                <p>Who can see your post?</p> 
                                                                                <p class="your-post-text">Your post will show up 
                                                                                    in Feed, on your profile and in search results.</p> 
                                                                                <p> Your default audience is set to Only me, 
                                                                                    but you can change the<br /> audience 
                                                                                    of this specific 
                                                                                    post.</p> 
                                                                            </div> 
                                                                            <div class="post-audience-options"> 
                                                                                <div class="audience-option"> 
                                                                                    <div class="audience-option-left"> 
                                                                                        <div class="audience-option-icon"><i class="icofont icofont-world"></i></div> 
                                                                                        <div class="audience-option-details"> 
                                                                                            <div class="audience-option-text">ALL</div> 
                                                                                            <!-- <span class="audience-option-desc">Anyone on 
                                                                                            or off Facebook</span>  -->
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="audience-option-right"> 
                                                                                        <div class="radio-btn"> 
                                                                                            <input type="radio" name="audience-option-radio" 
                                                                                                class="audience-option-radio"> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                </div> 
                                                                                <div class="audience-option"> 
                                                                                    <div class="audience-option-left"> 
                                                                                        <div class="audience-option-icon"><i class="icofont icofont-compass-alt-2"></i></div> 
                                                                                        <div class="audience-option-details"> 
                                                                                            <div class="audience-option-text">TNGC</div> 
                                                                                            <!-- <span class="audience-option-desc">Your friends 
                                                                                            on Facebook</span> --> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="audience-option-right"> 
                                                                                        <div class="radio-btn"> 
                                                                                            <input type="radio" name="audience-option-radio" 
                                                                                                class="audience-option-radio"> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                </div> 
                                                                                <div class="audience-option"> 
                                                                                    <div class="audience-option-left"> 
                                                                                        <div class="audience-option-icon"><i class="icofont icofont-girl-alt"></i></div> 
                                                                                        <div class="audience-option-details"> 
                                                                                            <div class="audience-option-text">SJI</div> 
                                                                                            <!-- <span class="audience-option-desc">Don't show 
                                                                                            to some friends</span>  -->
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="audience-option-right"> 
                                                                                        <div class="radio-btn"> 
                                                                                            <input type="radio" name="audience-option-radio" 
                                                                                                class="audience-option-radio"> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                </div> 
                                                                                <div class="audience-option"> 
                                                                                    <div class="audience-option-left"> 
                                                                                        <div class="audience-option-icon"></div> 
                                                                                        <div class="audience-option-details"> 
                                                                                            <div class="audience-option-text"> 
                                                                                            DI</div> 
                                                                                            <!-- <span class="audience-option-desc">Only 
                                                                                            show to some friends</span>  -->
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="audience-option-right"> 
                                                                                        <div class="radio-btn"> 
                                                                                            <input type="radio" 
                                                                                                name="audience-option-radio" 
                                                                                                class="audience-option-radio"> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                </div> 
                                                                                <div class="audience-option"> 
                                                                                    <div class="audience-option-left"> 
                                                                                        <div class="audience-option-icon"><i class="icofont icofont-man-in-glasses"></i></div> 
                                                                                        <div class="audience-option-details"> 
                                                                                            <div class="audience-option-text">QST</div> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="audience-option-right"> 
                                                                                        <div class="radio-btn"> 
                                                                                            <input type="radio" 
                                                                                                name="audience-option-radio" 
                                                                                                class="audience-option-radio"> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                </div> 
                                                                                <div class="audience-option"> 
                                                                                    <div class="audience-option-left"> 
                                                                                        <div class="audience-option-icon"><i class="icofont icofont-lock"></i></div> 
                                                                                        <div class="audience-option-details"> 
                                                                                            <div class="audience-option-text">Only Me</div> 
                                                                                            <!-- <span class="audience-option-desc">Include 
                                                                                            and exclude friends and lists</span>  -->
                                                                                        </div> 
                                                                                    </div> 
                                                                                    <div class="audience-option-right"> 
                                                                                        <div class="radio-btn"> 
                                                                                            <input type="radio" 
                                                                                                name="audience-option-radio" 
                                                                                                class="audience-option-radio"> 
                                                                                        </div> 
                                                                                    </div> 
                                                                                </div>
                                                                            </div> 
                                                                        </section> 
                                                                    </div> 
                                                                </main> 
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="myDiv"></div>
                            <script>
                            fetch('post')
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok: ' + response.statusText);
                                    }
                                    return response.text(); // Since we're expecting HTML
                                })
                                .then(data => {
                                    document.getElementById("myDiv").innerHTML = data; // Set the inner HTML
                                })
                                .catch(error => console.error('Error fetching data:', error));
                            </script>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="user-card-block card">
                    <div class="card-block" style="background-color: white; padding: 10px !important;">
                        <div id="memo"> 
                            <span><a href="#">Memo</a></span>
                            <ol>
                                <?php
                                     if (!empty($memos)) {
                                          foreach ($memos as $memo) {
                                ?>
                                <li>
                                  <strong><?=$memo['memo_subject'];?> <label class="badge badge-danger" style="float: right;">unread</label></strong>
                                  <p><?= date("F j, Y", strtotime($memo['memo_date'])) ?> | <?=$memo['memo_no'];?></p>
                                </li>
                                <?php } } ?>
                            </ol>
                        </div>
                        <hr>
                        <div id="memo"> 
                            <span><a href="#"><p>Leave / Offset</p></a></span>
                                <div class="m-portlet__body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="m_widget4_tab1_content">
                                            <div class="m-widget4 m-widget4--progress">
                                                <?php
                                                     if (!empty($leave)) {
                                                          foreach ($leave as $lv) {
                                                ?>
                                                <div class="m-widget4__item">
                                                    <div class="m-widget4__img m-widget4__img--pic">
                                                        <img src="assets/image/img/<?=$lv['la_empno'].'.jpg'?>" alt="">
                                                    </div>
                                                    <div class="m-widget4__info">
                                                        <span class="m-widget4__title">
                                                            <strong ><?=$lv['bi_empfname'].' '.$lv['bi_emplname']?></strong>
                                                        </span>
                                                        <br>
                                                        <span class="m-widget4__sub">
                                                            <strong class="text-muted"><?=$lv['jrec_department']?></strong>
                                                        </span>
                                                    </div>
                                                    <div class="m-widget4__progress">
                                                        <div class="m-widget4__progress-wrapper">
                                                            <span class="m-widget17__progress-number">
                                                               <strong>start: <?= date("F j, Y", strtotime($lv['la_start'])) ?></strong>
                                                            </span><br>
                                                            <span class="m-widget17__progress-label">
                                                               <strong>return: <?= date("F j, Y", strtotime($lv['la_return'])) ?></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="m-widget4__ext">
                                                        <label class="label label-inverse-danger"><?=$lv['la_type']?></label>
                                                    </div>
                                                </div>
                                                <?php }} ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <hr>
                        <div id="memo"> 
                            <span><a href="#">Resigning</a></span>
                            <div class="comment-wrapper">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <ul class="media-list">
                                            <li class="media">
                                                <a href="#" class="pull-left">
                                                    <img src="https://i.pinimg.com/564x/59/24/e0/5924e0f69d41b73a5e8127c8b6305385.jpg" alt="" class="img-circle">
                                                </a>
                                                <div class="media-body">
                                                    <span class="text-muted pull-right">
                                                        <strong>Last day: Sep 30, 2024</strong>
                                                    </span>
                                                    <strong >Judith S. Abila</strong>
                                                    <p>
                                                        <strong class="text-muted">MIS</strong>
                                                    </p>
                                                    <strong class="text-muted">Jr. Software Developer</strong>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <a href="#" class="pull-left">
                                                    <img src="https://i.pinimg.com/564x/59/24/e0/5924e0f69d41b73a5e8127c8b6305385.jpg" alt="" class="img-circle">
                                                </a>
                                                <div class="media-body">
                                                    <span class="text-muted pull-right">
                                                        <strong>Last day: Sep 30, 2024</strong>
                                                    </span>
                                                    <strong >Judith S. Abila</strong>
                                                    <p>
                                                        <strong class="text-muted">MIS</strong>
                                                    </p>
                                                    <strong class="text-muted">Jr. Software Developer</strong>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <a href="#" class="pull-left">
                                                    <img src="https://i.pinimg.com/564x/59/24/e0/5924e0f69d41b73a5e8127c8b6305385.jpg" alt="" class="img-circle">
                                                </a>
                                                <div class="media-body">
                                                    <span class="text-muted pull-right">
                                                        <strong>Last day: Sep 30, 2024</strong>
                                                    </span>
                                                    <strong >Judith S. Abila</strong>
                                                    <p>
                                                        <strong class="text-muted">MIS</strong>
                                                    </p>
                                                    <strong class="text-muted">Jr. Software Developer</strong>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>