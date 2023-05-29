// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
  // Get all elements with the class "dropdown"
  var dropdowns = document.getElementsByClassName("dropdown");
  
  // Iterate through each dropdown element
  for (var i = 0; i < dropdowns.length; i++) {
    // Add a click event listener to each dropdown
    dropdowns[i].addEventListener("click", function() {
      // Toggle the "active" class on the clicked dropdown
      this.classList.toggle("active");
      
      // Find the dropdown content within the clicked dropdown
      var dropdownContent = this.querySelector(".dropdown-content");
      
      // Toggle the display of the dropdown content
      if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
      } else {
        dropdownContent.style.display = "block";
      }
    });
  }
});
