import random
score = 0
name = ""

while len(name) > 20 or len(name) < 1:
    name = input("Please enter you name (Under 20 letters) : ")

for i in range(10):
    operationNum = random.randint(1,3)
    if operationNum == 1:
        sign = "+"
    elif operationNum == 2:
        sign = "-"
    elif operationNum == 3:
        sign = "*"
    
    if sign == "*":
        firstNum = random.randint(1,15)
        secondNum = random.randint(1,15)
    elif sign == "+" or sign == "-":
        firstNum = random.randint(1,30)
        secondNum = random.randint(1,30)
        
    if sign == "+":
        answer = firstNum + secondNum
    elif sign == "-":
        answer = firstNum - secondNum   
    elif sign == "*":
        answer = firstNum * secondNum 

    validAnswer = False
    while validAnswer == False:
        sumV = str(i + 1) + ". " + str(firstNum) + "" + sign + "" + str(secondNum) + " = "
        try:
            guess = int(input(sumV))
            validAnswer = True
        except ValueError as e:
            print("Please enter a number")

    if answer == guess:
        print("You got it right!")
        score += 1
        print("You have a score of",score,"\n")
    else:
        print("Sorry, that's wrong")
        print("You have a score of",score,"\n")

print(name,", You scored",score,"/10")
