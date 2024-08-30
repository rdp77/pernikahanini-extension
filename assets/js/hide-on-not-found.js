document.addEventListener("DOMContentLoaded", function () {
  // * Call function on load
  hideOnNotFound();
});

// * Function to hide elements
function hideOnNotFound() {
  const isHiddenNotFound = normalizeHTML(
    "element-is-hidden-not-found",
    "data-is-hidden-not-found"
  );
  let widgetElement = document.getElementById("dear-name");
  if (
    isHiddenNotFound === "yes" &&
    widgetElement &&
    widgetElement.textContent === "No data found."
  ) {
    widgetElement.style.display = "none";
  }
}
