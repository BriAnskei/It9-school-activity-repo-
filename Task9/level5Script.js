let coins = 0;

const coinDisplay = document.getElementById("coinDisplay");
const increaseBtn = document.getElementById("increaseBtn");
const decreaseBtn = document.getElementById("decreaseBtn");

increaseBtn.addEventListener("click", () => {
  coins++;
  coinDisplay.textContent = coins;
});

decreaseBtn.addEventListener("click", () => {
  if (coins > 0) {
    coins--;
    coinDisplay.textContent = coins;
  }
});
