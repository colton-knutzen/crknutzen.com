def score_input(test_name, test_score=-1, invalid_message="Invalid test score!"):
    try:
        test_score = int(test_score)
        if 0 <= test_score <= 100:
            return f"{test_name}, {test_score}, Valid!"
        else:
            return invalid_message
    except ValueError:
        return "Value Error"

if __name__ == '__main__':
    display_string = score_input('English', 100)
    print(display_string)

    display_string = score_input('Math', -50)
    print(display_string)

    display_string = score_input('History', 9000)
    print(display_string)

    display_string = score_input('Math', 'no_num')
    print(display_string)

    # no test_score given, use default
    display_string = score_input('no_test_score_passed')
    print(display_string)
