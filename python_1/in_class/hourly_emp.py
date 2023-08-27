def hourly_employee_input():
    try:
        name = input("Enter your name: ")
        hours_worked = int(input("Enter hours worked: "))
        hourly_wage = float(input("Enter hourly wage: "))

        if hours_worked < 0:
            print("Error! Hours worked must be positive.")
            hours_worked = 0

        if hourly_wage < 0:
            print("Error! Hourly wage must be positive.")
            hourly_wage = 0.0

        weekly_wage = hours_worked * hourly_wage

        return f"{name} earned ${weekly_wage}."

    except ValueError:
        return "Error! Invalid number entered."

def print_greeting(name):
    print(f"Hello, {name}! Glad you are here.")

if __name__ == '__main__':
    # print(hourly_employee_input())

    name = "Bob"
    print_greeting(name)