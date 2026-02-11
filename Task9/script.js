// max level
const MAX_LEVEL = 6;

// get saved level or default to 2
let level = parseInt(localStorage.getItem("level")) || 2;

const levelBadge = document.getElementById("levelBadge");
const levelUpBtn = document.getElementById("levelUpBtn");

// function to display level
function updateLevelDisplay() {
  levelBadge.textContent = `Level ${level}`;

  console.log("Current level: " + level);

  // disable button if max level reached
  if (level >= MAX_LEVEL) {
    levelUpBtn.disabled = true;
    levelUpBtn.textContent = "Max Level";
  }
}

// level up click
levelUpBtn.addEventListener("click", () => {
  if (level < MAX_LEVEL) {
    level++;
    localStorage.setItem("level", level);
    updateLevelDisplay();
  }
});

// initialize display on page load
updateLevelDisplay();

// level 4
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
