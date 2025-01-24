$(document).ready(function(){
            // Fetch provinces on page load
            $.ajax({
                url: "province",
                type: "GET",
                success: function(data) {
                    $('#province').html(data);
                }
            });

            // Fetch municipalities based on province
            $('#province').change(function(){
                var provinceId = $(this).val();
                if (provinceId) {
                    $.ajax({
                        url: "municipal",
                        type: "GET",
                        data: { province_id: provinceId },
                        success: function(data) {
                            $('#municipality').html(data);
                        }
                    });
                } else {
                    $('#municipality').html('<option value="">Select Municipality</option>');
                    $('#barangay').html('<option value="">Select Barangay</option>');
                }
            });

            // Fetch barangays based on municipality
            $('#municipality').change(function(){
                var municipalityId = $(this).val();
                if (municipalityId) {
                    $.ajax({
                        url: "brngy",
                        type: "GET",
                        data: { municipality_id: municipalityId },
                        success: function(data) {
                            $('#barangay').html(data);
                        }
                    });
                } else {
                    $('#barangay').html('<option value="">Select Barangay</option>');
                }
            });
        });