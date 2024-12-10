// Fetch and display employment data
fetch('emps')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.text(); // Expecting HTML
    })
    .then(data => {
        const employContainer = document.getElementById("employ");
        if (employContainer) {
            employContainer.innerHTML = data; // Set the inner HTML
        } else {
            console.error('Element with id "employ" not found.');
        }
    })
    .catch(error => console.error('Error fetching employment data:', error));

document.addEventListener('DOMContentLoaded', function () {
    // Use event delegation for dynamic elements
    document.body.addEventListener('click', function (event) {
        if (event.target && event.target.id === 'save-empl') {
            // Create a new FormData object
            const formData = new FormData();
            formData.append('company', document.getElementById('companyInput')?.value || '');
            formData.append('address', document.getElementById('addressInput')?.value || '');
            formData.append('position', document.getElementById('positionInput')?.value || '');
            formData.append('supervisor', document.getElementById('visorInput')?.value || '');
            formData.append('contact', document.getElementById('contInput')?.value || '');
            formData.append('sdate', document.getElementById('sdateInput')?.value || '');
            formData.append('edate', document.getElementById('edateInput')?.value || '');
            formData.append('reason', document.getElementById('reasonInput')?.value || '');

            // Send the form data to PHP using AJAX
            fetch('saveEmplo', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    const alertMessage = document.getElementById('empl-message');
                    if (alertMessage) {
                        if (data.success) {
                            // Display success message
                            alertMessage.className = 'alert alert-success';
                            alertMessage.textContent = "Data saved successfully!";

                            // Clear input values
                            document.getElementById('companyInput').value = '';
                            document.getElementById('addressInput').value = '';
                            document.getElementById('positionInput').value = '';
                            document.getElementById('visorInput').value = '';
                            document.getElementById('contInput').value = '';
                            document.getElementById('sdateInput').value = '';
                            document.getElementById('edateInput').value = '';
                            document.getElementById('reasonInput').value = '';
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
                        console.error('Element with id "empl-message" not found.');
                    }
                })
                .catch(error => console.error('Error saving employment data:', error));
        }
    });
});
