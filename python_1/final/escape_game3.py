import random
import tkinter as tk

def generate_random_tuple():
    random_numbers = tuple(random.randint(1, 99) for _ in range(3))
    return random_numbers

def check_equality():
    user_numbers = (int(entry1.get()), int(entry2.get()), int(entry3.get()))
    random_numbers = generate_random_tuple()

    if user_numbers == random_numbers:
        equal.set(True)
    else:
        equal.set(False)

# Create the GUI window
window = tk.Tk()
window.title("Number Comparison")

# Create input fields for user numbers
entry1 = tk.Entry(window, width=10)
entry1.pack(side=tk.LEFT, padx=5, pady=5)

entry2 = tk.Entry(window, width=10)
entry2.pack(side=tk.LEFT, padx=5, pady=5)

entry3 = tk.Entry(window, width=10)
entry3.pack(side=tk.LEFT, padx=5, pady=5)

# Button to check equality
check_button = tk.Button(window, text="Check Equality", command=check_equality)
check_button.pack(pady=10)

# Variable to store equality result
equal = tk.BooleanVar()
equal.set(False)

# Label to display equality result
result_label = tk.Label(window, textvariable=equal)
result_label.pack()

# Start the GUI event loop
window.mainloop()
