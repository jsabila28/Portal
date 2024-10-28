<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-2" id="prof-left">
                <ul class="sidebar-menu">
                  <div id="header"><label>Profile</label></div>
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
                        <i class="ion-ios-people"></i> Family Background
                      </p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <p>
                        <i class="zmdi zmdi-account-box-phone"></i> Emergency Contact
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
                       <i class="icofont icofont-certificate-alt-2"></i> Certificate
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
                        <i class="icofont icofont-certificate-alt-1"></i> Eligibility/Licenses
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
                            <p>Jr. Software Developer</p>
                          </div>
                        </div>
                        <div class="edit-profile">
                          <button class="btn btn-default btn-mini"><i class="icofont icofont-pencil-alt-2"></i> Edit Profile</button>
                        </div>  
                      </div>
                    </div>
                    <!-- #COMPLETE PERSONAL CONTACTS -->
                    <div class="card-block" id="prof-card">
                      <div class="contact">
                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-ui-call"></i>
                            </div>
                            <div class="content">
                              <p> +11111</p><br> 
                              <span>Telephone</span>
                            </div>
                          </div>
                          
                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-ipod-touch"></i>
                            </div>
                            <div class="content">
                              <p> 0950*****00</p><br> 
                              <span>Phone Number</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-ipod-touch"></i>
                            </div>
                            <div class="content">
                              <p> 09*********</p><br> 
                              <span>Company Phone</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-email"></i>
                            </div>
                            <div class="content">
                              <p> jsabila@teamtngc.com</p><br> 
                              <span>Email</span>
                            </div>
                          </div>
                      </div>
                    </div>
                    <!-- #COMPLETE PERSONAL CONTACTS END-->

                    <!-- #COMPLETE PERSONAL ADDRESS -->
                    <div class="card-block" id="prof-card">
                      <div class="contact">
                          <div class="numbers">
                            <div class="icon">
                              <i class="fa fa-home" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                              <p> Polangui Albay</p><br> 
                              <span>Permanent Address</span>
                            </div>
                          </div>
                          
                          <div class="numbers">
                            <div class="icon">
                              <i class="typcn typcn-location"></i>
                            </div>
                            <div class="content">
                              <p> Zamboanga City</p><br> 
                              <span>Current Address</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-social-gnome"></i>
                            </div>
                            <div class="content">
                              <p> Albay</p><br> 
                              <span>Place of birth</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="icofont icofont-map-search"></i>
                            </div>
                            <div class="content">
                              <p> Albay</p><br> 
                              <span>Province</span>
                            </div>
                          </div>

                      </div>
                    </div>
                    <!-- #COMPLETE PERSONAL ADDRESS END-->

                    <!-- #COMPLETE PERSONAL ADDRESS -->
                    <div class="card-block" id="prof-card">
                      <div class="contact" style="margin-bottom: 15px;">
                          <div class="numbers">
                            <div class="icon">
                              <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                              <p> July 28, 1999</p><br> 
                              <span>Date of birth</span>
                            </div>
                          </div>
                          
                          <div class="numbers">
                            <div class="icon">
                              <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                              <p> 25</p><br> 
                              <span>Age</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="typcn typcn-heart-half-outline"></i>
                            </div>
                            <div class="content">
                              <p> Single</p><br> 
                              <span>Civil Status</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="zmdi zmdi-male-female"></i>
                            </div>
                            <div class="content">
                              <p> Female</p><br> 
                              <span>Sex</span>
                            </div>
                          </div>

                      </div>
                      <div class="contact" style="margin-bottom: 25px;">
                          <div class="numbers">
                            <div class="icon">
                              
                            </div>
                            <div class="content">
                              <p> Roman Catholic</p><br> 
                              <span>Religion</span>
                            </div>
                          </div>
                          
                          <div class="numbers">
                            <div class="icon">
                              <i class="wi wi-raindrop"></i>
                            </div>
                            <div class="content">
                              <p> A</p><br> 
                              <span>Blood type</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="flag flag-icon-background flag-icon-PHP"></i>
                            </div>
                            <div class="content">
                              <p> Filipino</p><br> 
                              <span>Nationality</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="ti-ruler"></i>
                            </div>
                            <div class="content">
                              <p> 158cm</p><br> 
                              <span>Height</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              <i class="ti-dashboard"></i>
                            </div>
                            <div class="content">
                              <p> 57</p><br> 
                              <span>Weight</span>
                            </div>
                          </div>
                      </div>
                      <div class="contact">
                          <div class="numbers">
                            <div class="icon">
                              
                            </div>
                            <div class="content">
                              <p> 35-0017545-8</p><br> 
                              <span>SSS</span>
                            </div>
                          </div>
                          
                          <div class="numbers">
                            <div class="icon">
                              
                            </div>
                            <div class="content">
                              <p> 1212-7646-3910</p><br> 
                              <span>PAGIBIG</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              
                            </div>
                            <div class="content">
                              <p> 382-592-170</p><br> 
                              <span>TIN</span>
                            </div>
                          </div>

                          <div class="numbers">
                            <div class="icon">
                              
                            </div>
                            <div class="content">
                              <p> 100253981606</p><br> 
                              <span>PHILHEALTH</span>
                            </div>
                          </div>


                      </div>
                    </div>
                    <!-- #COMPLETE PERSONAL ADDRESS END-->
                </div>
            </div>
        </div>
    </div>
</div>
