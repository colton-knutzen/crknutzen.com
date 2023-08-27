import unittest

from methods import *


class TestMethods(unittest.TestCase):
    """
    When testing for boolean functions, you can utilize the self.assertTrue and self.assertFalse
    test methods. This provides simplicity and clarity over other options like self.assertEquals.
    """
    def test_greater(self):
        self.assertTrue(greater(10, 5))

        self.assertFalse(greater(5, 10))
        self.assertFalse(greater(5, 5))

    def test_lesser(self):
        self.assertTrue(lesser(5, 10))

        self.assertFalse(lesser(10, 5))
        self.assertFalse(lesser(5, 5))

    """
    When testing for specific values, it's important to label tests with the logic
    being used. Notice that I've added _int, _double, _mixed to the following three
    tests to denote what types of input values are being used.
    """
    def test_meanOfThree_int(self):
        expected = 4.0
        actual = meanOfThree(3, 4, 5)

        self.assertEquals(expected, actual)

    def test_meanOfThree_double(self):
        expected = 4.2
        actual = meanOfThree(3.1, 4.2, 5.3)

        self.assertEquals(expected, actual)

    """
    When comparing floating point values, you should use self.assertAlmostEqual. 
    This assert method allows you to add a "places" argument to round to a 
    specific number of decimal places.
    """
    def test_meanOfThree_mixed(self):
        expected = 4.183
        actual = meanOfThree(3.0, 4.2, 5.35)

        self.assertAlmostEqual(expected, actual, places=3)

    """
    When testing a method with branching logic, it's important to have test
    cases for each branch.

    Also, notice the _valid and _invalid parts of the names. When testing 
    for a range of values, you should include tests for both valid and 
    invalid data values.
    """
    def test_getGrade_valid(self):
        self.assertEquals("A", getGrade(100))
        self.assertEquals("A", getGrade(96))
        self.assertEquals("B", getGrade(85))
        self.assertEquals("C", getGrade(74))
        self.assertEquals("D", getGrade(63))
        self.assertEquals("F", getGrade(59))
        self.assertEquals("F", getGrade(0))

    def test_getGrade_invalid(self):
        self.assertEquals("Invalid score: too high.", getGrade(250))
        self.assertEquals("Invalid score: too high.", getGrade(101))

        self.assertEquals("Invalid score: too low.", getGrade(-1))
        self.assertEquals("Invalid score: too low.", getGrade(-250))


if __name__ == '__main__':
    unittest.main()
