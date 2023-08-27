class Employee:
    def __init__(self, first_name, last_name, address, city_state, phone_number):
        self.first_name = first_name
        self.last_name = last_name
        self.address = address
        self.city_state = city_state
        self.phone_number = phone_number


class SalariedEmployee(Employee):
    def __init__(self, first_name, last_name, start_date, salary):
        super().__init__(first_name, last_name, None, None, None)
        self.start_date = start_date
        self.salary = salary

    def give_raise(self, new_salary):
        self.salary = new_salary

    def display(self):
        return f"{self.first_name} {self.last_name} \n Start Date: {self.start_date} \n Salary: {self.salary}"


class HourlyEmployee(Employee):
    def __init__(self, first_name, last_name, start_date, hourly_pay):
        super().__init__(first_name, last_name, None, None, None)
        self.start_date = start_date
        self.hourly_pay = hourly_pay

    def give_raise(self, new_pay):
        self.hourly_pay = new_pay

    def display(self):
        return f"{self.first_name} {self.last_name} \n Start Date: {self.start_date} \n Hourly Pay: {self.hourly_pay}"


if __name__ == '__main__':
    boss_man = SalariedEmployee("John", "Doe", "6/29/23", 40000)
    print(boss_man.display())
    boss_man.give_raise(45000)
    print("\n")
    print(boss_man.display())
    print("\n")
    general_emp = HourlyEmployee("Jane", "Smith", "6/29/23", 10)
    print(general_emp.display())
    general_emp.give_raise(12)
    print("\n")
    print(general_emp.display())

# I'm having a difficult time see what the parent class is actually "doing" in these assignments. Because there is no
# difference between the below "SalariedEmp_NoParent class below as the one above. And in this assignment particularly,
# the Employee parent is hindering the child classes because they're inheriting address, city_state, and phone_number,
# which have to be dealt with None in the super.
# I don't understand what a Parent class will bring if you can't pick and choose the members to inherit

class SalariedEmployee():
    def __init__(self, first_name, last_name, start_date, salary):
        self.first_name = first_name
        self.last_name = last_name
        self.start_date = start_date
        self.salary = salary

    def give_raise(self, new_salary):
        self.salary = new_salary

    def display(self):
        return f"{self.first_name} {self.last_name} \n Start Date: {self.start_date} \n Salary: {self.salary}"