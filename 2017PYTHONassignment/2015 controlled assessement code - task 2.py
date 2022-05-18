import random
import json

while True:
    score = 0
    name = ""
    
    while len(name) > 20 or len(name) < 1:
        name = input("Please enter you name (Under 20 letters) : ")

    validClass = False
    while validClass == False:
        try:
            classV = int(input("What class are you in? 1,2,3  : "))
            validClass = True
        except ValueError as e:
            print("Please enter a number")

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

    nameL = [name]
    class1 = []
    class2 = []
    class3 = []

    if classV == 1:
        nameL.append(score)
        class1.append(nameL)
        f = open("Class1.txt","a+")
        json.dump(class1,f)
        f.write("\n")
        f.close()
        
    elif classV == 2:
        nameL.append(score)
        class2.append(nameL)
        f = open("Class2.txt","a+")
        json.dump(class2,f)
        f.write("\n")
        f.close()
        
    elif classV == 3:
        nameL.append(score)
        class3.append(nameL)
        f = open("Class3.txt","a+")
        json.dump(class3,f)
        f.write("\n")
        f.close()
        
    print("Class 1 : ",class1)
    print("Class 2 : ",class2)
    print("Class 3 : ",class3)















