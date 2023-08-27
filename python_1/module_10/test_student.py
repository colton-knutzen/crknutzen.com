import unittest
from student import Student


class TestStudent(unittest.TestCase):
    def setUp(self):
        self.student1 = Student("Doe", "John", "Computer Science")
        self.student2 = Student("Smith", "Jane", "Physics", 3.8)

    def tearDown(self):
        del self.student1
        del self.student2

    def test_object_created_required_attributes(self):
        self.assertEqual(self.student1.last_name, "Doe")
        self.assertEqual(self.student1.first_name, "John")
        self.assertEqual(self.student1.major, "Computer Science")

    def test_object_created_all_attributes(self):
        self.assertEqual(self.student2.last_name, "Smith")
        self.assertEqual(self.student2.first_name, "Jane")
        self.assertEqual(self.student2.major, "Physics")
        self.assertEqual(self.student2.gpa, 3.8)

    def test_student_str(self):
        self.assertEqual(str(self.student1), 'Doe, John has major Computer Science with GPA: 0.0')

    def test_object_not_created_error_last_name(self):
        with self.assertRaises(ValueError):
            p = Student('123', 'John', "Computer Science")

    def test_object_not_created_error_first_name(self):
        with self.assertRaises(ValueError):
            p = Student('Doe', '123', "Computer Science")

    def test_object_not_created_error_gpa(self):
        with self.assertRaises(ValueError):
            p = Student('Doe', 'John', "Computer Science", "abc")

    def test_object_not_created_invalid_gpa_range(self):
        with self.assertRaises(ValueError):
            p = Student('Doe', 'John', "Computer Science", 5.0)

if __name__ == '__main__':
    unittest.main()
