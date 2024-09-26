$(document).ready(function() {
    $('#fetch').on('click', function(event) {
        event.preventDefault();
        var month = $('#monthSelect').val();
        $('#loadingMessage').show();
        
        $.ajax({
            url: 'paymaster',
            type: 'POST',
            data: { month: month },
            success: function(response) {
                $('#loadingMessage').hide();
                alert('Data successfully fetched and inserted.');
                window.location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
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


function defaultRenderer(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.NumericRenderer.apply(this, arguments);
    if (cellProperties.backgroundColor) {
        td.style.backgroundColor = cellProperties.backgroundColor;
    }

    if (prop === 'bank_amount' || prop === 'Amount' || prop === 'TagPrice' || prop === 'Discount' ||
        prop === 'gcash_trans' || prop === 'ewt' || prop === 'mdr' || prop === 'CCARD' ||
        prop === 'net_amount') {
        // Apply accounting format for specific properties
        if (value != null) {
            td.innerHTML = formatToAccounting(value);
        } else {
            td.innerHTML = '';
        }
    }

    if (prop === 'mdr_rate') {
        percentageRenderer(instance, td, row, col, prop, value, cellProperties);
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

function accountingRenderer(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.NumericRenderer.apply(this, arguments);
    
    if (value != null) {
        const formattedValue = formatToAccounting(value);
        td.innerHTML = formattedValue;
    } else {
        td.innerHTML = ''; // Clear cell if no value
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
    // const ccard = parseFloat(hot.getDataAtCell(row, 17)) || 0;
    const gcashTransFee = parseFloat(hot.getDataAtCell(row, 14)) || 0;
    const ewt = parseFloat(hot.getDataAtCell(row, 15)) || 0;
    const mdr = parseFloat(hot.getDataAtCell(row, 16)) || 0;
    const ap = parseFloat(hot.getDataAtCell(row, 9)) || 0;
    return ap - (gcashTransFee + ewt + mdr);
}
function calculateMDR(row) {
    const mdrRate = parseFloat(hot.getDataAtCell(row, 19)) || 0;
    const amount = parseFloat(hot.getDataAtCell(row, 9)) || 0;
    const mdrRateDecimal = amount / 100; 
    return mdrRate * mdrRateDecimal;
}

function highlightCells(cells) {
    cells.forEach(({ row, col }) => {
        const cell = hot.getCell(row, col);
        if (cell) {
            cell.style.backgroundColor = 'lightyellow'; // Highlight color
        }
    });
}

function clearHighlight() {
    const cells = document.querySelectorAll('#credit_table td');
    cells.forEach(cell => {
        cell.style.backgroundColor = ''; // Clear highlight
    });
}

function evaluateFormula(formula) {
    if (formula.startsWith('=SUM(')) {
        const range = formula.slice(5, -1); // Remove =SUM( and )
        const cells = parseFormula(range);
        highlightCells(cells); // Highlight cells involved in the formula
        const sum = cells.reduce((acc, { row, col }) => {
            const value = parseFloat(hot.getDataAtCell(row, col)) || 0;
            return acc + value;
        }, 0);
        return sum;
    }
    return formula; // Return formula as-is if not handled
}

function parseFormula(formula) {
    formula = String(formula); // Ensure formula is a string
    const cells = [];
    const rangeRegex = /([A-Z]+)([0-9]+):([A-Z]+)([0-9]+)/;
    const cellRegex = /([A-Z]+)([0-9]+)/g;

    const rangeMatch = formula.match(rangeRegex);
    if (rangeMatch) {
        const startCol = letterToColumn(rangeMatch[1]);
        const startRow = parseInt(rangeMatch[2]) - 1;
        const endCol = letterToColumn(rangeMatch[3]);
        const endRow = parseInt(rangeMatch[4]) - 1;

        for (let r = startRow; r <= endRow; r++) {
            for (let c = startCol; c <= endCol; c++) {
                cells.push({ row: r, col: c });
            }
        }
    } else {
        let match;
        while ((match = cellRegex.exec(formula)) !== null) {
            const col = letterToColumn(match[1]);
            const row = parseInt(match[2]) - 1;
            cells.push({ row, col });
        }
    }

    return cells;
}


function initializeHandsontable(data) {
    const container = document.querySelector('#credit_table');
    
    if (container) {
        hot = new Handsontable(container, {
            data: data,
            colHeaders: ['ID', 'Customer ID', 'Customer Name', 'Invoice No.', 'OR Number', 'TransDate', 'Account ID', 'Outlet', 'TransType', 'Amount Paid', 'PayType', 'Terminal', 'Tag Price', 'Discount', 'Gcash Trans Fee', 'EWT(0.5%)', 'MDR', 'CCARD', 'Net Amount', 'MDR Rate', 'Bank', 'Bank Amount', 'Notes', 'Bank Paid Date', 'Deposit Ticket', 'Remarks'],
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
                { data: 'Amount', type: 'numeric', renderer: accountingRenderer }, //9
                { data: 'PayType', type: 'text', editor: false }, //10
                { data: 'TerminalType', type: 'text', editor: false }, //11
                { data: 'TagPrice', type: 'numeric', renderer: accountingRenderer, editor: false }, //12
                { data: 'Discount', type: 'numeric', renderer: accountingRenderer, editor: false }, //13
                { data: 'gcash_trans', type: 'numeric' }, //14
                { data: 'ewt', type: 'numeric' }, //15
                { data: 'mdr', type: 'numeric', renderer: accountingRenderer, editor: false }, //16
                { data: 'CCARD', type: 'numeric', renderer: accountingRenderer, editor: false }, //17
                { data: 'net_amount', type: 'numeric', renderer: accountingRenderer, editor: false }, //18
                { data: 'mdr_rate', type: 'numeric', renderer: percentageRenderer }, //19
                { data: 'banks', type: 'text' }, //20
                { data: 'bank_amount', type: 'text', renderer: accountingRenderer }, //21
                { data: 'notes', type: 'text' }, //22
                { data: 'date_p_bank', type: 'date', dateFormat: 'YYYY-MM-DD' }, //23
                { data: 'deposit_ticket', type: 'text' }, //24
                { data: 'remarks', type: 'text' } //25
            ],
            hiddenColumns: {
                columns: [0], // Index of the pID column
                indicators: false 
            },
            rowHeaders: true,
            stretchH: 'all',
            width: '100%',
            height: 1000,
            formulas: {
              engine: HyperFormula,
            },
            autoWrapRow: true,
            autoWrapCol: true,
            fixedColumnsStart: 2,
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
                     clearHighlight(); // Clear previous highlights
                    changes.forEach(([row, prop, oldValue, newValue]) => {
                        if (!pendingChanges[row]) {
                            pendingChanges[row] = hot.getDataAtRow(row); // Collect the entire row data
                        }

                        if (['gcash_trans', 'mdr', 'ewt','mdr_rate','CCard'].includes(prop)) {
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
                        if (prop === 'bank_amount') {
                            if (typeof newValue === 'string' && newValue.startsWith('=')) {
                                const result = evaluateFormula(newValue);
                                hot.setDataAtCell(row, 21, result);
                            }
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


function columnToLetter(column) {
    let letter = '';
    let temp;

    while (column >= 0) {
        temp = column % 26;
        letter = String.fromCharCode(temp + 65) + letter;
        column = Math.floor(column / 26) - 1;
    }

    return letter;
}

function letterToColumn(letter) {
    let column = 0;
    let length = letter.length;

    for (let i = 0; i < length; i++) {
        column = (column + (letter.charCodeAt(i) - 65 + 1)) * 26;
    }

    return column / 26 - 1;
}


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
    pendingChanges = {};
}

function exportTableToExcel() {
    const exportData = hot.getData();
    const headers = hot.getColHeader();

    const columnsToExport = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23,24]; 

    const filteredHeaders = columnsToExport.map(index => headers[index]);
    const filteredData = exportData.map(row => columnsToExport.map(index => row[index]));

    const worksheet = XLSX.utils.aoa_to_sheet([filteredHeaders, ...filteredData]);

    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Credit Card Data");

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
    applyColorsFromLocalStorage();
});
