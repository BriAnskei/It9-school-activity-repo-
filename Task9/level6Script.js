const correctDoor = Math.floor(Math.random() * 3) + 1;

const resultMessage = document.getElementById("resultMessage");

function checkDoor(doorNumber) {
  if (doorNumber === correctDoor) {
    resultMessage.textContent = "Congrats! You chose the right door!";
    resultMessage.className = "text-success";
  } else {
    resultMessage.textContent = "Wrong door! Try again or restart.";
    resultMessage.className = "text-danger";
  }
}

document.getElementById("door1").addEventListener("click", () => checkDoor(1));
document.getElementById("door2").addEventListener("click", () => checkDoor(2));
document.getElementById("door3").addEventListener("click", () => checkDoor(3));
