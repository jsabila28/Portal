$(function(){
    $('#btn-load-employee').click(function(){
        get_employees();
    });

    get_employees();
});

function get_employees() {
    $("#div-employee-list").html("Loading...");
    const fullUrl = 'get/employees?ym=' + $('#pi-month').val();
    try {
        fetch(fullUrl)
        .then(response => {
            // Check for successful response
            if (!response.ok) {
                throw new Error(`GET request to ${url} failed with status ${response.status}`);
            }
            return response.text();
        })
        .then(response => {
            $("#div-employee-list").html(response);
        })
        .catch(error => {
            console.log("Error: "+error);
        });

    } catch (error) {
        console.error('Error fetching data:', error);
    }
}