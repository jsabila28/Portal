$(document).ready(function() {
    $.ajax({
        url: 'province',
        type: 'GET',
        success: function(data) {
            $('#province-perm1').html(data);
        }
    });

    $('#province-perm1').on('change', function() {
        var provinceId = $(this).val();
        $.ajax({
            url: 'municipal',
            type: 'POST',
            data: { pr_code: provinceId },
            success: function(data) {
                $('#municipal-perm1').html(data);
                $('#brngy-perm1').html('<option value="">Select Barangay</option>'); 
            }
        });
    });

    $('#municipal-perm1').on('change', function() {
        var municipalId = $(this).val();
        $.ajax({
            url: 'brngy',
            type: 'POST',
            data: { municipal_id: municipalId },
            success: function(data) {
                $('#brngy-perm1').html(data);
            }
        });
    });

    $.ajax({
        url: 'province',
        type: 'GET',
        success: function(data) {
            $('#province-perm2').html(data);
        }
    });

    $('#province-perm2').on('change', function() {
        var provinceId = $(this).val();
        $.ajax({
            url: 'municipal',
            type: 'POST',
            data: { pr_code: provinceId },
            success: function(data) {
                $('#municipal-perm2').html(data);
                $('#brngy-perm2').html('<option value="">Select Barangay</option>');
            }
        });
    });

    $('#municipal-perm2').on('change', function() {
        var municipalId = $(this).val();
        $.ajax({
            url: 'brngy',
            type: 'POST',
            data: { municipal_id: municipalId },
            success: function(data) {
                $('#brngy-perm2').html(data);
            }
        });
    });

    $.ajax({
        url: 'province',
        type: 'GET',
        success: function(data) {
            $('#province-cur1').html(data);
        }
    });

    // Load municipalities when a province is selected
    $('#province-cur1').on('change', function() {
        var provinceId = $(this).val();
        $.ajax({
            url: 'municipal',
            type: 'POST',
            data: { pr_code: provinceId },
            success: function(data) {
                $('#municipal-cur1').html(data);
                $('#brngy-cur1').html('<option value="">Select Barangay</option>'); // Reset Barangay
            }
        });
    });

    // Load barangays when a municipality is selected
    $('#municipal-cur1').on('change', function() {
        var municipalId = $(this).val();
        $.ajax({
            url: 'brngy',
            type: 'POST',
            data: { municipal_id: municipalId },
            success: function(data) {
                $('#brngy-cur1').html(data);
            }
        });
    });

    $.ajax({
        url: 'province',
        type: 'GET',
        success: function(data) {
            $('#province-cur2').html(data);
        }
    });

    // Load municipalities when a province is selected
    $('#province-cur2').on('change', function() {
        var provinceId = $(this).val();
        $.ajax({
            url: 'municipal',
            type: 'POST',
            data: { pr_code: provinceId },
            success: function(data) {
                $('#municipal-cur2').html(data);
                $('#brngy-cur2').html('<option value="">Select Barangay</option>'); // Reset Barangay
            }
        });
    });

    // Load barangays when a municipality is selected
    $('#municipal-cur2').on('change', function() {
        var municipalId = $(this).val();
        $.ajax({
            url: 'brngy',
            type: 'POST',
            data: { municipal_id: municipalId },
            success: function(data) {
                $('#brngy-cur2').html(data);
            }
        });
    });

     $.ajax({
        url: 'province',
        type: 'GET',
        success: function(data) {
            $('#province-birth1').html(data);
        }
    });

    // Load municipalities when a province is selected
    $('#province-birth1').on('change', function() {
        var provinceId = $(this).val();
        $.ajax({
            url: 'municipal',
            type: 'POST',
            data: { pr_code: provinceId },
            success: function(data) {
                $('#municipal-birth1').html(data);
                $('#brngy-birth1').html('<option value="">Select Barangay</option>'); // Reset Barangay
            }
        });
    });

    // Load barangays when a municipality is selected
    $('#municipal-birth1').on('change', function() {
        var municipalId = $(this).val();
        $.ajax({
            url: 'brngy',
            type: 'POST',
            data: { municipal_id: municipalId },
            success: function(data) {
                $('#brngy-birth1').html(data);
            }
        });
    });

     $.ajax({
        url: 'province',
        type: 'GET',
        success: function(data) {
            $('#province-birth2').html(data);
        }
    });

    // Load municipalities when a province is selected
    $('#province-birth2').on('change', function() {
        var provinceId = $(this).val();
        $.ajax({
            url: 'municipal',
            type: 'POST',
            data: { pr_code: provinceId },
            success: function(data) {
                $('#municipal-birth2').html(data);
                $('#brngy-birth2').html('<option value="">Select Barangay</option>'); // Reset Barangay
            }
        });
    });

    // Load barangays when a municipality is selected
    $('#municipal-birth2').on('change', function() {
        var municipalId = $(this).val();
        $.ajax({
            url: 'brngy',
            type: 'POST',
            data: { municipal_id: municipalId },
            success: function(data) {
                $('#brngy-birth2').html(data);
            }
        });
    });
});
