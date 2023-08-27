def in_set(set, value):
    i = value in set
    if i == True:
        return f"The value '{value}' is in set {set}"

    if i == False:
        return f"The value '{value}' is NOT in set {set}"


if __name__ == '__main__':
    test_set = {"banana", "apple", "apple", "cherry"}
    test_value = 5

    print(in_set(test_set, test_value))

    test_value2 = "apple"

    print(in_set(test_set, test_value2))


