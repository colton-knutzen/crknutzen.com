if __name__ == '__main__':

    try:
        first_name = input("Enter your First name:")
        last_name = input("Enter your Last name:")
        age = int(input("Enter your age:"))
        score_one = float(input("Enter the test score of your first attempt:"))
        score_two = float(input("Enter the test score of your second attempt:"))
        score_three = float(input("Enter the test score of your third attempt:"))
        average_score = (score_one + score_two + score_three) / 3

        if age < 0 or score_one < 0 or score_two < 0 or score_three < 0:
            print("Please enter valid numbers for age and scores.")

        else:
            print(f'{last_name}, {first_name}. Age: {age} Average Grade: {average_score:.2f}')

    except ValueError:
        print("Please enter valid numbers for age and scores.")
