window.addEventListener("DOMContentLoaded", function() {
    var next = document.getElementById("next");
    var homepage = document.querySelector(".homepage");
    var content = document.querySelector(".content");
    var scroll = document.getElementById("scroll_b");
  
    next.addEventListener("click", function() {
      homepage.classList.add("active");
      content.classList.add("active");
      next.style.display = "none";
      scroll.style.display = "contents";
      scroll.style.left = "0";
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