document.addEventListener("DOMContentLoaded", function () {
  // * Call function on load
  hideElements();
});

// * Function to hide elements
function hideElements() {
  let widgetElement = document.getElementById("elements-selector-data");
  if (widgetElement) {
    let jsonData = widgetElement.getAttribute("data-array");

    // * Parse JSON to array
    let dataArray = JSON.parse(jsonData);

    // * Add "#" to each element
    const idSelectors = dataArray.map((item) => `#${item}`);

    // * Add "display-none" class to each element to hide them
    idSelectors.forEach(function (selector) {
      // * Get element by selector
      let elements = document.querySelectorAll(selector);
      elements.forEach(function (element) {
        element.style.display = "none";
      });
    });
  }
}
