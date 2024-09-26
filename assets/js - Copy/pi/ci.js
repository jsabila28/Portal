function fetchsecondPIData() {
    var month = document.getElementById('pi-month').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                updatesecondPiTable(data);
            } else {
                console.error('Failed to fetch data:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'pici?month=' + month, true); //php to get data
    xhr.send();
}


function updatesecondPiTable(data) {
    let secondtotalPiTableheader = document.getElementById('secondtotalPiTableheader');
    let secondtotalPiTablebody = document.getElementById('secondtotalPiTablebody');
    secondtotalPiTableheader.innerHTML = '';
    secondtotalPiTablebody.innerHTML = ''; // Clear existing data
    // console.log(data);

    let h_row1 = document.createElement('tr');
    let h_row2 = document.createElement('tr');
    let row1 = document.createElement('tr');
    let row2 = document.createElement('tr');
    let row3 = document.createElement('tr');
    let row4 = document.createElement('tr');



    h_row1.innerHTML += "<th></th>";
    h_row2.innerHTML += "<th></th>";
    row1.innerHTML += "<td>Regular Sales </td>";
    row2.innerHTML += "<td>LAP: Downpayment </td>";
    row3.innerHTML += "<td>LAP: Follow-up payment </td>";
    row4.innerHTML += "<td>LAP: Final payment </td>";


    for(x in data) {

        h_row1.innerHTML += "<th colspan='" + data[x]['item'].length + "'>" + x + "</th>";

        for(y in data[x]['item']) {
            let outlet = document.createElement('th');
            outlet.textContent = data[x]['item'][y].tpi_outlet;
            outlet.style.textAlign = 'center';
            h_row2.appendChild(outlet);

            let regsale = document.createElement('td');
            regsale.textContent = data[x]['item'][y].tpi_reg_sale;
            regsale.style.textAlign = 'right';
            row1.appendChild(regsale);

            let lapdp = document.createElement('td');
            lapdp.textContent = data[x]['item'][y].tpi_lap_dp;
            lapdp.style.textAlign = 'right';
            row2.appendChild(lapdp);

            let lapfup = document.createElement('td');
            lapfup.textContent = data[x]['item'][y].tpi_lap_fup;
            lapfup.style.textAlign = 'right';
            row3.appendChild(lapfup);

            let lapfp = document.createElement('td');
            lapfp.textContent = data[x]['item'][y].tpi_lap_fp;
            lapfp.style.textAlign = 'right';
            row4.appendChild(lapfp);

        }
    } 

    totalPiTableheader.appendChild(h_row1);
    totalPiTableheader.appendChild(h_row2);
    totalPiTablebody.appendChild(row1);
    totalPiTablebody.appendChild(row2);
    totalPiTablebody.appendChild(row3);
    totalPiTablebody.appendChild(row4);
}


$(function(){
    fetchsecondPIData();
});


// setInterval(fetchsecondPIData, 5000); 