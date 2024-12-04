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
                          <button class="btn btn-default btn-mini" data-toggle="modal" data-target="#MIQ"> Take MIQ Test</button>
                        </div> 
                      </div>
                    </div>
                    <div class="card-block" id="prof-card">
                        <div id="personal-info">
                            <div id="miq">
                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
fetch('miq')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
document.getElementById("miq").innerHTML = data; // Set the inner HTML
document.getElementById('save-miq').addEventListener('click', function () {
    const selectedValues = Array.from(document.querySelectorAll('#checkbox-group input[type="checkbox"]:checked'))
        .map(checkbox => checkbox.value);

    const valuesString = selectedValues.join(',');

    fetch('saveMIQ', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ selectedValues: valuesString })
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Handle response
    })
    .catch(error => console.error('Error:', error));
});

})
.catch(error => {
    console.error('Error loading innegram content:', error);
    alert('Error loading content');
});   
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