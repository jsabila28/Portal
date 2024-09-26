const canvas = document.getElementById("signature-pad").querySelector("canvas");

const signaturePad = new SignaturePad(canvas, {
    minWidth: 3,
    maxWidth: 3
});

function resizeCanvas() {
    const ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    signaturePad.fromData(signaturePad.toData());
}

$(function(){

    window.addEventListener("resize", resizeCanvas);

    if(
        /*$('#pi-status').val() != 'draft' 
        &&*/ 
        $('#pi-status').val() != 'approved'
        && $('#pi-status').val() != 'released'
    ){
        $('#btnconfirmsign').click(function(){
            if(signaturePad.isEmpty()){
                alert('Please sign');
            }else{

                try {
                    let pi_status = {
                        'draft': 'pending',
                        'pending': 'review',
                        'reviewed': 'audit',
                        'audited': 'approve'
                    };

                    let newstat = pi_status[$('#pi-status').val()] ?? '';

                    postRequest('update/pi-status', {
                        ym: $('#pi-month').val(),
                        empno: '',
                        status: newstat,
                        signature: signaturePad.toSVG()
                    })
                    .then(response => response.json())
                    .then(response => {
                        if(response['status'] == 1){
                            // $('#div-sign').html(signaturePad.toSVG());
                            if(newstat == 'pending'){
                                // $('#display-status').text('(PENDING)');
                                // $('#pi-status').val('pending');
                                // $('#btn-sign').text('SIGN');
                                alert('POSTED');
                                window.location.reload();
                            }else if(newstat == 'review'){
                                alert('REVIEWED');
                                $('#display-status').text('(REVIEWED)');
                                $('#pi-status').val('reviewed');
                            }else if(newstat == 'audit'){
                                alert('AUDITED');
                                $('#display-status').text('(AUDITED)');
                                $('#pi-status').val('audited');
                            }
                            /*else if(newstat == 'note'){
                                alert('NOTED');
                                $('#display-status').text('(NOTED)');
                                $('#pi-status').val('noted');
                            }*/
                            else if(newstat == 'approve'){
                                alert('APPROVED');
                                $('#display-status').text('(APPROVED)');
                                $('#pi-status').val('approved');
                                $('#wizard .actions #btn-sign').hide();
                            }

                            $('#modal-sign').modal('hide');
                        }else{
                            alert('Unable to process. Please try again');
                        }
                    })
                    .catch(error => {
                        console.log("Error: "+error);
                    });
                } catch (error) {
                    console.error('Error posting data:', error);
                    // throw error; // Re-throw for potential handling at the call site
                }
            }
        });

        $("#btnclearsign, #btncancelsign").click(function(){
            signaturePad.clear();
        });

        $("#modal-sign").on("shown.bs.modal", function(){
            $("#signature-pad").css({"width": "100%", "height": "200px"});
            signaturePad.clear();
            resizeCanvas();
        });

        $('#wizard').ready(function(){
            $('#wizard .actions ul').hide();
            $('#wizard .actions').html("<button type='button' class='btn btn-sm btn-info' id='btn-sign'>" + ($('#pi-status').val() == 'draft' ? 'POST' : 'SIGN') + "</button>");

            $('#wizard .actions #btn-sign').on('click', function(){
                $('#modal-sign').modal('show');
            });

            // $('#wizard [href="#finish"]').off();
            // $('#wizard [href="#finish"]').on('click', function(){
            //     $('#modal-sign').modal('show');
            // });

            $('#wizard .steps li').removeClass('disabled');
            $('#wizard .steps li:not(.current)').attr('aria-disabled', false);

            if($('#pi-status').val() != 'draft'){
                $('#wizard .steps li:not(.current)').addClass('done');
            }
        });
    }
    /*else if($('#pi-status').val() == 'draft'){
        $('#wizard').ready(function(){
            // $('#wizard [href="#finish"]').off();
            // $('#wizard [href="#finish"]').on('click', function(){
            //     // code here
            // });

            // $('#wizard [href="#finish"]').text('POST');

            $('#wizard .actions ul').hide();
            $('#wizard .actions').html("<button type='button' class='btn btn-sm btn-primary' id='btn-post'>POST</button>");

            $('#wizard .actions #btn-post').on('click', function(){
                postRequest('update/pi-status', {
                    ym: $('#pi-month').val(),
                    status: 'pending'
                })
                .then(response => response.json())
                .then(response => {
                    if(response['status'] == 1){
                        // $('#display-status').text('(PENDING)');
                        // $('#pi-status').val('pending');
                        // $('#wizard .actions #btn-post').hide();
                        window.location.reload();
                    }else{
                        alert('Unable to process. Please try again');
                    }
                })
                .catch(error => {
                    console.log("Error: "+error);
                });
            });

            $('#wizard .steps li').removeClass('disabled');
            $('#wizard .steps li:not(.current)').addClass('done');
            $('#wizard .steps li:not(.current)').attr('aria-disabled', false);
        });
    }*/
    else if($('#pi-status').val() == 'approved'){
        $('#wizard').ready(function(){
            $('#wizard .actions ul').hide();
            $('#wizard .actions').html("<button type='button' class='btn btn-sm btn-success' id='btn-release'>RELEASE</button>");

            $('#wizard .actions #btn-release').on('click', function(){
                postRequest('update/pi-status', {
                    ym: $('#pi-month').val(),
                    status: 'release'
                })
                .then(response => response.json())
                .then(response => {
                    if(response['status'] == 1){
                        alert('RELEASED');
                        $('#display-status').text('(RELEASED)');
                        $('#pi-status').val('released');
                        $('#wizard .actions #btn-release').hide();
                    }else{
                        alert('Unable to process. Please try again');
                    }
                })
                .catch(error => {
                    console.log("Error: "+error);
                });
            });

            $('#wizard .steps li').removeClass('disabled');
            $('#wizard .steps li:not(.current)').addClass('done');
            $('#wizard .steps li:not(.current)').attr('aria-disabled', false);
        });
    }else{
        $('#wizard').ready(function(){
            $('#wizard .actions ul').hide();
            $('#wizard .steps li').removeClass('disabled');
            $('#wizard .steps li:not(.current)').addClass('done');
            $('#wizard .steps li:not(.current)').attr('aria-disabled', false);
        });
    }
});


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