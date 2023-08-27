class Person:
    """Person class using class Address, Class Composition"""
    def __init__(self, lname, fname, addy=''):
        name_characters = set("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'-")
        if not (name_characters.issuperset(lname) and name_characters.issuperset(fname)):
            raise ValueError
        self.last_name = lname
        self.first_name = fname
        self.address = addy

    def display(self):
        return str(self.last_name) + ", " + str(self.first_name) + '\n' + self.address.display()


class Student(Person):
    def __init__(self, lname, fname, major='', start_date='', gpa=0.0, addy=''):
        super().__init__(lname, fname, addy)
        self.major = major
        self.start_date = start_date
        self.gpa = gpa

    def change_major(self, new_major):
        self.major = new_major

    def update_gpa(self, new_gpa):
        self.gpa = new_gpa

    def display(self):
        return str(self.last_name) + ", " + str(self.first_name) + '\n' + str(self.major) + '\n' + "Start Date: " \
            + str(self.start_date) + '\n' + "GPA: " + str(self.gpa)


if __name__ == '__main__':
    student_1 = Student("Smith", "Jane", "Computers", "6/29/23", 4.0)
    print(student_1.display())
    print('\n')
    student_1.change_major("Being Awesome!")
    student_1.update_gpa(3.0)
    print(student_1.display())
