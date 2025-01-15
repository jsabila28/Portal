document.addEventListener("DOMContentLoaded", function () {
    const dataContainer = document.getElementById("globe_agr");

    fetch("globe_pa")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then((data) => {
            dataContainer.innerHTML = data;
        })
        .catch((error) => {
            dataContainer.innerHTML = "Error loading data.";
            console.error("There was a problem with the fetch operation:", error);
        });
});
