fetch('license')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("license").innerHTML = data; // Set the inner HTML
})
//SAVING EDUCATION
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('save-license').addEventListener('click', function() {
        // Create a new FormData object
        let formData = new FormData();
        formData.append('licensename', document.getElementById('licenseInput').value);
        formData.append('startdate', document.getElementById('sdateInput').value);
        formData.append('enddate', document.getElementById('edateInput').value);
        formData.append('licenseprof', document.getElementById('profInput').value);
        
        // Append the file correctly
        let fileInput = document.getElementById('limgInput');
        if (fileInput.files.length > 0) {
            formData.append('licenseimg', fileInput.files[0]);  // Append the file object
        }

        // Send the form data to PHP using AJAX
        fetch('saveLicense', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const alertMessage = document.getElementById('license-message');

            if (data.success) {
                // Display success message
                alertMessage.className = 'alert alert-success';
                alertMessage.textContent = "Data saved successfully!";
                
                // Clear input values
                document.getElementById('licenseInput').value = '';
                document.getElementById('sdateInput').value = '';
                document.getElementById('edateInput').value = '';
                document.getElementById('profInput').value = '';
                document.getElementById('limgInput').value = '';
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
