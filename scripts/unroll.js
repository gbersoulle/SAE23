// function used to display and hide the data of the drop-down menus
function togglePanel(panel) {
  // Check if the current value of 'maxHeight' equal to the current total scroll height of the panel
  if (panel.style.maxHeight == panel.scrollHeight + "px") {

    // If the condition is true, it means the user want to close the menu : set the 'maxHeight' CSS property of the panel to null (0)
    panel.style.maxHeight = null;

    // remove the "active" class of the previous sibling element : .active css isn't applied anymore, arrow point to bottom
        panel.previousElementSibling.classList.remove("active");

  } else {
    // set the 'maxHeight' CSS property of the panel to its total scroll height, display its full content
    panel.style.maxHeight = panel.scrollHeight + "px";

    // Add the "active" class : .active css is applied, arrow points up (animation)
    panel.previousElementSibling.classList.add("active");
  }

  // Scroll the panel into view with smooth behavior
  // This will ensure that the panel is visible to the user after the toggle, with a smooth scrolling effect
  panel.scrollIntoView({ behavior: 'smooth' });
}
