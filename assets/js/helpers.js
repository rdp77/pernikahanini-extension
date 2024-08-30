function normalizeHTML(idHTML, dataForm) {
  let selectorById = document.getElementById(idHTML);

  if (!selectorById) {
    console.error(`Elemen dengan ID '${idHTML}' tidak ditemukan.`);
    return null;
  }

  let attributeData = selectorById.getAttribute(dataForm);

  if (!attributeData) {
    console.error(
      `Atribut '${dataForm}' tidak ditemukan pada elemen dengan ID '${idHTML}'.`
    );
    return null;
  }

  try {
    let getData = JSON.parse(attributeData);
    return getData;
  } catch (e) {
    console.error(
      `Error parsing JSON dari atribut '${dataForm}': ${e.message}`
    );
    return null;
  }
}
