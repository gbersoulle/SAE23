window.addEventListener("DOMContentLoaded", function() {
    var next = document.getElementById("next");
    var homepage = document.querySelector(".homepage");
    var content = document.querySelector(".content");
  
    next.addEventListener("click", function() {
      homepage.classList.add("active");
      content.classList.add("active");
      next.style.display = "none";

    });
  });

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