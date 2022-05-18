import turtle
import random
turtle.shape("turtle")
turtle.speed(10)

def square(length):
    for i in range(4):       
        turtle.fd(length)
        turtle.rt(90)

def triangle(length):
    for i in range(3):
        turtle.fd(length)
        turtle.lt(120)

def chimney(length):

    turtle.fillcolor("gray")
    turtle.begin_fill()
    turtle.fd(length/3)
    turtle.rt(90)
    turtle.fd(length/32)
    turtle.lt(90)
    turtle.fd(length/32)
    turtle.lt(90)
    turtle.fd(length/8+length/16)
    turtle.lt(90)
    turtle.fd(length/32)
    turtle.lt(90)
    turtle.fd(length/32)
    turtle.rt(90)
    turtle.fd(length/3)
    turtle.lt(90)
    turtle.fd(length/8)
    turtle.end_fill()

def roof(length):
    
    turtle.fillcolor("red")
    turtle.begin_fill()
    triangle(length)
    turtle.end_fill()

    turtle.fd(length)
    turtle.lt(120)
    
    turtle.fd(length/2-length/8)
    turtle.rt(30)

    chimney(length)

    turtle.lt(120)
    turtle.fd(length/2+length/8)
    turtle.lt(120)
    turtle.fd(length)
    turtle.lt(120)

    turtle.fillcolor("red")
    turtle.begin_fill()
    triangle(length)
    turtle.end_fill()

def door(length):
    turtle.fillcolor("brown")
    turtle.begin_fill()
    turtle.fd(length/2)
    turtle.rt(90)
    turtle.fd(length/4)
    turtle.rt(90)
    turtle.fd(length/2)
    turtle.end_fill()
    turtle.rt(90)
    turtle.fd(length/4)
    turtle.rt(90)
    
    turtle.fd(length/4+length/16)
    turtle.rt(90)
    turtle.penup()
    turtle.fd(length/16)
    turtle.lt(90)
    turtle.pendown()
    window(length/2)
    turtle.lt(90)
    turtle.fd(length/16)
    turtle.lt(90)
    turtle.fd(length/8)
    turtle.rt(90)
    turtle.penup()
    turtle.fd(length/16)
    turtle.rt(90)
    turtle.pendown()
    turtle.fd(length/8+length/16)
    turtle.rt(90)
    turtle.fd(length/4)
    turtle.rt(90)
    turtle.fd(length/4)
    turtle.rt(90)
    turtle.penup()
    turtle.fd(length/32)
    turtle.pendown()
    turtle.fd(length/32)
    turtle.rt(180)
    turtle.penup()
    turtle.fd(length/16)
    turtle.rt(90)
    turtle.pendown()
    turtle.fd(length/4)

def window(length):
    turtle.fillcolor("white")
    turtle.begin_fill()
    square(length/4)
    turtle.end_fill()
    square(length/4)
    turtle.fd(length/8)
    turtle.rt(90)
    turtle.fd(length/4)
    turtle.rt(90)
    turtle.fd(length/8)
    turtle.rt(90)
    turtle.fd(length/8)
    turtle.rt(90)
    turtle.fd(length/4)

def house(length):

    turtle.fillcolor("gray")
    turtle.begin_fill()
    square(length)
    turtle.end_fill()
    
    roof(length)
    
    turtle.rt(90)
    turtle.fd(length)
    turtle.lt(90)
    turtle.fd(length/5)
    turtle.lt(90)

    door(length)

    turtle.lt(90)
    turtle.fd(length/5)
    turtle.lt(90)
    turtle.penup()
    turtle.fd(length/4)
    turtle.pendown()

    window(length)

    turtle.penup()
    turtle.fd(length/2+length/4)
    turtle.lt(90)
    turtle.fd(length/8)
    turtle.fd((length/5)*0.75)
    turtle.fd(length/8)
    turtle.rt(90)
    turtle.pendown()

    window(length)

    turtle.penup()
    turtle.rt(90)
    turtle.fd(length/2)
    turtle.rt(90)
    turtle.fd(length/2)
    turtle.lt(90)
    turtle.fd(length/8)
    turtle.pendown()

#Christmas present trail


def present():
    height = random.randint(10,30)
    width = random.randint(10,30)

    turtle.fillcolor("red")
    turtle.begin_fill()
    turtle.lt(90)
    turtle.fd(height)
    turtle.rt(90)
    turtle.fd(width)
    turtle.rt(90)
    turtle.fd(height)
    turtle.rt(90)
    turtle.fd(width)
    turtle.end_fill()
    turtle.rt(90)
    
    turtle.fd(height/2-height/16)

    turtle.fillcolor("green")
    turtle.begin_fill()
    turtle.rt(90)
    turtle.fd(width)
    turtle.lt(90)
    turtle.fd(height/8)
    turtle.lt(90)
    turtle.fd(width)
    turtle.end_fill()
    turtle.rt(90)
    turtle.bk(height/8)
    turtle.fd(height/2+height/16)
    
    turtle.rt(90)

    turtle.fd(width/2-width/16)
    turtle.rt(90)
    turtle.begin_fill()
    turtle.fd(height)
    turtle.lt(90)
    turtle.fd(width/8)
    turtle.lt(90)
    turtle.fd(height)
    turtle.end_fill()
    turtle.rt(90)
    turtle.bk(width/8)
    turtle.fd(width/2+width/16)
    
    turtle.rt(90)
    turtle.fd(height)
    turtle.rt(90)
    turtle.fd(width)

    turtle.rt(180)
    turtle.fd(width)
    turtle.penup()
    turtle.fd(width*0.2)
    turtle.pendown()

def snow(num,minnum,maxnum):
    for i in range(num):
        turtle.penup()
        x = random.randint(minnum, maxnum)
        y = random.randint(minnum, maxnum)
        turtle.setpos(x,y)
        turtle.pendown()
        size = random.randint(10,30)
        for i in range(8):
            turtle.fd(size/2)
            turtle.bk(size)
            turtle.fd(size/2)
            turtle.rt(45)


