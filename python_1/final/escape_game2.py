import tkinter as tk
from tkinter import font
from script import *
import re
import random

class EscapeGame:
    def __init__(self):
        self.window = tk.Tk()

        self.text_area = tk.Text(self.window, height=12, width=50, wrap=tk.WORD)
        self.text_area.grid(row=0, column=0, columnspan=3, padx=10)
        self.text_area.configure(padx=15, pady=5)

        self.text_area_style()
        self.game_start()

        self.swimSpeed = 0
        self.gun = False
        self.password_list = [0, 0, 0]  # Changed to list
        self.password_input = [0, 0, 0]  # Changed to list of StringVars


    def one_button(self, text, command):
        self.button1 = tk.Button(self.window, text=text, width=15, height=1, command=command)
        self.button1.grid(row=1, column=1, padx=10, pady=10)

    def two_button(self, text1, text2, command1, command2):
        self.button1 = tk.Button(self.window, text=text1, width=15, height=1, command=command1)
        self.button1.grid(row=1, column=0, padx=10, pady=10)

        self.button2 = tk.Button(self.window, text=text2, width=15, height=1, command=command2)
        self.button2.grid(row=1, column=2, padx=10, pady=10)

    def text_area_style(self):
        custom_font = font.Font(family="Arial", size=14)
        self.text_area.configure(font=custom_font)
        self.text_area.tag_configure("center", justify='center')

    def ui_prep(self, game_text):
        if hasattr(self, 'button1'):
            self.button1.destroy()
        if hasattr(self, 'button2'):
            self.button2.destroy()
        if hasattr(self, 'password_entry1'):
            self.password_entry1.destroy()
        if hasattr(self, 'password_entry2'):
            self.password_entry2.destroy()
        if hasattr(self, 'password_entry3'):
            self.password_entry3.destroy()
        if hasattr(self, 'password_submit_button'):
            self.password_submit_button.destroy()

        self.text_area.configure(state='normal')
        self.text_area.delete(1.0, tk.END)
        self.text_area.insert(tk.END, game_text)
        self.text_area.tag_add("center", "1.0", "end")
        self.text_area.configure(state='disabled')

    def password_generated(self):
        self.password_list = [random.randint(1, 99) for _ in range(3)]  # Changed to list comprehension

    def game_start(self):
        self.swimSpeed = 0
        self.gun = False
        self.password_list = [0, 0, 0]  # Changed to list
        self.password_input = [0, 0, 0]  # Changed to list
        self.ui_prep(str(self.password_list))  # Converted tuple to string
        self.one_button("Start Game", self.chamber_17)

    def chamber_17(self):
        self.password_generated()
        self.ui_prep(str(self.password_list))  # Converted tuple to string
        self.one_button("Operate Pod", self.chamber_18)

    def chamber_18(self):
        self.ui_prep(str(self.password_list))  # Converted tuple to string

        self.button1 = tk.Button(self.window, text="Look Around", width=15, height=1, command=self.chamber_19b)
        self.button1.grid(row=2, column=2, padx=10, pady=10)

        self.password_entry1 = tk.Entry(self.window)
        self.password_entry1.grid(row=1, column=0, padx=5, pady=5)

        self.password_entry2 = tk.Entry(self.window)
        self.password_entry2.grid(row=1, column=1, padx=5, pady=5)

        self.password_entry3 = tk.Entry(self.window)
        self.password_entry3.grid(row=1, column=2, padx=5, pady=5)

        self.password_submit_button = tk.Button(self.window, text="Enter Password", width=15, height=1,
                                                command=self.process_password)
        self.password_submit_button.grid(row=2, column=0, padx=10, pady=10)

    def process_password(self):
        self.password_input = [
            int(self.password_entry1.get()), int(self.password_entry2.get()), int(self.password_entry3.get())
        ]
        if all(x == y for x, y in zip(self.password_input, self.password_list)):
            self.ui_prep("Correct")
        else:
            self.ui_prep("Incorrect")

    def chamber_19b(self):
        self.ui_prep(chamber_19b_text)
        self.two_button("Return to Pod", "Peak", self.chamber_18, self.chamber_20)

    def chamber_20(self):
        chamber_20_text_with_password = chamber_20_text.format(self.password_list)  # Changed to list
        self.ui_prep(chamber_20_text_with_password)
        self.one_button("Return to Pod", self.chamber_18)

    def run(self):
        self.window.mainloop()


if __name__ == '__main__':
    game = EscapeGame()
    game.run()
