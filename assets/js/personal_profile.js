fetch('personal')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("profile").innerHTML = data; // Set the inner HTML
})
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('save-personal').addEventListener('click', function () {
        // Create a new FormData object
        let formData = new FormData();

        // Collecting all other input values as before
        formData.append('lastname', document.getElementById('lastnameInput').value);
        formData.append('firstname', document.getElementById('firstnameInput').value);
        formData.append('midname', document.getElementById('midnameInput').value);
        formData.append('maidenname', document.getElementById('maidnameInput').value);
        formData.append('suffix', document.getElementById('suffixInput').value);
        formData.append('person_num', document.getElementById('persnumInput').value);
        formData.append('company_num', document.getElementById('compnameInput').value);
        formData.append('email', document.getElementById('emailInput').value);
        formData.append('telephone', document.getElementById('telphInput').value);
        formData.append('sss', document.getElementById('sssInput').value);
        formData.append('pagibig', document.getElementById('pagibigInput').value);
        formData.append('philhealth', document.getElementById('philInput').value);
        formData.append('tin', document.getElementById('tinInput').value);
        formData.append('Pprovince', document.getElementById('province-perm1').value);
        formData.append('Pmunicipal', document.getElementById('municipal-perm1').value);
        formData.append('Pbrngy', document.getElementById('brngy-perm1').value);
        formData.append('Cprovince', document.getElementById('province-cur1').value);
        formData.append('Cmunicipal', document.getElementById('municipal-cur1').value);
        formData.append('Cbrngy', document.getElementById('brngy-cur1').value);
        formData.append('Bprovince', document.getElementById('province-birth1').value);
        formData.append('Bmunicipal', document.getElementById('municipal-birth1').value);
        formData.append('Bbrngy', document.getElementById('brngy-birth1').value);
        formData.append('birthdate', document.getElementById('birthdayInput').value);
        formData.append('civilstat', document.getElementById('civilInput').value);
        formData.append('religion', document.getElementById('religInput').value);
        formData.append('height', document.getElementById('heightInput').value);
        formData.append('weight', document.getElementById('weightInput').value);
        formData.append('bloodtype', document.getElementById('bloodInput').value);
        formData.append('dialect', document.getElementById('dialectInput').value);

        // Handling the 'sex' radio buttons
        let sexValue = document.querySelector('input[name="sex"]:checked');
        if (sexValue) {
            formData.append('sex', sexValue.value);
        } else {
            formData.append('sex', ''); // Append an empty value if no radio is selected
        }

        // Send the form data to PHP using AJAX
        fetch('save_personal', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                const alertMessage = document.getElementById('skill-message');

                if (data.success) {
                    // Display success message
                    alertMessage.className = 'alert alert-success';
                    alertMessage.textContent = "Data saved successfully!";

                    // Clear all input values
                    // document.getElementById('lastnameInput').value = '';
                    // document.getElementById('firstnameInput').value = '';
                    // document.getElementById('midnameInput').value = '';
                    // document.getElementById('maidnameInput').value = '';
                    // document.getElementById('suffixInput').value = '';
                    // document.getElementById('persnumInput').value = '';
                    // document.getElementById('compnameInput').value = '';
                    // document.getElementById('emailInput').value = '';
                    // document.getElementById('telphInput').value = '';
                    // document.getElementById('sssInput').value = '';
                    // document.getElementById('pagibigInput').value = '';
                    // document.getElementById('philInput').value = '';
                    // document.getElementById('tinInput').value = '';
                    // document.getElementById('province-perm1').value = '';
                    // document.getElementById('municipal-perm1').value = '';
                    // document.getElementById('brngy-perm1').value = '';
                    // document.getElementById('province-cur1').value = '';
                    // document.getElementById('municipal-cur1').value = '';
                    // document.getElementById('brngy-cur1').value = '';
                    // document.getElementById('province-birth1').value = '';
                    // document.getElementById('municipal-birth1').value = '';
                    // document.getElementById('brngy-birth1').value = '';
                    // document.getElementById('birthdayInput').value = '';
                    // document.getElementById('civilInput').value = '';
                    // document.getElementById('gender').value = '';
                    // document.getElementById('religInput').value = '';
                    // document.getElementById('heightInput').value = '';
                    // document.getElementById('weightInput').value = '';
                    // document.getElementById('bloodInput').value = '';
                    // document.getElementById('dialectInput').value = '';
                    // document.querySelectorAll('input[name="sex"]').forEach(radio => radio.checked = false);

                } else {
                    // Display error message
                    alertMessage.className = 'alert alert-danger';
                    alertMessage.textContent = "Error saving data: " + data.error;
                }

                // Show the alert message
                alertMessage.style.display = 'block';

                // Hide the alert message after 3 seconds
                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 3000);
            })
            .catch(error => console.error('Error:', error));
    });
});
