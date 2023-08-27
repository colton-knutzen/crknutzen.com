import random
import tkinter as tk
from tkinter import messagebox


class NumberGuesser:
    guessed_list = []

    @classmethod
    def add_guess(cls, guess):
        cls.guessed_list.append(guess)


class NumberGuessingGame:
    def __init__(self):
        self.secret_number = None
        self.root = tk.Tk()
        self.buttons = []
        self.start_button = None
        self.text_box = None

        self.setup_ui()

    def setup_ui(self):
        self.root.title("Number Guessing Game")

        # Create buttons
        for i in range(1, 10 + 1):
            button = tk.Button(self.root, text=str(i), command=lambda num=i: self.check_guess(num))
            self.buttons.append(button)
            button.grid(row=0, column=i-1)

        # Start button
        self.start_button = tk.Button(self.root, text="Start Game", command=self.start_game)
        self.start_button.grid(row=1, column=0, columnspan=10)

        # Text box
        self.text_box = tk.Text(self.root, height=5, width=40, wrap=tk.WORD)
        self.text_box.grid(row=2, column=0, columnspan=10)

        self.display_prompt("Welcome to the Guessing Game. Press 'Start Game' to generate a random number and start "
                            "playing!")

    def start_game(self):
        self.secret_number = random.randint(1, 10)
        NumberGuesser.guessed_list = []
        self.enable_buttons()
        self.start_button.config(state=tk.DISABLED)
        self.text_box.delete(1.0, tk.END)


    def check_guess(self, guess):
        if guess == self.secret_number:
            self.show_winner_message()
            self.reset_game()
        else:
            self.buttons[guess - 1].config(state=tk.DISABLED)
            NumberGuesser.add_guess(guess)
            self.display_prompt(f"Wrong guess! Try again!")

    def show_winner_message(self):
        self.display_prompt("Congratulations! You guessed the number correctly! Press 'Start Game' to play again.")

    def display_prompt(self, prompt):
        self.text_box.insert(tk.END, prompt + "\n")
        self.text_box.see(tk.END)

    def enable_buttons(self):
        for button in self.buttons:
            button.config(state=tk.NORMAL)

    def reset_game(self):
        self.secret_number = None
        self.enable_buttons()
        self.start_button.config(state=tk.NORMAL)

    def run(self):
        self.root.mainloop()


if __name__ == '__main__':
    game = NumberGuessingGame()
    game.run()

