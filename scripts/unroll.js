function togglePanel(panel) {
  if (panel.style.maxHeight == panel.scrollHeight + "px") {
    panel.style.maxHeight = null;
  } else {
    panel.style.maxHeight = panel.scrollHeight + "px";
  }
  panel.scrollIntoView({ behavior: 'smooth' });
}
