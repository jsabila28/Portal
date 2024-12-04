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
                          <button class="btn btn-default btn-mini" data-toggle="modal" data-target="#Enneagram"> Take Enneagram Test</button>
                        </div> 
                      </div>
                    </div>
                    <div class="card" style="height: 500px !important; overflow: auto !important;margin-bottom: 200px !important;">
                        <div class="card-block" id="inne">
                         
                        </div>
                        <div class="card-block" id="inne">
                            <div class="col-lg-12 col-xl-12">
                                <!-- <h6 class="sub-title">Tab With Icon</h6> -->
                                <!-- <div class="sub-title">Tab With Icon</div>                                         -->
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs " role="tablist" style="font-size: 9px !important;">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#perfect" role="tab" style="color: #ba5e5b !important;font-size: 11px;"><i class="icofont icofont-law-alt-2"></i>(1) Perfectionist</a>
                                        
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#helper" role="tab" style="color: #c48660 !important;font-size: 11px;"><i class="icofont icofont-ui-user "></i>(2) Helper</a>
                                        
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#achive" role="tab" style="color: #c9c45f !important;font-size: 11px;"><i class="icofont icofont-trophy-alt"></i>(3) ACHIEVER</a>
                                        
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#romantic" role="tab" style="color: #65c985 !important;font-size: 11px;"><i class="icofont icofont-ui-love"></i>(4) ROMANTIC</a>
                                        
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#observer" role="tab" style="color: #5ec1c4 !important;font-size: 11px;"><i class="icofont icofont-ui-love"></i>(5) OBSERVER</a>
                                        
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#questioner" role="tab" style="color: #685cb8 !important;font-size: 11px;"><i class="icofont icofont-ui-love"></i>(6) QUESTIONER</a>
                                        
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#adventurer" role="tab" style="color: #a14f9a !important;font-size: 11px;"><i class="icofont icofont-map-pins"></i>(7) ADVENTURER</a>
                                        
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#asserter" role="tab" style="color: #a65162 !important;font-size: 11px;"><i class="icofont icofont-ui-love"></i>(8) ASSERTER</a>
                                        
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#peacemaker" role="tab" style="color: #122387 !important;font-size: 11px;"><i class="icofont icofont-ui-love"></i>(9) PEACEMAKER</a>
                                        
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabs card-block">
                                    <div class="tab-pane active" id="perfect" role="tabpanel">
                                        <p class="m-1">PERFECTIONIST</p>
                                        <h6>Ones are motivated by the need to live their life the right way, including improving themselves and the world around them.</h6><br>
                                        <div class="perf-container">
                                            <div class="first">
                                                <span>Ones at their BEST</span>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Ethical</td>
                                                            <td>Reliable</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Productive</td>
                                                            <td>Wise</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Idealistic</td>
                                                            <td>Fair</td>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>Honest</td>
                                                            <td>Orderly</td>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>Self-disciplined</td>
                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="second">
                                                <span>Ones at their WORST</span>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Judgmental</td>
                                                            <td>Inflexible</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Dogmatic (strict)</td>
                                                            <td>Obsessive-compulsive</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Critical of others</td>
                                                            <td>Overly Serious</td>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>Controlling</td>
                                                            <td>Anxious</td>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>Jealous</td>
                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="">
                                            <ul class="sticky">
                                                <li class="sticky-notes">
                                                    <a href = "#">
                                                        <h5>HOW TO GET ALONG WITH ME</h5><br><br>
                                                        <p>Take your share of the responsibility so I don’t end up with all the work.</p>
                                                        <p>Acknowledge my achievements.</p>
                                                        <p>I’m hard on myself. Reassure me that I’m fine the way I am.</p>
                                                        <p>Tell me that you value my advice.</p>
                                                        <p>Be fair and considerate, as I am.</p>
                                                        <p>Apologize if you have been unthoughtful. It will help me to forgive.</p>
                                                        <p>Gently encourage me to lighten up and to laugh at myself when I get uptight, but hear my worries first.</p>
                                                    </a>
                                                </li>
                                                <li class="sticky-notes">
                                                    <a href = "#">
                                                        <h5>RELATIONSHIPS</h5><br><br>
                                                        <p>Ones at their best in a relationship are loyal, dedicated, conscientious, and helpful. They are well balanced and have a good sense of humor.</p>
                                                        <p>Ones at their worst in a relationship are critical, argumentative, nit-picking, and uncompromising. They have high expectations of others.</p>
                                                    </a>
                                                </li>
                                                <li class="sticky-notes">
                                                    <a href = "#">
                                                        <h5>CAREERS</h5><br><br>
                                                        <p>Ones are efficient, organized, and always complete the task. The more analytical and tough-minded Ones are found in management, science, and law enforcement. The more people-oriented Ones are found in health care, education, and religious work. </p>
                                                        
                                                        <p>Since they do things in a professional, honest, and ethical manner, you would do well to have Ones as your car mechanic, surgeon, dentist, banker, and stockbroker.
                                                        </p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="helper" role="tabpanel">
                                        <p class="m-1">HELPER</p>
                                        <h6>Two are motivated by the need to be loved and valued and to express their positive feelings toward others. Traditionally society has encouraged Two qualities in females more than in males.</h6><br>
                                        <div class="perf-container">
                                            <div class="first">
                                                <span>Twos at their BEST</span>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Loving</td>
                                                            <td>Caring</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Adaptable</td>
                                                            <td>Insightful</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Generous</td>
                                                            <td>Enthusiastic</td>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>Turned in to how</td>
                                                            <td>People feel</td>
                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="second">
                                                <span>Twos at their WORST</span>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Martyr like</td>
                                                            <td>Indirect</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Manipulative</td>
                                                            <td>Possessive</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Hysterical</td>
                                                            <td>Overly Accommodating</td>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>Overly demonstrative (the more extroverted Twos)</td>
                                                           
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="">
                                            <ul class="sticky">
                                                <li class="sticky-notes">
                                                    <a href = "#">
                                                        <h5>HOW TO GET ALONG WITH ME</h5><br><br>
                                                        <p>Tell me that you appreciate me. Be specific.</p>
                                                        <p>Share fun times with me.</p>
                                                        <p>Take an interest in my problems, though I will probably try to focus on yours.</p>
                                                        <p>Let me know that I am important and special to you.</p>
                                                        <p>Be gentle if you decide to criticize me.</p>
                                                    </a>
                                                </li>
                                                <li class="sticky-notes">
                                                    <a href = "#">
                                                        <h5>RELATIONSHIPS</h5><br><br>
                                                        <p>Twos at their best in a relationship are attentive, appreciative, generous, warm, playful, and nurturing.</p>
                                                        <p>Twos makes their partners feel special and loved.</p>
                                                        <p>Twos at their worst in relationship are controlling, possessive, needy, and insincere. Since they have trouble asking directly, they tend to manipulate to get what they want.</p>

                                                    </a>
                                                </li>
                                                <li class="sticky-notes">
                                                    <a href = "#">
                                                        <h5>CAREERS</h5><br><br>
                                                        <p>Twos usually prefer to work with people, often in the helping professions, as counselors, teachers, and health workers. </p>
                                                        <p>Extroverted twos are sometimes found in the limelight as actresses, actors, and motivational speakers.</p>
                                                        </p>
                                                        <p>Twos also work in sales and helping others as receptionists, secretaries, assistants, decorators, and clothing consultants.</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="achive" role="tabpanel">
                                        <p class="m-1">ACHIEVER</p>
                                        <h6>Threes are motivated by the need to be productive, achieve success, and avoid failure.</h6><br>
                                        <div class="perf-container">
                                            <div class="first">
                                                <span>Threes at their BEST</span>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Optimistic</td>
                                                            <td>Confident</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Industrious</td>
                                                            <td>Efficient</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Self-propelled</td>
                                                            <td>Energetic</td>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>Practical</td>
                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="second">
                                                <span>Threes at their WORST</span>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Deceptive</td>
                                                            <td>Narcissistic</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Pretentious</td>
                                                            <td>Vain</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>Superficial</td>
                                                            <td>Vindictive</td>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td>Overly competitive</td>
                                                           
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="">
                                            <ul class="sticky">
                                                <li class="sticky-notes">
                                                    <a href = "#">
                                                        <h5>HOW TO GET ALONG WITH ME</h5><br><br>
                                                        <p>Leave me alone when I am doing my work.</p>
                                                        <p>Give me honest, but not unduly critical or judgmental, feedback.</p>
                                                        <p>Help me keep my environment harmonious and peaceful.</p>
                                                        <p>Don’t burden me with negative emotions. </p>
                                                        <p>Tell me when you’re proud of me or my accomplishments.</p>
                                                        <p>Tell me you like being around me.</p>
                                                    </a>
                                                </li>
                                                <li class="sticky-notes">
                                                    <a href = "#">
                                                        <h5>RELATIONSHIPS</h5><br><br>
                                                        <p>Threes at their best in relationship value and accept their partners. They are playful, giving, responsible, and well regarded by others in the community.</p>
                                                        <p>Threes are their worst in a relationship are preoccupied with work and projects. They are self-absorbed, defensive, impatient, dishonest, and controlling.</p>

                                                    </a>
                                                </li>
                                                <li class="sticky-notes">
                                                    <a href = "#">
                                                        <h5>CAREERS</h5><br><br>
                                                        <p>These are hardworking, goal oriented, organized, and decisive. They are frequently in management or leadership positions in business, law, banking, the computer field, and politics. Being in the public eye, as broadcasters and performers, is also common. The more helping-oriented Threes also become homemakers who put tremendous energy into their responsibilities.</p> 
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="romantic" role="tabpanel">
                                        <p class="m-1"></p>
                                    </div>
                                    <div class="tab-pane" id="observer" role="tabpanel">
                                        <p class="m-1"></p>
                                    </div>
                                    <div class="tab-pane" id="questioner" role="tabpanel">
                                        <p class="m-1"></p>
                                    </div>
                                    <div class="tab-pane" id="adventurer" role="tabpanel">
                                        <p class="m-1"></p>
                                    </div>
                                    <div class="tab-pane" id="asserter" role="tabpanel">
                                        <p class="m-1"></p>
                                    </div>
                                    <div class="tab-pane" id="peacemaker" role="tabpanel">
                                        <p class="m-1"></p>
                                    </div>
                                </div>
                            </div>
                            <br><br><br>
                            <br><br><br>
                            <br><br><br>
                            <br><br><br>
                            <br><br><br>
                            <br><br><br>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script type="text/javascript">
fetch('innegram')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("inne").innerHTML = data;
    // Add the event listener after the content is loaded
    document.querySelector('#save-enneagram').addEventListener('click', function () {
        const selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        const selectedValues = [];
        const qCategories = [];

        selectedCheckboxes.forEach(checkbox => {
            const qSet = checkbox.getAttribute('q_set');
            const qCategory = checkbox.getAttribute('q_category');
            selectedValues.push(`${qSet}-${qCategory}`);
            qCategories.push(qCategory);
        });

        // Combine the values into a single string
        const formattedData = selectedValues.join(',');

        // Send the data as JSON
        fetch('saveEnneagram', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                qCategories: qCategories,
                data: formattedData,
            }),
        })
            .then(response => response.json())
            .then(result => {
                console.log('Response:', result);
                if (result.status === 'success') {
                    alert(result.message);
                    window.location.reload();
                } else {
                    alert(result.message || 'Error saving data');
                }
            })
            .catch(error => {
                console.error('Error saving data:', error);
                alert('An unexpected error occurred');
            });
    });
})
.catch(error => {
    console.error('Error loading innegram content:', error);
    alert('Error loading content');
});

// Fetch data using AJAX
          fetch('enneagram') // Replace with the path to your PHP script
              .then(response => response.json())
              .then(data => {
                  const labels = data.map(item => item.type);
                  const scores = data.map(item => item.score);
      
                  // Create Polar Area Chart
                  const ctx = document.getElementById('polarChart').getContext('2d');
                  new Chart(ctx, {
                      type: 'polarArea',
                      data: {
                          labels: labels,
                          datasets: [{
                              label: 'Enneagram Scores',
                              data: scores,
                              backgroundColor: [
                                  '#f77d79',
                                  '#f7a979',
                                  '#f7f179',
                                  '#79f7a1',
                                  '#79f3f7',
                                  '#8a79f7',
                                  '#f779ed',
                                  '#f77992',
                                  '#798cf7'
                              ],
                              borderColor: [
                                  'rgba(255, 99, 132, 1)',
                                  'rgba(54, 162, 235, 1)',
                                  'rgba(255, 206, 86, 1)',
                                  'rgba(75, 192, 192, 1)',
                                  'rgba(153, 102, 255, 1)',
                                  'rgba(255, 159, 64, 1)',
                                  'rgba(140, 199, 132, 1)',
                                  'rgba(170, 152, 235, 1)',
                                  'rgba(200, 159, 100, 1)'
                              ],
                              borderWidth: 1
                          }]
                      },
                      options: {
                          responsive: true,
                          maintainAspectRatio: true,
                          plugins: {
                              legend: {
                                  display: false  // Hide the legend
                              },
                              datalabels: {
                                  // Label configuration
                                  display: true,
                                  align: 'end', // Position labels at the edge of the slice
                                  anchor: 'end', // Ensure the label is anchored at the edge
                                  color: 'black', // Label text color
                                  font: {
                                      size: 14,
                                      weight: 'bold'
                                  },
                                  formatter: (value, context) => {
                                      return context.chart.data.labels[context.dataIndex]; // Display label at the edge
                                  },
                                  offset: 10, // Add space between the slice and label
                              }
                          },
                          scales: {
                              r: {
                                  beginAtZero: true
                              }
                          },
                          layout: {
                              padding: {
                                  top: 20,
                                  bottom: 20,
                                  left: 20,
                                  right: 20
                              }
                          }
                      },
                      plugins: [ChartDataLabels] // Register the plugin
                  });
              })
              .catch(error => console.error('Error fetching data:', error));

// Functions for modal navigation
function goToNextDiv(nextSectionId) {
    // Hide all sections
    $('.modal-content').addClass('hidden');
    // Show the next section
    $('#' + nextSectionId).removeClass('hidden');
}

function goToPreviousDiv(previousSectionId) {
    // Hide all sections
    $('.modal-content').addClass('hidden');
    // Show the previous section
    $('#' + previousSectionId).removeClass('hidden');
}

</script>