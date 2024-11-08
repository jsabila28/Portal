<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-2" id="prof-left">
                <ul class="sidebar-menu">
                  <div id="header"><label>Profile</label></div>
                  <li>
                    <a href="person">
                      <p>
                        <i class="icon-user-female"></i> Personal
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="fam">
                      <p>
                        <i class="ion-ios-people"></i> Family Background
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="zmdi zmdi-favorite"></i> Special Skills
                      </p>
                    </a>
                  </li>
                  <hr>
                  <div id="header"><label>Education</label></div>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icon-graduation"></i> Education
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icofont icofont-certificate-alt-1"></i> Eligibility/Licenses
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                       <i class="icofont icofont-certificate-alt-2"></i> Certificate
                      </p>
                    </a>
                  </li>
                  
                  <hr>
                  <div id="header"><label>Work</label></div>
                  <li>
                    <a href="#">
                      <p>
                        <i class="ion-briefcase"></i> Employment Record
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icofont icofont-certificate-alt-2"></i> Internal Certificate
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="zmdi zmdi-accounts-list-alt"></i> Character Reference
                      </p>
                    </a>
                  </li>
                  <hr>
                  <div id="header"><label>Personality Test</label></div>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icofont icofont-brainstorming"></i> Enneagram
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icofont icofont-brainstorming"></i> TAPT
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icofont icofont-brainstorming"></i> DISC
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icofont icofont-brain-alt"></i> Multiple Intelligent Quotient
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icofont icofont-brainstorming"></i> What color are you?
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icofont icofont-brainstorming"></i> VAK
                      </p>
                    </a>
                  </li>
                  <hr>
                  <div id="header"><label>Time off / Offset</label></div>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icon-user-female"></i> Personal
                      </p>
                    </a>
                  </li>
                  <hr>
                  <div id="header"><label>Benefit</label></div>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icon-user-female"></i> Personal
                      </p>
                    </a>
                  </li>
                  <hr>
                  <div id="header"><label>Exit Interview</label></div>
                  <li>
                    <a href="#">
                      <p>
                        <i class="icon-user-female"></i> Personal
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                       
                      </p>
                    </a>
                  </li>
                </ul>
            </div>
            <div class="col-md-1">
             
            </div>
            <div class="col-md-8" id="prof-center">
                <div class="card">
                    <div class="card-block" id="prof-card">
                      <div id="personal-info">
                        <div class="profile">
                          <img src="https://e-classtngcacademy.s3.ap-southeast-1.amazonaws.com/e-class/Thumbnail/img/<?= $empno ?>.JPG" alt="User-Profile-Image" width="100" height="100" style="border-radius: 50px;">
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
                          <button class="btn btn-default btn-mini" data-toggle="modal" data-target="#Family-<?=$empno?>"><i class="icofont icofont-pencil-alt-2"></i> Edit Family Profile</button>
                        </div>  
                      </div>
                    </div>
                    <div id="family"></div>
                    <script>
                    fetch('family')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response.statusText);
                            }
                            return response.text(); // Since we're expecting HTML
                        })
                        .then(data => {
                            document.getElementById("family").innerHTML = data; // Set the inner HTML
                        })
                        .catch(error => console.error('Error fetching data:', error));
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/js/fam_back.js"></script>