
function fetchTargetData() {
    var month = document.getElementById('pi-month').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                updatetargetTable(data);
            } else {
                console.error('Failed to fetch data:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'targetjs?month=' + month, true); //php to get data
    xhr.send();
}


        // Function to update the table with fetched data
function updatetargetTable(data) {
    var targetTablebody = document.getElementById('targetTablebody');
    targetTablebody.innerHTML = ''; // Clear existing data

    data.forEach(function(item) {
        var row = document.createElement('tr');
        var area = document.createElement('td');
        area.textContent = item.target_area;
        row.appendChild(area);
        var outlet = document.createElement('td');
        outlet.textContent = item.target_outlet;
        outlet.style.textAlign = 'center';
        row.appendChild(outlet);
        var month = document.createElement('td');
        month.textContent = item.target_month;
        month.style.textAlign = 'center';
        row.appendChild(month);
        var year = document.createElement('td');
        year.textContent = item.target_year;
        year.style.textAlign = 'center';
        row.appendChild(year);
        var cash = document.createElement('td');
        cash.textContent = item.target_cash;
        cash.style.textAlign = 'center';
        row.appendChild(cash);
        var nlap = document.createElement('td');
        nlap.textContent = item.target_new_lap;
        nlap.style.textAlign = 'center';
        row.appendChild(nlap);
        var nmto = document.createElement('td');
        nmto.textContent = item.target_new_mto;
        nmto.style.textAlign = 'center';
        row.appendChild(nmto);
        var cashcoll = document.createElement('td');
        cashcoll.textContent = item.target_cash_coll;
        cashcoll.style.textAlign = 'right';
        row.appendChild(cashcoll);
        var lapdp = document.createElement('td');
        lapdp.textContent = item.target_lapdownpayment;
        lapdp.style.textAlign = 'right';
        row.appendChild(lapdp);
        var lapcoll = document.createElement('td');
        lapcoll.textContent = item.target_total_lapcoll;
        lapcoll.style.textAlign = 'right';
        row.appendChild(lapcoll);
        var mtocoll = document.createElement('td');
        mtocoll.textContent = item.target_total_mtocoll;
        mtocoll.style.textAlign = 'right';
        row.appendChild(mtocoll);
        var gcol = document.createElement('td');
        gcol.style.textAlign = 'right';
        gcol.textContent = item.grand_coll;
        row.appendChild(gcol);
        var gtc = document.createElement('td');
        gtc.style.textAlign = 'center';
        gtc.textContent = item.grand_tc;
        row.appendChild(gtc);
        var tl = document.createElement('td');
        tl.textContent = item.target_tl_assign;
        row.appendChild(tl);
        

        targetTablebody.appendChild(row);
    });
}

// $(function(){
//     fetchTargetData();
// });
function fetchTargetDataAndUpdate() {
    fetchTargetData();
}

$(function(){
    // Initially fetch the data
    fetchTargetDataAndUpdate();
    
    // Fetch data again when the page regains focus
    // $(window).on('focus', fetchTargetDataAndUpdate);
});