$(function () {
    let dist_td_recalc = '';
    let remarks_td_recalc = '';

    $("#wizard form").on("click", "#div-distribution-recalc td.isinput", function () {
        $('#modal-dist-recalc #dist-empno-recalc').val($(this).parent().attr('dist-empno'));
        $('#modal-dist-recalc #dist-type-recalc').val($(this).attr('dist-type'));
        $('#modal-dist-recalc #dist-val-recalc').val($(this).attr('dist-val'));

        $('#modal-dist-recalc .modal-title').text($(this).attr('dist-type').toUpperCase().replace("-", " "));

        dist_td_recalc = this;

        $('#modal-dist-recalc').modal('show');
    });

    $('#modal-dist-recalc #btn-dist-confirm-recalc').on("click", function () {
        compute_cib_mbtc_recalc(dist_td_recalc);
    });

    $('#div-distribution-recalc').on('change', '.dist-status', function () {
        let this1 = $(this);
        this1.prop('disabled', true);

        postRequest('update/dist/release', {
            ym: $('#pi-month').val(),
            empno: this1.val(),
            status: (this1.is(':checked') ? 1 : 0),
            r: 1
        })
            .then(response => response.json())
            .then(response => {
                if (response['status'] == 1) {
                    // 
                } else {
                    this1.prop('checked', (this1.is(':checked') ? false : true));
                    alert('Unable to save. Please try again');
                }
                this1.prop('disabled', false);
            })
            .catch(error => {
                this1.prop('checked', (this1.is(':checked') ? false : true));
                this1.prop('disabled', false);
                alert('Unable to save. Please try again');
                console.log("Error: " + error);
            });
    });

    $('#div-distribution-recalc').on('click', '.dist-remarks', function () {
        $('#modal-user-remarks-recalc #remarks-empno-recalc').val($(this).parent().attr('dist-empno'));
        $('#modal-user-remarks-recalc #user-remarks-recalc').val($(this).attr('user-remarks'));

        remarks_td_recalc = this;

        $('#modal-user-remarks-recalc').modal('show');
    });

    $('#btn-user-remarks-recalc').on('click', function () {
        postRequest('update/dist/remarks', {
            ym: $('#pi-month').val(),
            empno: $('#remarks-empno-recalc').val(),
            remarks: $('#user-remarks-recalc').val(),
            r: 1
        })
            .then(response => response.json())
            .then(response => {
                if (response['status'] == 1) {
                    $(remarks_td_recalc).attr('user-remarks', $('#user-remarks-recalc').val());
                    $(remarks_td_recalc).html($(remarks_td_recalc).attr('dtr-remarks') + ($('#user-remarks-recalc').val() ? "<hr>" + $('#user-remarks-recalc').val() : ''));
                    $('#modal-user-remarks-recalc').modal('hide');
                } else {
                    alert('Unable to save. Please try again');
                }
            })
            .catch(error => {
                alert('Unable to save. Please try again');
                console.log("Error: " + error);
            });
    });

    get_distribution_recalc();
});

function get_distribution_recalc(update = 0) {
    // if (update) {
    //     update = $("#div-distribution-recalc").text().trim().length ? 1 : 0;
    // }
    if (
        (
            update == 1 
            && $("#div-distribution-recalc").text().trim().length > 0
            && confirm("Changes made will be lost. Continue?")
        ) 
        || $("#div-distribution-recalc").text().trim().length == 0
    ) {
        $("#div-distribution-recalc").html("Loading...");
        getRequest('get/distribution', {
            ym: $('#pi-month').val(),
            update: update,
            r: 1
        })
            .then(response => response.text())
            .then(response => {
                $("#div-distribution-recalc").html(response);
            })
            .catch(error => {
                console.log("Error: " + error);
            });
    }
}

function compute_cib_mbtc_recalc(td) {

    let type = $(td).attr('dist-type');
    let empno = $(td).parent().attr('dist-empno');
    let newval = parseFloat($('#modal-dist-recalc #dist-val').val().replace(/[^0-9\.\-]/g, ""));

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
        cib_mbtc: cib_mbtc,
        r: 1
    })
        .then(response => response.json())
        .then(response => {
            if (response['status'] == 1) {
                $(td).attr('dist-val', $('#modal-dist-recalc #dist-val').val().replace(/[^0-9\.\-]/g, ""));
                $(td).text(addCommaToNum($('#modal-dist-recalc #dist-val').val().replace(/[^0-9\.\-]/g, "")));
                $(td).parent().find("td[dist-type='dist-cib-mbtc']").text(addCommaToNum(cib_mbtc.toFixed(2)));
                $('#modal-dist-recalc').modal('hide');
                dist_td_recalc = '';
                compute_outlet_total_recalc($(td).parent().attr('dist-outlet'));
            } else {
                alert('Unable to save. Please try again');
            }
        })
        .catch(error => {
            console.log("Error: " + error);
        });
}

function compute_grand_total_recalc() {

    let productivity = 0;
    let fund = 0;
    let ar = 0;
    let cash_incentive = 0;

    $('#div-distribution-recalc table tbody tr:not(.outlet-total, #grand-total-recalc)').each(function () {
        productivity += parseFloat($(this).find("td[dist-type='productivity']").attr('dist-val'));
        fund += parseFloat($(this).find("td[dist-type='fund']").attr('dist-val'));
        ar += parseFloat($(this).find("td[dist-type='ar']").attr('dist-val'));
        cash_incentive += parseFloat($(this).find("td[dist-type='cash incentive']").attr('dist-val'));
    });

    let cib_mbtc = productivity - fund + ar + cash_incentive;

    $('#grand-total-recalc .g-total-productivity').text(addCommaToNum(productivity.toFixed(2)));
    $('#grand-total-recalc .g-total-fund').text(addCommaToNum(fund.toFixed(2)));
    $('#grand-total-recalc .g-total-ar').text(addCommaToNum(ar.toFixed(2)));
    $('#grand-total-recalc .g-total-cash-incentive').text(addCommaToNum(cash_incentive.toFixed(2)));
    $('#grand-total-recalc .g-total-cib-mbtc').text(addCommaToNum(cib_mbtc.toFixed(2)));
}

function compute_outlet_total_recalc(outlet) {
    let productivity = 0;
    let fund = 0;
    let ar = 0;
    let cash_incentive = 0;

    $('tr[dist-outlet="' + outlet + '"]:not(.outlet-total)').each(function () {
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

    compute_grand_total_recalc();
}