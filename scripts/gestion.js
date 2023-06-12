window.addEventListener("DOMContentLoaded", function() {
    var filterButton = document.getElementById("filterButton");
    var gestionFieldset = document.getElementById("gestion");
  
    filterButton.addEventListener("click", function() {
        if (gestionFieldset.style.display === "none") {
            gestionFieldset.style.display = "block";
        } else {
            gestionFieldset.style.display = "none";
        }
    });
  });