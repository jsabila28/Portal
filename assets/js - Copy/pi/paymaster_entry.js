function fetchPaymasterData() {
    var month = document.getElementById('pi-month').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                updatepaymasterTable(data);
            } else {
                console.error('Failed to fetch data:', xhr.status);
            }
        }
    };
    xhr.open('GET', 'paymasterjs?month=' + month, true); //php to get data
    xhr.send();
}

        // Function to update the table with fetched data
function updatepaymasterTable(data) {
    var paymasterTableBody = document.getElementById('paymasterBody');
    paymasterTableBody.innerHTML = ''; // Clear existing data

    data.forEach(function(item) {
        var row = document.createElement('tr');
        var ctrlno = document.createElement('td');
        ctrlno.textContent = item.CtrlNo;
        row.appendChild(ctrlno);
        var fullname = document.createElement('td');
        fullname.textContent = item.Fullname;
        row.appendChild(fullname);
        var trndate = document.createElement('td');
        trndate.textContent = item.TrnDate;
        row.appendChild(trndate);
        var lap = document.createElement('td');
        lap.textContent = item.LAPDate;
        row.appendChild(lap);
        var mto = document.createElement('td');
        mto.textContent = item.MTODate;
        row.appendChild(mto);
        var stockcode = document.createElement('td');
        stockcode.textContent = item.StockCode;
        row.appendChild(stockcode);
        var amntg = document.createElement('td');
        amntg.style.textAlign = 'right';
        amntg.textContent = item.AmtGross;
        row.appendChild(amntg);
        var amnt = document.createElement('td');
        amnt.style.textAlign = 'right';
        amnt.textContent = item.Amount;
        row.appendChild(amnt);
        var bal = document.createElement('td');
        bal.style.textAlign = 'right';
        bal.textContent = item.Balance;
        row.appendChild(bal);
        var charge = document.createElement('td');
        charge.textContent = item.ChargeCode;
        row.appendChild(charge);
        var trnstatus = document.createElement('td');
        trnstatus.textContent = item.TrnStatus;
        row.appendChild(trnstatus);
        var trntype = document.createElement('td');
        trntype.textContent = item.TrnType;
        row.appendChild(trntype);
        var paytype = document.createElement('td');
        paytype.textContent = item.PayType;
        row.appendChild(paytype);
        var outlet = document.createElement('td');
        outlet.textContent = item.Outlet;
        row.appendChild(outlet);
        var itemclass = document.createElement('td');
        itemclass.textContent = item.ItemClass;
        row.appendChild(itemclass);
        var area = document.createElement('td');
        area.textContent = item.Area;
        row.appendChild(area);

        paymasterTableBody.appendChild(row);
    });
}


// $(function(){
//     fetchPaymasterData();
// });


function fetchPaymasterDataAndUpdate() {
    fetchPaymasterData();
}

$(function(){
    // Initially fetch the data
    fetchPaymasterDataAndUpdate();
    
    // Fetch data again when the page regains focus
    $(window).on('focus', fetchPaymasterDataAndUpdate);
});