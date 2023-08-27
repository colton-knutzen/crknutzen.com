from datetime import datetime

class Employee:
    def __init__(self, first_name, last_name, address, city_state, phone_number, salaried, start_date, salary):
        self.first_name = first_name
        self.last_name = last_name
        self.address = address
        self.city_state = city_state
        self.phone_number = phone_number
        self.salaried = salaried
        self.start_date = start_date
        self.salary = salary

    def display(self):
        start_date = self.start_date.strftime("%m-%d-%Y")

        if self.salaried == True:
            return f"{self.first_name} {self.last_name} \n {self.address} \n {self.city_state} \n Salaried Employee: ${self.salary}/year \n Start date: {start_date}"

        else:
            return f"{self.first_name} {self.last_name} \n {self.address} \n {self.city_state} \n Hourly Employee: ${self.salary}/hour \n Start date: {start_date}"


if __name__ == '__main__':
    emp = Employee('Sasha', 'Patel', '123 Main St', 'Urban, Iowa', '123-4567', True, datetime(2019, 6, 28), 40000.00)  # call the construtor, needs to have a first and last name in parameter
    print(emp.display())                # display returns a str, so print the information
    del emp                             # clean up!

    emp = Employee('Jack', 'Telpa', '456 Side St', 'Rural, Iowa', '765-4321', False, datetime(2023, 7, 19), 15.75)  # call the construtor, needs to have a first and last name in parameter
    print(emp.display())                # display returns a str, so print the information
    del emp                             # clean up!
