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
  