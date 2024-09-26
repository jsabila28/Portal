$(document).ready(function() {
    $('#fetch').on('click', function(event) {
        event.preventDefault();
        var month = $('#monthSelect').val();
        $('#loadingMessage').show();
        
        $.ajax({
            url: 'get_pymster',
            type: 'POST',
            data: { month: month },
            success: function(response) {
                $('#loadingMessage').hide();
                alert('Data successfully fetched and updated/inserted.');
                window.location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
});

let hot = null;
let pendingChanges = {};

// Function to fetch data by year-month
function fetchData(month = '') {
    return fetch(`get_cash?month=${month}`)
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

function formatToAccounting(value) {
    let number = parseFloat('-' + value);
    if (isNaN(number)) return value;

    return number.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function accountingRenderer(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.NumericRenderer.apply(this, arguments);

    if (value != null) {
        const formattedValue = formatToAccounting('-' + value);
        td.innerHTML = formattedValue;
    }
}




function defaultRenderer(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.NumericRenderer.apply(this, arguments);
    if (cellProperties.backgroundColor) {
        td.style.backgroundColor = cellProperties.backgroundColor;
    }

    if (prop === 'amount') {
        // Apply accounting format for specific properties
        if (value != null) {
            td.innerHTML = formatToAccounting(value);
        } else {
            td.innerHTML = '';
        }
    }

   
}

function saveColorToLocalStorage(row, col, color) {
    const cellKey = `${row}-${col}`;
    localStorage.setItem(cellKey, color);
}

function getColorFromLocalStorage(row, col) {
    const cellKey = `${row}-${col}`;
    return localStorage.getItem(cellKey) || '';
}

function applyColorsFromLocalStorage() {
    hot.getData().forEach((row, rowIndex) => {
        row.forEach((cell, colIndex) => {
            const color = getColorFromLocalStorage(rowIndex, colIndex);
            if (color) {
                hot.setCellMeta(rowIndex, colIndex, 'backgroundColor', color);
            }
        });
    });
}

function initializeHandsontable(data) {
    const container = document.querySelector('#cash_table');
    
    if (container) {
        hot = new Handsontable(container, {
            data: data,
            colHeaders: ['ID',
                'Outlet',
                'Date',
                'Deposit Ticket ID',
                'Customer ID',
                'Customer Name', 
                'Reference', 
                'Deposit Date', 
                'Payment Method', 
                'Cash Account', 
                'Number of Distribution', 
                'Invoice Paid', 
                'Serial Number', 
                'Description', 
                'G/L Account', 
                'Amount'],
            columns: [
                { data: 'c_pay_id', type: 'text', editor: false }, //0
                { data: 'c_outlet', type: 'text' }, //1
                { data: 'c_trn_date', type: 'date'},  //2
                { data: 'r_depo_ticket', type: 'text'},  //3
                { data: 'cust_id', type: 'text'}, //4
                { data: 'cust_name', type: 'text'}, //5
                { data: 'r_reference'}, //6
                { data: 'r_depo_date', type: 'date', dateFormat: 'YYYY-MM-DD', correctFormat: true}, //7
                { data: 'c_paytype', type: 'text', editor: false }, //8
                { data: 's_gl_acc', type: 'text'}, //9
                { data: 'r_dist_num', type: 'text'}, //10
                { data: 'r_inv_paid', type: 'text'}, //11
                { data: 'r_serial_num', type: 'text'}, //12
                { data: 'r_description', type: 'text'}, //13
                { data: 's_cash_acc', type: 'text'}, //14
                { data: 'amount', type: 'numeric', renderer: accountingRenderer}, //15
               
            ],
            hiddenColumns: {
                columns: [0], // Index of the pID column
                indicators: false 
            },
            rowHeaders: true,
            stretchH: 'all',
            width: '100%',
            height: 800,
            formulas: {
              engine: HyperFormula,
            },
            autoWrapRow: false,
            autoWrapCol: false,
            filters: true,
            undo: true,
            dropdownMenu: true,
            autoColumnSize: true,
            licenseKey: 'non-commercial-and-evaluation',
            contextMenu: true,
            cells: function(row, col, prop) {
                const cellProperties = {};
                // Apply defaultRenderer to all cells
                cellProperties.renderer = defaultRenderer;
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
                if (['edit', 'paste', 'Insert row', 'Autofill.fill', 'CopyPaste.paste'].includes(source)) {
                    changes.forEach(([row, prop, oldValue, newValue]) => {
                        if (!pendingChanges[row]) {
                            pendingChanges[row] = hot.getDataAtRow(row); // Collect the entire row data
                        }
                        if (prop === 'r_dist_num' && (newValue === null || newValue === '')) {
                            hot.setDataAtCell(row, 10, '1'); // Set the value of 'r_dist_num' (column 10) to '1'
                        }
                        if (prop === 'r_serial_num' && (newValue === null || newValue === '')) {
                            hot.setDataAtCell(row, 12, '1'); // Set the value of 'r_serial_num' (column 12) to '1'
                        }
                    });

                    // Debounce the save to avoid excessive saves
                    clearTimeout(pendingSaveTimer);
                    pendingSaveTimer = setTimeout(() => {
                        saveAllPendingChanges();
                    }, 1000); // Adjust the debounce delay as needed
                }
            }
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
    applyColorsFromLocalStorage();
});

document.getElementById('monthSelect').addEventListener('change', function () {
    const selectedMonth = this.value;
    fetchData(selectedMonth).then(data => {
        if (hot) {
            hot.loadData(data);
            applyColorsFromLocalStorage();
        } else {
            initializeHandsontable(data);
            applyColorsFromLocalStorage();
        }
    });
});

function saveDataToDatabase(rowData) {
    console.log('Saving rowData:', rowData);

    $.ajax({
        url: 'save_cash',
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
    pendingChanges = {};
}
function exportTableToExcel() {
    const exportData = hot.getData();
    const headers = hot.getColHeader();

    // Define the columns you want to export (e.g., 1 to 15)
    const columnsToExport = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];

    // Filter the headers for the columns to export
    const filteredHeaders = columnsToExport.map(index => headers[index]);

    // Filter and format the data
    const filteredData = exportData.map(row => {
        return columnsToExport.map((index, colIndex) => {
            let value = row[index];
            
            // Apply the '-' formatting only for the 'Amount' column (column 15 in this case)
            if (colIndex === 14 && value != null && value !== '') { // Assuming column index 15 (zero-based index is 14)
                value = `-${value}`;
            }
            
            return value;
        });
    });

    // Create a worksheet with the filtered data
    const worksheet = XLSX.utils.aoa_to_sheet([filteredHeaders, ...filteredData]);

    // Create a new workbook and append the worksheet
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Cash Collection Data");

    // Retrieve the selected month
    const selectedMonth = $('#monthSelect').val();
    
    // Create the file name based on the selected month
    const fileName = `CreditCardData_${selectedMonth}.xlsx`;

    // Save the file with the dynamic name
    XLSX.writeFile(workbook, fileName);
}

document.getElementById('export-excel').addEventListener('click', exportTableToExcel);


fetchData().then(data => {
    initializeHandsontable(data);
});