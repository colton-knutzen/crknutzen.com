"""
This file contains standard methods with various return types.
"""


def greater(first, second):
    """Returns true if first > second"""
    return first > second


def lesser(first, second):
    """Returns true if first < second"""
    return first < second


def meanOfThree(x, y, z):
    """Returns average of 3 integers"""
    sumVal = x + y + z

    return sumVal / 3


def getGrade(score):
    """Returns string letter grade matching score"""
    tooHigh = 101
    aThreshold = 90
    bThreshold = 80
    cThreshold = 70
    dThreshold = 60
    fThreshold = 0

    if score >= tooHigh:
        grade = "Invalid score: too high."
    elif score >= aThreshold:
        grade = "A"
    elif score >= bThreshold:
        grade = "B"
    elif score >= cThreshold:
        grade = "C"
    elif score >= dThreshold:
        grade = "D"
    elif score >= fThreshold:
        grade = "F"
    else:
        grade = "Invalid score: too low."

    return grade


if __name__ == "__main__":
    """ *Driver Code*
        This section is used for simple testing and
        consolidating overall logic of the program.
    """
    print("\n**************************\n")
    print("Below is the simplest form of testing. We call each function to verify it works.")
    print("However, this is messy and is difficult to be thorough")
    print("\n**************************\n")

    print(f"Calling greater(5, 4): {greater(5, 4)}")
    print(f"Calling lesser(5, 4): {lesser(5, 4)}")
    print(f"Calling meanOfThree(2, 3.5, 4.75): {meanOfThree(2, 3.5, 4.75)}")
    print(f"Calling getGrade(87): {getGrade(87)}")
    print("\n**************************\n")

    print("Instead of testing like this, we can use the unittest.testCase class to create more robust test suites.")
    print("\n**************************\n")
