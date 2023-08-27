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
    def __init__(self, person, major='', start_date='', gpa=0.0):
        super().__init__(person.last_name, person.first_name, person.address)
        self.major = major
        self.start_date = start_date
        self.gpa = gpa

    def display(self):
        return str(self.last_name) + ", " + str(self.first_name) + '\n' + str(self.major) + '\n' + "Start Date: " \
            + str(self.start_date) + '\n' + "GPA: " + str(self.gpa)


if __name__ == '__main__':
    person_1 = Person("Smith", "Jane")
    student_1 = Student(person_1, "Computers", "6/29/23", 4.0)
    print(student_1.display())

