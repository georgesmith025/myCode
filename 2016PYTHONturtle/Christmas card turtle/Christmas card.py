import turtle
import random
import Turtlestuff
import shapes
import Christmastree

turtle.shape("turtle")

turtle.speed(0)

Christmastree.tree()

turtle.penup()

turtle.fd(120)
turtle.lt(90)
turtle.fd(57)
turtle.rt(90)

turtle.pendown()

length = 200

Turtlestuff.house(length)

turtle.penup()
turtle.rt(90)
turtle.fd(length)
turtle.rt(90)
turtle.fd(length/2+length/8)
turtle.rt(180)
turtle.pendown()

for i in range(3):
    Turtlestuff.present()

Turtlestuff.snow(50,-300,300)

turtle.hideturtle()

