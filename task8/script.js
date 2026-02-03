const display = document.getElementById("display");

let currentValue = "0";
let previousValue = "";
let operator = "";
let shouldResetDisplay = false;

function updateDisplay() {
  display.textContent = currentValue;
}

function appendNumber(num) {
  if (shouldResetDisplay) {
    currentValue = num;
    shouldResetDisplay = false;
  } else {
    if (currentValue === "0" && num !== ".") {
      currentValue = num;
    } else if (num === "." && currentValue.includes(".")) {
      return;
    } else {
      currentValue += num;
    }
  }
  updateDisplay();
}

function appendOperator(op) {
  if (operator && !shouldResetDisplay) {
    calculate();
  }
  previousValue = currentValue;
  operator = op;
  shouldResetDisplay = true;
}

function calculate() {
  if (!operator || shouldResetDisplay) return;

  const prev = parseFloat(previousValue);
  const current = parseFloat(currentValue);
  let result;

  switch (operator) {
    case "+":
      result = prev + current;
      break;
    case "-":
      result = prev - current;
      break;
    case "*":
      result = prev * current;
      break;
    case "/":
      result = current !== 0 ? prev / current : "Error";
      break;
    default:
      return;
  }

  currentValue = result.toString();
  operator = "";
  previousValue = "";
  shouldResetDisplay = true;
  updateDisplay();
}

function clearDisplay() {
  currentValue = "0";
  previousValue = "";
  operator = "";
  shouldResetDisplay = false;
  updateDisplay();
}

function deleteLast() {
  currentValue = currentValue.length > 1 ? currentValue.slice(0, -1) : "0";
  updateDisplay();
}

// Keyboard support
document.addEventListener("keydown", (event) => {
  if ((event.key >= "0" && event.key <= "9") || event.key === ".") {
    appendNumber(event.key);
  } else if ("+-*/".includes(event.key)) {
    appendOperator(event.key);
  } else if (event.key === "Enter" || event.key === "=") {
    calculate();
  } else if (event.key.toLowerCase() === "c" || event.key === "Escape") {
    clearDisplay();
  } else if (event.key === "Backspace") {
    deleteLast();
  }
});
