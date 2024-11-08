// Fetch request for loading personal information
fetch('personal')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.text(); // Since we're expecting HTML
    })
    .then(data => {
        document.getElementById("personal").innerHTML = data; // Set the inner HTML
        showNotification('success', 'Personal information loaded successfully.');
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        showNotification('danger', 'Failed to load personal information.');
    });

// Document ready for the modal save button click event
$(document).ready(function() {
    $('#save-personal').click(function() {
        // Collect data from the modal inputs
        var personalData = {
            pers_id: $('[name="pers_id"]').val(),
            lastname: $('[name="lastname"]').val(),
            midname: $('[name="midname"]').val(),
            firstname: $('[name="firstname"]').val(),
            maidenname: $('[name="maidenname"]').val(),
            person_num: $('[name="person_num"]').val(),
            company_num: $('[name="company_num"]').val(),
            email: $('[name="email"]').val(),
            telephone: $('[name="telephone"]').val(),
            sss: $('[name="sss"]').val(),
            pagibig: $('[name="pagibig"]').val(),
            philhealth: $('[name="philhealth"]').val(),
            tin: $('[name="tin"]').val(),
            Pprovince: $('[name="Pprovince"]').val(),
            Pmunicipal: $('[name="Pmunicipal"]').val(),
            Pbrngy: $('[name="Pbrngy"]').val(),
            Cprovince: $('[name="Cprovince"]').val(),
            Cmunicipal: $('[name="Cmunicipal"]').val(),
            Cbrngy: $('[name="Cbrngy"]').val(),
            Bprovince: $('[name="Bprovince"]').val(),
            Bmunicipal: $('[name="Bmunicipal"]').val(),
            Bbrngy: $('[name="Bbrngy"]').val(),
            birthdate: $('[name="birthdate"]').val(),
            civilstat: $('[name="civilstat"]').val(),
            sex: $('input[name="sex"]:checked').val(),
            religion: $('[name="religion"]').val(),
            height: $('[name="height"]').val(),
            weight: $('[name="weight"]').val(),
            bloodtype: $('[name="bloodtype"]').val(),
            dialect: $('[name="dialect"]').val()
        };

        // AJAX request to save personal data
        $.ajax({
            url: 'save_personal',
            type: 'POST',
            data: personalData,
            success: function(response) {
                console.log(response);  // Debug the server's response
                if (response.success) {
                    showNotification('success', 'Data saved successfully!');
                } else {
                    showNotification('danger', response.error || 'Failed to save data.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
                showNotification('danger', 'Error saving data. Please try again.');
            }
        });
    });
});

// Notification function for feedback messages
function showNotification(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;

    // Display the message in both responseMessage and itemMessage elements
    $('#PersonalMessage').html(alertHtml);

    // Auto-fade notification after 3 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 3000);
}
