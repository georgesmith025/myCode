//All code written by George Smith

//Functions
function incorrectOne() {
  var p = document.getElementById('buttonsQ3');
  p.className = "redBackground";
}
  
function correctOne() {
  var p = document.getElementById('buttonsQ3');
  p.className = "greenBackground";
}

function clear() {
  var p = document.getElementById('buttonsQ3');
  p.className = "clearBackground";
}

//Buttons

//Incorrect
var incorrect = document.getElementById('button_ruby');
incorrect.addEventListener('click', incorrectOne, false);
  
incorrect = document.getElementById('button_java');
incorrect.addEventListener('click', incorrectOne, false);
  
//Correct
correct = document.getElementById('button_web');
correct.addEventListener('click', correctOne, false);

//Clear
clearButton = document.getElementById('button_clearQ3');
clearButton.addEventListener('click', clear, false);