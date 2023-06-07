function togglePanel(panel) {
    if (panel.style.maxHeight == panel.scrollHeight + "px") {
      panel.style.maxHeight = null;
      panel.previousElementSibling.classList.remove("active");
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
      panel.previousElementSibling.classList.add("active");
    }
    panel.scrollIntoView({ behavior: 'smooth' });
  }
  