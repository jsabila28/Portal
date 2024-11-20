fetch('educ')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("educ").innerHTML = data; // Set the inner HTML
})
//SAVING EDUCATION
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('save-education').addEventListener('click', function() {
        // Create a new FormData object
        let formData = new FormData();
        formData.append('levelSchool', document.getElementById('SchLevel').value);
        formData.append('Degree', document.getElementById('degreeInput').value);
        formData.append('Major', document.getElementById('majorInput').value);
        formData.append('School', document.getElementById('schoolInput').value);
        formData.append('SchoolAdd', document.getElementById('addressInput').value);
        formData.append('DateGrad', document.getElementById('dateInput').value);
        formData.append('Status', document.getElementById('statusInput').value);

        // Send the form data to PHP using AJAX
        fetch('saveEduc', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const alertMessage = document.getElementById('educ-message');

            if (data.success) {
                // Display success message
                alertMessage.className = 'alert alert-success';
                alertMessage.textContent = "Data saved successfully!";
                
                // Clear input values
                document.getElementById('SchLevel').value = '';
                document.getElementById('degreeInput').value = '';
                document.getElementById('majorInput').value = '';
                document.getElementById('schoolInput').value = '';
                document.getElementById('addressInput').value = '';
                document.getElementById('dateInput').value = '';
                document.getElementById('statusInput').value = '';
                // document.getElementById('othersInput').style.display = 'none';
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
