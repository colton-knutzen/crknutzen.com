import tkinter as tk

def pick_breakfast():
    label.config(text="Breakfast")

def pick_second_breakfast():
    label.config(text="Second Breakfast")

def pick_lunch():
    label.config(text="Lunch")

def pick_dinner():
    label.config(text="Dinner")

def pick_other():
    label2.config(text="I don't think he knows about those")

m = tk.Tk()
m.title('Favorite Meal')

label = tk.Label(m, text='Waiting')
label.grid(row=5)

check1 = tk.IntVar()
check1 = tk.Checkbutton(m, text="Breakfast", variable=check1, command=pick_breakfast).grid(row=1)

check2 = tk.IntVar()
check2 = tk.Checkbutton(m, text="Second Breakfast", variable=check2, command=pick_second_breakfast).grid(row=2)

check3 = tk.IntVar()
check3 = tk.Checkbutton(m, text="Lunch", variable=check3, command=pick_lunch).grid(row=3)

check4 = tk.IntVar()
check4 = tk.Checkbutton(m, text="Dinner", variable=check4, command=pick_dinner).grid(row=4)

button = tk.Button(m, text='Exit', width=25, command=m.destroy)
button.grid(row=6)




label2 = tk.Label(m)
label2.grid(row=12)
check5 = tk.IntVar()
check5 = tk.Checkbutton(m, text="What about Elevensies?", variable=check5, command=pick_other).grid(row=7)

check6 = tk.IntVar()
check6 = tk.Checkbutton(m, text="Luncheon?", variable=check6, command=pick_other).grid(row=8)

check7 = tk.IntVar()
check7 = tk.Checkbutton(m, text="Afternoon Tea?", variable=check7, command=pick_other).grid(row=9)

check8 = tk.IntVar()
check8 = tk.Checkbutton(m, text="Dinner?", variable=check8, command=pick_other).grid(row=10)

check9 = tk.IntVar()
check9 = tk.Checkbutton(m, text="Supper?", variable=check9, command=pick_other).grid(row=11)
m.mainloop()