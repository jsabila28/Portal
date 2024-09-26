function fetchCCardData() {
    var month = document.getElementById('pi-month').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                updateTable(data);
            } else {
                console.error('Failed to fetch data:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'ccardjs?month=' + month, true); // PHP endpoint to get data
    xhr.send();
}

function updateTable(data) {
    var tableBody = document.getElementById('classData');
    tableBody.innerHTML = '';

    var totalAmount = data.reduce((sum, item) => sum + parseAmount(item.ccard_amount), 0);

    data.forEach(function(item) {
        var row = document.createElement('tr');

        var outlet = document.createElement('td');
        outlet.style.textAlign = 'center';
        outlet.textContent = item.ccard_outlet;
        row.appendChild(outlet);

        var amount = document.createElement('td');
        amount.style.textAlign = 'right';
        amount.textContent = item.ccard_amount;
        row.appendChild(amount);

        tableBody.appendChild(row);
    });

    var additionalRow = document.createElement('tr');

    var total = document.createElement('td');
    total.style.textAlign = 'center';
    total.textContent = 'Total';
    total.style.fontWeight = 'bold';
    additionalRow.appendChild(total);

    var additionalAmount = document.createElement('td');
    additionalAmount.style.textAlign = 'right';
    additionalAmount.textContent = formatAmount(totalAmount);
    additionalAmount.style.fontWeight = 'bold';
    additionalRow.appendChild(additionalAmount);

    tableBody.appendChild(additionalRow);
}

function parseAmount(amount) {
    // Remove any commas and parse the float value
    return parseFloat(amount.replace(/,/g, '')) || 0;
}

function formatAmount(amount) {
    // Format the number as a string with commas
    return parseFloat(amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// $(function(){
//     fetchCCardData();
// });

function fetchCCardDataAndUpdate() {
    fetchCCardData();
}

$(function(){
    // Initially fetch the data
    fetchCCardDataAndUpdate();
    
    // Fetch data again when the page regains focus
    $(window).on('focus', fetchCCardDataAndUpdate);
});

// Uncomment this line to fetch data every 5 seconds
// setInterval(fetchCCardData, 5000);
