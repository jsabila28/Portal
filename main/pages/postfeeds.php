<?php
    if (!empty($moods)) {
?>
<div id="memo" style="margin-bottom: 5px; border-radius: 40px;"> 
    <div class="comment-wrapper">
        <div class="panel panel-info">
            <div id="scroll">
                <ul>
                    <li class="media" style="margin-left: 10px;">
                        <?php 
                            foreach ($moods as $v) {
                        ?>
                        <a href="#" class="pull-left" style="position: relative;width: 55px;">
                            <img src="https://teamtngc.com/hris2/pages/empimg/<?= $v['m_empno'] ?>.JPG" alt="" class="img-circle">
                            <!-- Mood icon at the top right corner -->
                            <div style="position: absolute; top: 0; right: 0; background-color: white; color: white; padding: 2px; border-radius: 50%;">
                                <?php if ($v['m_mood'] == 'anger') {
                                    echo'<img id="img-emoji" src="/Portal/assets/reactions/sadness.WEBP">';  
                                }elseif ($v['m_mood'] == 'crying') {
                                    echo'<img id="img-emoji" src="/Portal/assets/reactions/cry.WEBP">'; 
                                }elseif ($v['m_mood'] == 'eyeroll') {
                                    echo'<img id="img-emoji" src="/Portal/assets/reactions/ROLL.JPG">'; 
                                }elseif ($v['m_mood'] == 'inlove') {
                                    echo'<img id="img-emoji" src="/Portal/assets/reactions/inlove.JPG">'; 
                                }elseif ($v['m_mood'] == 'sleepy') {
                                    echo'<img id="img-emoji" src="/Portal/assets/reactions/sleep.JPG">'; 
                                }elseif ($v['m_mood'] == 'tired') {
                                    echo'<img id="img-emoji" src="/Portal/assets/reactions/Tireds.JPG">'; 
                                }elseif ($v['m_mood'] == 'nuh') {
                                    echo'<img id="img-emoji" src="/Portal/assets/reactions/lough.WEBP">'; 
                                } ?>
                            </div>
                        </a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php
    if (!empty($birthday)) {
?>
<div id="memo" style="margin-bottom: 5px; border-radius: 40px;"> 
    <div class="comment-wrapper">
        <div class="panel panel-info">
            <div id="scroll">
                <ul>
                    <li class="media" style="margin-left: 10px;">
                        <?php 
                            foreach ($birthday as $b) {
                        ?>
                        <a href="#" class="pull-left" style="position: relative;width: 55px;margin-right: 60px;">
                            <img src="/Portal/assets/img/birthday.gif" alt="" style="width: 50px;height: 50px;">
                            <!-- Mood icon at the top right corner -->
                            <div class="right-birthday">
                                 <strong><?=$b['bi_empfname'].' '.$b['bi_emplname']?></strong><br>
                                 <small>Birthday Today!</small>
                            </div>
                        </a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div id="memo" style="margin-bottom: 5px; border-radius: 40px;"> 
    <div class="comment-wrapper">

        <div class="panel panel-info">
            <div>
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
                                        <h6 class="modal-title" style="text-align: center; width: 100%;color: black !important;"><b>Create Post</b></h6>
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
                                                                <!-- <i id="resultText" class="fa fa-user"></i> -->
                                                                <!-- <span id="resultIcon" class="audience-text">Only Me</span>  -->
                                                                <i id="resultIcon" class="fa fa-user"></i>
                                                                <span id="resultText">Only Me</span>
                                                                <div class="drop-down"><i class="icofont icofont-caret-down"></i></div> 
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                    <div class="post-content"> 
                                                        <textarea name="post-desc" id="post-desc" cols="30" rows="5" placeholder="What's on you mind ?"></textarea>
                                                        <div id="add-text-post" class="">
                                                            <textarea name="post-desc" id="post-desc2" cols="30" rows="5" placeholder="What's on you mind ?"></textarea>
                                                        </div> 
                                                        <div id="first-pick" class="custom-pick">
                                                            <div id="first-picker" class="background-picker"> 
                                                                <img height="38" alt="" class="xz74otr" referrerpolicy="origin-when-cross-origin" src="assets/img/foto.png">
                                                            </div>
                                                            <div class="emoji-picker"> 
                                                                <img height="38" alt="" class="xz74otr" referrerpolicy="origin-when-cross-origin" src="assets/img/emoji.png">
                                                            </div>
                                                        </div>
                                                        <!-- BACKGROUND SELECTION -->
                                                        <div id="second-pick" class="custom-pick" style="display: none;">
                                                            <div id="second-picker" class="background-picker"> 
                                                                <img height="38" alt="" style="border-radius: 10px;" class="xz74otr" referrerpolicy="origin-when-cross-origin" src="assets/img/angle-left.png">
                                                            </div>
                                                            <div id="back-picker" class="background-picker"> 
                                                                <img height="38" alt="" style="border-radius: 10px;" class="xz74otr" referrerpolicy="origin-when-cross-origin" src="assets/img/templates/8.png">
                                                            </div>
                                                            <div id="img-back" class="background-picker"> 
                                                                <img height="38"  style="border-radius: 10px;" class="xz74otr" data-bg="assets/img/templates/1.png" referrerpolicy="origin-when-cross-origin" src="assets/img/templates/bday1.png">
                                                            </div>
                                                            <div id="img-back" class="background-picker"> 
                                                                <img height="38"  style="border-radius: 10px;" class="xz74otr" data-bg="assets/img/templates/4.png" referrerpolicy="origin-when-cross-origin" src="assets/img/templates/bday3.png">
                                                            </div>
                                                            <div id="img-back" class="background-picker"> 
                                                                <img height="38"  style="border-radius: 10px;" class="xz74otr" data-bg="assets/img/templates/6.png" referrerpolicy="origin-when-cross-origin" src="assets/img/templates/bday5.png">
                                                            </div>
                                                            <div id="img-back" class="background-picker"> 
                                                                <img height="38"  style="border-radius: 10px;" class="xz74otr" data-bg="assets/img/templates/2.png" referrerpolicy="origin-when-cross-origin" src="assets/img/templates/ann2.png">
                                                            </div>
                                                            <div id="img-back" class="background-picker"> 
                                                                <img height="38"  style="border-radius: 10px;" class="xz74otr" data-bg="assets/img/templates/5.png" referrerpolicy="origin-when-cross-origin" src="assets/img/templates/ann4.png">
                                                            </div>
                                                            <div id="img-back" class="background-picker"> 
                                                                <img height="38"  style="border-radius: 10px;" class="xz74otr" data-bg="assets/img/templates/7.png" referrerpolicy="origin-when-cross-origin" src="assets/img/templates/ann6.png">
                                                            </div>
                                                            <div class="emoji-picker"> 
                                                                <img height="38"  style="border-radius: 10px;" class="xz74otr" referrerpolicy="origin-when-cross-origin" src="assets/img/emoji.png">
                                                            </div>
                                                        </div>
                                                        <!-- BACKGROUND SELECTION -->
                                                        <div id="add-photo-video" class="hide-image">
                                                            <div class="image-video" id="image-video" style="background-image: url('assets/img/upload.png');" onclick="document.getElementById('file-input').click();">
                                                            </div>
                                                            <input type="file" id="file-input" name="post-content[]" style="display: none;" onchange="updateFileContent()" multiple>
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
                                                        <button class="post-btn" id="post-btn" disabled>Post</button> 
                                                        <button class="post-btn" id="post-btn2" disabled style="display: none;">Post</button> 
                                                    </div> 
                                                </section> 
                                                <section class="post-audience-section" id="optionsDiv"> 
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
                                                                        class="audience-option-radio" data-icon="fa fa-users" data-text="ALL"> 
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
                                                                        class="audience-option-radio" data-icon="fa fa-users" data-text="TNGC"> 
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
                                                                        class="audience-option-radio" data-icon="fa fa-users" data-text="SJI"> 
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
                                                                        class="audience-option-radio" data-icon="fa fa-users" data-text="DI"> 
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
                                                                        class="audience-option-radio" data-icon="fa fa-users" data-text="QST"> 
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
                                                                        class="audience-option-radio" data-icon="fa fa-user" data-text="Only Me"> 
                                                                </div> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="post-audience-options" style="display:flex;float: right;">
                                                        <a id="cancel" class="btn btn-default btn-mini" style="text-decoration: none; font-size: 12px;margin-right: 5px;">Cancel</a>
                                                        <a type="button" class="btn btn-primary btn-mini" style="font-size: 12px;color: white;" id="submitBtn">Done</a>
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
 <!-- <div>Loading more posts...</div> -->
<div id="loading" class="timeline-wrapper" style="display:none;">
    <div class="timeline-item">
        <div class="animated-background facebook">
            <div class="background-masker header-top"></div>
            <div class="background-masker header-left"></div>
            <div class="background-masker header-right"></div>
            <div class="background-masker header-bottom"></div>
            <div class="background-masker subheader-left"></div>
            <div class="background-masker subheader-right"></div>
            <div class="background-masker subheader-bottom"></div>
            <div class="background-masker content-top"></div>
            <div class="background-masker content-first-end"></div>
            <div class="background-masker content-second-line"></div>
            <div class="background-masker content-second-end"></div>
            <div class="background-masker content-third-line"></div>
            <div class="background-masker content-third-end"></div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0/html2canvas.min.js"></script>
<script>
    let page = 1;

    function loadMorePosts() {
        $('#loading').show();
        $.ajax({
            url: 'post',
            type: 'POST',
            data: { page: page },
            success: function(response) {
                $('#loading').hide();
                if (response.trim() !== '') {
                    $('#myDiv').append(response);
                    page++;
                } else {
                    $('#loading').html('No more posts available.');
                }
            }
        });
    }

    // Initial load
    $(document).ready(function() {
        loadMorePosts();

        // Detect when the user reaches the bottom of the page
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                loadMorePosts();
            }
        });
    });

    // Get elements
    const firstPick = document.getElementById('first-pick');
    const secondPick = document.getElementById('second-pick');
    const firstPicker = document.getElementById('first-picker');
    const secondPicker = document.getElementById('second-picker');
    const textpost = document.getElementById('post-desc');
    const addTextPost = document.getElementById('add-text-post');
    const image = document.getElementById('img-back');
    const back = document.getElementById('back-picker');
    const post = document.getElementById('post-btn');
    const post2 = document.getElementById('post-btn2');
    const textArea = document.getElementById('post-desc2');

    firstPicker.addEventListener('click', () => {
        firstPick.style.display = 'none';
        secondPick.style.display = 'flex';
    });

    secondPicker.addEventListener('click', () => {
        secondPick.style.display = 'none';
        firstPick.style.display = 'flex';
    });

    image.addEventListener('click', () => {
        textpost.style.display = 'none';
        addTextPost.style.display = 'block';
        post.style.display = 'none';
        post2.style.display = 'block';
    });

    back.addEventListener('click', () => {
        textpost.style.display = 'block';
        addTextPost.style.display = 'none';
        post.style.display = 'block';
        post2.style.display = 'none';
    });

    // Set background image selection
    document.querySelectorAll('#second-pick .background-picker img').forEach(image => {
        image.addEventListener('click', () => {
            const selectedBackground = image.getAttribute('data-bg');
            if (selectedBackground) {
                addTextPost.style.backgroundImage = `url('${selectedBackground}')`;
                addTextPost.style.backgroundSize = 'cover';
                addTextPost.style.backgroundPosition = 'center';
            }
        });
    });

    // Capture and save post content on button click
    document.getElementById('post-btn2').addEventListener('click', (event) => {
        event.preventDefault(); // Prevent form submission or page reload

        // Debug: Check if addTextPost is accessible
        console.log('addTextPost:', addTextPost);

        // Capture the div with background and text using html2canvas
        html2canvas(addTextPost).then(canvas => {
            // Debug: Check if canvas was created correctly
            console.log('Canvas created:', canvas);

            const imageData = canvas.toDataURL('image/png'); // Convert to Base64 image
            console.log('Generated Image Data:', imageData);

            // Check if imageData is valid
            if (!imageData) {
                console.error('Failed to generate image data');
                alert('Failed to generate image data');
                return;
            }

            const content = textArea.value; // Get content from the textarea
            console.log('Post Content:', content);

            // Send data to server via AJAX
            fetch('save_post', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    image: imageData,
                    content: content
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Post saved successfully!');
                } else {
                    alert('Failed to save the post.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }).catch(error => {
            console.error('Error capturing canvas:', error);
        });
    });
</script>
