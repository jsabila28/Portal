function fetchModules() {
  fetch('access?method=GetModules') // Adjust URL as per your application's endpoint
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      const moduleTableBody = document.getElementById('moduleBody');
      moduleTableBody.innerHTML = '';

      data.forEach(module => {
        let newRow = `<tr>
                      <td>${module.module_name}</td>
                      <td>${module.module_code}</td>
                      <td>
                        <button class="btn btn-primary btn-mini"><i class="ti-pencil"></i></button>
                        <button class="btn btn-danger btn-mini"><i class="ti-close"></i></button>
                      </td>
                      </tr>`;
        moduleTableBody.innerHTML += newRow;
      });
    })
    .catch(error => {
      console.error('Error fetching data:', error);
    });
}

fetchModules();
