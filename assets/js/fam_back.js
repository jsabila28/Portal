$(document).ready(function () {
    $('#save-personal').on('click', function () {
        var lastname = $('#lastname').val();
        var midname = $('#midname').val();
        var firstname = $('#firstname').val();
        var maidenname = $('#maidenname').val();
        var relationship = $('#relationship').val();
        var person_num = $('#person_num').val();
        var birthdate = $('#birthdate').val();
        var occupation = $('#occupation').val();
        var sex = $('input[name="sex"]:checked').val(); // get selected radio button value

        // AJAX request
        $.ajax({
            url: 'Bfamily',  // PHP file that will handle the request
            type: 'POST',
            data: {
                lastname: lastname,
                midname: midname,
                firstname: firstname,
                maidenname: maidenname,
                relationship: relationship,
                person_num: person_num,
                birthdate: birthdate,
                occupation: occupation,
                sex: sex
            },
            success: function (response) {
                // Display success message
                $('#alert-message').removeClass('alert-danger').addClass('alert-success').text(response).show();
                
                // Reset form fields
                $('#lastname').val('');
                $('#midname').val('');
                $('#firstname').val('');
                $('#maidenname').val('');
                $('#relationship').val('Select Relation');
                $('#person_num').val('');
                $('#birthdate').val('');
                $('#occupation').val('');
                $('input[name="sex"]').prop('checked', false); // uncheck radio buttons
                
                // Hide the modal after 2 seconds
                setTimeout(function () {
                    $('#alert-message').hide();  // Hide the alert message
                }, 2000);
            },
            error: function (xhr, status, error) {
                // Display error message
                $('#alert-message').removeClass('alert-success').addClass('alert-danger').text("An error occurred. Please try again.").show();
            }
        });
    });
});
