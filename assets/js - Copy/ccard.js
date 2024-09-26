$(document).ready(function() {

    $(document).on('click', '#fetch', function() {
        var selectedMonth = $('#monthSelect').val();
        
        // Show the loading message
        $('#loadingMessage').show();

        $.ajax({
            url: 'ccard',
            type: 'GET',
            data: { moveMonth: selectedMonth },
            dataType: 'json',
            success: function(response) {
                // Hide the loading message
                $('#loadingMessage').hide();

                if (response.success) {
                    alert('Data moved successfully.');
                    $('#credit_table').show();
                } else {
                    console.error('Data move failed:', response.message);
                }
            },
            error: function(xhr, status, error) {
                $('#loadingMessage').hide();
                console.error("AJAX Error: ", status, error);
                alert('An error occurred while moving data.');
            }
        });
    });

});

let hot = null;
let pendingChanges = {};  // Object to store pending changes

// Function to fetch data by year-month
function fetchData(month = '') {
    return fetch(`get_ccard?month=${month}`)
        .then(response => response.json())
        .then(data => {
            console.log('Fetched data:', data);
            return data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            return [];
        });
}

function accountingRenderer(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.NumericRenderer.apply(this, arguments);
    
    if (value != null) {
        const formattedValue = formatToAccounting(value);
        td.innerHTML = formattedValue;
    }
}

function formatToAccounting(value) {
    let number = parseFloat(value);
    if (isNaN(number)) return value;

    return number.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function percentageRenderer(instance, td, row, col, prop, value, cellProperties) {
    if (typeof value === 'number') {
        td.innerHTML = value.toFixed(2) + '%';
    } else {
        td.innerHTML = '';
    }
    return td;
}

function calculateSum(row) {
    const gcashTransFee = parseFloat(hot.getDataAtCell(row, 14)) || 0;
    const ewt = parseFloat(hot.getDataAtCell(row, 15)) || 0;
    const mdr = parseFloat(hot.getDataAtCell(row, 16)) || 0;
    return gcashTransFee + mdr + ewt;
}

function calculateNet(row) {
    const ccard = parseFloat(hot.getDataAtCell(row, 17)) || 0;
    const ap = parseFloat(hot.getDataAtCell(row, 9)) || 0;
    return (ap - ccard);
}

function calculateMDR(row) {
    const mdrRate = parseFloat(hot.getDataAtCell(row, 19)) || 0;
    const amount = parseFloat(hot.getDataAtCell(row, 9)) || 0;
    const mdrRateDecimal = amount / 100; 
    return mdrRate * mdrRateDecimal;
}

function initializeHandsontable(data) {
    const container = document.querySelector('#credit_table');
    
    if (container) {
        hot = new Handsontable(container, {
            data: data,
            // formula: HyperFormula,
            colHeaders: ['ID', 'Customer ID', 'Customer Name', 'Invoice No.', 'OR No.', 'TransDate', 'Account ID', 'Outlet', 'TransType', 'Amount Paid', 'PayType', 'Terminal', 'Tag Price', 'Discount', 'Gcash Trans Fee', 'EWT(0.5%)', 'MDR', 'CCARD', 'Net Amount', 'MDR Rate', 'Bank', 'Bank Amount', 'Bank Paid Date', 'Deposit Ticket', 'Remarks'],
            columns: [
                { data: 'pID', type: 'numeric', editor: false }, //0
                { data: 'Customer_id', type: 'text', editor: false },  //1
                { data: 'Customer_Name', type: 'text', editor: false },  //2
                { data: 'Invoice_No', type: 'text', editor: false }, //3
                { data: 'OR_No', type: 'text', editor: false }, //4
                { data: 'TrnDate', type: 'date', editor: false }, //5
                { data: 'Account_Code', type: 'text', editor: false }, //6
                { data: 'Outlet', type: 'text', editor: false }, //7
                { data: 'TrnType', type: 'text', editor: false }, //8
                { data: 'Amount', type: 'numeric', renderer: accountingRenderer, editor: false }, //9
                { data: 'PayType', type: 'text', editor: false }, //10
                { data: 'TerminalType', type: 'text', editor: false }, //11
                { data: 'TagPrice', type: 'numeric', renderer: accountingRenderer, editor: false }, //12
                { data: 'Discount', type: 'numeric', renderer: accountingRenderer, editor: false }, //13
                { data: 'gcash_trans', type: 'numeric', renderer: accountingRenderer }, //14
                { data: 'ewt', type: 'numeric', renderer: accountingRenderer }, //15
                { data: 'mdr', type: 'numeric', renderer: accountingRenderer, editor: false }, //16
                { data: 'CCARD', type: 'numeric', renderer: accountingRenderer, editor: false }, //17
                { data: 'net_amount', type: 'numeric', renderer: accountingRenderer, editor: false }, //18
                { data: 'mdr_rate', type: 'numeric', renderer: percentageRenderer }, //19
                { data: 'bank', type: 'text' }, //20
                { data: 'bank_amount', type: 'numeric', renderer: accountingRenderer }, //21
                { data: 'date_p_bank', type: 'date', dateFormat: 'YYYY-MM-DD' }, //22
                { data: 'deposit_ticket', type: 'text' }, //23
                { data: 'remarks', type: 'text' } //24
            ],
            hiddenColumns: {
                columns: [0], // Index of the pID column
                indicators: false 
            },
            rowHeaders: true,
            stretchH: 'all',
            width: '100%',
            height: 400,
            autoWrapRow: false,
            autoWrapCol: false,
            fixedColumnsStart: 2,
            filters: true,
            dropdownMenu: true,
            autoColumnSize: true,
            licenseKey: 'non-commercial-and-evaluation',
            cells: function (row, col, prop) {
                const cellProperties = {};
                const readOnlyCols = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15, 16, 17]; 
                if (readOnlyCols.includes(col)) {
                    cellProperties.readOnly = false;
                    cellProperties.className = 'read-only-cell';
                }
                return cellProperties;
            },
            afterSelectionEnd: function (row1, col1, row2, col2) {
                const selectedRanges = hot.getSelected(); 
                let sum = 0, count = 0;
            
                selectedRanges.forEach(range => {
                    const [startRow, startCol, endRow, endCol] = range;
                    for (let row = startRow; row <= endRow; row++) {
                        for (let col = startCol; col <= endCol; col++) {
                            const value = parseFloat(hot.getDataAtCell(row, col)) || 0;
                            sum += value;
                            count++;
                        }
                    }
                });
            
                const average = count > 0 ? sum / count : 0;
                displayResults(`Count: ${count} | Sum: ${sum} | Average: ${average}`);
            },
            afterChange: function(changes, source) {
                if (source === 'edit' || source === 'paste' || source === 'Insert row') {
                    changes.forEach(([row, prop, oldValue, newValue]) => {
                        if (!pendingChanges[row]) {
                            pendingChanges[row] = hot.getDataAtRow(row); // Collect the entire row data
                        }

                        if (['CCARD','gcash_trans', 'mdr', 'ewt','mdr_rate'].includes(prop)) {
                            const ccard = calculateSum(row);
                            hot.setDataAtCell(row, 17, ccard); 
                            const netAmount = calculateNet(row);
                            hot.setDataAtCell(row, 18, netAmount); 
                        }
                        if (prop === 'mdr_rate') {
                            const mdrAmount = calculateMDR(row);
                            hot.setDataAtCell(row, 16, mdrAmount);
                            const netAmount = calculateNet(row);
                            hot.setDataAtCell(row, 18, netAmount);
                        }
                    });

                    // Debounce the save to avoid excessive saves
                    clearTimeout(pendingSaveTimer);
                    pendingSaveTimer = setTimeout(() => {
                        saveAllPendingChanges();
                    }, 1000); // Adjust the debounce delay as needed
                }
            },
        });

        // Apply initial calculations
        hot.getData().forEach((row, rowIndex) => {
            const ccard = calculateSum(rowIndex);
            hot.setDataAtCell(rowIndex, 17, ccard);

            const netAmount = calculateNet(rowIndex);
            hot.setDataAtCell(rowIndex, 18, netAmount);

            const mdrAmount = calculateMDR(rowIndex);
            hot.setDataAtCell(rowIndex, 16, mdrAmount);
        });

    } else {
        console.error('Container element #credit_table not found.');
    }
}

function displayResults(result) {
    const resultsDiv = document.getElementById('results');
    if (resultsDiv) {
        resultsDiv.textContent = result;
    } else {
        console.error('Results div not found.');
    }
}

fetchData().then(data => {
    initializeHandsontable(data);
});

document.getElementById('monthSelect').addEventListener('change', function () {
    const selectedMonth = this.value;
    fetchData(selectedMonth).then(data => {
        if (hot) {
            hot.loadData(data);
        } else {
            initializeHandsontable(data);
        }
    });
});

function saveDataToDatabase(rowData) {
    console.log('Saving rowData:', rowData);

    $.ajax({
        url: 'save_ccard',
        method: 'POST',
        data: { data: JSON.stringify(rowData) },
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        success: function(response) {
            console.log('Data saved successfully:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error saving data:', error);
            console.error('XHR:', xhr);
            console.error('Status:', status);
            console.error('Error:', error);
        }
    });
}

let pendingSaveTimer = null;

function saveAllPendingChanges() {
    Object.keys(pendingChanges).forEach(row => {
        const rowData = pendingChanges[row];
        saveDataToDatabase(rowData);
    });
    pendingChanges = {}; // Clear pending changes after saving
}
