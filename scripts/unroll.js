// function used to display and hide the data of the drop-down menus
function togglePanel(panel) {
  // Check if the current value of 'maxHeight' is equal to the current total scroll height of the panel
  if (panel.previousElementSibling.classList.contains("active")) {
    // If the condition is true, it means the user wants to close the menu: set the 'maxHeight' CSS property of the panel to null (0)
    panel.style.maxHeight = null;
    // remove the "active" class from the previous sibling element: .active CSS isn't applied anymore, arrow points to bottom
    panel.previousElementSibling.classList.remove("active");
  } else {
    // set the 'maxHeight' CSS property of the panel to its total scroll height, display its full content
    panel.style.maxHeight = panel.scrollHeight + "px";
    // Add the "active" class: .active CSS is applied, arrow points up (animation)
    panel.previousElementSibling.classList.add("active");
  }
}

function expand(panel) {
  // set the 'maxHeight' CSS property of the panel to its total scroll height, display its full content
  panel.style.maxHeight = panel.scrollHeight + "px";
}

// Opens the menu you clicked on, rolls up every other building menu
function Show_And_Hide(panel) {
  // Get all elements with the class "accordion"
  var accordions = document.getElementsByClassName('accordion');

  // Loop through each accordion element
  for (var i = 0; i < accordions.length; i++) {
    var accordion = accordions[i];
    var panelToToggle = accordion.nextElementSibling;

    // Check if the current accordion is the one being executed
    if (accordion === panel.previousElementSibling) {
      // Toggle the visibility of the panel associated with the clicked button
      togglePanel(panelToToggle);
    } else if (accordion.classList.contains("active")) {
      // Roll up the panel for all other accordions
      togglePanel(panelToToggle);
    }
  }
}
