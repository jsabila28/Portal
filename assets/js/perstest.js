fetch('innegram')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("inne").innerHTML = data; // Set the inner HTML
})

fetch('disc')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("disc").innerHTML = data; // Set the inner HTML
})
fetch('color')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("color").innerHTML = data; // Set the inner HTML
})
fetch('vak')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("vak").innerHTML = data; // Set the inner HTML
})
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

document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('#save-enneagram').addEventListener('click', function () {
        const selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        const selectedValues = [];
        const qCategories = [];

        selectedCheckboxes.forEach(checkbox => {
            const qSet = checkbox.getAttribute('q_set');
            const qCategory = checkbox.getAttribute('q_category');
            selectedValues.push(`${qSet}-${qCategory}`);
            qCategories.push(qCategory);
        });

        // Combine the values into a single string
        const formattedData = selectedValues.join(',');

        // Send the data as JSON
        fetch('saveEnneagram', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                qCategories: qCategories,
                data: formattedData,
            }),
        })
            .then(response => response.json())
            .then(result => {
                console.log('Response:', result);
                if (result.status === 'success') {
                    alert(result.message);
                    window.location.reload();
                } else {
                    alert(result.message || 'Error saving data');
                }
            })
            .catch(error => {
                console.error('Error saving data:', error);
                alert('An unexpected error occurred');
            });
    });

});
