function fetchAndDisplay(url, elementId) {
  fetch(url)
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
      }
      return response.text();
    })
    .then(data => {
      document.getElementById(elementId).innerHTML = data;
    })
    .catch(error => {
      console.error('Error fetching data:', error);
      document.getElementById(elementId).innerHTML = "Error fetching data";
    });
}

fetchAndDisplay('13_a', '_13A');
fetchAndDisplay('posted13_a', '_13Aposted');
fetchAndDisplay('checked13_a', '_13Achecked');
fetchAndDisplay('reviewed13_a', '_13Areviewed');
fetchAndDisplay('issued13_a', '_13Aissued');