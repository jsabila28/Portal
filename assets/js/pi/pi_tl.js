function fetchTLData() {
    var month = document.getElementById('pi-month').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                updateTLPIdata(data, month); // Pass month to the function
            } else {
                console.error('Failed to fetch data:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'tlpi?month=' + month, true); // PHP to get data
    xhr.send();
}

// Function to update the table with fetched data
function updateTLPIdata(data, month) {
    let tlTablebody = document.getElementById('tlPiTablebody');
    tlTablebody.innerHTML = ''; // Clear existing data

    let totalGrandTotal = 0;

    data.forEach(function(item) {
        let row = document.createElement('tr');

        // Create the checkbox column
        let checkboxTd = document.createElement('td');
        let checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.checked = item.tl_dist_status === '1'; // Check the checkbox if status is 1

        checkbox.addEventListener('change', function() {
            let newStatus = this.checked ? 1 : 0;
            updateStatus(item.id, newStatus);
        });

        checkboxTd.appendChild(checkbox);
        row.appendChild(checkboxTd);

        let tl = document.createElement('td');
        tl.textContent = item.tl_name;
        row.appendChild(tl);

        let status = document.createElement('td');
        status.textContent = "TL";
        status.style.textAlign = 'center';
        row.appendChild(status);

        let tl_name = item.tl_name;
        
        let actual = document.createElement('td');
        actual.textContent = item.tl_tc;
        actual.style.textAlign = 'center';
        row.appendChild(actual);

        let tctarget = document.createElement('td');
        tctarget.textContent = item.tl_tc_target;
        tctarget.style.textAlign = 'center';
        row.appendChild(tctarget);

        let tc_att = document.createElement('td');
        tc_att.textContent = item.tl_tc_attain + '%';
        tc_att.style.textAlign = 'center';
        row.appendChild(tc_att);

        let actualcoll = document.createElement('td');
        actualcoll.textContent = item.tl_coll;
        actualcoll.style.textAlign = 'right';
        row.appendChild(actualcoll);

        let colltarget = document.createElement('td');
        colltarget.textContent = item.tl_coll_target;
        colltarget.style.textAlign = 'right';
        row.appendChild(colltarget);

        let coll_att = document.createElement('td');
        coll_att.textContent = item.tl_coll_attain + '%';
        coll_att.style.textAlign = 'center';
        row.appendChild(coll_att);

        let actCollRate = document.createElement('td');
        actCollRate.textContent = item.tl_cr_act + '%';
        actCollRate.style.textAlign = 'center';
        row.appendChild(actCollRate);

        let targetCollRate = document.createElement('td');
        targetCollRate.textContent = '90%';
        targetCollRate.style.textAlign = 'center';
        row.appendChild(targetCollRate);

        let collRateAtt = document.createElement('td');
        collRateAtt.textContent = item.tl_cr_attain + '%';
        collRateAtt.style.textAlign = 'center';
        row.appendChild(collRateAtt);

        let tcTd = document.createElement('td');
        tcTd.textContent = item.tl_tc_pi;
        tcTd.style.textAlign = 'center';
        tcTd.style.borderLeft = '2px solid black';
        row.appendChild(tcTd);

        let colltd = document.createElement('td');
        colltd.textContent = item.tl_coll_pi;
        colltd.style.textAlign = 'center';
        row.appendChild(colltd);

        let crtd = document.createElement('td');
        crtd.textContent = item.tl_cr_pi;
        crtd.style.textAlign = 'center';
        row.appendChild(crtd);

        let tl_tc_pi_raw = item.tl_tc_pi;
        let tl_coll_pi_raw = item.tl_coll_pi;
        let tl_cr_pi_raw = item.tl_cr_pi;

        let tl_tc_pi = parseFloat(tl_tc_pi_raw.replace(/,/g, ''));
        let tl_coll_pi = parseFloat(tl_coll_pi_raw.replace(/,/g, ''));
        let tl_cr_pi = parseFloat(tl_cr_pi_raw.replace(/,/g, ''));

        let total = tl_tc_pi + tl_coll_pi + tl_cr_pi;

        let totalTd = document.createElement('td');
        totalTd.textContent = total.toLocaleString('en-US');
        totalTd.style.textAlign = 'center';
        row.appendChild(totalTd);

        let qualifier = document.createElement('td');
        qualifier.textContent = item.tl_add_inc;
        qualifier.style.textAlign = 'center';
        row.appendChild(qualifier);

        let tl_add_inc_raw = item.tl_add_inc;
        let tl_add_inc = parseFloat(tl_add_inc_raw.replace(/,/g, ''));

        let totalValue = total + tl_add_inc;

        let ar = document.createElement('td');
        let input = document.createElement('input');
        input.value = item.tl_retro_pi || '0';
        input.style.textAlign = 'right';
        input.style.width = '50px';
        input.id = 'retro_' + item.id;
        input.setAttribute('data-toggle', 'modal');
        input.setAttribute('data-target', '#TLincentive' + item.id);
        input.setAttribute('data-previous-value', input.value);

        input.addEventListener('change', function() {
            let inputValue = parseFloat(this.value) || 0;
            let previousValue = parseFloat(this.getAttribute('data-previous-value')) || 0;
            totalGrandTotal = totalGrandTotal - previousValue + inputValue;
            this.setAttribute('data-previous-value', this.value);
            grandTotal.textContent = (totalValue + inputValue).toLocaleString('en-US');
            updateTotalSum(totalGrandTotal);
        });

        ar.appendChild(input);
        row.appendChild(ar);

        let grandTotal = document.createElement('td');
        grandTotal.textContent = (totalValue + parseFloat(input.value)).toLocaleString('en-US');
        grandTotal.style.textAlign = 'center';
        grandTotal.style.borderRight = '2px solid black';
        row.appendChild(grandTotal);

        tlTablebody.appendChild(row);

        totalGrandTotal += totalValue + parseFloat(input.value);
    });

    let additionalRow = document.createElement('tr');
    for (let i = 0; i < 12; i++) {  // Adjusted the loop to account for the new checkbox column
        let emptyTd = document.createElement('td');
        additionalRow.appendChild(emptyTd);
    }
    let emptyTd = document.createElement('td');
    emptyTd.style.borderBottom = '2px solid black';
    emptyTd.style.borderLeft = '2px solid black';
    additionalRow.appendChild(emptyTd);
    for (let i = 0; i < 4; i++) {
        let emptyTd = document.createElement('td');
        emptyTd.style.borderBottom = '2px solid black';
        additionalRow.appendChild(emptyTd);
    }
    let total = document.createElement('td');
    total.style.textAlign = 'center';
    total.textContent = 'Total';
    total.style.fontWeight = 'bold';
    total.style.borderBottom = '2px solid black';
    additionalRow.appendChild(total);

    let totalSumCell = document.createElement('td');
    totalSumCell.id = 'totalSumCell';
    totalSumCell.textContent = totalGrandTotal.toLocaleString('en-US');
    totalSumCell.style.textAlign = 'center';
    totalSumCell.style.fontWeight = 'bold';
    totalSumCell.style.borderBottom = '2px solid black';
    totalSumCell.style.borderRight = '2px solid black';
    additionalRow.appendChild(totalSumCell);

    tlTablebody.appendChild(additionalRow);
}

function updateTotalSum(totalSum) {
    document.getElementById('totalSumCell').textContent = totalSum.toLocaleString('en-US');
}


function updateStatus(id, newStatus) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'tl_release', true); // PHP endpoint to update status
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        console.error('Error:', response.error);
                    } else {
                        console.log(response.success);
                    }
                } catch (e) {
                    console.error('Invalid JSON response:', e);
                }
            } else {
                console.error('Failed to update status:', xhr.status);
            }
        }
    };
    xhr.send('id=' + encodeURIComponent(id) + '&tl_dist_status=' + encodeURIComponent(newStatus));
}

$(function() {
    fetchTLData();
});
