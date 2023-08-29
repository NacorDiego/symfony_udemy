document.addEventListener("DOMContentLoaded", function () {
  const name = document.getElementById("game_form_upload_name");
  const errors = document.getElementById("errorsjs");
  name.focus();
  name.addEventListener("blur", function () {
    const nameValue = name.value.trim();

    if (nameValue === null || nameValue === "") {
      errors.innerHTML += "<li>El campo de nombre no puede estar vacío</li>";
      name.classList.add("is-invalid");
    } else {
      errors.innerHTML = "";
      name.classList.remove("is-invalid");
    }
  });
});
