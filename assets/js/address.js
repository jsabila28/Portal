$(document).ready(function() {
    // Load permanent
    $.ajax({
        url: 'province', // PHP file to get countries from database
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#province').append(data.map(province => `<option value="${province.pr_code}">${province.pr_name}</option>`));
            $('#province').select2({ placeholder: 'Select Municipal', allowClear: true }); // Initialize Select2
        }
    });

    // Load states based on province selection
    $('#province').on('change', function() {
        const province = $(this).val();
        $('#municipal').prop('disabled', !province);
        $('#brngy').prop('disabled', true).empty().append('<option value="">Select Barangay</option>');
        
        if (province) {
            $.ajax({
                url: 'municipal', // PHP file to get states based on province
                type: 'GET',
                data: { pr_code: province },
                dataType: 'json',
                success: function(data) {
                    $('#municipal').empty().append('<option value="">Select Municipality</option>');
                    $('#municipal').append(data.map(municipal => `<option value="${municipal.ct_id}">${municipal.ct_name}</option>`));
                    $('#municipal').select2({ placeholder: 'Select Municipal', allowClear: true }); // Initialize Select2
                }
            });
        }
    });

    // Load cities based on municipal selection
    $('#municipal').on('change', function() {
        const municipal = $(this).val();
        $('#brngy').prop('disabled', !municipal);
        
        if (municipal) {
            $.ajax({
                url: 'brngy', // PHP file to get cities based on municipal
                type: 'GET',
                data: { ct_id: municipal },
                dataType: 'json',
                success: function(data) {
                    $('#brngy').empty().append('<option value="">Select Barangay</option>');
                    $('#brngy').append(data.map(brngy => `<option value="${brngy.br_id}">${brngy.br_name}</option>`));
                    $('#brngy').select2({ placeholder: 'Select Municipal', allowClear: true }); // Initialize Select2
                }
            });
        }
    });

        // Load current address
    $.ajax({
        url: 'province', // PHP file to get countries from database
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#provincec').append(data.map(province => `<option value="${province.pr_code}">${province.pr_name}</option>`));
            $('#provincec').select2({ placeholder: 'Select Municipal', allowClear: true }); // Initialize Select2
        }
    });

    // Load states based on province selection
    $('#provincec').on('change', function() {
        const province = $(this).val();
        $('#municipalc').prop('disabled', !province);
        $('#brngyc').prop('disabled', true).empty().append('<option value="">Select Barangay</option>');
        
        if (province) {
            $.ajax({
                url: 'municipal', // PHP file to get states based on province
                type: 'GET',
                data: { pr_code: province },
                dataType: 'json',
                success: function(data) {
                    $('#municipalc').empty().append('<option value="">Select Municipality</option>');
                    $('#municipalc').append(data.map(municipal => `<option value="${municipal.ct_id}">${municipal.ct_name}</option>`));
                    $('#municipalc').select2({ placeholder: 'Select Municipal', allowClear: true }); // Initialize Select2
                }
            });
        }
    });

    // Load cities based on municipal selection
    $('#municipalc').on('change', function() {
        const municipal = $(this).val();
        $('#brngyc').prop('disabled', !municipal);
        
        if (municipal) {
            $.ajax({
                url: 'brngy', // PHP file to get cities based on municipal
                type: 'GET',
                data: { ct_id: municipal },
                dataType: 'json',
                success: function(data) {
                    $('#brngyc').empty().append('<option value="">Select Barangay</option>');
                    $('#brngyc').append(data.map(brngy => `<option value="${brngy.br_id}">${brngy.br_name}</option>`));
                    $('#brngyc').select2({ placeholder: 'Select Municipal', allowClear: true }); // Initialize Select2
                }
            });
        }
    });

        // Load birth address
    $.ajax({
        url: 'province', // PHP file to get countries from database
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#provincep').append(data.map(province => `<option value="${province.pr_code}">${province.pr_name}</option>`));
            $('#provincep').select2({ placeholder: 'Select Municipal', allowClear: true }); // Initialize Select2
        }
    });

    // Load states based on province selection
    $('#provincep').on('change', function() {
        const province = $(this).val();
        $('#municipalp').prop('disabled', !province);
        $('#brngyp').prop('disabled', true).empty().append('<option value="">Select Barangay</option>');
        
        if (province) {
            $.ajax({
                url: 'municipal', // PHP file to get states based on province
                type: 'GET',
                data: { pr_code: province },
                dataType: 'json',
                success: function(data) {
                    $('#municipalp').empty().append('<option value="">Select Municipality</option>');
                    $('#municipalp').append(data.map(municipal => `<option value="${municipal.ct_id}">${municipal.ct_name}</option>`));
                    $('#municipalp').select2({ placeholder: 'Select Municipal', allowClear: true }); // Initialize Select2
                }
            });
        }
    });

    // Load cities based on municipal selection
    $('#municipalp').on('change', function() {
        const municipal = $(this).val();
        $('#brngyp').prop('disabled', !municipal);
        
        if (municipal) {
            $.ajax({
                url: 'brngy', // PHP file to get cities based on municipal
                type: 'GET',
                data: { ct_id: municipal },
                dataType: 'json',
                success: function(data) {
                    $('#brngyp').empty().append('<option value="">Select Barangay</option>');
                    $('#brngyp').append(data.map(brngy => `<option value="${brngy.br_id}">${brngy.br_name}</option>`));
                    $('#brngyp').select2({ placeholder: 'Select Municipal', allowClear: true }); // Initialize Select2
                }
            });
        }
    });
});
