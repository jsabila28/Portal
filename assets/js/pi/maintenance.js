"use strict"

// import { getRequest, postRequest } from '../request.js';

function addCommaToNum(number) {
    // Split the number into integer and decimal parts
    var parts = number.toString().split(".");
    
    // Add commas to the integer part
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    
    // Join the parts back together
    return parts.join(".");
}

$(document).ready(function() {

    getUserMap();
    getSLGuidelines();


    $("#btn-load-umap").on("click", function() {
        getUserMap();
    });

    $("#btn-load-sl").on("click", function() {
        getSLGuidelines();
    });

    let inputTime;
    $("#tbl-sl-guidelines").on("input", "input[class*='sl-tc-'], input[class*='sl-ccr-']", function(e){
        clearTimeout(inputTime);
        inputTime = setTimeout(() => {
            // $(this).val(this.value.replace(/[^0-9\.]/g, ""));
            let value = $(this).val();

            const allowedPattern2 = /^[0-9.,]*$/;
            // Check if input is valid
            if (value && !allowedPattern2.test(value)) {
                // Formatting with commas (replace with your preferred method)
                $(this).addClass("invalid-pattern");
            }else{
                $(this).removeClass("invalid-pattern");
                $(this).val(addCommaToNum(value.replace(/[^0-9\.]/g, "")));
            }
        }, 1000);

        // $(this).val(value);
    });

    $("#tbl-sl-guidelines").on("click", ".btn-edit-sl", function(){
        $(this).parents("tr").addClass("edit-mode");
    });

    $("#tbl-sl-guidelines").on("click", ".btn-save-sl", function(){
        let err = 0;
        let e1 = this; // .btn-save-sl
        let args = {
            id: $(e1).parent().parent().attr("slid"),
            type: $(e1).parent().parent().attr("sltype")
        };
        $(e1).parent().parent().find("input[class*='sl-tc-'], input[class*='sl-ccr-']").each(function(){
            // $(this).val(this.value.replace(/[^0-9.,]/g, ""));
            let e2 = this; // input[class*='sl-tc-'], input[class*='sl-ccr-']
            let value = $(e2).val();
            const allowedPattern = /^\d+(\,?\d{3})*(?:\.\d*)?$|^$/;

            if (value && !allowedPattern.test(value)) {
                err = 1;
                return false;
            }

            let slpercent = (this.className.match(/(\b(sl-(tc|ccr)-\d+)\b)/g) ?? []).join('').replace(/^sl-(tc|ccr)-(\d+)/g, '$1$2');

            args[slpercent] = value.replace(/[^0-9\.]/g, "");

            $(e2).parent().find("span").text(addCommaToNum(args[slpercent]));
        });

        if($(e1).parent().parent().find("input[class*='sl-tc-'], input[class*='sl-ccr-']").length == 0 || err == 1) return;

        postRequest('save/sl-guidelines', args)
        .then(response => response.json())
        .then(response => {
            if(response.status == 1){
                $(e1).parent().parent().attr("slid", response.id);
                $(this).parents("tr").removeClass("edit-mode");
            }else{
                alert("Failed to save. Please try again.");
            }
        })
        .catch(error => {
            console.log("Error: "+error);
        });
    });
});

function getUserMap() {
    $("#tblumap").html("Loading...");
    getRequest('get/usermap-list')
    .then(response => response.text())
    .then(response => $("#tblumap").html(response))
    .catch(error => {
        console.log("Error: "+error);
    });
}

function getSLGuidelines() {
    $("#tbl-sl-guidelines").html("Loading...");
    getRequest('get/sl-guidelines')
    .then(response => response.text())
    .then(response => $("#tbl-sl-guidelines").html(response))
    .catch(error => {
        console.log("Error: "+error);
    });
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