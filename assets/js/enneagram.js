fetch('innegram')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.text(); // Since we're expecting HTML
})
.then(data => {
    document.getElementById("inne").innerHTML = data;
    // Add the event listener after the content is loaded
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
})
.catch(error => {
    console.error('Error loading innegram content:', error);
    alert('Error loading content');
});

// Fetch data using AJAX
fetch('enneagram') // Replace with your API endpoint or PHP script
    .then(response => response.json())
    .then(data => {
        const labels = data.map(item => item.type);
        const scores = data.map(item => item.score);

        // Define original colors for each segment
        const originalColors = [
            '#f77d79',
            '#f7a979',
            '#f7f179',
            '#79f7a1',
            '#79f3f7',
            '#8a79f7',
            '#f779ed',
            '#f77992',
            '#798cf7'
        ];

        // Set a default color (gray) for all sections
        const defaultColor = '#d3d3d3';

        // Determine the top 3 highest scores
        const sortedIndices = scores
            .map((score, index) => ({ score, index }))
            .sort((a, b) => b.score - a.score) // Sort descending
            .map(item => item.index); // Extract indices

        const top3Indices = sortedIndices.slice(0, 3); // Get the top 3 indices

        // Assign colors: top 3 get original colors, others get gray
        const backgroundColors = scores.map((_, index) =>
            top3Indices.includes(index) ? originalColors[index] : defaultColor
        );

        // Create Polar Area Chart
        const ctx = document.getElementById('polarChart').getContext('2d');
        new Chart(ctx, {
            type: 'polarArea',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Enneagram Scores',
                    data: scores,
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors.map(color => 
                        color === defaultColor ? 'rgba(169, 169, 169, 1)' : 'rgba(0, 0, 0, 0.1)'
                    ),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false  // Hide the legend
                    },
                    datalabels: {
                        display: true,
                        align: 'end', // Position labels at the edge of the slice
                        anchor: 'end', // Ensure the label is anchored at the edge
                        color: 'black', // Label text color
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        formatter: (value, context) => {
                            return context.chart.data.labels[context.dataIndex]; // Display label at the edge
                        },
                        offset: 10, // Add space between the slice and label
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true
                    }
                },
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 20,
                        right: 20
                    }
                }
            },
            plugins: [ChartDataLabels] // Register the plugin
        });
    })
    .catch(error => console.error('Error fetching data:', error));


// Functions for modal navigation
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
