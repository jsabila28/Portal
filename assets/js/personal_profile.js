fetch('personal')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.text(); // Since we're expecting HTML
    })
    .then(data => {
        document.getElementById("personal").innerHTML = data; // Set the inner HTML
    })
    .catch(error => console.error('Error fetching data:', error));

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
            sex:  $('[name="sex"]').val(),
            religion: $('[name="religion"]').val(),
            height: $('[name="height"]').val(),
            weight: $('[name="weight"]').val(),
            bloodtype: $('[name="bloodtype"]').val(),
            dialect: $('[name="dialect"]').val()
        };

        $.ajax({
            url: 'save_personal',
            type: 'POST',
            data: personalData,
            success: function(response) {
                alert('Data saved successfully!');
                $('#Personal-' + personalData.pers_id).modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    });
});

