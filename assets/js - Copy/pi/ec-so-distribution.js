$(function(){
    let dist_td = '';
    let remarks_td = '';

    $("#wizard form").on("click", "#div-distribution td.isinput", function(){
        $('#modal-dist #dist-empno').val($(this).parent().attr('dist-empno'));
        $('#modal-dist #dist-type').val($(this).attr('dist-type'));
        $('#modal-dist #dist-val').val($(this).attr('dist-val'));

        $('#modal-dist .modal-title').text($(this).attr('dist-type').toUpperCase().replace("-", " "));

        dist_td = this;

        $('#modal-dist').modal('show');
    });

    $('#modal-dist #btn-dist-confirm').on("click", function(){
        compute_cib_mbtc(dist_td);
    });

    $('#div-distribution').on('change', '.dist-status', function(){
        let this1 = $(this);
        this1.prop('disabled', true);

        postRequest('update/dist/release', {
            ym: $('#pi-month').val(),
            empno: this1.val(),
            status: (this1.is(':checked') ? 1 : 0)
        })
        .then(response => response.json())
        .then(response => {
            if(response['status'] == 1){
                // 
            }else{
                this1.prop('checked', (this1.is(':checked') ? false : true));
                alert('Unable to save. Please try again');
            }
            this1.prop('disabled', false);
        })
        .catch(error => {
            this1.prop('checked', (this1.is(':checked') ? false : true));
            this1.prop('disabled', false);
            alert('Unable to save. Please try again');
            console.log("Error: "+error);
        });
    });

    $('#div-distribution').on('click', '.dist-remarks', function(){
        $('#modal-user-remarks #remarks-empno').val($(this).parent().attr('dist-empno'));
        $('#modal-user-remarks #user-remarks').val($(this).attr('user-remarks'));

        remarks_td = this;

        $('#modal-user-remarks').modal('show');
    });

    $('#btn-user-remarks').on('click', function(){
        postRequest('update/dist/remarks', {
            ym: $('#pi-month').val(),
            empno: $('#remarks-empno').val(),
            remarks: $('#user-remarks').val()
        })
        .then(response => response.json())
        .then(response => {
            if(response['status'] == 1){
                $(remarks_td).attr('user-remarks', $('#user-remarks').val());
                $(remarks_td).html($(remarks_td).attr('dtr-remarks')+($('#user-remarks').val() ? "<hr>"+$('#user-remarks').val() : ''));
                $('#modal-user-remarks').modal('hide');
            }else{
                alert('Unable to save. Please try again');
            }
        })
        .catch(error => {
            alert('Unable to save. Please try again');
            console.log("Error: "+error);
        });
    });

    get_distribution();
});

function get_distribution(recalc = 0) {
    if((recalc == 1 && confirm("Changes made will be lost. Continue?")) || recalc == 0){
        $("#div-distribution").html("Loading...");
        getRequest('get/distribution', {
            ym: $('#pi-month').val(),
            recalc : recalc
        })
        .then(response => response.text())
        .then(response => {
            $("#div-distribution").html(response);
        })
        .catch(error => {
            console.log("Error: "+error);
        });
    }
}

function compute_cib_mbtc(td) {

    let type = $(td).attr('dist-type');
    let empno = $(td).parent().attr('dist-empno');
    let newval = parseFloat($('#modal-dist #dist-val').val().replace(/[^0-9\.\-]/g, ""));

    let productivity = type == 'productivity' ? newval : parseFloat($(td).parent().find("td[dist-type='productivity']").attr('dist-val'));
    let fund = type == 'fund' ? newval : parseFloat($(td).parent().find("td[dist-type='fund']").attr('dist-val'));
    let ar = type == 'ar' ? newval : parseFloat($(td).parent().find("td[dist-type='ar']").attr('dist-val'));
    let cash_incentive = type == 'cash incentive' ? newval : parseFloat($(td).parent().find("td[dist-type='cash incentive']").attr('dist-val'));

    let cib_mbtc = productivity - fund + ar + cash_incentive;

    postRequest('compute/distribution', {
        ym: $('#pi-month').val(),
        empno: empno,
        type: type,
        amount: newval,
        cib_mbtc: cib_mbtc
    })
    .then(response => response.json())
    .then(response => {
        if(response['status'] == 1){
            $(td).attr('dist-val', $('#modal-dist #dist-val').val().replace(/[^0-9\.\-]/g, ""));
            $(td).text(addCommaToNum($('#modal-dist #dist-val').val().replace(/[^0-9\.\-]/g, "")));
            $(td).parent().find("td[dist-type='dist-cib-mbtc']").text( addCommaToNum(cib_mbtc.toFixed(2)) );
            $('#modal-dist').modal('hide');
            dist_td = '';
            compute_outlet_total($(td).parent().attr('dist-outlet'));
        }else{
            alert('Unable to save. Please try again');
        }
    })
    .catch(error => {
        console.log("Error: "+error);
    });
}

function compute_grand_total() {

    let productivity = 0;
    let fund = 0;
    let ar = 0;
    let cash_incentive = 0;

    $('#div-distribution table tbody tr:not(.outlet-total, #grand-total)').each(function(){
        productivity += parseFloat($(this).find("td[dist-type='productivity']").attr('dist-val'));
        fund += parseFloat($(this).find("td[dist-type='fund']").attr('dist-val'));
        ar += parseFloat($(this).find("td[dist-type='ar']").attr('dist-val'));
        cash_incentive += parseFloat($(this).find("td[dist-type='cash incentive']").attr('dist-val'));
    });

    let cib_mbtc = productivity - fund + ar + cash_incentive;

    $('#grand-total .g-total-productivity').text( addCommaToNum(productivity.toFixed(2)) );
    $('#grand-total .g-total-fund').text( addCommaToNum(fund.toFixed(2)) );
    $('#grand-total .g-total-ar').text( addCommaToNum(ar.toFixed(2)) );
    $('#grand-total .g-total-cash-incentive').text( addCommaToNum(cash_incentive.toFixed(2)) );
    $('#grand-total .g-total-cib-mbtc').text( addCommaToNum(cib_mbtc.toFixed(2)) );
}

function compute_outlet_total(outlet) {
    let productivity = 0;
    let fund = 0;
    let ar = 0;
    let cash_incentive = 0;

    $('tr[dist-outlet="' + outlet + '"]:not(.outlet-total)').each(function(){
        productivity += parseFloat($(this).find("td[dist-type='productivity']").attr('dist-val'));
        fund += parseFloat($(this).find("td[dist-type='fund']").attr('dist-val'));
        ar += parseFloat($(this).find("td[dist-type='ar']").attr('dist-val'));
        cash_incentive += parseFloat($(this).find("td[dist-type='cash incentive']").attr('dist-val'));
    });

    let cib_mbtc = productivity - fund + ar + cash_incentive;

    $('tr.' + outlet + '-total td.total-productivity').text(addCommaToNum(productivity.toFixed(2)));
    $('tr.' + outlet + '-total td.total-fund').text(addCommaToNum(fund.toFixed(2)));
    $('tr.' + outlet + '-total td.total-ar').text(addCommaToNum(ar.toFixed(2)));
    $('tr.' + outlet + '-total td.total-cash-incentive').text(addCommaToNum(cash_incentive.toFixed(2)));
    $('tr.' + outlet + '-total td.total-cib-mbtc').text(addCommaToNum(cib_mbtc.toFixed(2)));

    compute_grand_total();
}

function addCommaToNum(number) {
    // Split the number into integer and decimal parts
    var parts = number.toString().split(".");
    
    // Add commas to the integer part
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    
    // Join the parts back together
    return parts.join(".");
}

async function getRequest(url, params = {}) {
    // Build query string (handle empty object gracefully)
    const queryString = new URLSearchParams(params).toString();
    const fullUrl = queryString ? `${url}?${queryString}` : url;

    try {
        const response = await fetch(fullUrl);

        // Check for successful response
        if (!response.ok) {
            throw new Error(`GET request to ${url} failed with status ${response.status}`);
        }

        return response;
    } catch (error) {
        console.error('Error fetching data:', error);
        // throw error; // Re-throw for potential handling at the call site
    }
}

async function postRequest(url, params = {}) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded' // for $_POST
            },
            body: JSON.stringify(params) // Replace with your data to be sent
        });

        // Check for successful response
        if (!response.ok) {
            throw new Error(`POST request to ${url} failed with status ${response.status}`);
        }

        return response;
    } catch (error) {
        console.error('Error posting data:', error);
        // throw error; // Re-throw for potential handling at the call site
    }
}