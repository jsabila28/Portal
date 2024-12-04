fetch('characters')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("char").innerHTML = data; // Set the inner HTML
})

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('save-charac').addEventListener('click', function() {
        // Create a new FormData object
        let formData = new FormData();
        formData.append('reflname', document.getElementById('reflnameInput').value);
        formData.append('reffname', document.getElementById('reffnameInput').value);
        formData.append('refmname', document.getElementById('refmnameInput').value);
        formData.append('position', document.getElementById('positionInput').value);
        formData.append('refcompany', document.getElementById('refcompanyInput').value);
        formData.append('refcompadd', document.getElementById('refcompaddInput').value);
        formData.append('refcontact', document.getElementById('refcontactInput').value);

        // Send the form data to PHP using AJAX
        fetch('saveRef', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const alertMessage = document.getElementById('charac-message');

            if (data.success) {
                // Display success message
                alertMessage.className = 'alert alert-success';
                alertMessage.textContent = "Data saved successfully!";
                
                // Clear input values
                document.getElementById('reflnameInput').value = '';
                document.getElementById('reffnameInput').value = '';
                document.getElementById('refmnameInput').value = '';
                document.getElementById('positionInput').value = '';
                document.getElementById('refcompanyInput').value = '';
                document.getElementById('refcompaddInput').value = '';
                document.getElementById('refcontactInput').value = '';
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
