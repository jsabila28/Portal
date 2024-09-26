function openSystem(evt, systemName) {
     var i, tabcontent, tablinks;
     tabcontent = document.getElementsByClassName("tabcontent");
     for (i = 0; i < tabcontent.length; i++) {
       tabcontent[i].style.display = "none";
     }
     tablinks = document.getElementsByClassName("tablinks");
     for (i = 0; i < tablinks.length; i++) {
       tablinks[i].className = tablinks[i].className.replace(" active", "");
     }
     document.getElementById(systemName).style.display = "block";
     evt.currentTarget.className += " active";
}


                                    
document.getElementById("defaultOpen").click();
                                    
 function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}


function submitForm() {
    const form = document.getElementById('systemForm');
    const formData = new FormData(form);
    
    fetch('system', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        form.reset();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

document.getElementById('saveButton').addEventListener('click', function (event) {
    event.preventDefault();
    saveModule();
    saveModule();
    saveGrpRole();
});

// function saveModule() {
//     const moduleform = document.getElementById('moduleForm');
//     const formModule = new FormData(moduleform);
    
//     fetch('module', {
//         method: 'POST',
//         body: formModule
//     })
//     .then(response => response.text())
//     .then(data => {
//         alert(data);
//         moduleform.reset();
//     })
//     .catch(error => {
//         console.error('Error:', error);
//     });
// }
function saveModule(button) {
    var form = button.closest('.modal-content').querySelector('form');

    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "module", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Module added successfully!");
            form.reset();
        }
    };
    xhr.send(formData);
}

function saveIndvRole(button) {
    var form = button.closest('.modal-content').querySelector('form');

    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "indvRole", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Individual Role added successfully!");
            form.reset();
        }
    };
    xhr.send(formData);
}

function saveGrpRole(button) {
    var form = button.closest('.modal-content').querySelector('form');

    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "grpRole", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Group Role added successfully!");
            form.reset();
        }
    };
    xhr.send(formData);
}

function saveUserAccess(button) {
    var form = button.closest('.modal-content').querySelector('form');

    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "user_access", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Group Role added successfully!");
            form.reset();
        }
    };
    xhr.send(formData);
}

 function saveSystem(button) {
        var form = button.closest('.modal-content').querySelector('form');

        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_system", true); // Ensure the URL points to your PHP script
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert("System updated successfully!");
                form.reset();
            }
        };
        xhr.send(formData);
    }