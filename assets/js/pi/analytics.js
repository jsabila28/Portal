document.addEventListener('DOMContentLoaded', function() {
    fetch('pi_graph')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.label);
            const values = data.map(item => item.value1);
            const values2 = data.map(item => item.value2);

            const ctx = document.getElementById('lineChart').getContext('2d');
            
            try {
                const lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Realeased',
                                data: values,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Total',
                                data: values2,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } catch (e) {
                console.error(`Invalid scale configuration for scale: ${e}`);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
});
document.addEventListener('DOMContentLoaded', function() {
    fetch('pi_graph')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.label);
            const values = data.map(item => item.value3);
            const values2 = data.map(item => item.value4);

            const ctx = document.getElementById('tlChart').getContext('2d');
            
            try {
                const tlChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Realeased',
                                data: values,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Total',
                                data: values2,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } catch (e) {
                console.error(`Invalid scale configuration for scale: ${e}`);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
});
  fetch('pi_graph')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.label);
            const num1 = data.map(item => item.num1);
            const num2 = data.map(item => item.num2);

            const ctx = document.getElementById('ecCount').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Released',
                            data: num1,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            categoryPercentage: 0.5
                        },
                        {
                            label: 'Total',
                            data: num2,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        x:{
                            stacked: true,
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));