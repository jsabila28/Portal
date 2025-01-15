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

fetchAndDisplay('13_b', '13B');
fetchAndDisplay('postIR', 'IRposted');
fetchAndDisplay('draftIR', 'IRdraft');
fetchAndDisplay('solvedIR', 'IRsolved');
fetchAndDisplay('explIR', 'IRexplain');