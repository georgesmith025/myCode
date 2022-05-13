//All code written by George Smith

//Functions
function incorrectOne() {
  var p = document.getElementById('buttonsQ2');
  p.className = "redBackground";
}
  
function correctOne() {
  var p = document.getElementById('buttonsQ2');
  p.className = "greenBackground";
}

function clear() {
  var p = document.getElementById('buttonsQ2');
  p.className = "clearBackground";
}
  
//Buttons

//Incorrect
var incorrect = document.getElementById('button_firth');
incorrect.addEventListener('click', incorrectOne, false);

incorrect = document.getElementById('button_arts');
incorrect.addEventListener('click', incorrectOne, false);

//Correct
var correct = document.getElementById('button_diamond');
correct.addEventListener('click', correctOne, false);

//Clear
var clearButton = document.getElementById('button_clearQ2');
clearButton.addEventListener('click', clear, false);