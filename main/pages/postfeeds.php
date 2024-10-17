<div id="memo" style="margin-bottom: 5px; border-radius: 40px;"> 
    <div class="comment-wrapper">
        <div class="panel panel-info">
            <div >
                <ul>
                    <li class="media" style="margin-left: 10px;">
                        <a href="#" class="pull-left">
                            <img src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/<?= $empno ?>.JPG" alt="" class="img-circle">
                        </a>
                        <div class="media-body">
                           <button id="post-button" class="btn btn-mini btn-round" data-toggle="modal" data-target="#default-Modal" style="width: 90%; align-items: left;background-color:#b5b5b3;color:white;text-align: left;font-size: 14px;">Post Announcement or Celebration ?</button>
                        </div>
                        <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" style="text-align: center; width: 100%;">Create Post</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i style="cursor: pointer;font-size: 30px;" class="fa fa-times-circle"></i></span>
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
                                                            <input type="hidden" name="posted-by" value="<?= $user_id ?>">
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
                                                            placeholder="What's on you mind ?">   
                                                        </textarea> 
                                                        <!-- <div class="custom-pick">
                                                            <div class="background-picker"> 
                                                                <img height="38" alt="" class="xz74otr" referrerpolicy="origin-when-cross-origin" src="assets/img/foto.png">
                                                            </div>
                                                            <div class="emoji-picker"> 
                                                                <img height="38" alt="" class="xz74otr" referrerpolicy="origin-when-cross-origin" src="assets/img/emoji.png">
                                                            </div>
                                                        </div> -->
                                                        <div id="add-photo-video" class="hide-image">
                                                            <div class="image-video" id="image-video" style="background-image: url('assets/img/upload.png');" onclick="document.getElementById('file-input').click();">
                                                                <i id="close" onclick="toggleDiv()" style="cursor: pointer;" class="fa fa-times-circle"></i>
                                                                <!-- <div>
                                                                    <img src="assets/img/upload.png" width="100" height="100">
                                                                </div> -->
                                                            </div>
                                                            <input type="file" id="file-input" name="post-content" style="display: none;" onchange="updateFileContent()">
                                                        </div>
                                                        <div class="add-to-your-post"> 
                                                            <p class="add-to-post-text">Add to your post</p> 
                                                            <div class="add-to-post-icons"> 
                                                                <div class="photo-video" id="showIcon" onclick="toggleDiv()"></div> 
                                                                <div class="tag-people"></div> 
                                                                <div class="feeling-activity"></div> 
                                                                <!-- <div class="check-in"></div>  -->
                                                                <!-- <div class="gif"></div>  -->
                                                                <!-- <div class="live-video"></div>  -->
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
                                                        <h6>Who can see your post?</h6> 
                                                        <h6 class="your-post-text">Your post will show up 
                                                            in Feed, on your profile and in search results.</h6> 
                                                        <h6> Your default audience is set to Only me, 
                                                            but you can change the<br /> audience 
                                                            of this specific 
                                                            post.</h6> 
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
                                                                    <input type="radio" value="All" name="audience" 
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
                                                                    <input type="radio" value="TNGC" name="audience" 
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
                                                                    <input type="radio" value="SJI" name="audience" 
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
                                                                    <input type="radio" value="DI" 
                                                                        name="audience" 
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
                                                                    <input type="radio" value="QST" 
                                                                        name="audience" 
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
                                                                    <input type="radio" value="Only Me" 
                                                                        name="audience" 
                                                                        class="audience-option-radio"> 
                                                                </div> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="post-audience-options" style="text-align: right;">
                                                        <a id="cancel" style="text-decoration: none; font-size: 12px;margin-right: 5px;">Cancel</a>
                                                        <button class="btn btn-primary btn-mini" style="font-size: 12px;">Done</button>
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