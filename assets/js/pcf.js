function applyCurrencyFormatting() {
    document.querySelectorAll("td[id='n']").forEach(cell => {
        // Ensure initial formatting
        if (cell.innerText.trim() !== "") {
            let value = parseFloat(cell.innerText.replace(/,/g, "")) || 0;
            cell.innerText = value.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        cell.addEventListener("input", function (event) {
            // Allow only numbers and decimals
            let value = this.innerText.replace(/[^0-9.]/g, "");

            // Update the cell's value without resetting the cursor
            if (this.innerText !== value) {
                this.innerText = value;
                setCaretToEnd(this); // Keep cursor at the end
            }
        });

        cell.addEventListener("blur", function () {
            // Format the value as currency when the cell loses focus
            let value = parseFloat(this.innerText.replace(/,/g, "")) || 0;
            this.innerText = value.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Recalculate the row total
            let row = this.parentElement;
            calculateRowTotal(row);
        });
    });
}

// Function to set the cursor at the end of a contentEditable element
function setCaretToEnd(element) {
    let range = document.createRange();
    let selection = window.getSelection();
    range.selectNodeContents(element);
    range.collapse(false); // Move cursor to the end
    selection.removeAllRanges();
    selection.addRange(range);
}



function calculateRowTotal(row) {
    let total = 0;
    let amountCells = row.querySelectorAll('td[id="n"]'); // Get all expense columns

    amountCells.forEach(cell => {
        let value = parseFloat(cell.innerText.replace(/,/g, '')) || 0; // Convert to float, default to 0 if empty
        total += value;
    });

    let totalCell = row.querySelector('td[id="total"]');
    if (totalCell) {
        totalCell.innerText = total.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    if (total > 500) {
        const rowId = row.getAttribute('data-id');
        const rightSideDiv = document.getElementById(rowId);
        if (rightSideDiv) {
            const proofApproval = rightSideDiv.querySelector('#proofApproval');
            if (proofApproval) {
                proofApproval.style.display = 'flex';
            }
        }
    }

    updateFooterTotals();
}


function updateSecCoh() {
    let secBalElement = document.querySelector(".sec-bal");
    let etotalElement = document.querySelector("#etotal");
    let secCohElement = document.querySelector(".sec-coh p");
    let warningIcon = document.querySelector("#warning"); // Select the warning icon

    if (secBalElement && etotalElement && secCohElement && warningIcon) {
        let secBal = parseFloat(secBalElement.innerText.replace(/,/g, '')) || 0;
        let etotal = parseFloat(etotalElement.innerText.replace(/,/g, '')) || 0;

        let newSecCoh = secBal - etotal;
        secCohElement.innerText = newSecCoh.toFixed(2);

        // Show the icon if newSecCoh is 50% or less of secBal
        if (newSecCoh <= secBal * 0.5) {
            warningIcon.style.display = "inline"; // Show the icon
        } else {
            warningIcon.style.display = "none"; // Hide the icon
        }
    } else {
        // console.error("One or more elements not found!");
    }
}

function updateFooterTotals() {
    let columnTotals = [0, 0, 0, 0, 0]; // 5 expense columns (Office/Store Supply to Miscellaneous)
    let grandTotal = 0; // This will store the sum of the "Total" column

    document.querySelectorAll("#myTable tr").forEach(row => {
        let rowStatus = row.getAttribute("data-stat"); // Get row status
        if (rowStatus && rowStatus.toLowerCase() === "cancelled") return; // Skip cancelled rows

        let amountCells = row.querySelectorAll('td[id="n"]'); // Expense columns
        let totalCell = row.querySelector('td[id="total"]'); // "Total" column

        amountCells.forEach((cell, index) => {
            columnTotals[index] += parseFloat(cell.innerText.replace(/,/g, '')) || 0;
        });

        if (totalCell) {
            grandTotal += parseFloat(totalCell.innerText.replace(/,/g, '')) || 0; // Sum all "Total" column values
        }
    });

    // Update column-wise totals in <tfoot>
    let footerCells = document.querySelectorAll("tfoot td[id='ftotal']");
    footerCells.forEach((cell, index) => {
        if (cell) {
            cell.innerText = columnTotals[index].toFixed(2);
        }
    });

    // Compute alltotal (sum of all ftotal values)
    let allTotal = columnTotals.reduce((acc, val) => acc + val, 0);

    // Update alltotal cell
    let allTotalCell = document.querySelector("tfoot td[id='alltotal']");
    if (allTotalCell) {
        allTotalCell.innerText = allTotal.toFixed(2);
    }

    // Set etotal same as alltotal
    let expenseCell = document.querySelector("tfoot td[id='etotal']");
    if (expenseCell) {
        expenseCell.innerText = allTotal.toFixed(2);
    }

    // Call updateSecCoh after updating etotal
    updateSecCoh();
}

// Function to calculate rtotal based on checked rows
function calculateRtotal() {
    let rtotal = 0;
    
    // Get all checked rows (excluding cancelled ones)
    document.querySelectorAll('#myTable tr').forEach(row => {
        const checkbox = row.querySelector('input[type="checkbox"]');
        const rowStatus = row.getAttribute('data-stat');
        
        // Only include checked rows that aren't cancelled
        if (checkbox && checkbox.checked && (!rowStatus || rowStatus.toLowerCase() !== 'cancelled')) {
            const totalCell = row.querySelector('td[id="total"]');
            if (totalCell) {
                rtotal += parseFloat(totalCell.innerText.replace(/,/g, '')) || 0;
            }
        }
    });
    
    // Update the rtotal cell
    const rtotalCell = document.querySelector('tfoot td[id="rtotal"]');
    if (rtotalCell) {
        rtotalCell.innerText = rtotal.toFixed(2);
    }

    // Update balance after updating rtotal
    updateBalance();
}

function updateBalance() {
    let cohElement = document.querySelector(".sec-bal"); // Cash on Hand
    let rtotalElement = document.querySelector('tfoot td[id="rtotal"]'); // Request Total
    let balanceElement = document.querySelector('tfoot td[id="balance"]'); // Balance

    if (!cohElement) {
        console.error("Error: .coh element not found.");
        return;
    }
    if (!rtotalElement) {
        console.error("Error: #rtotal element not found.");
        return;
    }
    if (!balanceElement) {
        console.error("Error: #balance element not found.");
        return;
    }

    let coh = parseFloat(cohElement.innerText.replace(/,/g, '')) || 0;
    let rtotal = parseFloat(rtotalElement.innerText.replace(/,/g, '')) || 0;

    let balance = coh - rtotal;

    balanceElement.innerText = balance.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    balanceElement.style.color = balance < 0 ? "red" : "black";

    console.log("COH:", coh, "RTOTAL:", rtotal, "BALANCE:", balance);
}


// Ensure updateBalance runs when the page loads
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("#myTable tr").forEach(row => {
        calculateRowTotal(row);
    });
    updateFooterTotals();
    calculateRtotal(); // Add this to initial calculation
    updateBalance(); // Ensure balance is updated at start
});

document.addEventListener("change", function(event) {
    if (event.target.matches('#myTable input[type="checkbox"]')) {
        calculateRtotal();
        updateBalance(); // Update balance after checking/unchecking
    }
});

document.addEventListener("input", function (event) {
    if (event.target.closest("#myTable td[id='n']")) {
        calculateRtotal();
        updateBalance(); // Update balance after input change
    }
});

document.addEventListener("blur", function (event) {
    if (event.target.closest("#myTable td[id='n']")) {
        calculateRtotal();
        updateBalance(); // Update balance after blur
    }
}, true);



// Call this function after the table is loaded
applyCurrencyFormatting();

// Function to add a new row dynamically
function addRow() {
    var table = document.getElementById("myTable");
    var newRow = table.insertRow();

    newRow.innerHTML = `
        <td id="a"><input type="checkbox" name="" checked></td>
        <td id="a" class="entry-id" style="display:none;"></td>
        <td id="a">
            <input type="date" class="date-input" data-field="dis_date" id="datePCF" value="">
        </td> 
        <td id="a" contenteditable></td>
        <td id="a" contenteditable></td>
        <td id="p" contenteditable></td>
        <td id="n" contenteditable></td>
        <td id="n" contenteditable></td>
        <td id="n" contenteditable></td>
        <td id="n" contenteditable></td>
        <td id="n" contenteditable></td>
        <td id="total" class="num">0.00</td>
    `;

    // Fetch department & last entry ID to generate a new one
    getNewEntryId(newRow);

    newRow.querySelectorAll("td[id='n']").forEach(cell => {
        cell.addEventListener("input", function () {
            this.innerText = this.innerText.replace(/[^0-9.]/g, "");
            setCaretToEnd(this);
        });

        cell.addEventListener("blur", function () {
            let value = parseFloat(this.innerText.replace(/,/g, "")) || 0;
            this.innerText = value.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            let row = this.parentElement;
            calculateRowTotal(row); // Update row total
        });
    });
}

// Function to fetch user's department and get new entry ID
function getNewEntryId(row) {
    let userId = ''; 
    $.ajax({
        url: "get_custodian_dept",
        method: "POST",
        data: { user_id: userId },
        dataType: "json",
        success: function (data) {
            if (data.outlet_dept) {
                let outlet_dept = data.outlet_dept;
                fetchLastEntryId(outlet_dept, row);
            } else {
                console.error("Department not found.");
            }
        },
        error: function () {
            console.error("Failed to fetch user department.");
        }
    });
}

// Function to fetch the last entry ID and generate a new one
function fetchLastEntryId(outlet_dept, row) {
    $.ajax({
        url: "get_last_entry",
        method: "POST",
        data: { outlet_dept: outlet_dept },
        dataType: "json",
        success: function (data) {
            let lastNumber = data.dis_no || 0;
            let newNumber = lastNumber + 1;
            let newEntryId = outlet_dept + "-" + newNumber.toString().padStart(4, "0");

            row.querySelector(".entry-id").innerText = newEntryId;
            
            // ✅ Now correctly passing outlet_dept to saveNewRow
            saveNewRow(row, newEntryId, outlet_dept); 
        },
        error: function () {
            console.error("Failed to fetch last entry ID.");
        }
    });
}


function saveNewRow(row, entryId, outlet_dept) {
    if (!row) {
        console.error("Row is null or undefined");
        return;
    }

    let rowData = {
        dis_no: entryId,
        outlet_dept: outlet_dept,
        date: row.cells[2] ? row.cells[2].innerText.trim() : "",  // ✅ Check if cell exists
        pcv: row.cells[3] ? row.cells[3].innerText.trim() : "",
        or: row.cells[4] ? row.cells[4].innerText.trim() : "",
        payee: row.cells[5] ? row.cells[5].innerText.trim() : "",
        office_supply: row.cells[6] ? row.cells[6].innerText.trim() : "",
        transportation: row.cells[7] ? row.cells[7].innerText.trim() : "",
        repairs: row.cells[8] ? row.cells[8].innerText.trim() : "",
        communication: row.cells[9] ? row.cells[9].innerText.trim() : "",
        misc: row.cells[10] ? row.cells[10].innerText.trim() : "",
        total: row.cells[11] ? row.cells[11].innerText.trim() : "0.00"
    };

    console.log("Saving row data:", rowData); // ✅ Debugging

    $.ajax({
        url: "save_entry",
        method: "POST",
        data: rowData,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                console.log("Row saved successfully!");
                location.reload();
            } else {
                alert("Error saving row: " + response.error);
            }
        },
        error: function () {
            alert("Failed to save row.");
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#myTable');

    if (!table) {
        console.error('Table not found');
        return;
    }

    table.addEventListener('input', function (event) {
        const row = event.target.closest('tr');

        if (!row) {
            console.error('Row not found');
            return;
        }

        const entryIdElement = row.querySelector('.entry-id');
        if (!entryIdElement) {
            console.error('.entry-id element not found in the row');
            return;
        }

        const dis_no = entryIdElement.innerText;
        const dis_pcv = row.querySelector('[data-field="dis_pcv"]').innerText.trim(); // PCV Field
        const dis_date = row.querySelector('[data-field="dis_date"]').value;
        const dis_or = row.querySelector('[data-field="dis_or"]').innerText;
        const dis_payee = row.querySelector('[data-field="dis_payee"]').innerText;
        const dis_office_store = parseFloat(row.querySelector('[data-field="dis_office_store"]').innerText) || 0;
        const dis_transpo = parseFloat(row.querySelector('[data-field="dis_transpo"]').innerText) || 0;
        const dis_repair_maint = parseFloat(row.querySelector('[data-field="dis_repair_maint"]').innerText) || 0;
        const dis_commu = parseFloat(row.querySelector('[data-field="dis_commu"]').innerText) || 0;
        const dis_misc = parseFloat(row.querySelector('[data-field="dis_misc"]').innerText) || 0;
        const total = dis_office_store + dis_transpo + dis_repair_maint + dis_commu + dis_misc;

        if (event.target.dataset.field === "dis_pcv") { // Check PCV duplicate
            checkPCVDuplicate(dis_pcv, row, function(isDuplicate) {
                if (!isDuplicate) {
                    // Proceed with updating entry since PCV is unique
                    updateEntry({
                        dis_no: dis_no,
                        dis_date: dis_date,
                        dis_pcv: dis_pcv,
                        dis_or: dis_or,
                        dis_payee: dis_payee,
                        dis_office_store: dis_office_store,
                        dis_transpo: dis_transpo,
                        dis_repair_maint: dis_repair_maint,
                        dis_commu: dis_commu,
                        dis_misc: dis_misc,
                        total: total
                    });
                }
            });
        } else {
            // Directly update entry for other input fields
            updateEntry({
                dis_no: dis_no,
                dis_date: dis_date,
                dis_pcv: dis_pcv,
                dis_or: dis_or,
                dis_payee: dis_payee,
                dis_office_store: dis_office_store,
                dis_transpo: dis_transpo,
                dis_repair_maint: dis_repair_maint,
                dis_commu: dis_commu,
                dis_misc: dis_misc,
                total: total
            });
        }
    });
});

/**
 * Function to Check PCV Duplicate
 */
function checkPCVDuplicate(pcvValue, row, callback) {
    fetch('check_pcv', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `dis_pcv=${encodeURIComponent(pcvValue)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.exists) {
            showAlert('danger', 'PCV already exists!', true);
            row.querySelector('[data-field="dis_pcv"]').innerText = ''; // Clear the duplicate value
            callback(true); // PCV is duplicate
        } else {
            callback(false); // PCV is unique
        }
    })
    .catch(error => {
        console.error('Error:', error);
        callback(true); // Assume duplicate in case of error
    });
}

/**
 * Function to Update Entry in Database
 */
function updateEntry(data) {
    console.log('Sending data:', data);

    fetch('update_entry', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showAlert('success', result.message, true);
        } else {
            showAlert('danger', result.error, true);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'An unexpected error occurred.', true);
    });
}

function showAlert(type, message, autoClose = false) {
    // Check if an alert container exists, if not create one
    let alertContainer = document.getElementById('alert-container');
    if (!alertContainer) {
        alertContainer = document.createElement('div');
        alertContainer.id = 'alert-container';
        alertContainer.style.position = 'fixed';
        alertContainer.style.top = '20px';
        alertContainer.style.right = '20px';
        alertContainer.style.zIndex = '1050';
        document.body.appendChild(alertContainer);
    }

    // Create the alert element
    const alertBox = document.createElement('div');
    alertBox.className = `alert alert-${type} alert-dismissible fade show border border-${type}`;
    alertBox.role = 'alert';
    alertBox.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertContainer.appendChild(alertBox);

    // Automatically close the alert after 3 seconds
    if (autoClose) {
        setTimeout(() => {
            alertBox.classList.remove('show');
            setTimeout(() => {
                alertBox.remove();
            }, 500); // Wait for fade effect
        }, 500);
    }
}



// Select modal and elements properly
const modal = document.getElementById("signature-modal");
const openModalBtn = document.getElementById("open-modal");
const cancelBtn = document.getElementById("cancel-btn");
const confirmBtn = document.getElementById("confirm-btn");
const clearBtn = document.getElementById("clear-btn");
const canvas = document.getElementById("signature-pad");
const signaturePad = new SignaturePad(canvas);
const ctx = canvas.getContext("2d");
let drawing = false;

// Open modal
openModalBtn.addEventListener("click", () => {
    modal.style.display = "flex";  // Ensure modal is defined
});

// Close modal
cancelBtn.addEventListener("click", () => {
    modal.style.display = "none";  // Ensure modal is defined
});

// Clear signature
clearBtn.addEventListener("click", () => {
    signaturePad.clear();
});

// Drawing event listeners
canvas.addEventListener("mousedown", (event) => {
    drawing = true;
    ctx.beginPath();
    ctx.moveTo(event.offsetX, event.offsetY);
});

canvas.addEventListener("mousemove", (event) => {
    if (!drawing) return;
    ctx.lineTo(event.offsetX, event.offsetY);
    ctx.stroke();
});

canvas.addEventListener("mouseup", () => {
    drawing = false;
});

// Function to check if canvas is empty
function isCanvasEmpty(canvas) {
    const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
    return !pixelData.some((pixel, index) => index % 4 === 3 && pixel !== 0);
}

// Save signature & send via AJAX
confirmBtn.addEventListener("click", () => {
    if (signaturePad.isEmpty()) {
        alert("Please sign before confirming.");
        return;
    }

    const svgData = signaturePad.toDataURL('image/svg+xml'); // Get SVG data
    console.log("Signature Data:", svgData);

    $("#signature-container").html(`<img src="${svgData}" alt="Signature" width="100" height="40">`);
    $("#dateSign").text(new Date().toISOString().split("T")[0]);

    var secCoh = $("#balance").text().trim();
    var etotal = $("#rtotal").text().trim();
    var pcfID = $("input[name='pcfID']").val();
    var company = $("input[name='company']").val();
    var outlet = $("input[name='outlet']").val();

    var disbData = [];
    $(".clickable-row").each(function () {
        var rowPcfID = $(this).find(".entry-id").text().trim();
        if (rowPcfID === pcfID) {
            disbData.push({ dis_no: $(this).data("id") });
        }
    });

    $.ajax({
        url: "save_replenish",
        type: "POST",
        data: {
            sec_coh: secCoh,
            etotal: etotal,
            pcfID: pcfID,
            company: company,
            outlet: outlet,
            signature: encodeURIComponent(svgData), // Send SVG data
            disbursements: JSON.stringify(disbData)
        },
        success: function (response) {
            alert("Signature saved successfully!");
            modal.style.display = "none";  // Close modal after saving
            location.reload();
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
        }
    });
});

$(document).on("click", "#confirm-btn", function() {
    let disbursements = [];

    $("#myTable tr").each(function() {
        if ($(this).find('input[type="checkbox"]').is(":checked")) {
            let dis_no = $(this).data("id"); 
            if (dis_no) {
                disbursements.push({ dis_no: dis_no });
            }
        }
    });

    console.log("Collected disbursements:", disbursements);

    if (disbursements.length === 0) {
        alert("No disbursements selected.");
        return;
    }

    $.ajax({
        url: "update_disburse",
        type: "POST",
        data: {
            pcfID: $("#pcfIDs").val(),
            disbursements: JSON.stringify(disbursements)
        },
        success: function(response) {
            console.log("Server Response:", response);
            alert("Replenished successfully!");
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
});
$(document).ready(function() {
    $('.clickable-row').on('click', function() {
        $('.clickable-row').removeClass('highlighted-row');

        $(this).addClass('highlighted-row');

        $('.right-side').hide();

        const id = $(this).data('id');

        $('#' + id).show();

        $('#center-sided').css('width', '60%');
    });
});

$(document).ready(function() {
    console.log("Fetched images:", $('.image-container img').map(function() { return $(this).attr('src'); }).get());

    const imageStore = {
        attachment: [],
        screenshot: []
    };

    $('.image-container img').each(function() {
        imageStore.attachment.push($(this).attr('src'));
    });

    function displayAllImages(container) {
        $(container).empty();

        imageStore.attachment.forEach(image => {
            $(container).append(
                `<img src="${image}" style="width: 100px; height: auto; margin: 5px;" alt="Attachment">`
            );
        });

        imageStore.screenshot.forEach(image => {
            $(container).append(
                `<img src="${image}" style="width: 100px; height: auto; margin: 5px;" alt="Screenshot">`
            );
        });
    }

    function handleFileSelection(input, inputType) {
        if (input.files && input.files.length > 0) {
            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageStore[inputType].push(e.target.result);
                    displayAllImages('.image-container');
                };
                reader.readAsDataURL(input.files[i]);
            }
        } else {
            displayAllImages('.image-container');
        }
    }

    $('input[name="attachment[]"]').on('change', function() {
        handleFileSelection(this, 'attachment');
    });

    $('input[name="screenshot[]"]').on('change', function() {
        handleFileSelection(this, 'screenshot');
    });

    displayAllImages('.image-container');

        $('#saveFile').on('click', function() {
            const formData = new FormData();
            const disburNo = $('input[name="disbur_no"]').val();

            // Append all attachment files
            $.each($('input[name="attachment[]"]')[0].files, function(i, file) {
                formData.append('attachment[]', file);
            });

            // Append all screenshot files
            $.each($('input[name="screenshot[]"]')[0].files, function(i, file) {
                formData.append('screenshot[]', file);
            });

            // Append disbur_no
            formData.append('disbur_no', disburNo);

            // Send AJAX request
            $.ajax({
                url: 'save_attachment', // PHP script to handle file upload
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('.alert-success').show(); // Show success message
                    setTimeout(function() {
                        $('.alert-success').hide(); // Hide success message after 3 seconds
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        // Handle table row click
        $('.clickable-row').on('click', function() {
            $('.image-container').empty(); // Clear old images
            const disburNo = $(this).data('id');
        
            $.ajax({
                url: 'fetch_attachment', // Your PHP script to get image paths
                type: 'POST',
                data: { disbur_no: disburNo },
                success: function(response) {
                    const images = JSON.parse(response);
                    imageStore.attachment = images; // Store images
                    displayAllImages('.image-container'); // Display them
                },
                error: function(error) {
                    console.log('Error fetching images:', error);
                }
            });
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // Get today's date in YYYY-MM-DD format
    let today = new Date().toISOString().split("T")[0];

    // Select all date inputs with class 'date-input' and set the max attribute
    document.querySelectorAll(".date-input").forEach(function (input) {
        input.setAttribute("max", today);
    });
});
