function fetchPIData() {
    var month = document.getElementById('pi-month').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                updatePiTable(data, month);
            } else {
                console.error('Failed to fetch data:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'totalpijs?month=' + month, true); //php to get data
    xhr.send();
}

function updatePiTable(data, month) {
    let totalPiTableheader = document.getElementById('totalPiTableheader');
    let totalPiTablebody = document.getElementById('totalPiTablebody');
    totalPiTableheader.innerHTML = '';
    totalPiTablebody.innerHTML = ''; // Clear existing data

    let h_row1 = document.createElement('tr');
    let h_row2 = document.createElement('tr');
    let row1 = document.createElement('tr');
    let row2 = document.createElement('tr');
    let row3 = document.createElement('tr');
    let row4 = document.createElement('tr');
    let row5 = document.createElement('tr');
    let row6 = document.createElement('tr');
    let row7 = document.createElement('tr');
    let row8 = document.createElement('tr');
    let row9 = document.createElement('tr');
    let row10 = document.createElement('tr');
    let row11 = document.createElement('tr');
    let row12 = document.createElement('tr');
    let row13 = document.createElement('tr');
    let row14 = document.createElement('tr');
    let row15 = document.createElement('tr');
    let row16 = document.createElement('tr');
    let row17 = document.createElement('tr');
    let row18 = document.createElement('tr');
    let row19 = document.createElement('tr');
    let row20 = document.createElement('tr');
    let row21 = document.createElement('tr');
    let row22 = document.createElement('tr');
    let rowAI1 = document.createElement('tr');
    let rowAI2 = document.createElement('tr');

    let r = document.createElement('tr');


    h_row1.innerHTML += "<th></th>";
    h_row2.innerHTML += "<th></th>";
    row1.innerHTML += "<td>Regular Sales </td>";
    row2.innerHTML += "<td>LAP: Downpayment </td>";
    row3.innerHTML += "<td>LAP: Follow-up payment </td>";
    row4.innerHTML += "<td>LAP: Final payment </td>";
    row5.innerHTML += "<td>MTO: Downpayment </td>";
    row6.innerHTML += "<td>MTO: Follow-up payment </td>";
    row7.innerHTML += "<td>MTO: Final payment </td>";
    row8.innerHTML += "<td>Other Services & Platero </td>";
    row9.innerHTML += "<td>Total Collections per DSR </td>";
    row10.innerHTML += "<td>Applied Refund  </td>";
    row11.innerHTML += "<td>Credit Card Fees (actual bank charges)  </td>";
    row12.innerHTML += "<td>Actual Cash Collection </td>";
    row13.innerHTML += "<td style='color: green;'>Regular Incentive Rate 0.75%</td>";
    row14.innerHTML += "<td>Total Productivity Incentive </td>";
    row15.innerHTML += "<td style='color: red;'>Divided by # of pax </td>";
    row16.innerHTML += "<td><b>PI per pax </b></td>";

    rowAI1.innerHTML += "<td><b>TC Attainment </b></td>";
    rowAI2.innerHTML += "<td><b>Collection Attainment </b></td>";
    // FOR ADDING 0.25%
    row17.innerHTML += `<td><b><input type='checkbox' id='additional' onchange='toggleAdditionalRows()'> Add (0.25%) </b></td>`;
    row18.innerHTML += "<td>Actual Cash Collection </td>";
    row19.innerHTML += "<td style='color: green;'>Additional Incentive Rate (0.25%) </td>";
    row20.innerHTML += "<td>Total Productivity Incentive </td>";
    row21.innerHTML += "<td style='color: red;'>Divided by # of pax </td>";
    row22.innerHTML += "<td><b>PI per pax </b></td>";
    r.innerHTML += "<td></td>";

    h_row2.id = 'h_row2';
    row18.id = 'row18';
    row19.id = 'row19';
    row20.id = 'row20';
    row21.id = 'row21';
    row22.id = 'row22';

    let checkForMonth = false;

    for (let x in data) {
        if (data[x] && data[x]['item'] && data[x]['item'].length) {
            h_row1.innerHTML += "<th colspan='" + data[x]['item'].length + "'>" + x + "</th>";

            for (let y in data[x]['item']) {

                let dates = document.createElement('th');
                dates.textContent = data[x]['item'][y].ci_date;
                r.appendChild(dates);


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

                let mtodp = document.createElement('td');
                mtodp.textContent = data[x]['item'][y].tpi_mto_dp;
                mtodp.style.textAlign = 'right';
                row5.appendChild(mtodp);

                let mtofup = document.createElement('td');
                mtofup.textContent = data[x]['item'][y].tpi_mto_fup;
                mtofup.style.textAlign = 'right';
                row6.appendChild(mtofup);

                let mtofp = document.createElement('td');
                mtofp.textContent = data[x]['item'][y].tpi_mto_fp;
                mtofp.style.textAlign = 'right';
                row7.appendChild(mtofp);

                let platero = document.createElement('td');
                platero.textContent = data[x]['item'][y].tpi_plat;
                platero.style.textAlign = 'right';
                row8.appendChild(platero);

                let sales_raw = data[x]['item'][y].tpi_reg_sale;
                let lap_dp_raw = data[x]['item'][y].tpi_lap_dp;
                let lap_fup_raw = data[x]['item'][y].tpi_lap_fup;
                let lap_fp_raw = data[x]['item'][y].tpi_lap_fp;
                let co_dp_raw = data[x]['item'][y].tpi_mto_dp;
                let co_fup_raw = data[x]['item'][y].tpi_mto_fup;
                let co_fp_raw = data[x]['item'][y].tpi_mto_fp;

                let tpi_reg_sale = parseFloat(sales_raw.replace(/,/g, ''));
                let tpi_lap_dp = parseFloat(lap_dp_raw.replace(/,/g, ''));
                let tpi_lap_fup = parseFloat(lap_fup_raw.replace(/,/g, ''));
                let tpi_lap_fp = parseFloat(lap_fp_raw.replace(/,/g, ''));
                let tpi_mto_dp = parseFloat(co_dp_raw.replace(/,/g, ''));
                let tpi_mto_fup = parseFloat(co_fup_raw.replace(/,/g, ''));
                let tpi_mto_fp = parseFloat(co_fp_raw.replace(/,/g, ''));
                let sum = tpi_reg_sale + tpi_lap_dp + tpi_lap_fup + tpi_lap_fp + tpi_mto_dp + tpi_mto_fup + tpi_mto_fp;

                let actualColl = document.createElement('td');
                actualColl.textContent = sum.toLocaleString('en-US');
                actualColl.style.textAlign = 'right';
                row9.appendChild(actualColl);

                let refund = document.createElement('td');
                refund.textContent = data[x]['item'][y].tpi_refund;
                refund.style.textAlign = 'right';
                row10.appendChild(refund);

                let ccard = document.createElement('td');
                ccard.textContent = data[x]['item'][y].tpi_ccard;
                ccard.style.textAlign = 'right';
                row11.appendChild(ccard);

                let refund_raw = data[x]['item'][y].tpi_refund;
                let ccard_raw = data[x]['item'][y].tpi_ccard;
                let refunds = parseFloat(refund_raw.replace(/,/g, ''));
                let ccards = parseFloat(ccard_raw.replace(/,/g, ''));
                let total = refunds + ccards;
                let totalcol = sum -= total;

                let totalColl = document.createElement('td');
                totalColl.textContent = totalcol.toLocaleString('en-US');
                totalColl.style.textAlign = 'right';
                row12.appendChild(totalColl);

                let totalpi = (totalcol * 0.75) / 100;
                let roundedTotalPi = parseFloat(totalpi.toFixed(2));
                let totalPI = document.createElement('td');
                totalPI.textContent = roundedTotalPi.toLocaleString('en-US');
                totalPI.style.textAlign = 'right';
                totalPI.style.fontWeight = 'bold';
                row14.appendChild(totalPI);

                let pax = document.createElement('td');
                pax.textContent = data[x]['item'][y].tpi_pax;
                pax.style.textAlign = 'center';
                row15.appendChild(pax);

                let tpiPaxValue = parseFloat(data[x]['item'][y].tpi_pax);

                let result;
                if (tpiPaxValue === 0) {
                    result = Number.POSITIVE_INFINITY;
                } else {
                    result = roundedTotalPi / tpiPaxValue;
                }

                let roundedResult = result === Number.POSITIVE_INFINITY ? '0' : parseFloat(result.toFixed(2));


                let resultCell = document.createElement('td');
                resultCell.textContent = roundedResult.toLocaleString('en-US');
                resultCell.style.textAlign = 'right';
                resultCell.style.fontWeight = 'bold';
                row16.appendChild(resultCell);

                let TCTarget = parseFloat(data[x]['item'][y].tpi_tc_target);
                let TC = parseFloat(data[x]['item'][y].tpi_tc);

                let tcAttainment;
                if (!isNaN(TCTarget) && !isNaN(TC) && TCTarget !== null && TC !== null) {
                    tcAttainment = (TC / TCTarget) * 100;
                } else {
                    tcAttainment = 0;
                }

                let tcPercentage = Math.round(tcAttainment);
                let tcAtt = document.createElement('td');
                tcAtt.textContent = tcPercentage.toLocaleString('en-US') + '%';
                tcAtt.style.textAlign = 'right';
                rowAI1.appendChild(tcAtt);

                // let CollectionTarget = parseFloat(data[x]['item'][y].tpi_coll_target);
                let dsr = tpi_reg_sale + tpi_lap_dp + tpi_lap_fup + tpi_lap_fp + tpi_mto_dp + tpi_mto_fup + tpi_mto_fp;
                let coll_target_raw = data[x]['item'][y].tpi_coll_target;
                let tpi_coll_target = parseFloat(coll_target_raw.replace(/,/g, ''));
                let collAttainment = (dsr / tpi_coll_target) * 100;
                // let collAttainment;
                // if (!isNaN(CollectionTarget) && CollectionTarget !== null) {
                //     collAttainment = (sum / CollectionTarget) * 100;
                // } else {
                //     collAttainment = 0;
                // }

                let collPercentage = Math.round(collAttainment);
                let collAtt = document.createElement('td');
                collAtt.textContent = collPercentage.toLocaleString('en-US') + '%';
                collAtt.style.textAlign = 'right';
                rowAI2.appendChild(collAtt);


                let actualCollsecond = document.createElement('td');
                actualCollsecond.textContent = sum.toLocaleString('en-US');
                actualCollsecond.style.textAlign = 'right';
                row18.appendChild(actualCollsecond);

                let secondtotalpi = (totalcol * 0.25) / 100;
                let roundedsecondTotalPi = parseFloat(secondtotalpi.toFixed(2));
                let secondtotalPI = document.createElement('td');
                if (tcPercentage >= 100 && collPercentage >= 100) {
                    secondtotalPI.textContent = roundedsecondTotalPi.toLocaleString('en-US');
                } else {
                    secondtotalPI.textContent = '0';
                }
                secondtotalPI.style.textAlign = 'right';
                secondtotalPI.style.fontWeight = 'bold';
                row20.appendChild(secondtotalPI);

                let second_pax = document.createElement('td');
                second_pax.textContent = data[x]['item'][y].tpi_pax;
                second_pax.style.textAlign = 'center';
                row21.appendChild(second_pax);

                let result2;
                if (tpiPaxValue === 0) {
                    result2 = Number.POSITIVE_INFINITY;
                } else {
                    result2 = roundedsecondTotalPi / tpiPaxValue;
                }

                let secondroundedResult = result2 === Number.POSITIVE_INFINITY ? '0' : parseFloat(result2.toFixed(2));


                let additional = document.createElement('td');
                if (tcPercentage >= 100 && collPercentage >= 100) {
                    additional.textContent = secondroundedResult.toLocaleString('en-US');
                } else {
                    additional.textContent = '0';
                }
                // additional.textContent = secondroundedResult.toLocaleString('en-US');
                additional.style.textAlign = 'right';
                additional.style.fontWeight = 'bold';
                row22.appendChild(additional);

                if (data[x]['item'][y].ci_date === month) {
                    checkForMonth = true;
                }

            }
        }
    }

    totalPiTableheader.appendChild(h_row1);
    totalPiTableheader.appendChild(h_row2);
    totalPiTablebody.appendChild(row1);
    totalPiTablebody.appendChild(row2);
    totalPiTablebody.appendChild(row3);
    totalPiTablebody.appendChild(row4);
    totalPiTablebody.appendChild(row5);
    totalPiTablebody.appendChild(row6);
    totalPiTablebody.appendChild(row7);
    totalPiTablebody.appendChild(row8);
    totalPiTablebody.appendChild(row9);
    totalPiTablebody.appendChild(row10);
    totalPiTablebody.appendChild(row11);
    totalPiTablebody.appendChild(row12);
    totalPiTablebody.appendChild(row13);
    totalPiTablebody.appendChild(row14);
    totalPiTablebody.appendChild(row15);
    totalPiTablebody.appendChild(row16);
    totalPiTablebody.appendChild(rowAI1);
    totalPiTablebody.appendChild(rowAI2);
    totalPiTablebody.appendChild(row17);
    totalPiTablebody.appendChild(row18);
    totalPiTablebody.appendChild(row19);
    totalPiTablebody.appendChild(row20);
    totalPiTablebody.appendChild(row21);
    totalPiTablebody.appendChild(row22);

    if (checkForMonth) {
        document.getElementById('additional').checked = true;
    } else {
        // HIDE 0.25% ROW
        document.getElementById('row18').style.display = 'none';
        document.getElementById('row19').style.display = 'none';
        document.getElementById('row20').style.display = 'none';
        document.getElementById('row21').style.display = 'none';
        document.getElementById('row22').style.display = 'none';

    }
}

function toggleAdditionalRows() {
    let displayStyle = document.getElementById('additional').checked ? '' : 'none';

    let row18 = document.getElementById('row18');
    let row19 = document.getElementById('row19');
    let row20 = document.getElementById('row20');
    let row21 = document.getElementById('row21');
    let row22 = document.getElementById('row22');

    if (row18 && row19 && row20 && row21 && row22) {
        row18.style.display = displayStyle;
        row19.style.display = displayStyle;
        row20.style.display = displayStyle;
        row21.style.display = displayStyle;
        row22.style.display = displayStyle;


    }

    if (document.getElementById('additional').checked) {
        if (confirm("Do you want to save the 0.25% incentive?")) {
            saveAdditionalRows();
        }
    }
    if (!canUncheckAdditionalIncentive()) {
        additionalCheckbox.checked = true;
        alert("You cannot uncheck the additional incentive checkbox at this time.");
    }
}

function canUncheckAdditionalIncentive() {
    return true;
}


function saveAdditionalRows() {
    var month = document.getElementById('pi-month').value;
    let table = document.getElementById('totalPiTablebody');
    let headers = document.getElementById('h_row2').children;
    let rows = table.getElementsByTagName('tr');
    let dataToSave = [];

    // Ensure that the expected rows are present in the table
    if (rows.length < 23) {
        console.error('The expected rows are not present in the table.');
        return;
    }

    for (let i = 1; i < headers.length; i++) {
        let outlet = headers[i].textContent;

        // Check if the expected rows and cells exist
        let row18 = rows[19] && rows[19].children[i];
        let row20 = rows[21] && rows[21].children[i];
        let row21 = rows[22] && rows[22].children[i];
        let row22 = rows[23] && rows[23].children[i];

        // Log for debugging
        console.log(`Row 18: ${row18 ? row18.textContent : 'Not available'}`);
        console.log(`Row 20: ${row20 ? row20.textContent : 'Not available'}`);
        console.log(`Row 21: ${row21 ? row21.textContent : 'Not available'}`);
        console.log(`Row 22: ${row22 ? row22.textContent : 'Not available'}`);

        if (!row18 || !row20 || !row21 || !row22) {
            console.error('One of the rows does not contain the expected number of cells.');
            continue;
        }

        let outletData = {
            outlet: outlet,
            dates: month,
            row18: row18.textContent,
            row20: row20.textContent,
            row21: row21.textContent,
            row22: row22.textContent
        };
        dataToSave.push(outletData);
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'saveCI?month=' + month, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let checkbox = document.getElementById('additional');
                let response = JSON.parse(xhr.responseText);
                if (response.error) {
                    alert(response.error);
                } else if (response.success) {
                    alert(response.success);
                }
            } else {
                alert('Failed to save data: ' + xhr.status);
            }
        }
    };
    xhr.send(JSON.stringify(dataToSave));
}

document.addEventListener('DOMContentLoaded', function () {
    fetchPIData();
});