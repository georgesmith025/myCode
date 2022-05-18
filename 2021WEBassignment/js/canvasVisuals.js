//All code written by George Smith

"use strict";

//Functions

function clearCanvas() {
    context.clearRect(0, 0, WIDTH, HEIGHT);
  }

function drawPieChart() {
    clearCanvas();
    var mobileTimeAngle = 2 * Math.PI * (mobileTimeMinutes/total);
    var exerciseTimeAngle = 2 * Math.PI * (exerciseTimeMinutes/total);

    context.strokeStyle = colour4;

    //Phone screen time colour label
    context.font = "12px Arial";
    context.strokeText("Phone screen", WIDTH/20, HEIGHT/5);
    context.beginPath();
    context.rect(WIDTH*13/40, HEIGHT/5 - 15, 15, 15);
    context.fillStyle = colour1;
    context.fill();

    //Exercise time colour label
    context.font = "12px Arial";
    context.strokeText("Exercise", WIDTH/20, HEIGHT*2/5);
    context.beginPath();
    context.rect(WIDTH*9/40, HEIGHT*2/5 - 15, 15, 15);
    context.fillStyle = colour2;
    context.fill();

    //University work time colour label
    context.font = "12px Arial";
    context.strokeText("University work", WIDTH/20, HEIGHT*3/5);
    context.beginPath();
    context.rect(WIDTH*7/20, HEIGHT*3/5 - 15, 15, 15);
    context.fillStyle = colour3;
    context.fill();

    //Phone screen time segment of pie chart
    context.beginPath();
    context.strokeStyle = colour1;
    context.arc(WIDTH*2/3, HEIGHT/2, WIDTH/5, 0, mobileTimeAngle);
    context.lineTo(WIDTH*2/3, HEIGHT/2);
    context.fillStyle = colour1;
    context.fill();

    //Exercise time segment of pie chart
    context.beginPath();
    context.strokeStyle = colour2;
    context.arc(WIDTH*2/3, HEIGHT/2, WIDTH/5, mobileTimeAngle, mobileTimeAngle + exerciseTimeAngle);
    context.lineTo(WIDTH*2/3, HEIGHT/2);
    context.fillStyle = colour2;
    context.fill();
    
    //University work time segment of pie chart
    context.beginPath();
    context.strokeStyle = colour3;
    context.arc(WIDTH*2/3, HEIGHT/2, WIDTH/5, mobileTimeAngle + exerciseTimeAngle, 0);
    context.lineTo(WIDTH*2/3, HEIGHT/2);
    context.fillStyle = colour3;
    context.fill();

    //Pie chart outline to make segments stand out more
    context.beginPath();
    context.strokeStyle = colour4;
    context.arc(WIDTH*2/3, HEIGHT/2, WIDTH/5, 0, mobileTimeAngle);
    context.lineTo(WIDTH*2/3, HEIGHT/2);
    context.arc(WIDTH*2/3, HEIGHT/2, WIDTH/5, mobileTimeAngle, mobileTimeAngle + exerciseTimeAngle);
    context.lineTo(WIDTH*2/3, HEIGHT/2);
    context.arc(WIDTH*2/3, HEIGHT/2, WIDTH/5, mobileTimeAngle + exerciseTimeAngle, 0);
    context.lineTo(WIDTH*2/3, HEIGHT/2);

    context.stroke();
}

function drawAxis(xLevels,yLevels) {
    //Draws an X and Y axis taking the amount of values on each axis as a variable

    //Distances between values
    xSeparation = xLength/(xLevels-1);
    ySeparation = yLength/(yLevels-1);

    context.beginPath();
    context.strokeStyle = colour4;
    context.moveTo(WIDTH/5, HEIGHT/10);

    //Y axis
    for (var i=0; i<yLevels-1; i++)    {
        context.moveTo(WIDTH/5 - 5, HEIGHT/10 + ySeparation*i)
        context.lineTo(WIDTH/5, HEIGHT/10 + ySeparation*i);
        context.lineTo(WIDTH/5, HEIGHT/10 + ySeparation*(i+1));
    }
    context.moveTo(WIDTH/5 - 5, HEIGHT/10 + ySeparation*(yLevels-1))
    context.lineTo(WIDTH/5, HEIGHT/10 + ySeparation*(yLevels-1));

    //X axis
    for (var i=0; i<xLevels-1; i++)    {
        context.moveTo(WIDTH/5 + xSeparation*i, HEIGHT*8/10 + 5);
        context.lineTo(WIDTH/5 + xSeparation*i, HEIGHT*8/10);
        context.lineTo(WIDTH/5 + xSeparation*(i+1), HEIGHT*8/10);
    }
    context.moveTo(WIDTH/5 + xSeparation*(xLevels-1), HEIGHT*8/10 + 5);
    context.lineTo(WIDTH/5 + xSeparation*(xLevels-1), HEIGHT*8/10);
    
    context.stroke();
}

function drawBarChart() {
    clearCanvas();
    drawAxis(8,9);

    //Y axis values and title
    context.strokeText("Mins", WIDTH/50, HEIGHT/2);
    context.strokeText("0", WIDTH*2/13, HEIGHT/10 + ySeparation*8);
    context.strokeText("50", WIDTH/7, HEIGHT/10 + ySeparation*7);
    context.strokeText("100", WIDTH/8, HEIGHT/10 + ySeparation*6);
    context.strokeText("150", WIDTH/8, HEIGHT/10 + ySeparation*5);
    context.strokeText("200", WIDTH/8, HEIGHT/10 + ySeparation*4);
    context.strokeText("250", WIDTH/8, HEIGHT/10 + ySeparation*3);
    context.strokeText("300", WIDTH/8, HEIGHT/10 + ySeparation*2);
    context.strokeText("350", WIDTH/8, HEIGHT/10 + ySeparation*1);
    context.strokeText("400", WIDTH/8, HEIGHT/10 + ySeparation*0);

    //X axis titles
    context.font = "10px Arial";
    context.strokeText("Mon", WIDTH/5 + xSeparation*0.25, HEIGHT*17/20);
    context.strokeText("Tue", WIDTH/5 + xSeparation*1.25, HEIGHT*17/20);
    context.strokeText("Wed", WIDTH/5 + xSeparation*2.25, HEIGHT*17/20);
    context.strokeText("Thu", WIDTH/5 + xSeparation*3.25, HEIGHT*17/20);
    context.strokeText("Fri", WIDTH/5 + xSeparation*4.25, HEIGHT*17/20);
    context.strokeText("Sat", WIDTH/5 + xSeparation*5.25, HEIGHT*17/20);
    context.strokeText("Sun", WIDTH/5 + xSeparation*6.25, HEIGHT*17/20);

    //Phone screen time bars
    context.beginPath();
    context.strokeStyle = colour1;
    context.rect(WIDTH/5 + xSeparation*0 +1, HEIGHT/10 + yLength*(400-271)/400, xSeparation*1/3 -1, yLength*271/400 -1);
    context.rect(WIDTH/5 + xSeparation*1, HEIGHT/10 + yLength*(400-252)/400, xSeparation*1/3, yLength*252/400 -1);
    context.rect(WIDTH/5 + xSeparation*2, HEIGHT/10 + yLength*(400-326)/400, xSeparation*1/3, yLength*326/400 -1);
    context.rect(WIDTH/5 + xSeparation*3, HEIGHT/10 + yLength*(400-270)/400, xSeparation*1/3, yLength*270/400 -1);
    context.rect(WIDTH/5 + xSeparation*4, HEIGHT/10 + yLength*(400-263)/400, xSeparation*1/3, yLength*263/400 -1);
    context.rect(WIDTH/5 + xSeparation*5, HEIGHT/10 + yLength*(400-193)/400, xSeparation*1/3, yLength*193/400 -1);
    context.rect(WIDTH/5 + xSeparation*6, HEIGHT/10 + yLength*(400-384)/400, xSeparation*1/3, yLength*384/400 -1);
    context.fillStyle = colour1;
    context.fill();

    //Exercise time bars
    context.beginPath();
    context.strokeStyle = colour2;
    context.rect(WIDTH/5 + xSeparation*(1/3+0), HEIGHT/10 + yLength*(400-75)/400, xSeparation*1/3, yLength*75/400 -1);
    context.rect(WIDTH/5 + xSeparation*(1/3+1), HEIGHT/10 + yLength*(400-105)/400, xSeparation*1/3, yLength*105/400 -1);
    context.rect(WIDTH/5 + xSeparation*(1/3+2), HEIGHT/10 + yLength*(400-45)/400, xSeparation*1/3, yLength*45/400 -1);
    context.rect(WIDTH/5 + xSeparation*(1/3+3), HEIGHT/10 + yLength*(400-120)/400, xSeparation*1/3, yLength*120/400 -1);
    context.rect(WIDTH/5 + xSeparation*(1/3+4), HEIGHT/10 + yLength*(400-135)/400, xSeparation*1/3, yLength*135/400 -1);
    context.rect(WIDTH/5 + xSeparation*(1/3+5), HEIGHT/10 + yLength*(400-210)/400, xSeparation*1/3, yLength*210/400 -1);
    context.rect(WIDTH/5 + xSeparation*(1/3+6), HEIGHT/10 + yLength*(400-20)/400, xSeparation*1/3, yLength*20/400 -1);
    context.fillStyle = colour2;
    context.fill();

    //University work time bars
    context.beginPath();
    context.strokeStyle = colour3;
    context.rect(WIDTH/5 + xSeparation*(2/3+0), HEIGHT/10 + yLength*(400-120)/400, xSeparation*1/3, yLength*120/400 -1);
    context.rect(WIDTH/5 + xSeparation*(2/3+1), HEIGHT/10 + yLength*(400-135)/400, xSeparation*1/3, yLength*135/400 -1);
    context.rect(WIDTH/5 + xSeparation*(2/3+2), HEIGHT/10 + yLength*(400-210)/400, xSeparation*1/3, yLength*210/400 -1);
    context.rect(WIDTH/5 + xSeparation*(2/3+3), HEIGHT/10 + yLength*(400-240)/400, xSeparation*1/3, yLength*240/400 -1);
    context.rect(WIDTH/5 + xSeparation*(2/3+4), HEIGHT/10 + yLength*(400-180)/400, xSeparation*1/3, yLength*180/400 -1);
    context.rect(WIDTH/5 + xSeparation*(2/3+5), HEIGHT/10 + yLength*(400-255)/400, xSeparation*1/3, yLength*255/400 -1);
    context.rect(WIDTH/5 + xSeparation*(2/3+6), HEIGHT/10 + yLength*(400-120)/400, xSeparation*1/3, yLength*120/400 -1);
    context.fillStyle = colour3;
    context.fill();

    //Phone screen time colour label
    context.strokeStyle = colour4;
    context.font = "10px Arial";
    context.strokeText("Phone screen", WIDTH*1/24, HEIGHT*39/40);
    context.beginPath();
    context.strokeStyle = colour1;
    context.rect(WIDTH*7/24, HEIGHT*39/40 - 10, 10, 10);
    context.fillStyle = colour1;
    context.fill();

    //Exercise time colour label
    context.strokeStyle = colour4;
    context.strokeText("Exercise", WIDTH*9/24, HEIGHT*39/40);
    context.beginPath();
    context.strokeStyle = colour2;
    context.rect(WIDTH*13/24, HEIGHT*39/40 - 10, 10, 10);
    context.fillStyle = colour2;
    context.fill();

    //University work time colour label
    context.strokeStyle = colour4;
    context.strokeText("University work", WIDTH*16/24, HEIGHT*39/40);
    context.beginPath();
    context.strokeStyle = colour3;
    context.rect(WIDTH*22/24, HEIGHT*39/40 - 10, 10, 10);
    context.fillStyle = colour3;
    context.fill();

    context.stroke();
}

function drawLineGraph() {
    clearCanvas();
    drawAxis(8,9);

    //Y axis values and title
    context.strokeText("Mins", WIDTH/50, HEIGHT/2);
    context.strokeText("0", WIDTH*2/13, HEIGHT/10 + ySeparation*8);
    context.strokeText("50", WIDTH/7, HEIGHT/10 + ySeparation*7);
    context.strokeText("100", WIDTH/8, HEIGHT/10 + ySeparation*6);
    context.strokeText("150", WIDTH/8, HEIGHT/10 + ySeparation*5);
    context.strokeText("200", WIDTH/8, HEIGHT/10 + ySeparation*4);
    context.strokeText("250", WIDTH/8, HEIGHT/10 + ySeparation*3);
    context.strokeText("300", WIDTH/8, HEIGHT/10 + ySeparation*2);
    context.strokeText("350", WIDTH/8, HEIGHT/10 + ySeparation*1);
    context.strokeText("400", WIDTH/8, HEIGHT/10 + ySeparation*0);

    //X axis titles
    context.font = "10px Arial";
    context.strokeText("Mon", WIDTH/5 + xSeparation*0.6, HEIGHT*9/10);
    context.strokeText("Tue", WIDTH/5 + xSeparation*1.7, HEIGHT*9/10);
    context.strokeText("Wed", WIDTH/5 + xSeparation*2.6, HEIGHT*9/10);
    context.strokeText("Thu", WIDTH/5 + xSeparation*3.6, HEIGHT*9/10);
    context.strokeText("Fri", WIDTH/5 + xSeparation*4.7, HEIGHT*9/10);
    context.strokeText("Sat", WIDTH/5 + xSeparation*5.6, HEIGHT*9/10);
    context.strokeText("Sun", WIDTH/5 + xSeparation*6.7, HEIGHT*9/10);

    //Phone screen time line 
    context.beginPath();
    context.strokeStyle = colour1;
    context.moveTo(WIDTH/5 +1, HEIGHT*8/10 -1);
    context.lineTo(WIDTH/5 + xSeparation*1, HEIGHT/10 + yLength*(400-271)/400);
    context.lineTo(WIDTH/5 + xSeparation*2, HEIGHT/10 + yLength*(400-252)/400);
    context.lineTo(WIDTH/5 + xSeparation*3, HEIGHT/10 + yLength*(400-326)/400);
    context.lineTo(WIDTH/5 + xSeparation*4, HEIGHT/10 + yLength*(400-270)/400);
    context.lineTo(WIDTH/5 + xSeparation*5, HEIGHT/10 + yLength*(400-263)/400);
    context.lineTo(WIDTH/5 + xSeparation*6, HEIGHT/10 + yLength*(400-193)/400);
    context.lineTo(WIDTH/5 + xSeparation*7, HEIGHT/10 + yLength*(400-384)/400);
    context.stroke();

    //Exercise time line
    context.beginPath();
    context.strokeStyle = colour2;
    context.moveTo(WIDTH/5 +1, HEIGHT*8/10 -1);
    context.lineTo(WIDTH/5 + xSeparation*1, HEIGHT/10 + yLength*(400-75)/400);
    context.lineTo(WIDTH/5 + xSeparation*2, HEIGHT/10 + yLength*(400-105)/400);
    context.lineTo(WIDTH/5 + xSeparation*3, HEIGHT/10 + yLength*(400-45)/400);
    context.lineTo(WIDTH/5 + xSeparation*4, HEIGHT/10 + yLength*(400-120)/400);
    context.lineTo(WIDTH/5 + xSeparation*5, HEIGHT/10 + yLength*(400-135)/400);
    context.lineTo(WIDTH/5 + xSeparation*6, HEIGHT/10 + yLength*(400-210)/400);
    context.lineTo(WIDTH/5 + xSeparation*7, HEIGHT/10 + yLength*(400-20)/400);
    context.stroke();

    //University work time line
    context.beginPath();
    context.strokeStyle = colour3;
    context.moveTo(WIDTH/5 +1, HEIGHT*8/10 -1);
    context.lineTo(WIDTH/5 + xSeparation*1, HEIGHT/10 + yLength*(400-120)/400);
    context.lineTo(WIDTH/5 + xSeparation*2, HEIGHT/10 + yLength*(400-135)/400);
    context.lineTo(WIDTH/5 + xSeparation*3, HEIGHT/10 + yLength*(400-210)/400);
    context.lineTo(WIDTH/5 + xSeparation*4, HEIGHT/10 + yLength*(400-240)/400);
    context.lineTo(WIDTH/5 + xSeparation*5, HEIGHT/10 + yLength*(400-180)/400);
    context.lineTo(WIDTH/5 + xSeparation*6, HEIGHT/10 + yLength*(400-255)/400);
    context.lineTo(WIDTH/5 + xSeparation*7, HEIGHT/10 + yLength*(400-120)/400);
    context.stroke();

    //Phone screen time colour label
    context.strokeStyle = colour4;
    context.font = "10px Arial";
    context.strokeText("Phone screen", WIDTH*1/24, HEIGHT*39/40);
    context.beginPath();
    context.strokeStyle = colour1;
    context.rect(WIDTH*7/24, HEIGHT*39/40 - 10, 10, 10);
    context.fillStyle = colour1;
    context.fill();

    //Exercise time colour label
    context.strokeStyle = colour4;
    context.strokeText("Exercise", WIDTH*9/24, HEIGHT*39/40);
    context.beginPath();
    context.strokeStyle = colour2;
    context.rect(WIDTH*13/24, HEIGHT*39/40 - 10, 10, 10);
    context.fillStyle = colour2;
    context.fill();

    //University work time colour label
    context.strokeStyle = colour4;
    context.strokeText("University work", WIDTH*16/24, HEIGHT*39/40);
    context.beginPath();
    context.strokeStyle = colour3;
    context.rect(WIDTH*22/24, HEIGHT*39/40 - 10, 10, 10);
    context.fillStyle = colour3;
    context.fill();

    context.stroke();
}

//Colour scheme functions
function changeColour1() {
    colour1 = "red";
    colour2 = "yellow";
    colour3 = "orange";
}

function changeColour2() {
    colour1 = "Blue";
    colour2 = "Purple";
    colour3 = "Green";
}

function changeColour3() {
    colour1 = "Black";
    colour2 = "Gray";
    colour3 = "White";
}


//Main code


var canvas = document.getElementById('canvas_dataVisual');
var context = canvas.getContext('2d');
const WIDTH = canvas.width;
const HEIGHT = canvas.height;

//Colour scheme
var colour1 = "red";
var colour2 = "yellow";
var colour3 = "orange";
//Text and outline colours
var colour4 = "black";

//Length of each axis
var yLength = HEIGHT*7/10;
var xLength = WIDTH*7/10;
//Distance between each value on the axis
var ySeparation;
var xSeparation;
//Amound of values on each axis
var yLevels;
var xLevels;

//Time spent per activity in 1 week
var mobileTimeMinutes = 1959;
var exerciseTimeMinutes = 710;
var universityTimeMinutes = 1260;
var total = mobileTimeMinutes + exerciseTimeMinutes + universityTimeMinutes;

//Buttons
var button_pieChart = document.getElementById("button_pieChart");
var button_barGraph = document.getElementById("button_barGraph");
var button_lineGraph = document.getElementById("button_lineGraph");
var button_colourScheme1 = document.getElementById("button_colourScheme1");
var button_colourScheme2 = document.getElementById("button_colourScheme2");
var button_colourScheme3 = document.getElementById("button_colourScheme3");

//Buttons clicked events
button_pieChart.addEventListener("click", drawPieChart);
button_barGraph.addEventListener("click", drawBarChart);
button_lineGraph.addEventListener("click", drawLineGraph);
button_colourScheme1.addEventListener("click", changeColour1);
button_colourScheme2.addEventListener("click", changeColour2);
button_colourScheme3.addEventListener("click", changeColour3);