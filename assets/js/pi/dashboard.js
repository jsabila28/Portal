$(function () {
    const today = new Date();
    const currentYear = today.getFullYear();
    const currentMonth = (today.getMonth() + 1).toString().padStart(2, '0');

    $('#create-pi-year').val(currentYear);
    $('#create-pi-month').val(currentMonth);


    $('#form-create-pi').submit(function (e) {
        e.preventDefault();

        fetch('create_pi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded' // for $_POST
            },
            body: new URLSearchParams({
                date: $('#create-pi-year').val() + "-" + $('#create-pi-month').val(),
                dashboard: 1
            }).toString()
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`GET request to ${url} failed with status ${response.status}`);
                }
                return response.text();
            })
            .then(response => {
                $('#create-pi-result').html(response);
            })
            .catch(error => {
                console.log("Error: " + error);
            });
    });

    $('#div-prooflist').on('change', '.deposit-to', function () {
        $(this).prop('disabled', true);
        let this1 = this;
        let source = $(this1).parent().parent().find('.dist-cib-mbtc');
        let sourceFinal = source.parent().find('.dist-cib-mbtc-final');
        let targetFinalPrev = $('#div-prooflist tbody tr[dist-empno="' + $(this1).attr('curval') + '"]').find('.dist-cib-mbtc-final');
        let targetFinal = $('#div-prooflist tbody tr[dist-empno="' + this1.value + '"]').find('.dist-cib-mbtc-final');

        postRequest('update/report/prooflist', {
            ym: $('#prooflist-month').val(),
            empno: $(this1).parent().parent().attr('dist-empno'),
            deposit_to: this1.value
        })
            .then(response => response.json())
            .then(response => {
                if (response['status'] == 1) {
                    if ($(this1).attr('curval')) {
                        let targetFinalPrevTotal = parseFloat($('#div-prooflist tbody tr[dist-empno="' + $(this1).attr('curval') + '"]:has(.deposit-to option[value=""]:selected)').find('.dist-cib-mbtc').attr('dist-val') ?? 0);
                        $('#div-prooflist .deposit-to:has(option[value="' + $(this1).attr('curval') + '"]:selected)').each(function () {
                            targetFinalPrevTotal += parseFloat($(this1).parent().parent().find('.dist-cib-mbtc').attr('dist-val'));
                        });

                        targetFinalPrev.attr('dist-val', targetFinalPrevTotal);
                        targetFinalPrev.text(targetFinalPrevTotal ? addCommaToNum(targetFinalPrevTotal.toFixed(2)) : '');
                    }

                    if (this1.value) {
                        let targetFinalTotal = parseFloat($('#div-prooflist tbody tr[dist-empno="' + this1.value + '"]:has(.deposit-to option[value=""]:selected)').find('.dist-cib-mbtc').attr('dist-val') ?? 0);
                        $('#div-prooflist .deposit-to:has(option[value="' + this1.value + '"]:selected)').each(function () {
                            targetFinalTotal += parseFloat($(this1).parent().parent().find('.dist-cib-mbtc').attr('dist-val'));
                        });

                        targetFinal.attr('dist-val', targetFinalTotal);
                        targetFinal.text(targetFinalTotal ? addCommaToNum(targetFinalTotal.toFixed(2)) : '');

                        let sourceTotal = 0;
                        $('#div-prooflist .deposit-to:has(option[value="' + source.parent().attr('dist-empno') + '"]:selected)').each(function () {
                            sourceTotal += parseFloat($(this1).parent().parent().find('.dist-cib-mbtc').attr('dist-val'));
                        });
                        sourceFinal.attr('dist-val', sourceTotal);
                        sourceFinal.text(sourceTotal ? addCommaToNum(sourceTotal.toFixed(2)) : '');
                    } else {
                        let sourceTotal = parseFloat(source.attr('dist-val'));
                        $('#div-prooflist .deposit-to:has(option[value="' + source.parent().attr('dist-empno') + '"]:selected)').each(function () {
                            sourceTotal += parseFloat($(this1).parent().parent().find('.dist-cib-mbtc').attr('dist-val'));
                        });
                        sourceFinal.attr('dist-val', sourceTotal);
                        sourceFinal.text(sourceTotal ? addCommaToNum(sourceTotal.toFixed(2)) : '');
                    }

                    $(this1).attr('curval', this1.value);
                } else {
                    $(this1).val($(this1).attr('curval'));
                    alert('Unable to save. Please try again');
                }
                $(this1).prop('disabled', false);
            })
            .catch(error => {
                console.log("Error: " + error);
            });
    });
});

function getProoflist(yearMonth) {

    if (!$('#modal-prooflist').hasClass('show')) {
        $('#div-prooflist').html('Loading..');
        $('#prooflist-month').val(yearMonth);
        $('#modal-prooflist').modal('show');
        // await new Promise(r => setTimeout(r, 1000)); // sleep 1 sec
    }

    getRequest('get/report/prooflist', {
        ym: yearMonth
    })
        .then(response => response.text())
        .then(response => {
            setTimeout(() => {
                $('#div-prooflist').html(response)
                // $('#div-prooflist .deposit-to').each(function(){
                //     $(this).attr('curval', this.value);
                // });
            }, 1000);
        })
        .catch(error => {
            console.log("Error: " + error);
        });
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

async function printProoflist() {
    // console.log($('#div-prooflist table').css());
    let divContents = $('#div-prooflist > label').prop('outerHTML');
    divContents += "<p></p>";
    divContents += "<table style='width: 100%; border-collapse: collapse; font-family: Arial; font-size: 11px;'>";

    divContents += "<tbody style='text-align: left;'>";
    $('#div-prooflist table thead tr').each(function () {
        divContents += $(this).prop("outerHTML");
    });
    $('#div-prooflist table tbody tr').each(function () {
        divContents += "<tr>";
        $(this).find('td').each(function () {
            if ($(this).find('select').length > 0) {
                divContents += "<td style='" + this.style.cssText + "'>" + $(this).find('select option:selected').text() + "</td>";
            } else {
                divContents += $(this).prop('outerHTML');
            }
        });
        divContents += "</tr>";
    });
    divContents += "</tbody>";

    divContents += "</table>";

    // Extract and modify styles (replace with your desired styles)
    let printStyles = "font-family: Arial; margin: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; color-adjust: exact;";

    // Wrap content with styled element
    let printDiv = document.createElement("div");
    printDiv.innerHTML = divContents;
    printDiv.style.cssText = printStyles;

    // let printWin = window.open('', '', 'width=400,height=300');
    let printWin = window.open('', '', '');
    printWin.document.write(printDiv.outerHTML);
    // printWin.document.write(divContents);
    printWin.document.close();
    printWin.focus();
    // printWin.document.documentElement.requestFullscreen();
    printWin.print();

    // await new Promise(r => setTimeout(r, 1000)); // sleep 1 sec
    // Optionally close the new window:
    // printWin.close();
    setTimeout(function(){
        printWin.close();
    }, 1500);
}

