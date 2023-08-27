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

    def one_button(self, text, command):
        self.button1 = tk.Button(self.window, text=text, width=15, height=1, command=command)
        self.button1.grid(row=1, column=1, padx=10, pady=10)

    def two_button(self, text1, text2, command1, command2):
        self.button1 = tk.Button(self.window, text=text1, width=15, height=1, command=command1)
        self.button1.grid(row=1, column=0, padx=10, pady=10)

        self.button2 = tk.Button(self.window, text=text2, width=15, height=1, command=command2)
        self.button2.grid(row=1, column=2, padx=10, pady=10)

    def password_generated(self):
        self.password_list = [random.randint(1, 99) for _ in range(3)]  # Changed to list comprehension

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

    def game_start(self):
        self.ui_prep(game_start)
        self.one_button("Start Game", self.chamber_1)
        self.swimSpeed = 0
        self.gun = False

    def chamber_1(self):
        self.ui_prep(chamber_1_text)
        self.one_button("Open Eyes", self.chamber_2)

    def chamber_2(self):
        self.ui_prep(chamber_2_text)
        self.one_button("What's going on?", self.chamber_3)

    def chamber_3(self):
        self.ui_prep(chamber_3_text)
        self.one_button("Look Around", self.chamber_4)

    def chamber_4(self):
        self.ui_prep(chamber_4_text)
        self.one_button("Get up", self.chamber_5)

    def chamber_5(self):
        self.ui_prep(chamber_5_text)
        self.one_button("Pick it Up", self.chamber_6)

    def chamber_6(self):
        self.ui_prep(chamber_6_text)
        self.player_name_entry = tk.Entry(self.window)
        self.player_name_entry.grid(row=2, column=1, padx=10, pady=10)

        self.submit_button = tk.Button(self.window, text="My name is...", width=15, height=1, command=self.process_name)
        self.submit_button.grid(row=3, column=1, padx=10, pady=10)

    def process_name(self):
        self.player_name = self.player_name_entry.get()

        try:
            if not re.match(r'^[a-zA-Z\s]+$', self.player_name):
                raise ValueError
            else:
                self.chamber_7()
        except ValueError:
            self.chamber_6_invalid()

    def chamber_6_invalid(self):
        self.player_name_entry.destroy()
        self.submit_button.destroy()

        self.ui_prep(chamber_6_text_invalid_name)
        self.player_name_entry = tk.Entry(self.window)
        self.player_name_entry.grid(row=2, column=1, padx=10, pady=10)

        self.submit_button = tk.Button(self.window, text="My name is...", width=15, height=1, command=self.process_name)
        self.submit_button.grid(row=3, column=1, padx=10, pady=10)

    def chamber_7(self):
        chamber_7_text_with_name = chamber_7_text.format(self.player_name)
        self.player_name_entry.destroy()
        self.submit_button.destroy()
        self.ui_prep(chamber_7_text_with_name)
        self.two_button("What happened?", "Enter Name Again", self.chamber_8, self.chamber_6)

    def chamber_8(self):
        self.ui_prep(chamber_8_text)
        self.one_button("Leave the House", self.chamber_9)

    def chamber_9(self):
        self.ui_prep(chamber_9_text)
        self.one_button("Dive in", self.chamber_10)

    def chamber_10(self):
        self.ui_prep(chamber_10_text)
        self.two_button("Swim Faster", "Conserve Energy", self.swimSpeed_1, self.chamber_11)

    def swimSpeed_1(self):
        self.swimSpeed += 1
        self.chamber_11()

    def chamber_11(self):
        self.ui_prep(chamber_11_text)
        self.two_button("Swim Faster", "Conserve Energy", self.swimSpeed_2, self.chamber_12)

    def swimSpeed_2(self):
        self.swimSpeed += 1
        self.chamber_12()

    def chamber_12(self):
        self.ui_prep(chamber_12_text)
        self.two_button("Swim Faster", "Conserve Energy", self.swimSpeed_3, self.chamber_13_check)

    def swimSpeed_3(self):
        self.swimSpeed += 1
        self.chamber_13_check()

    def chamber_13_check(self):
        if self.swimSpeed >= 3:
            self.chamber_13a()
        else:
            self.chamber_13b()
            self.swimSpeed = 0

    def chamber_13a(self):
        self.ui_prep(chamber_13a_text)
        self.one_button("Run up the stairs", self.chamber_14)

    def chamber_13b(self):
        self.ui_prep(chamber_13b_text)
        self.one_button("Restart", self.chamber_9)

    def chamber_14(self):
        self.ui_prep(chamber_14_text)
        self.two_button("Check House", "Advance Forward", self.chamber_15_house, self.chamber_15_check)
        if self.gun == True:
            self.button1.config(state=tk.DISABLED)

    def chamber_15_house(self):
        self.ui_prep(chamber_15a_text)
        self.gun = True
        self.one_button("Return", self.chamber_14)

    def chamber_15_check(self):
        if self.gun == False:
            self.chamber_16a()

        else:
            self.chamber_16()

    def chamber_16a(self):
        self.ui_prep(chamber_15b_text)
        self.one_button("Restart", self.chamber_14)

    def chamber_16(self):
        self.ui_prep(chamber_16_text)
        self.one_button("Drop the Gun", self.chamber_17)

    def chamber_17(self):
        self.password_generated()
        self.ui_prep(chamber_17_text)  # Converted tuple to string
        self.one_button("Operate Pod", self.chamber_18)

    def chamber_18(self):
        self.ui_prep(chamber_18_text)  # Converted tuple to string

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
            self.chamber_21()
        else:
            self.chamber_19a()

    def chamber_19a(self):
        self.ui_prep(chamber_19a_text)
        self.one_button("Restart", self.chamber_17)

    def chamber_19b(self):
        self.ui_prep(chamber_19b_text)
        self.two_button("Return to Pod", "Peak", self.chamber_18, self.chamber_20)

    def chamber_20(self):
        chamber_20_text_with_password = chamber_20_text.format(self.password_list)  # Changed to list
        self.ui_prep(chamber_20_text_with_password)
        self.one_button("Return to Pod", self.chamber_18)

    def chamber_21(self):
        self.ui_prep(chamber_21_text)
        self.one_button("Restart Game", self.game_start)

    def run(self):
        self.window.mainloop()


if __name__ == '__main__':
    game = EscapeGame()
    game.run()
