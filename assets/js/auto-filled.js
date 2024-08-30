document.addEventListener("DOMContentLoaded", () => {
  // Call function on load
  autoFilledTextForm();
});

function autoFilledTextForm() {
  const filledData = normalizeHTML("element-filled-data", "data-filled-name");
  if (filledData !== "yes") return; // Stop execution if data is not filled

  const textFormData = normalizeHTML("form-filled-data", "data-form-name");
  const textForm = document.getElementById(textFormData);

  if (
    textForm instanceof HTMLInputElement ||
    textForm instanceof HTMLTextAreaElement
  ) {
    const nameData = document.getElementById("dear-name");
    textForm.value = nameData.textContent;
  } else {
    console.error(
      "Elemen dengan ID yang diberikan bukan elemen input atau textarea."
    );
  }
}
