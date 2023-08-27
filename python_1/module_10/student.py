class Student:
    def __init__(self, lname, fname, major, gpa=0.0):
        name_characters = set("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'-")

        if not (name_characters.issuperset(lname) and name_characters.issuperset(fname) and name_characters.issuperset(
                major)):
            raise ValueError("Invalid name or major")

        if not isinstance(gpa, float) or not (0.0 <= gpa <= 4.0):
            raise ValueError("Invalid GPA")

        self.last_name = lname
        self.first_name = fname
        self.major = major
        self.gpa = gpa

    def __str__(self):
        return self.last_name + ", " + self.first_name + " has major " + self.major + "with gpa: " + str(self.gpa)

if __name__ == '__main__':
    Student("Doe", "John", "Computer Science")
    Student("Smith", "Jane", "Physics", 3.8)
