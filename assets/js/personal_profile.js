document.addEventListener('DOMContentLoaded', function () {
    // Fetch and display personal data
    fetch('personal')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.text(); // Expecting HTML
        })
        .then(data => {
            const educContainer = document.getElementById("profile");
            if (educContainer) {
                educContainer.innerHTML = data; // Set the inner HTML
            } else {
                console.error('Element with id "personal" not found.');
            }
        })
        .catch(error => console.error('Error fetching personal data:', error));

    // Use event delegation for dynamic elements
    document.body.addEventListener('click', function (event) {
        if (event.target && event.target.id === 'save-personal') {
            // Create a new FormData object
            const formData = new FormData();
            formData.append('lastname', document.getElementById('lastnameInput')?.value || '');
            formData.append('firstname', document.getElementById('firstnameInput')?.value || '');
            formData.append('midname', document.getElementById('midnameInput')?.value || '');
            formData.append('maidenname', document.getElementById('maidnameInput')?.value || '');
            formData.append('suffix', document.getElementById('suffixInput')?.value || '');
            formData.append('person_num', document.getElementById('persnumInput')?.value || '');
            formData.append('company_num', document.getElementById('compnameInput')?.value || '');
            formData.append('email', document.getElementById('emailInput')?.value || '');
            formData.append('telephone', document.getElementById('telphInput')?.value || '');
            formData.append('sss', document.getElementById('sssInput')?.value || '');
            formData.append('pagibig', document.getElementById('pagibigInput')?.value || '');
            formData.append('philhealth', document.getElementById('philInput')?.value || '');
            formData.append('tin', document.getElementById('tinInput')?.value || '');
            formData.append('Pprovince', document.getElementById('province-perm1')?.value || '');
            formData.append('Pmunicipal', document.getElementById('municipal-perm1')?.value || '');
            formData.append('Pbrngy', document.getElementById('brngy-perm1')?.value || '');
            formData.append('Cprovince', document.getElementById('province-cur1')?.value || '');
            formData.append('Cmunicipal', document.getElementById('municipal-cur1')?.value || '');
            formData.append('Cbrngy', document.getElementById('brngy-cur1')?.value || '');
            formData.append('Bprovince', document.getElementById('province-birth1')?.value || '');
            formData.append('Bmunicipal', document.getElementById('municipal-birth1')?.value || '');
            formData.append('Bbrngy', document.getElementById('brngy-birth1')?.value || '');
            formData.append('birthdate', document.getElementById('birthdayInput')?.value || '');
            formData.append('civilstat', document.getElementById('civilInput')?.value || '');
            formData.append('religion', document.getElementById('religInput')?.value || '');
            formData.append('height', document.getElementById('heightInput')?.value || '');
            formData.append('weight', document.getElementById('weightInput')?.value || '');
            formData.append('bloodtype', document.getElementById('bloodInput')?.value || '');
            formData.append('dialect', document.getElementById('dialectInput')?.value || '');


            // Send the form data to PHP using AJAX
            fetch('save_personal', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    const alertMessage = document.getElementById('personal-message');
                    if (alertMessage) {
                        if (data.success) {
                            // Display success message
                            alertMessage.className = 'alert alert-success';
                            alertMessage.textContent = "Data saved successfully!";
                        } else {
                            // Display error message
                            alertMessage.className = 'alert alert-danger';
                            alertMessage.textContent = "Error saving data: " + (data.error || 'Unknown error.');
                        }

                        // Show the alert message
                        alertMessage.style.display = 'block';

                        // Hide the alert message after 3 seconds
                        setTimeout(() => {
                            alertMessage.style.display = 'none';
                        }, 3000);
                    } else {
                        console.error('Element with id "educ-message" not found.');
                    }
                })
                .catch(error => console.error('Error saving education data:', error));
        }
    });
});
