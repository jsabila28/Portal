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
$(document).ready(function () {
   fetchAndDisplay('phoneAgree', 'phone-agreement');
   fetchAndDisplay('globe_pa', 'globe_agr');
   fetchAndDisplay('smart_pa', 'smart_agr');
   fetchAndDisplay('sun_agr', 'sun_agr');
   fetchAndDisplay('gcash_agr', 'gcash_agr');
   fetchAndDisplay('maya_agr', 'maya_agr');
   fetchAndDisplay('sign_agr', 'sign_agr');
   fetchAndDisplay('release_agr', 'release_agr');
   fetchAndDisplay('issued_agr', 'issued_agr');
   fetchAndDisplay('returned_agr', 'returned_agr');
   fetchAndDisplay('phoneSet', 'phone-setting');
   fetchAndDisplay('phoneMobile', 'mobile-account');
});

// fetchAndDisplay('phoneAgree', 'phone-agreement');
// fetchAndDisplay('globe_pa', 'globe_agr');
// fetchAndDisplay('smart_pa', 'smart_agr');
// fetchAndDisplay('smart_pa', 'sun_agr');
// fetchAndDisplay('smart_pa', 'gcash_agr');
// fetchAndDisplay('smart_pa', 'maya_agr');
// fetchAndDisplay('smart_pa', 'sign_agr');
// fetchAndDisplay('smart_pa', 'release_agr');
// fetchAndDisplay('smart_pa', 'issued_agr');
// fetchAndDisplay('smart_pa', 'returned_agr');
// fetchAndDisplay('phoneSet', 'phone-setting');
// fetchAndDisplay('phoneMobile', 'mobile-account');
