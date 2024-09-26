$(function(e){
	$('#btn-load-dtr').click(function(){
		get_dtr(1);
	});

    get_dtr();
});

function get_dtr(recalc = 0) {
    if((recalc == 1 && confirm("Extracted data may be replaced. Continue?")) || recalc == 0){
    	$("#div-pi-dtr").html("Loading...");
        postRequest('compute/pi-dtr', {
        	from: $('#pi-month').val(),
    		type: 'dtr',
    		includeempno: true,
            recalc: recalc
        })
        .then(response => response.text())
        .then(response => {
            $("#div-pi-dtr").html(response);

            if ( $.fn.DataTable.isDataTable('#div-pi-dtr table') ) {
                $('#div-pi-dtr table').DataTable().destroy();
            }

            let t = $('#div-pi-dtr table').DataTable({
                "scrollY": "300px",
                "scrollX": true,
                "scrollCollapse": true,
                "ordering": false,
                // "paging": false
            });

            t.columns.adjust().draw(false);
        })
        .catch(error => {
            console.log("Error: "+error);
        });
    }
}

function getLastDayOfMonth(inputDate) {
    // Parse input date
    const [year, month] = inputDate.split('-').map(Number);
    
    // Create a new date object for the first day of the next month
    const nextMonth = new Date(year, month, 1);
    
    // Subtract one day from the first day of the next month to get the last day of the current month
    const lastDayOfMonth = new Date(nextMonth - 1);
    
    // Format last day of the month as yyyy-mm-dd
    const lastDayFormatted = lastDayOfMonth.toISOString().slice(0, 10);

    return lastDayFormatted;
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