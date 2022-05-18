import turtle
turtle.shape("turtle")
turtle.speed(0)

length = 400

def square(length):
    for i in range(4):
        turtle.fd(length)
        turtle.rt(90)

def rectangle(length,width):
    for i in range(2):
        turtle.fd(length)
        turtle.rt(90)
        turtle.fd(width)
        turtle.rt(90)

def laptop(length):
    rectangle(length,length/1.5)
    turtle.fd(length/13)
    rectangle(length/13,length/14)
    turtle.fd(length/13*10)
    rectangle(length/13,length/14)
    turtle.fd(length/13*2)
    turtle.bk(length-length/13)
    turtle.lt(90)
    turtle.fd(length/30)
    turtle.lt(90)
    turtle.fd(length/13)
    turtle.rt(90)
    turtle.fd(length/1.5)
    turtle.rt(90)
    rectangle(length,length/1.5)
    turtle.fd(length/26)
    turtle.penup()
    turtle.rt(90)
    turtle.fd(length/26)
    turtle.lt(90)
    turtle.pendown()
    turtle.fillcolor("black")
    turtle.begin_fill()
    rectangle(length-length/13,length/1.5-length/13)
    turtle.end_fill()
    turtle.fd(length-length/13)
    turtle.rt(90)
    turtle.fd(length/1.5-length/13)
    turtle.penup()
    turtle.fd(length/26)
    turtle.rt(90)
    turtle.fd(length/26)
    turtle.pendown()
    turtle.lt(90)
    turtle.fd(length/30)
    turtle.rt(90)
    turtle.fd(length-length/13)
    turtle.lt(90)
    turtle.fd(length/13+length/26)
    turtle.lt(90)
    turtle.penup()
    turtle.fd(length/13-length/26/2)
    turtle.pendown()
    rectangle(length/13,length/13/3)
    turtle.penup()
    turtle.bk(length/13-length/26/2)
    turtle.pendown()
    turtle.rt(90)
    turtle.fd(length/13)
    turtle.lt(90)
    turtle.penup()
    turtle.fd(length/13-length/26/2)
    turtle.pendown()
    
    KBW = (length-length/13*3)/3
    KBL = length-2*(length/13-length/26/2)
    turtle.begin_fill()
    rectangle(KBL,KBW)
    
    turtle.end_fill()
    turtle.rt(90)
    turtle.fd(KBW/29)
    turtle.lt(90)
    turtle.penup()
    turtle.fd(KBL/77)
    turtle.pendown()
    turtle.fillcolor("white")
    for i in range(19):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*2)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.penup()
    turtle.bk(KBL)
    turtle.rt(90)
    turtle.fd(KBW/29*3)
    turtle.lt(90)
    turtle.penup()
    turtle.fd(KBL/77)
    turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*2,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*2+KBL/77)
    turtle.pendown()
    for i in range(12):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*8,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*8+KBL/77)
    turtle.pendown()
    for i in range(4):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.penup()
    turtle.bk(KBL)
    turtle.rt(90)
    turtle.fd(KBW/29*5)
    turtle.lt(90)
    turtle.fd(KBL/77)
    turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*4,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*4+KBL/77)
    turtle.pendown()
    for i in range(12):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.begin_fill()
    turtle.fd(KBL/77*5)
    turtle.rt(90)
    turtle.fd(KBW/29*9)
    turtle.rt(90)
    turtle.fd(KBL/77*4)
    turtle.rt(90)
    turtle.fd(KBW/29*5)
    turtle.lt(90)
    turtle.fd(KBL/77*1)
    turtle.rt(90)
    turtle.fd(KBW/29*4)
    turtle.end_fill()
    turtle.rt(90)
    turtle.penup()
    turtle.fd(KBL/77*5+KBL/77)
    turtle.pendown()
    for i in range(3):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*4,KBW/29*9)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*4+KBL/77)
    turtle.pendown()
    turtle.penup()
    turtle.bk(KBL)
    turtle.rt(90)
    turtle.fd(KBW/29*5)
    turtle.lt(90)
    turtle.fd(KBL/77)
    turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*5,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*5+KBL/77)
    turtle.pendown()
    for i in range(12):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.penup()
    turtle.fd(KBL/77*5)
    turtle.pendown()
    for i in range(3):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.penup()
    turtle.fd(KBL/77*5)
    turtle.pendown()
    turtle.penup()
    turtle.bk(KBL)
    turtle.rt(90)
    turtle.fd(KBW/29*5)
    turtle.lt(90)
    turtle.fd(KBL/77)
    turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*4,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*4+KBL/77)
    turtle.pendown()
    for i in range(11):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*9,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*9+KBL/77)
    turtle.pendown()
    for i in range(3):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*4,KBW/29*9)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*4+KBL/77)
    turtle.pendown()
    turtle.penup()
    turtle.bk(KBL)
    turtle.rt(90)
    turtle.fd(KBW/29*5)
    turtle.lt(90)
    turtle.fd(KBL/77)
    turtle.pendown()
    for i in range(4):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*22,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*22+KBL/77)
    turtle.pendown()
    for i in range(3):
        turtle.begin_fill()
        rectangle(KBL/77*3,KBW/29*4)
        turtle.end_fill()
        turtle.penup()
        turtle.fd(KBL/77*3+KBL/77)
        turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*3,KBW/29*4)
    turtle.end_fill()
    turtle.begin_fill()
    rectangle(KBL/77*3,KBW/29*2)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*3+KBL/77)
    turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*3,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*3+KBL/77)
    turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*7,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*7+KBL/77)
    turtle.pendown()
    turtle.begin_fill()
    rectangle(KBL/77*3,KBW/29*4)
    turtle.end_fill()
    turtle.penup()
    turtle.fd(KBL/77*3+KBL/77)
    turtle.pendown()

    turtle.penup()
    turtle.bk(KBL)
    turtle.rt(90)
    turtle.fd(length/13)
    turtle.lt(90)
    turtle.fd((length/13*3)+(KBL/77*5))
    turtle.pendown()
    rectangle(length/13*3,length/26*3)
    turtle.rt(90)
    turtle.fd(length/26*3)
    turtle.lt(90)
    rectangle(length/13*3,length/26)
    rectangle((length/13*3)/2,length/26)

turtle.bk(length/2)

laptop(length)

turtle.hideturtle()






























































