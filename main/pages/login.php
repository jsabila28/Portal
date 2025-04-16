<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        @font-face {
            font-family: "MyCustomFont";
            src: url("assets/fonts/Comfortaa-Regular.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Facebook Letter Faces';
            src: url('assets/fonts/Fonts/Facebook_Letter_Faces/FACEBOLF.OTF') format('truetype');
            font-weight: 500;
            font-style: normal;
        }
        input {
          font-family: "MyCustomFont", sans-serif;
        }

        body {
            font-family: "Facebook Letter Faces", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 900px;
            margin-bottom: 200px;
            /*background: white;*/
            /*border-radius: 10px;*/
            overflow: hidden;
            /*box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);*/
        }

        .logo-section, .form-section {
            padding : 50px;
        }
        .logo-section {
            /*background: #0073e6;*/
            color: #64402f;
            /*display: flex;*/
            justify-content: center;
            align-items: center;
            width: 40%;
            text-align: center;
            padding-left: 50px;
            padding-right: 50px;
            padding-top: 20px;
            padding-bottom: 50px;
        }

        .logo-section h1 {
            font-size: 3rem;
        }

        .form-section {
            width: 60%;
            align-content: center;
            text-align: center;
        }

        .form-section h2 {
            margin-bottom: 20px;
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            background: #0073e6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #005bb5;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .logo-section, .form-section {
                width: 100%;
                padding: 30px;
            }
            .logo-section h1 {
                font-size: 2rem;
            }
        }
        .input-field {
          max-width: 380px;
          width: 100%;
          background-color: #f0f0f0;
          margin: 10px 0;
          height: 55px;
          border-radius: 55px;
          display: grid;
          grid-template-columns: 15% 85%;
          padding: 0 0.4rem;
          position: relative;
        }
        
        .input-field i {
          text-align: center;
          line-height: 55px;
          color: #acacac;
          transition: 0.5s;
          font-size: 1.1rem;
        }
        
        .input-field input {
          background: none;
          outline: none;
          border: none;
          line-height: 1;
          font-weight: 600;
          font-size: 1.1rem;
          color: #333;
          padding: 10px;
        }
        
        .input-field input::placeholder {
          /*color: #aaa;*/
          font-weight: 500;
        }
        .btn {
          width: 150px;
          background-color: #5995fd;
          border: none;
          outline: none;
          height: 49px;
          border-radius: 49px;
          color: #fff;
          text-transform: uppercase;
          font-weight: 600;
          margin: 10px 0;
          cursor: pointer;
          transition: 0.5s;
        }
        
        .btn:hover {
          background-color: #4d84e2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-section">
            <img src="https://teamtngc.com/zen/assets/img/coffi.png">
            <h2>Zenhub</h2>
            <p>Your Daily Dose of Energy & Inspiration.</p>
        </div>
        <div class="form-section">
            <form  action="" method="post" id="loginForm" class="sign-in-form">
                <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" class="form-control form-control-sm" name="username" id="username" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" class="form-control form-control-sm" name="password" id="password" placeholder="Password" />
            </div>
            <input type="submit" name="submit" value="Login" class="btn btn-sm btn-block login" />
            <div id="alertPlaceholder"></div>
            </form>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        
        $.ajax({
            url: 'signIn',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log('Server response:', response); // Debugging line

                try {
                    let result = typeof response === 'string' ? JSON.parse(response) : response;

                    if (result.success) {
                        showAlert(result.message, 'success');
                        setTimeout(function() {
                            window.location.href = '/Portal/dashboard';
                        }, 2000); // Redirect after 2 seconds
                    } else {
                        showAlert('Login failed: ' + result.message, 'danger');
                    }
                } catch (e) {
                    showAlert('An error occurred while processing the response.', 'danger');
                    console.error('Error parsing JSON:', e);
                }
            },
            error: function(xhr, status, error) {
                showAlert('An error occurred: ' + error, 'danger');
                console.error('AJAX error:', xhr, status, error);
            }
        });
    });
});
function showAlert(message, type) {
    let alertBox = $(`
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `);

    $('#alertPlaceholder').html(alertBox);

    // Ensure the alert can be dismissed automatically after 3 seconds
    setTimeout(function() {
        alertBox.alert('close');
    }, 1000); // Auto-dismiss after 3 seconds
}


function password_show_hide() {
  var x = document.getElementById("password");
  var show_eye = document.getElementById("show_eye");
  var hide_eye = document.getElementById("hide_eye");
  hide_eye.classList.remove("d-none");
  if (x.type === "password") {
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } else {
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  }
}
</script>

<link rel="stylesheet" type="text/css" href="src/plugins/sweetalert2/sweetalert2.css"/>
<script src="src/plugins/sweetalert2/sweet-alert.init.js"></script>
<script src="app.js"></script>
</body>
</html>