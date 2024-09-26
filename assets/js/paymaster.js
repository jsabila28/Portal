$(document).ready(function() {
  $("#GeneratePaymaster").click(function() {
    $("#preloader").show(); // Show preloader before request

    $.ajax({
      type: "POST",
      url: "get_paymaster",
      success: function(response) {
        $("#paymaster_data").html(response);
        $("#preloader").hide(); // Hide preloader after success
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#preloader").hide(); // Hide preloader on error
        // Handle errors (optional)
        console.error("Error:", textStatus, errorThrown);
      }
    });
  });

  $("#GenerateTarget").click(function() {
    $("#preloader2").show(); // Show preloader before request
  
    $.ajax({
      type: "POST",
      url: "get_target",
      success: function(response) {
        $("#target_data").html(response);
        $("#preloader2").hide(); // Hide preloader after success
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#preloader2").hide(); // Hide preloader on error
        // Handle errors (optional)
        console.error("Error:", textStatus, errorThrown);
      }
    });
  });

  $("#TotalPI").click(function() {
    $("#preloader3").show(); // Show preloader before request
                                            
    $.ajax({
      type: "POST",
      url: "get_target",
      success: function(response) {
        $("#target_data").html(response);
        $("#preloader3").hide(); // Hide preloader after success
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#preloader3").hide(); // Hide preloader on error
        // Handle errors (optional)
        console.error("Error:", textStatus, errorThrown);
      }
    });
  });
});