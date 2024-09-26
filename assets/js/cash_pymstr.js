let hot = null;
let pendingChanges = {};  // Object to store pending changes

// Function to fetch data by year-month
function fetchData(month = '') {
    return fetch(`pymstr_entry?month=${month}`)
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
    let number = parseFloat(value);
    if (isNaN(number)) return value;

    return number.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function accountingRenderer(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.NumericRenderer.apply(this, arguments);

    if (value != null) {
        const formattedValue = formatToAccounting(value);
        td.innerHTML = formattedValue;
    }
}

function defaultRenderer(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments); // Changed to TextRenderer for general use

    if (cellProperties.backgroundColor) {
        td.style.backgroundColor = cellProperties.backgroundColor;
    }

    if (prop === 'c_discount' || prop === 'c_gross_amt' || prop === 'c_amount' || prop === 'c_balance') {
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
    const container = document.querySelector('#pymstr_table');
    
    if (container) {
        hot = new Handsontable(container, {
            data: data,
            colHeaders: [
                'DISCOUNT',
                'AREA',
                'CustomerId',
                'ORnumber',
                'FULLNAME',
                'TRNDATE',
                'LAPDATE',
                'MTODATE',
                'EXPDATE',
                'STOCKCODE',
                'GUARCARD',
                'GROSSAMT',
                'AMOUNT',
                'BALANCE',
                'CHARGECODE',
                'TRNSTATUS',
                'TRNTYPE',
                'PAYTYPE',
                'OUTLET',
                'ITMCLASS',
                'JWLSTYLE',
                'GOLDTYPE',
                'FOHDR'
            ],
            columns: [
                { data: 'c_discount', type: 'numeric', editor: false },
                { data: 'c_area', type: 'text', editor: false },
                { data: 'c_cust_id', type: 'text', editor: false },
                { data: 'c_or_num', type: 'text', editor: false },
                { data: 'c_cust_name', type: 'text', editor: false },
                { data: 'c_trn_date', type: 'date', editor: false },
                { data: 'c_lap_date', type: 'date', editor: false },
                { data: 'c_mto_date', type: 'date', editor: false },
                { data: 'c_exp_date', type: 'date', editor: false },
                { data: 'c_sctockcode', type: 'text', editor: false },
                { data: 'c_guarcard', type: 'text', editor: false },
                { data: 'c_gross_amt', type: 'numeric', renderer: accountingRenderer, editor: false },
                { data: 'c_amount', type: 'numeric', renderer: accountingRenderer, editor: false },
                { data: 'c_balance', type: 'numeric', renderer: accountingRenderer, editor: false },
                { data: 'c_chrg_code', type: 'text', editor: false },
                { data: 'c_trn_stat', type: 'text', editor: false },
                { data: 'c_trntype', type: 'text', editor: false },
                { data: 'c_paytype', type: 'text', editor: false },
                { data: 'c_outlet', type: 'text', editor: false },
                { data: 'c_itemclass', type: 'text', editor: false },
                { data: 'c_jwlstyle', type: 'text', editor: false },
                { data: 'c_goldtype', type: 'text', editor: false },
                { data: 'c_fohdr', type: 'text', editor: false }
            ],
            rowHeaders: true,
            stretchH: 'all',
            width: '100%',
            height: 1000,
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
            contextMenu: {
                items: {
                    "set_color": {
                        name: 'Set Cell Color',
                        callback: function(key, selection) {
                const selected = hot.getSelected();
                if (selected && selected.length > 0) {
                    const row = selected[0][0];
                    const col = selected[0][1];
            
                    // Create and display the color picker
                    const input = document.createElement('input');
                    input.setAttribute('data-jscolor', '');
                    document.body.appendChild(input);
            
                    // Initialize jscolor on the input
                    jscolor.install();
            
                    // Position the input over the cell
                    const rect = hot.getCell(row, col).getBoundingClientRect();
                    input.style.position = 'absolute';
                    input.style.left = `${rect.left}px`;
                    input.style.top = `${rect.top}px`;
                    input.focus();
            
                    // When color is selected, apply it to the cell
                    input.addEventListener('change', function() {
                        let color = input.value;
                        if (color && !color.startsWith('#')) {
                            color = `#${color}`;
                        }
                        
                        // Apply the color if it's a valid hex format
                        if (/^#[0-9A-F]{6}$/i.test(color)) {
                            hot.setCellMeta(row, col, 'backgroundColor', color);
                            saveColorToLocalStorage(row, col, color); // Save color to local storage
                            hot.render(); // Re-render to apply the color
                        } else {
                            console.error('Invalid color format');
                        }
                        document.body.removeChild(input); // Remove the input
                    }, { once: true });
                }
            }
            
                    }
                }
            },
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
            }
        });

    } else {
        console.error('Container element #pymstr_table not found.');
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
