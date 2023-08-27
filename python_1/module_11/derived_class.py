class Person:
    """Person class"""
    def __init__(self, lname, fname, addy=''):
        self._last_name = lname
        self._first_name = fname
        self._address = addy

    def display(self):
        return self._last_name + ", " + self._first_name + ":" + self._address


class Student(Person):
    def __init__(self, student_id, lname, fname, major="Computer Science", gpa=0):
        super().__init__(lname, fname)
        self.major = major
        self.gpa = gpa
        self.student_id = student_id

    def display(self):
        return self._last_name + ", " + self._first_name + ":" + "(" + str(self.student_id) + ")" + " " + self.major + " gpa: " + str(self.gpa)


if __name__ == '__main__':
    my_student = Student(900111111, 'Doe', 'John')
    print(my_student.display())
    my_student = Student(900111111, 'Doe', 'John', 'Computer Engineering')
    print(my_student.display())
    my_student = Student(900111111, 'Doe', 'John', 'Computer Engineering', 4.0)
    print(my_student.display())
    del my_student