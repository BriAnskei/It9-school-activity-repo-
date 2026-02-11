const submitBtn = document.getElementById("submitBtn");
const nameInput = document.getElementById("nameInput");
const message = document.getElementById("message");

submitBtn.addEventListener("click", () => {
  console.log("dsfsdf");

  const name = nameInput.value.trim();

  if (name === "") {
    // ❌ Error message
    message.innerHTML =
      '<div class="alert alert-danger">Name is required.</div>';
  } else {
    // ✅ Success message with name
    message.innerHTML = `<div class="alert alert-success">Success! Hello, ${name} 👋</div>`;
  }
});
