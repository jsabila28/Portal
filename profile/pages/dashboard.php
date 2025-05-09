<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <?php if (!empty($profsidenav)) include_once($profsidenav); ?>
            <div class="col-md-1">
             
            </div>
            <div class="col-md-8" id="prof-center">
                <div class="card">
                    <div class="card-block" id="prof-card">
                      <div id="personal-info">
                        <div class="profile">
                          <img src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/<?= $empno ?>.JPG" alt="User-Profile-Image" width="100" height="100" style="border-radius: 50px;">
                          <a style="margin-top: 30%;font-size: 16px;"><i class="icofont icofont-camera-alt"></i></a>
                          <div class="basic-info">
                            <span id="userName">
                            <?php
                                echo $username;
                            ?>
                            </span>
                             <p><?php
                                echo $position;
                            ?></p>
                            <p><?php
                                echo $empno;
                            ?></p>
                          </div>
                        </div>
                        <div class="edit-profile">
                          <button class="btn btn-default btn-mini" id="profileButton" data-toggle="modal" data-target="#Personal-<?=$empno?>"><i class="icofont icofont-pencil-alt-2"></i> Edit Profile</button>
                        </div> 
                      </div>
                    </div>
                    <div id="profile"></div>
                   
                </div>
            </div>
        </div>
    </div>
</div> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="../assets/js/address.js"></script>
<script type="text/javascript" src="../assets/js/personal_profile.js"></script>

