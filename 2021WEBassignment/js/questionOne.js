//All code written by George Smith

//Functions
function incorrectOne() {
  var p = document.getElementById('buttonsQ1');
  p.className = "redBackground";
}
  
function correctOne() {
  var p = document.getElementById('buttonsQ1');
  p.className = "greenBackground";
}

function clear() {
  var p = document.getElementById('buttonsQ1');
  p.className = "clearBackground";
}
  
//Buttons

//Incorrect
var incorrect = document.getElementById('button_option1');
incorrect.addEventListener('click', incorrectOne, false);

incorrect = document.getElementById('button_option2');
incorrect.addEventListener('click', incorrectOne, false);

incorrect = document.getElementById('button_option3');
incorrect.addEventListener('click', incorrectOne, false);

incorrect = document.getElementById('button_option5');
incorrect.addEventListener('click', incorrectOne, false);

incorrect = document.getElementById('button_option6');
incorrect.addEventListener('click', incorrectOne, false);

incorrect = document.getElementById('button_option7');
incorrect.addEventListener('click', incorrectOne, false);

//Correct
var correct = document.getElementById('button_option4');
correct.addEventListener('click', correctOne, false);

//Clear
var clearButton = document.getElementById('button_clearQ1');
clearButton.addEventListener('click', clear, false);